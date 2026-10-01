<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\Damage;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorekeeperController extends Controller
{
    /**
     * Display Storekeeper Warehouse Dashboard with live KPIs, alerts, and stock ledger.
     */
    public function dashboard(Request $request): View
    {
        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);
        $tenant = Tenant::find($tenantId) ?? Tenant::first();
        $branch = Branch::find($branchId) ?? Branch::where('tenant_id', $tenantId)->first();

        // Load all active products with category and branch stock
        $products = Product::where('tenant_id', $tenantId)
            ->with(['category', 'branchStocks' => fn ($q) => $q->where('branch_id', $branchId)])
            ->orderBy('name')
            ->get();

        // Calculate KPI values
        $totalProducts = $products->count();
        $totalUnits = 0;
        $totalStockValue = 0.0;
        $lowStockItems = collect();

        foreach ($products as $product) {
            $stock = $product->branchStocks->first();
            $qty = $stock ? (int) $stock->quantity : 0;
            $location = $stock ? $stock->shelf_location : 'Main Hall - Bay A';
            $product->current_stock = $qty;
            $product->current_location = $location;

            $totalUnits += $qty;
            $price = (float) ($product->cost_price ?: $product->selling_price ?: 0);
            $totalStockValue += $qty * $price;

            $threshold = (int) ($product->min_alert_qty ?: 15);
            if ($qty <= $threshold) {
                $lowStockItems->push($product);
            }
        }

        $lowStockCount = $lowStockItems->count();

        // Recent Inbound GRNs (Purchases with status received)
        $recentPurchases = Purchase::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->with(['supplier', 'items.product'])
            ->latest()
            ->take(6)
            ->get();

        // Recent Stock Adjustments & Damages
        $recentDamages = Damage::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->with(['product', 'recorder'])
            ->latest()
            ->take(6)
            ->get();

        // Suppliers list for GRN receiving form
        $suppliers = Supplier::where('tenant_id', $tenantId)->where('is_active', true)->get();

        return view('storekeeper.dashboard', [
            'tenant' => $tenant,
            'branch' => $branch,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalUnits' => $totalUnits,
            'totalStockValue' => $totalStockValue,
            'lowStockCount' => $lowStockCount,
            'lowStockItems' => $lowStockItems->take(10),
            'recentPurchases' => $recentPurchases,
            'recentDamages' => $recentDamages,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Display Storekeeper Products & Stock inventory list with real-time editing & intake.
     */
    public function stock(Request $request): View
    {
        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);
        $tenant = Tenant::find($tenantId) ?? Tenant::first();
        $branch = Branch::find($branchId) ?? Branch::where('tenant_id', $tenantId)->first();

        $categories = Category::where('tenant_id', $tenantId)->where('is_active', true)->get();
        $suppliers = Supplier::where('tenant_id', $tenantId)->where('is_active', true)->get();

        $products = Product::where('tenant_id', $tenantId)
            ->with(['category', 'branchStocks' => fn ($q) => $q->where('branch_id', $branchId)])
            ->orderBy('name')
            ->get();

        $totalUnits = 0;
        $totalValuation = 0.0;
        $lowStockCount = 0;
        $expiringCount = 0;

        $now = now();
        $thirtyDaysAhead = now()->addDays(30);

        foreach ($products as $product) {
            $stock = $product->branchStocks->first();
            $qty = $stock ? (int) $stock->quantity : 0;
            $location = $stock ? $stock->shelf_location : 'Main Hall - Bay A';

            $product->current_stock = $qty;
            $product->current_location = $location;

            $totalUnits += $qty;
            $cost = (float) ($product->cost_price ?: $product->selling_price ?: 0);
            $totalValuation += $qty * $cost;

            $threshold = (int) ($product->min_alert_qty ?: 15);
            if ($qty <= $threshold) {
                $lowStockCount++;
            }

            if ($product->expiry_date && $product->expiry_date->between($now, $thirtyDaysAhead)) {
                $expiringCount++;
            }
        }

        return view('storekeeper.stock', [
            'tenant' => $tenant,
            'branch' => $branch,
            'products' => $products,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'totalProducts' => $products->count(),
            'totalUnits' => $totalUnits,
            'totalValuation' => $totalValuation,
            'lowStockCount' => $lowStockCount,
            'expiringCount' => $expiringCount,
        ]);
    }

    /**
     * Process Inbound Stock Intake (Goods Received Note - GRN).
     */
    public function receiveGoods(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier_name' => 'nullable|string|max:255',
            'invoice_no' => 'nullable|string|max:100',
            'unit_cost' => 'nullable|numeric|min:0',
            'shelf_location' => 'nullable|string|max:60',
            'notes' => 'nullable|string|max:500',
        ]);

        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);

        $product = Product::where('tenant_id', $tenantId)->findOrFail($request->input('product_id'));
        $qty = (int) $request->input('quantity');
        $unitCost = (float) ($request->input('unit_cost') ?: $product->cost_price ?: 1000);
        $shelfLocation = trim((string) $request->input('shelf_location')) ?: 'Main Hall - Bay A';

        // 1. Increment branch stock
        $branchStock = BranchStock::firstOrCreate(
            ['tenant_id' => $tenantId, 'branch_id' => $branchId, 'product_id' => $product->id],
            ['quantity' => 0, 'shelf_location' => $shelfLocation]
        );

        $branchStock->increment('quantity', $qty);
        if ($request->filled('shelf_location')) {
            $branchStock->update(['shelf_location' => $shelfLocation]);
        }

        // 2. Find or create supplier
        $supplierName = trim((string) $request->input('supplier_name')) ?: 'General Wholesale Supplier';
        $supplier = Supplier::firstOrCreate(
            ['tenant_id' => $tenantId, 'name' => $supplierName],
            ['phone' => '+255 700 000 000', 'is_active' => true]
        );

        // 3. Create verified purchase / GRN entry
        $poNumber = trim((string) $request->input('invoice_no')) ?: 'GRN-'.date('Ymd').'-'.rand(100, 999);
        $totalAmount = $qty * $unitCost;

        $purchase = Purchase::create([
            'tenant_id' => $tenantId,
            'branch_id' => $branchId,
            'supplier_id' => $supplier->id,
            'po_number' => $poNumber,
            'total_amount' => $totalAmount,
            'paid_amount' => $totalAmount,
            'payment_status' => 'paid',
            'status' => 'received',
            'created_by' => Auth::id() ?: session('active_user_id'),
            'notes' => $request->input('notes') ?: "GRN intake of {$qty} units of {$product->name}",
        ]);

        PurchaseItem::create([
            'purchase_id' => $purchase->id,
            'product_id' => $product->id,
            'quantity' => $qty,
            'unit_cost' => $unitCost,
            'subtotal' => $totalAmount,
        ]);

        $message = __("Mzigo wa ':product' (Units :qty) umepokelewa na kuongezwa stoo kikamilifu! Salio jipya: :newStock", [
            'product' => $product->name,
            'qty' => $qty,
            'newStock' => $branchStock->fresh()->quantity,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'product_id' => $product->id,
                'new_stock' => $branchStock->fresh()->quantity,
                'shelf_location' => $branchStock->fresh()->shelf_location,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Process Stock Adjustments (Damages, Shortages, Audits, Recounts).
     */
    public function adjustStock(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'adjustment_type' => 'required|in:damage,shortage,surplus,recount',
            'quantity' => 'required|integer',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);

        $product = Product::where('tenant_id', $tenantId)->findOrFail($request->input('product_id'));
        $type = (string) $request->input('adjustment_type');
        $qty = (int) $request->input('quantity');

        $branchStock = BranchStock::firstOrCreate(
            ['tenant_id' => $tenantId, 'branch_id' => $branchId, 'product_id' => $product->id],
            ['quantity' => 0, 'shelf_location' => 'Main Hall - Bay A']
        );

        $currentQty = $branchStock->quantity;
        $adjustedQty = $currentQty;

        if ($type === 'damage' || $type === 'shortage') {
            $deduct = abs($qty);
            $adjustedQty = max(0, $currentQty - $deduct);
            $branchStock->update(['quantity' => $adjustedQty]);

            // Log damage / shrinkage
            Damage::create([
                'tenant_id' => $tenantId,
                'branch_id' => $branchId,
                'product_id' => $product->id,
                'quantity' => $deduct,
                'reason' => $type === 'damage' ? 'broken' : 'lost',
                'recorded_by' => Auth::id() ?: session('active_user_id'),
                'total_loss' => $deduct * (float) ($product->cost_price ?: $product->selling_price),
                'notes' => ($request->input('reason') ?: 'Storekeeper stock audit').($request->filled('notes') ? ' - '.$request->input('notes') : ''),
            ]);
        } elseif ($type === 'surplus') {
            $add = abs($qty);
            $adjustedQty = $currentQty + $add;
            $branchStock->update(['quantity' => $adjustedQty]);
        } elseif ($type === 'recount') {
            $adjustedQty = max(0, $qty);
            $diff = $adjustedQty - $currentQty;
            $branchStock->update(['quantity' => $adjustedQty]);

            if ($diff < 0) {
                Damage::create([
                    'tenant_id' => $tenantId,
                    'branch_id' => $branchId,
                    'product_id' => $product->id,
                    'quantity' => abs($diff),
                    'reason' => 'other',
                    'recorded_by' => Auth::id() ?: session('active_user_id'),
                    'total_loss' => abs($diff) * (float) ($product->cost_price ?: $product->selling_price),
                    'notes' => 'Recount audit adjustment: '.($request->input('notes') ?: 'Shortage discrepancy reconciled'),
                ]);
            }
        }

        $message = __("Marekebisho ya stoo kwa ':product' yamekamilika! Idadi mpya: :qty", [
            'product' => $product->name,
            'qty' => $adjustedQty,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'product_id' => $product->id,
                'new_stock' => $adjustedQty,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Store new product directly from Storekeeper panel.
     */
    public function storeProduct(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|max:60',
            'sku' => 'nullable|string|max:60',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'initial_stock' => 'nullable|integer|min:0',
            'min_alert_qty' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:30',
            'shelf_location' => 'nullable|string|max:60',
        ]);

        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);

        $sku = $request->filled('sku')
            ? strtoupper(trim((string) $request->input('sku')))
            : 'SKU-'.strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $request->input('name')), 0, 3)).'-'.rand(100, 999);

        $product = Product::create([
            'tenant_id' => $tenantId,
            'category_id' => $request->input('category_id'),
            'name' => trim((string) $request->input('name')),
            'barcode' => $request->input('barcode') ?: (string) rand(61600000000, 61699999999),
            'sku' => $sku,
            'cost_price' => (float) $request->input('cost_price'),
            'selling_price' => (float) $request->input('selling_price'),
            'wholesale_price' => (float) ($request->input('selling_price') * 0.92),
            'min_alert_qty' => (int) ($request->input('min_alert_qty') ?: 15),
            'unit' => $request->input('unit') ?: 'pcs',
            'is_active' => true,
        ]);

        $initialStock = (int) ($request->input('initial_stock') ?: 0);
        $shelfLocation = trim((string) $request->input('shelf_location')) ?: 'Main Hall - Bay A';

        BranchStock::create([
            'tenant_id' => $tenantId,
            'branch_id' => $branchId,
            'product_id' => $product->id,
            'quantity' => $initialStock,
            'shelf_location' => $shelfLocation,
        ]);

        $message = __("Bidhaa ':name' imeongezwa kwenye mfumo wa stoo kikamilifu!", ['name' => $product->name]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'product' => $product,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update shelf/bin location for a product.
     */
    public function updateLocation(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $request->validate([
            'shelf_location' => 'required|string|max:60',
        ]);

        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);

        if ($product->tenant_id !== $tenantId) {
            abort(403);
        }

        $location = trim((string) $request->input('shelf_location'));

        $branchStock = BranchStock::firstOrCreate(
            ['tenant_id' => $tenantId, 'branch_id' => $branchId, 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $branchStock->update(['shelf_location' => $location]);

        $message = __("Eneo la rafu kwa ':product' limesasishwa kuwa :location", [
            'product' => $product->name,
            'location' => $location,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'shelf_location' => $location,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Stream CSV export of current warehouse inventory and valuation.
     */
    public function exportValuation(): StreamedResponse
    {
        $tenantId = $this->resolveActiveTenantId();
        $branchId = $this->resolveActiveBranchId($tenantId);
        $tenant = Tenant::find($tenantId);

        $products = Product::where('tenant_id', $tenantId)
            ->with(['category', 'branchStocks' => fn ($q) => $q->where('branch_id', $branchId)])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="mercanto_warehouse_inventory_'.date('Y-m-d').'.csv"',
        ];

        return response()->stream(function () use ($products) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            // CSV Header Row
            fputcsv($handle, [
                'Product Name',
                'Category',
                'SKU',
                'Barcode',
                'Shelf Location',
                'Stock Quantity',
                'Unit',
                'Cost Price (TZS)',
                'Retail Price (TZS)',
                'Total Valuation (TZS)',
            ]);

            foreach ($products as $p) {
                $qty = $p->branchStocks->first()?->quantity ?? 0;
                $cost = (float) ($p->cost_price ?: 0);
                $retail = (float) ($p->selling_price ?: 0);
                $val = $qty * $cost;

                fputcsv($handle, [
                    $p->name,
                    $p->category?->name ?? 'General',
                    $p->sku,
                    $p->barcode,
                    $p->branchStocks->first()?->shelf_location ?? 'Main Floor',
                    $qty,
                    $p->unit,
                    number_format($cost, 2, '.', ''),
                    number_format($retail, 2, '.', ''),
                    number_format($val, 2, '.', ''),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Resolve active tenant ID from session, auth user, or fallback.
     */
    protected function resolveActiveTenantId(): int
    {
        if (session()->has('tenant_id') && session('tenant_id')) {
            return (int) session('tenant_id');
        }

        if (Auth::check() && Auth::user()->tenant_id) {
            return (int) Auth::user()->tenant_id;
        }

        $fallback = Tenant::first();

        return $fallback ? (int) $fallback->id : 1;
    }

    /**
     * Resolve active branch ID from session, auth user, or fallback.
     */
    protected function resolveActiveBranchId(int $tenantId): int
    {
        if (session()->has('branch_id') && session('branch_id')) {
            return (int) session('branch_id');
        }

        if (Auth::check() && Auth::user()->branch_id) {
            return (int) Auth::user()->branch_id;
        }

        $mainBranch = Branch::where('tenant_id', $tenantId)->first();

        return $mainBranch ? (int) $mainBranch->id : 1;
    }
}
