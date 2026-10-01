<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Branch;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Supplier;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InventoryManagementController extends Controller
{
    /**
     * Display 3-tab Inventory Hub: In-Stock, Low Stock, Expired/Near-Expiry Batches.
     */
    public function index(Request $request): View
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;

        $categories = Category::where('tenant_id', $tenantId)->where('is_active', true)->with('subCategories')->get();
        $subCategories = SubCategory::where('tenant_id', $tenantId)->where('is_active', true)->get();
        $suppliers = Supplier::where('tenant_id', $tenantId)->get();

        // 1. In Stock Products
        $inStockProducts = Product::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with(['category', 'subCategory', 'branchStocks' => fn ($q) => $q->where('branch_id', $branchId)])
            ->whereHas('branchStocks', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->where('quantity', '>', 0);
            })
            ->orderBy('name')
            ->get();

        // 2. Low Stock & Out of Stock
        $lowStockProducts = Product::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with(['category', 'subCategory', 'branchStocks' => fn ($q) => $q->where('branch_id', $branchId)])
            ->where(function ($query) use ($branchId) {
                $query->whereDoesntHave('branchStocks', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId)->where('quantity', '>', 0);
                })->orWhereHas('branchStocks', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId)->whereRaw('quantity <= products.min_alert_qty');
                });
            })
            ->orderBy('name')
            ->get();

        // 3. Batches near expiry or expired
        $batchesAlert = Batch::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->where('quantity', '>', 0)
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', Carbon::today()->addDays(60))
            ->with(['product', 'supplier'])
            ->orderBy('expiry_date')
            ->get();

        return view('manager.inventory', [
            'inStockProducts' => $inStockProducts,
            'lowStockProducts' => $lowStockProducts,
            'batchesAlert' => $batchesAlert,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'suppliers' => $suppliers,
            'branchId' => $branchId,
        ]);
    }

    /**
     * Store new batch for a product.
     */
    public function storeBatch(Request $request): RedirectResponse
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'manufacture_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        DB::transaction(function () use ($validated, $product, $tenantId, $branchId) {
            $qty = (int) $validated['quantity'];

            // Create batch
            Batch::create([
                'tenant_id' => $tenantId,
                'branch_id' => $branchId,
                'product_id' => $product->id,
                'supplier_id' => $validated['supplier_id'] ?? null,
                'batch_number' => $validated['batch_number'],
                'quantity' => $qty,
                'initial_quantity' => $qty,
                'cost_price' => (float) ($validated['cost_price'] ?? $product->cost_price),
                'selling_price' => (float) ($validated['selling_price'] ?? $product->selling_price),
                'manufacture_date' => $validated['manufacture_date'] ?? null,
                'expiry_date' => $validated['expiry_date'] ?? null,
                'status' => 'active',
            ]);

            // Increment branch stock
            $branchStock = BranchStock::firstOrCreate([
                'tenant_id' => $tenantId,
                'branch_id' => $branchId,
                'product_id' => $product->id,
            ], [
                'quantity' => 0,
            ]);
            $branchStock->increment('quantity', $qty);
        });

        return redirect()->back()->with('success', 'Batch mpya ya bidhaa imehifadhiwa na stoo imeongezwa!');
    }

    /**
     * Store new sub-category.
     */
    public function storeSubCategory(Request $request): RedirectResponse
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        SubCategory::create([
            'tenant_id' => $tenantId,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Kategoria ndogo (Sub-Category) imeongezwa kikamilifu!');
    }

    /**
     * Export Inventory Valuation CSV.
     */
    public function exportValuation(Request $request): StreamedResponse
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;

        $products = Product::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with(['category', 'subCategory', 'branchStocks' => fn ($q) => $q->where('branch_id', $branchId)])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="mercanto-stock-valuation-'.date('Ymd-His').'.csv"',
        ];

        return response()->stream(function () use ($products, $branchId) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Product Code / SKU', 'Product Name', 'Category', 'Sub-Category', 'Quantity', 'Cost Price (TZS)', 'Selling Price (TZS)', 'Total Valuation (Cost TZS)', 'Total Potential (Sales TZS)']);

            $totalValuation = 0;
            $totalSales = 0;

            foreach ($products as $p) {
                $qty = $p->getStockForBranch($branchId);
                $costVal = $qty * (float) $p->cost_price;
                $sellVal = $qty * (float) $p->selling_price;
                $totalValuation += $costVal;
                $totalSales += $sellVal;

                fputcsv($handle, [
                    $p->sku ?? $p->barcode ?? $p->id,
                    $p->name,
                    $p->category?->name ?? 'General',
                    $p->subCategory?->name ?? '-',
                    $qty,
                    number_format((float) $p->cost_price, 2, '.', ''),
                    number_format((float) $p->selling_price, 2, '.', ''),
                    number_format($costVal, 2, '.', ''),
                    number_format($sellVal, 2, '.', ''),
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['JUMLA KUU', '', '', '', '', '', '', number_format($totalValuation, 2, '.', ''), number_format($totalSales, 2, '.', '')]);

            fclose($handle);
        }, 200, $headers);
    }
}
