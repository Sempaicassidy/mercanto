<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tenant;
use App\Models\WhatsappMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display list of customers with wallet balances and debt ledgers.
     */
    public function index(Request $request): View
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;

        $customers = Customer::where('tenant_id', $tenantId)
            ->with(['wallet', 'sales' => fn ($q) => $q->latest()->limit(5)])
            ->orderBy('name')
            ->paginate(25);

        $totalCustomers = Customer::where('tenant_id', $tenantId)->count();
        $totalDebt = (float) Customer::where('tenant_id', $tenantId)->sum('balance_due');
        $owingCount = Customer::where('tenant_id', $tenantId)->where('balance_due', '>', 0)->count();
        $cleanCount = Customer::where('tenant_id', $tenantId)->where('balance_due', '<=', 0)->count();

        return view('manager.customers', [
            'customers' => $customers,
            'totalCustomers' => $totalCustomers,
            'totalDebt' => $totalDebt,
            'owingCount' => $owingCount,
            'cleanCount' => $cleanCount,
        ]);
    }

    /**
     * Store new customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'customer_type' => 'required|in:retail,wholesale',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $customer = Customer::create([
            'tenant_id' => $tenantId,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'customer_type' => $validated['customer_type'],
            'credit_limit' => (float) ($validated['credit_limit'] ?? 0),
            'loyalty_points' => 0,
            'balance_due' => 0,
            'is_active' => true,
        ]);

        // Initialize wallet
        $customer->getOrCreateWallet();

        return redirect()->back()->with('success', 'Mteja amesajiliwa kikamilifu!');
    }

    /**
     * Deposit funds into customer wallet.
     */
    public function depositWallet(Request $request, Customer $customer): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'description' => 'nullable|string',
            'reference' => 'nullable|string',
        ]);

        $amount = (float) $validated['amount'];
        $wallet = $customer->getOrCreateWallet();
        $txn = $wallet->deposit(
            $amount,
            $validated['description'] ?? 'Amana ya Pochi / Wallet Deposit',
            $validated['reference'] ?? 'DEP-'.date('Ymd-His'),
            Auth::id()
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Salio la TSh '.number_format($amount).' limewekwa kwenye pochi ya mteja.',
                'wallet_balance' => (float) $wallet->balance,
                'transaction' => $txn,
            ]);
        }

        return redirect()->back()->with('success', 'Salio la TSh '.number_format($amount).' limewekwa kwenye pochi ya mteja.');
    }

    /**
     * Send WhatsApp notification to customer (Receipt / Debt reminder / Promo).
     */
    public function sendWhatsApp(Request $request, Customer $customer): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'message_type' => 'required|in:debt_reminder,receipt,promo,custom',
            'custom_message' => 'nullable|string',
        ]);

        if (! $customer->phone) {
            return back()->with('error', 'Mteja hana namba ya simu iliyosajiliwa.');
        }

        $tenant = $customer->tenant ?? Tenant::find($customer->tenant_id);
        $storeName = $tenant?->name ?? 'Mercanto Store';
        $type = $validated['message_type'];

        if ($type === 'debt_reminder') {
            $message = "⚠️ *Taarifa ya Deni - {$storeName}*\n"
                ."Hujambo {$customer->name},\n"
                .'Tafadhali kumbuka una deni la *TSh '.number_format($customer->balance_due)."* katika duka letu.\n"
                .'Tafadhali wasiliana nasi au fika dukani kulipia. Asante sana!';
        } elseif ($type === 'promo') {
            $message = "🎉 *Ofa Maalum - {$storeName}*\n"
                ."Habari {$customer->name}! Tuna bidhaa mpya na ofa maalum wiki hii katika duka letu la jumla na rejareja. Karibu tukuhudumie!";
        } else {
            $message = $validated['custom_message'] ?? "Habari {$customer->name}, kutoka {$storeName}.";
        }

        $waRecord = WhatsappMessage::create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'recipient_phone' => $customer->phone,
            'message_type' => $type,
            'message' => $message,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'whatsapp_url' => $waRecord->whatsapp_url,
                'message' => 'Ujumbe wa WhatsApp umehifadhiwa na kiungo kimeandaliwa.',
            ]);
        }

        return redirect()->away($waRecord->whatsapp_url);
    }
}
