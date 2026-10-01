<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DeliveryOrder;
use App\Models\Rider;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    /**
     * Display Delivery Dispatch Board and Riders.
     */
    public function index(Request $request): View
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;

        $riders = Rider::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->orderBy('name')
            ->get();

        $deliveries = DeliveryOrder::where('tenant_id', $tenantId)
            ->where('branch_id', $branchId)
            ->with(['rider', 'customer', 'sale'])
            ->latest()
            ->paginate(30);

        return view('manager.deliveries', [
            'riders' => $riders,
            'deliveries' => $deliveries,
            'branchId' => $branchId,
        ]);
    }

    /**
     * Add new delivery rider (Bodaboda / Bajaj / Van).
     */
    public function storeRider(Request $request): RedirectResponse
    {
        $tenantId = session('active_tenant_id') ?? Auth::user()?->tenant_id ?? Tenant::query()->first()?->id ?? 1;
        $branchId = session('active_branch_id') ?? Auth::user()?->branch_id ?? Branch::where('tenant_id', $tenantId)->first()?->id ?? 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'vehicle_type' => 'required|in:motorcycle,van,bajaj,bicycle,foot',
            'vehicle_no' => 'nullable|string|max:50',
        ]);

        Rider::create([
            'tenant_id' => $tenantId,
            'branch_id' => $branchId,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_no' => $validated['vehicle_no'] ?? null,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Dereva / Rider wa usambazaji amesajiliwa kikamilifu!');
    }

    /**
     * Assign rider to delivery order.
     */
    public function assignRider(Request $request, DeliveryOrder $delivery): RedirectResponse
    {
        $validated = $request->validate([
            'rider_id' => 'required|exists:riders,id',
        ]);

        $delivery->update([
            'rider_id' => $validated['rider_id'],
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        Rider::where('id', $validated['rider_id'])->update(['status' => 'busy']);

        return redirect()->back()->with('success', 'Oda imekabidhiwa kwa dereva wa usambazaji!');
    }

    /**
     * Update delivery status (In Transit, Delivered, Failed).
     */
    public function updateStatus(Request $request, DeliveryOrder $delivery): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:in_transit,delivered,failed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $status = $validated['status'];
        $updates = [
            'status' => $status,
            'notes' => $validated['notes'] ?? $delivery->notes,
        ];

        if ($status === 'in_transit') {
            $updates['dispatched_at'] = now();
        } elseif ($status === 'delivered') {
            $updates['delivered_at'] = now();
            if ($delivery->rider_id) {
                Rider::where('id', $delivery->rider_id)->update(['status' => 'available']);
            }
        } elseif (in_array($status, ['failed', 'cancelled'], true) && $delivery->rider_id) {
            Rider::where('id', $delivery->rider_id)->update(['status' => 'available']);
        }

        $delivery->update($updates);

        return redirect()->back()->with('success', 'Hali ya usafirishaji imesasishwa kikamilifu!');
    }
}
