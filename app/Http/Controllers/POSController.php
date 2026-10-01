<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Shift;
use App\Models\Tenant;
use App\Models\WhatsappMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class POSController extends Controller
{
    /**
     * Display POS Kaunta Interface.
     */
    public function index(Request $request): View
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;
        $userId = Auth::id() ?? 1;

        $businessMode = session('business_mode', 'retailer');
        $isWholesale = $businessMode === 'wholesaler';

        // Check if cashier has active open shift
        $activeShift = Shift::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->latest('opened_at')
            ->first();

        $categories = Category::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with(['subCategories' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();

        $customers = Customer::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with('wallet')
            ->orderBy('name')
            ->get();

        return view('cashier.dashboard', [
            'activeShift' => $activeShift,
            'categories' => $categories,
            'customers' => $customers,
            'isWholesale' => $isWholesale,
            'tenantId' => $tenantId,
            'branchId' => $branchId,
        ]);
    }

    /**
     * Search products for POS catalog and barcode scanner.
     */
    public function search(Request $request): JsonResponse
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;
        $query = trim((string) $request->input('q', ''));
        $categoryId = $request->input('category_id');
        $isWholesale = session('business_mode') === 'wholesaler';

        $productsQuery = Product::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->with([
                'category',
                'subCategory',
                'branchStocks' => fn ($q) => $q->where('branch_id', $branchId),
                'batches' => fn ($q) => $q->where('branch_id', $branchId)->active()->fefo(),
            ]);

        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        if ($query !== '') {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('barcode', $query)
                    ->orWhere('sku', 'LIKE', "%{$query}%");
            });
        }

        $products = $productsQuery->orderBy('name')->limit(50)->get()->map(function (Product $product) use ($branchId, $isWholesale) {
            $stock = $product->getStockForBranch($branchId);
            $nearestBatch = $product->getNearestExpiringBatch($branchId);
            $price = ($isWholesale && $product->wholesale_price && $product->wholesale_price > 0)
                ? (float) $product->wholesale_price
                : (float) $product->selling_price;

            return [
                'id' => $product->id,
                'name' => $product->name,
                'barcode' => $product->barcode,
                'sku' => $product->sku,
                'category' => $product->category?->name ?? 'General',
                'sub_category' => $product->subCategory?->name ?? '',
                'unit' => $product->unit ?? 'pcs',
                'price' => $price,
                'stock' => $stock,
                'nearest_batch' => $nearestBatch ? [
                    'id' => $nearestBatch->id,
                    'batch_number' => $nearestBatch->batch_number,
                    'expiry_date' => $nearestBatch->expiry_date?->format('d/m/Y'),
                    'days_remaining' => $nearestBatch->days_until_expiry,
                ] : null,
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    /**
     * Process checkout and finalize sale with atomic DB transaction.
     */
    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.qty' => 'required|numeric|min:1',
            'cart.*.price' => 'required|numeric|min:0',
            'cart.*.batch_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'customer_id' => 'nullable|integer',
            'tendered_amount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;
        $userId = Auth::id() ?? 1;

        // Ensure active shift exists or auto-open a general shift
        $shift = Shift::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->latest('opened_at')
            ->first();

        if (! $shift) {
            $shift = Shift::create([
                'tenant_id' => $tenantId,
                'branch_id' => $branchId,
                'user_id' => $userId,
                'shift_code' => 'SHF-'.date('Ymd-His'),
                'opening_float' => 0,
                'status' => 'open',
                'opened_at' => now(),
            ]);
        }

        try {
            DB::beginTransaction();

            $subtotal = 0;
            foreach ($validated['cart'] as $item) {
                $subtotal += ((float) $item['price'] * (float) $item['qty']);
            }

            $discount = (float) ($validated['discount'] ?? 0);
            $tax = round($subtotal * 0.18, 2); // 18% standard VAT calculation
            $grandTotal = max(0, $subtotal - $discount);
            $paidAmount = (float) ($validated['tendered_amount'] ?? $grandTotal);
            $changeAmount = max(0, $paidAmount - $grandTotal);
            $paymentMethod = strtolower($validated['payment_method']);

            $invoiceNo = 'EDK-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -5));

            // Create Sale Record
            $sale = Sale::create([
                'tenant_id' => $tenantId,
                'branch_id' => $branchId,
                'shift_id' => $shift->id,
                'cashier_id' => $userId,
                'customer_id' => $validated['customer_id'] ?? null,
                'invoice_no' => $invoiceNo,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'paid_amount' => $paidAmount,
                'change_amount' => $changeAmount,
                'payment_method' => in_array($paymentMethod, ['cash', 'card', 'mpesa', 'airtel', 'tigopesa', 'bank', 'wallet', 'credit', 'split']) ? $paymentMethod : 'cash',
                'payment_status' => ($paymentMethod === 'credit') ? 'due' : 'paid',
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Process Items, FEFO Batches, and Branch Stock Deductions
            foreach ($validated['cart'] as $item) {
                $product = Product::find($item['id']);
                if (! $product) {
                    continue;
                }

                $qtyToDeduct = (int) $item['qty'];
                $itemPrice = (float) $item['price'];
                $lineSubtotal = $qtyToDeduct * $itemPrice;

                // Pick Batch (either specified or FEFO)
                $batch = null;
                if (! empty($item['batch_id'])) {
                    $batch = Batch::find($item['batch_id']);
                } else {
                    $batch = $product->getNearestExpiringBatch($branchId);
                }

                if ($batch && $batch->quantity >= $qtyToDeduct) {
                    $batch->decrement('quantity', $qtyToDeduct);
                }

                // Deduct from branch_stocks table
                $branchStock = BranchStock::firstOrCreate([
                    'tenant_id' => $tenantId,
                    'branch_id' => $branchId,
                    'product_id' => $product->id,
                ], [
                    'quantity' => 0,
                ]);
                $branchStock->decrement('quantity', $qtyToDeduct);

                // Create Sale Item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'batch_id' => $batch?->id,
                    'quantity' => $qtyToDeduct,
                    'unit_price' => $itemPrice,
                    'cost_price' => $batch?->cost_price ?? $product->cost_price,
                    'discount' => 0,
                    'subtotal' => $lineSubtotal,
                ]);
            }

            // Update Shift Register Financials
            if ($paymentMethod === 'cash') {
                $shift->increment('cash_sales', $grandTotal);
            } else {
                $shift->increment('digital_sales', $grandTotal);
            }

            // Customer Loyalty & Wallet Handling
            $whatsappUrl = null;
            if (! empty($validated['customer_id'])) {
                $customer = Customer::find($validated['customer_id']);
                if ($customer) {
                    // Award 1 loyalty point per 10,000 TZS
                    $pointsEarned = (int) floor($grandTotal / 10000);
                    if ($pointsEarned > 0) {
                        $customer->increment('loyalty_points', $pointsEarned);
                    }

                    // Debit wallet if paid via wallet
                    if ($paymentMethod === 'wallet') {
                        $wallet = $customer->getOrCreateWallet();
                        $wallet->debit($grandTotal, "Malipo ya Mauzo #{$invoiceNo}", $invoiceNo, $userId);
                    } elseif ($paymentMethod === 'credit') {
                        $customer->increment('balance_due', $grandTotal);
                    }

                    // Queue WhatsApp Digital Receipt
                    if ($customer->phone) {
                        $tenant = Tenant::find($tenantId);
                        $storeName = $tenant?->name ?? 'Mercanto Store';
                        $waMessage = "🧾 *Risiti ya Mauzo - {$storeName}*\n"
                            ."Namba ya Risiti: *#{$invoiceNo}*\n"
                            .'Mteja: '.htmlspecialchars($customer->name)."\n"
                            .'Jumla Kuu: *TSh '.number_format($grandTotal)."*\n"
                            .'Njia ya Malipo: *'.strtoupper($paymentMethod)."*\n"
                            .'Tarehe: '.date('d/m/Y H:i')."\n\n"
                            .'Asante sana kwa kufanya manunuzi nasi! Karibu tena.';

                        $waRecord = WhatsappMessage::create([
                            'tenant_id' => $tenantId,
                            'customer_id' => $customer->id,
                            'sale_id' => $sale->id,
                            'recipient_phone' => $customer->phone,
                            'message_type' => 'receipt',
                            'message' => $waMessage,
                            'status' => 'sent',
                            'sent_at' => now(),
                        ]);

                        $whatsappUrl = $waRecord->whatsapp_url;
                    }
                }
            }

            // Record in Audit Log
            AuditLog::create([
                'tenant_id' => $tenantId,
                'user_id' => $userId,
                'action' => 'POS Checkout',
                'module' => 'pos',
                'description' => "POS Checkout #{$invoiceNo} - TSh ".number_format($grandTotal)." ({$paymentMethod})",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mauzo yamekamilika kikamilifu!',
                'sale' => [
                    'id' => $sale->id,
                    'invoice_no' => $invoiceNo,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'grand_total' => $grandTotal,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount,
                    'payment_method' => $paymentMethod,
                    'created_at' => $sale->created_at->format('d/m/Y H:i'),
                ],
                'whatsapp_url' => $whatsappUrl,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Hitilafu wakati wa kukamilisha mauzo: '.$e->getMessage(),
            ], 422);
        }
    }

    /**
     * Open Cash Register Shift with Opening Float.
     */
    public function openShift(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'opening_float' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;
        $userId = Auth::id() ?? 1;

        // Check if already open
        $existing = Shift::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => 'Una shift iliyo wazi tayari.',
                'shift' => $existing,
            ]);
        }

        $shift = Shift::create([
            'tenant_id' => $tenantId,
            'branch_id' => $branchId,
            'user_id' => $userId,
            'shift_code' => 'SHF-'.date('Ymd-His'),
            'opening_float' => (float) $validated['opening_float'],
            'cash_sales' => 0,
            'digital_sales' => 0,
            'status' => 'open',
            'opened_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kaunta imefunguliwa kikamilifu!',
            'shift' => $shift,
        ]);
    }

    /**
     * Close Shift and Reconcile Physical Cash vs Expected Cash.
     */
    public function closeShift(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'closing_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;
        $userId = Auth::id() ?? 1;

        $shift = Shift::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->latest('opened_at')
            ->first();

        if (! $shift) {
            return response()->json([
                'success' => false,
                'message' => 'Hakuna shift iliyo wazi kwa sasa.',
            ], 422);
        }

        $physicalCash = (float) $validated['closing_cash'];
        $expectedCash = (float) $shift->opening_float + (float) $shift->cash_sales;
        $variance = $physicalCash - $expectedCash;

        $shift->update([
            'closing_cash' => $physicalCash,
            'difference' => $variance,
            'status' => 'closed',
            'closed_at' => now(),
            'notes' => $validated['notes'] ?? $shift->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shift imefungwa kikamilifu.',
            'summary' => [
                'shift_code' => $shift->shift_code,
                'opening_float' => (float) $shift->opening_float,
                'cash_sales' => (float) $shift->cash_sales,
                'digital_sales' => (float) $shift->digital_sales,
                'total_sales' => (float) ($shift->cash_sales + $shift->digital_sales),
                'expected_cash' => $expectedCash,
                'actual_cash' => $physicalCash,
                'variance' => $variance,
                'opened_at' => $shift->opened_at?->format('d/m/Y H:i'),
                'closed_at' => $shift->closed_at?->format('d/m/Y H:i'),
            ],
        ]);
    }
}
