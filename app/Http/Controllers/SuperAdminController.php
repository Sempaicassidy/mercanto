<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Contract;
use App\Models\SupportTicket;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Display the Global SaaS Super Admin Platform Dashboard.
     */
    public function dashboard(): View
    {
        $tenantsCount = Tenant::count();
        $activeTenantsCount = Tenant::where('status', 'active')->count();
        $trialTenantsCount = Tenant::where('status', 'trial')->count();
        $suspendedTenantsCount = Tenant::where('status', 'suspended')->count();

        $branchesCount = Branch::count();
        $usersCount = User::where('role', '!=', 'super_admin')->count();

        // Financial & Contract KPIs
        $contractsCount = Contract::count();
        $activeContractsCount = Contract::where('status', 'active')->count();
        $totalLeaseRevenue = (float) Contract::where('status', 'active')->sum('amount');
        $expiringContractsCount = Contract::where('status', 'active')
            ->whereDate('end_date', '<=', now()->addDays(45))
            ->whereDate('end_date', '>=', now())
            ->count();

        // Support Tickets KPIs
        $openTicketsCount = SupportTicket::whereIn('status', ['open', 'in_progress'])->count();
        $urgentTicketsCount = SupportTicket::whereIn('status', ['open', 'in_progress'])
            ->where('priority', 'urgent')
            ->count();
        $resolvedTicketsCount = SupportTicket::where('status', 'resolved')->count();

        // Recent items
        $recentTenants = Tenant::with(['branches', 'activeContract'])
            ->withCount(['branches', 'users'])
            ->latest()
            ->take(5)
            ->get();

        $recentContracts = Contract::with('tenant')
            ->latest()
            ->take(5)
            ->get();

        $recentTickets = SupportTicket::with('tenant')
            ->latest()
            ->take(5)
            ->get();

        return view('super_admin.dashboard', compact(
            'tenantsCount',
            'activeTenantsCount',
            'trialTenantsCount',
            'suspendedTenantsCount',
            'branchesCount',
            'usersCount',
            'contractsCount',
            'activeContractsCount',
            'totalLeaseRevenue',
            'expiringContractsCount',
            'openTicketsCount',
            'urgentTicketsCount',
            'resolvedTicketsCount',
            'recentTenants',
            'recentContracts',
            'recentTickets'
        ));
    }

    /**
     * Display all registered SaaS tenants and stores with search and filters.
     */
    public function tenants(Request $request): View
    {
        $statusFilter = $request->query('status');
        $typeFilter = $request->query('type');
        $search = trim((string) $request->query('search'));

        $query = Tenant::with(['branches', 'activeContract'])
            ->withCount(['branches', 'users']);

        if (! empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }

        if (! empty($typeFilter)) {
            $query->where('business_type', $typeFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('tin_number', 'like', "%{$search}%");
            });
        }

        $tenants = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'total' => Tenant::count(),
            'active' => Tenant::where('status', 'active')->count(),
            'trial' => Tenant::where('status', 'trial')->count(),
            'suspended' => Tenant::where('status', 'suspended')->count(),
        ];

        return view('super_admin.tenants', compact('tenants', 'counts', 'statusFilter', 'typeFilter', 'search'));
    }

    /**
     * Register a new SaaS Tenant and provision its main branch, admin user, and initial lease.
     */
    public function storeTenant(Request $request): RedirectResponse
    {
        // Support aliases
        if ($request->filled('lease_fee') && ! $request->filled('lease_amount')) {
            $request->merge(['lease_amount' => $request->input('lease_fee')]);
        }
        if ($request->filled('billing_cycle') && ! $request->filled('lease_billing_cycle')) {
            $request->merge(['lease_billing_cycle' => $request->input('billing_cycle')]);
        }
        if ($request->filled('admin_name') && ! $request->filled('manager_name')) {
            $request->merge(['manager_name' => $request->input('admin_name')]);
        }
        if ($request->filled('admin_email') && ! $request->filled('manager_email')) {
            $request->merge(['manager_email' => $request->input('admin_email')]);
        }
        if ($request->filled('admin_password') && ! $request->filled('manager_password')) {
            $request->merge(['manager_password' => $request->input('admin_password')]);
        }
        if (! $request->filled('plan_title') && $request->filled('name')) {
            $request->merge(['plan_title' => $request->input('name').' SaaS Lease']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'required|in:retailer,wholesaler,supplier,hybrid',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:10',
            'plan_title' => 'required|string|max:255',
            'lease_amount' => 'required|numeric|min:0',
            'lease_billing_cycle' => 'required|in:monthly,quarterly,annual,annually',
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|email|unique:users,email|max:255',
            'manager_password' => 'required|string|min:6',
        ]);

        $billingCycle = in_array($validated['lease_billing_cycle'], ['annual', 'annually'], true) ? 'annually' : $validated['lease_billing_cycle'];
        $businessType = in_array($validated['business_type'], ['supplier', 'wholesaler'], true) ? 'supplier' : $validated['business_type'];

        DB::transaction(function () use ($validated, $billingCycle, $businessType) {
            // 1. Generate unique slug
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Tenant::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }

            // 2. Create Tenant
            $tenant = Tenant::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'business_type' => $businessType,
                'status' => 'active',
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'tin_number' => $validated['tin_number'] ?? null,
                'currency' => $validated['currency'] ?? 'TZS',
                'settings' => [
                    'tax_rate' => 18,
                    'allow_credit_sales' => true,
                ],
            ]);

            // 3. Create Default HQ Branch
            $branch = Branch::create([
                'tenant_id' => $tenant->id,
                'name' => 'Main Branch (HQ)',
                'code' => 'HQ-01',
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_main' => true,
                'is_active' => true,
            ]);

            // 4. Create Manager User
            User::create([
                'tenant_id' => $tenant->id,
                'branch_id' => $branch->id,
                'name' => $validated['manager_name'],
                'email' => $validated['manager_email'],
                'password' => Hash::make($validated['manager_password']),
                'role' => 'manager',
                'phone' => $validated['phone'] ?? null,
                'status' => 'active',
            ]);

            // 5. Create Initial SaaS Contract / Lease
            $contractNumber = 'CNT-'.date('Y').'-'.str_pad((string) (Contract::count() + 1), 4, '0', STR_PAD_LEFT);
            $endDate = match ($billingCycle) {
                'monthly' => now()->addMonth(),
                'quarterly' => now()->addMonths(3),
                default => now()->addYear(),
            };

            Contract::create([
                'tenant_id' => $tenant->id,
                'contract_number' => $contractNumber,
                'title' => $validated['plan_title'],
                'type' => 'lease',
                'billing_cycle' => $billingCycle,
                'amount' => $validated['lease_amount'],
                'currency' => $validated['currency'] ?? 'TZS',
                'start_date' => now(),
                'end_date' => $endDate,
                'status' => 'active',
                'payment_status' => 'paid',
                'sla_terms' => 'Standard Cloud SLA, 99.9% Uptime, Regular data backups, Helpdesk technical support.',
                'notes' => 'New SaaS tenant onboarded via Super Admin Command Center.',
            ]);
        });

        return redirect()->route('super_admin.tenants')
            ->with('success', __('Duka/Tenant jipya limefanikiwa kusajiliwa pamoja na tawi lake kuu na mkataba wa kuanzia!'));
    }

    /**
     * Update status of a tenant (active, suspended, trial).
     */
    public function updateTenantStatus(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:active,suspended,trial',
        ]);

        $tenant->update(['status' => $validated['status']]);

        $statusLabels = [
            'active' => 'limewashwa (Active)',
            'suspended' => 'limesimamishwa (Suspended)',
            'trial' => 'limewekwa kwenye Jaribio (Trial)',
        ];

        return redirect()->back()
            ->with('success', "Duka la {$tenant->name} {$statusLabels[$validated['status']]}.");
    }

    /**
     * Display all SaaS Contracts and Store Leases.
     */
    public function contracts(Request $request): View
    {
        $statusFilter = $request->query('status');
        $typeFilter = $request->query('type');
        $search = trim((string) $request->query('search'));

        $query = Contract::with('tenant');

        if (! empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }

        if (! empty($typeFilter)) {
            $query->where('type', $typeFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('contract_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('tenant', function ($tq) use ($search) {
                        $tq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $contracts = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'total' => Contract::count(),
            'active' => Contract::where('status', 'active')->count(),
            'expiring_soon' => Contract::where('status', 'active')
                ->whereDate('end_date', '<=', now()->addDays(45))
                ->whereDate('end_date', '>=', now())
                ->count(),
            'pending_payment' => Contract::where('payment_status', 'pending')->count(),
            'total_value' => (float) Contract::where('status', 'active')->sum('amount'),
        ];

        $allTenants = Tenant::orderBy('name')->get(['id', 'name', 'business_type', 'currency']);

        return view('super_admin.contracts', compact('contracts', 'counts', 'allTenants', 'statusFilter', 'typeFilter', 'search'));
    }

    /**
     * Store a new SaaS contract or store lease.
     */
    public function storeContract(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:lease,subscription,custom_license,service_agreement',
            'billing_cycle' => 'required|in:monthly,quarterly,annual,annually,one_time',
            'amount' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|in:active,pending,grace_period',
            'payment_status' => 'required|in:paid,partial,pending,overdue',
            'sla_terms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $billingCycle = in_array($validated['billing_cycle'], ['annual', 'annually'], true) ? 'annually' : $validated['billing_cycle'];
        $contractNumber = 'CNT-'.date('Y').'-'.str_pad((string) (Contract::count() + 1), 4, '0', STR_PAD_LEFT);

        Contract::create([
            'tenant_id' => $validated['tenant_id'],
            'contract_number' => $contractNumber,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'billing_cycle' => $billingCycle,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'] ?? 'TZS',
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'] ?? 'active',
            'payment_status' => $validated['payment_status'],
            'sla_terms' => $validated['sla_terms'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('super_admin.contracts')
            ->with('success', __('Mkataba / Lease mpya imehifadhiwa kikamilifu!'));
    }

    /**
     * Update contract status, renewal, or payment status.
     */
    public function updateContractStatus(Request $request, Contract $contract): RedirectResponse
    {
        if ($request->has('action') && $request->input('action') === 'renew') {
            // Renew contract for +1 year or +1 month
            $monthsToAdd = $contract->billing_cycle === 'monthly' ? 1 : 12;
            $newStartDate = $contract->end_date->isPast() ? now() : $contract->end_date;
            $newEndDate = (clone $newStartDate)->addMonths($monthsToAdd);

            $contract->update([
                'start_date' => $newStartDate,
                'end_date' => $newEndDate,
                'status' => 'active',
                'payment_status' => 'paid',
                'notes' => ($contract->notes ? $contract->notes."\n" : '').'Renewed on '.now()->toFormattedDateString(),
            ]);

            return redirect()->back()
                ->with('success', "Mkataba {$contract->contract_number} umehuishwa (Renewed) hadi ".$newEndDate->toFormattedDateString().'.');
        }

        $validated = $request->validate([
            'status' => 'nullable|in:active,pending,expired,terminated,grace_period',
            'payment_status' => 'nullable|in:paid,partial,pending,overdue',
        ]);

        $contract->update(array_filter($validated));

        return redirect()->back()
            ->with('success', "Mkataba {$contract->contract_number} umesasishwa.");
    }

    /**
     * Display SaaS Support & Helpdesk Tickets.
     */
    public function support(Request $request): View
    {
        $statusFilter = $request->query('status');
        $priorityFilter = $request->query('priority');
        $categoryFilter = $request->query('category');
        $search = trim((string) $request->query('search'));

        $query = SupportTicket::with(['tenant', 'user', 'assignedAgent']);

        if (! empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }

        if (! empty($priorityFilter)) {
            $query->where('priority', $priorityFilter);
        }

        if (! empty($categoryFilter)) {
            $query->where('category', $categoryFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('tenant', function ($tq) use ($search) {
                        $tq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'total' => SupportTicket::count(),
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'urgent' => SupportTicket::whereIn('status', ['open', 'in_progress'])->where('priority', 'urgent')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
        ];

        $allTenants = Tenant::orderBy('name')->get(['id', 'name']);

        return view('super_admin.support', compact('tickets', 'counts', 'allTenants', 'statusFilter', 'priorityFilter', 'categoryFilter', 'search'));
    }

    /**
     * Store a new support ticket.
     */
    public function storeSupportTicket(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'subject' => 'required|string|max:255',
            'category' => 'required|in:technical,billing,pos_hardware,hardware,feature_request,training,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'description' => 'required|string',
        ]);

        $category = in_array($validated['category'], ['hardware', 'pos_hardware'], true) ? 'pos_hardware' : $validated['category'];
        $ticketNumber = 'TCK-'.date('Y').'-'.str_pad((string) (SupportTicket::count() + 1), 4, '0', STR_PAD_LEFT);

        SupportTicket::create([
            'tenant_id' => $validated['tenant_id'],
            'user_id' => auth()->id(),
            'ticket_number' => $ticketNumber,
            'subject' => $validated['subject'],
            'category' => $category,
            'priority' => $validated['priority'],
            'description' => $validated['description'],
            'status' => 'open',
            'assigned_to' => auth()->id(),
        ]);

        return redirect()->route('super_admin.support')
            ->with('success', __('Tiketi ya msaada imefunguliwa kikamilifu!'));
    }

    /**
     * Update support ticket status, assigned agent, or resolution notes.
     */
    public function updateSupportTicketStatus(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'resolution_notes' => 'nullable|string',
        ]);

        $updates = [
            'status' => $validated['status'],
        ];

        if (array_key_exists('resolution_notes', $validated)) {
            $updates['resolution_notes'] = $validated['resolution_notes'];
        }

        if ($validated['status'] === 'resolved' && ! $ticket->resolved_at) {
            $updates['resolved_at'] = now();
        }

        $ticket->update($updates);

        return redirect()->back()
            ->with('success', "Tiketi {$ticket->ticket_number} imesasishwa.");
    }

    /**
     * Start Support Masquerade Mode: Super Admin enters tenant store as Manager.
     */
    public function masquerade(Tenant $tenant): RedirectResponse
    {
        $mainBranch = $tenant->branches()->where('is_main', true)->first() ?? $tenant->branches()->first();

        session([
            'masquerade_tenant_id' => $tenant->id,
            'active_tenant_id' => $tenant->id,
            'active_branch_id' => $mainBranch?->id,
            'active_role' => 'manager',
            'actual_role' => 'super_admin',
        ]);

        return redirect('/manager/dashboard')
            ->with('support_mode_active', "MODI YA USAIDIZI (Support Mode): Umeingia kama Msimamizi katika duka la {$tenant->name}.");
    }

    /**
     * End Support Masquerade Mode and return to SaaS Command Center.
     */
    public function endMasquerade(): RedirectResponse
    {
        session()->forget(['masquerade_tenant_id', 'active_tenant_id', 'active_branch_id']);
        session(['active_role' => 'super_admin']);

        return redirect('/super-admin/dashboard')
            ->with('success', 'Umetoka kwenye Modi ya Usaidizi na kurudi kwenye Dashibodi Kuu ya SaaS.');
    }

    /**
     * Toggle specific feature flag for a tenant.
     */
    public function toggleFeature(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'feature' => 'required|string',
            'enabled' => 'required|boolean',
        ]);

        $tenant->setFeature($validated['feature'], (bool) $validated['enabled']);

        return redirect()->back()
            ->with('success', "Feature {$validated['feature']} imesasishwa kwa {$tenant->name}.");
    }
}
