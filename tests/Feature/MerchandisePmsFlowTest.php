<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Branch;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\Product;
use App\Models\Rider;
use App\Models\Shift;
use App\Models\SubCategory;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchandisePmsFlowTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenant;

    protected Branch $branch;

    protected User $cashier;

    protected User $manager;

    protected User $superAdmin;

    protected Category $category;

    protected SubCategory $subCategory;

    protected Product $product;

    protected BranchStock $branchStock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->tenant = Tenant::first();
        $this->branch = Branch::where('tenant_id', $this->tenant->id)->first();

        $this->cashier = User::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'name' => 'Neema Cashier',
            'email' => 'cashier.test@eduka.tz',
            'password' => bcrypt('password'),
            'role' => 'cashier',
            'status' => 'active',
        ]);

        $this->manager = User::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'name' => 'Baraka Manager',
            'email' => 'manager.test@eduka.tz',
            'password' => bcrypt('password'),
            'role' => 'manager',
            'status' => 'active',
        ]);

        $this->superAdmin = User::create([
            'tenant_id' => null,
            'branch_id' => null,
            'name' => 'System Director',
            'email' => 'superadmin.test@eduka.tz',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $this->category = Category::where('tenant_id', $this->tenant->id)->first() ?? Category::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Vyakula na Nafaka',
            'business_chain' => 'fmcg_grocery',
            'target_margin' => 15,
            'is_active' => true,
        ]);

        $this->subCategory = SubCategory::create([
            'tenant_id' => $this->tenant->id,
            'category_id' => $this->category->id,
            'name' => 'Mchele wa Kyela',
            'code' => 'SUB-MCH-01',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'tenant_id' => $this->tenant->id,
            'category_id' => $this->category->id,
            'sub_category_id' => $this->subCategory->id,
            'name' => 'Mchele Safi Super 5kg',
            'barcode' => '616999888777',
            'sku' => 'MCH-SUPER-5KG',
            'cost_price' => 12000,
            'selling_price' => 15000,
            'wholesale_price' => 14000,
            'min_alert_qty' => 10,
            'is_active' => true,
        ]);

        $this->branchStock = BranchStock::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'quantity' => 50,
        ]);
    }

    /**
     * Test FEFO (First-Expired, First-Out) batch auto-selection and deduction.
     */
    public function test_pos_checkout_deducts_batch_using_fefo(): void
    {
        // Batch 1: expires soon (2026-10-15)
        $soonBatch = Batch::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'batch_number' => 'BAT-OCT-01',
            'quantity' => 10,
            'initial_quantity' => 10,
            'cost_price' => 12000,
            'selling_price' => 15000,
            'expiry_date' => '2026-10-15',
            'status' => 'active',
        ]);

        // Batch 2: expires later (2026-12-31)
        $laterBatch = Batch::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'batch_number' => 'BAT-DEC-02',
            'quantity' => 20,
            'initial_quantity' => 20,
            'cost_price' => 12000,
            'selling_price' => 15000,
            'expiry_date' => '2026-12-31',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->cashier)->postJson('/api/pos/checkout', [
            'payment_method' => 'cash',
            'tendered_amount' => 60000,
            'cart' => [
                [
                    'id' => $this->product->id,
                    'qty' => 4,
                    'price' => 15000,
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        // Batch 1 should be decremented from 10 to 6
        $soonBatch->refresh();
        $this->assertEquals(6, $soonBatch->quantity);

        // Later batch untouched
        $laterBatch->refresh();
        $this->assertEquals(20, $laterBatch->quantity);

        // Branch stock decremented from 50 to 46
        $this->branchStock->refresh();
        $this->assertEquals(46, $this->branchStock->quantity);
    }

    /**
     * Test Customer Wallet debit and loyalty points accrual.
     */
    public function test_customer_wallet_payment_and_loyalty_points(): void
    {
        $customer = Customer::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Mama Aisha Mkazi',
            'phone' => '+255754000111',
            'customer_type' => 'retail',
            'credit_limit' => 100000,
            'loyalty_points' => 0,
            'balance_due' => 0,
            'is_active' => true,
        ]);

        // Deposit funds into wallet
        $wallet = $customer->getOrCreateWallet();
        $wallet->deposit(100000, 'Top-up M-Pesa', 'DEP-001', $this->manager->id);

        $this->assertEquals(100000, $wallet->fresh()->balance);

        // Checkout with wallet
        $response = $this->actingAs($this->cashier)->postJson('/api/pos/checkout', [
            'customer_id' => $customer->id,
            'payment_method' => 'wallet',
            'tendered_amount' => 30000,
            'cart' => [
                [
                    'id' => $this->product->id,
                    'qty' => 2,
                    'price' => 15000,
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        // Wallet balance reduced by 30,000 (100,000 - 30,000 = 70,000)
        $this->assertEquals(70000, $wallet->fresh()->balance);

        // Loyalty points accrued (1 point per 10,000 TSh spent => 30,000 = 3 points)
        $customer->refresh();
        $this->assertEquals(3, $customer->loyalty_points);
    }

    /**
     * Test Cashier Shift open, drawer counting and variance reconciliation.
     */
    public function test_cashier_shift_reconciliation_and_variance(): void
    {
        // 1. Open shift with float of 50,000 TSh
        $openResp = $this->actingAs($this->cashier)->postJson('/api/pos/open-shift', [
            'opening_float' => 50000,
        ]);
        $openResp->assertStatus(200);
        $openResp->assertJsonPath('success', true);

        $shift = Shift::where('user_id', $this->cashier->id)->where('status', 'open')->first();
        $this->assertNotNull($shift);
        $this->assertEquals(50000, $shift->opening_float);

        // 2. Complete a cash sale of 15,000 TSh
        $this->actingAs($this->cashier)->postJson('/api/pos/checkout', [
            'payment_method' => 'cash',
            'tendered_amount' => 15000,
            'cart' => [
                [
                    'id' => $this->product->id,
                    'qty' => 1,
                    'price' => 15000,
                ],
            ],
        ]);

        // Expected cash in drawer = 50,000 float + 15,000 sales = 65,000 TSh
        // Cashier counts 63,000 TSh (shortage of 2,000 TSh)
        $closeResp = $this->actingAs($this->cashier)->postJson('/api/pos/close-shift', [
            'closing_cash' => 63000,
            'notes' => 'TSh 2,000 shortage checked and confirmed.',
        ]);

        $closeResp->assertStatus(200);
        $closeResp->assertJsonPath('success', true);
        $closeResp->assertJsonPath('summary.variance', -2000);

        $shift->refresh();
        $this->assertEquals('closed', $shift->status);
        $this->assertEquals(63000, $shift->closing_cash);
        $this->assertEquals(-2000, $shift->difference);
    }

    /**
     * Test Delivery Rider registration and Dispatch Workflow.
     */
    public function test_delivery_dispatch_workflow(): void
    {
        // Register rider
        $riderResp = $this->actingAs($this->manager)->post('/manager/deliveries/rider', [
            'name' => 'Ally Juma Bodaboda',
            'phone' => '+255714223344',
            'vehicle_type' => 'motorcycle',
            'vehicle_no' => 'MC 456 DEF',
        ]);
        $riderResp->assertRedirect();

        $rider = Rider::where('phone', '+255714223344')->first();
        $this->assertNotNull($rider);
        $this->assertEquals('Ally Juma Bodaboda', $rider->name);

        // Create delivery order
        $delivery = DeliveryOrder::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'tracking_number' => 'DEL-'.time(),
            'delivery_address' => 'Mikocheni B, Block 4',
            'recipient_name' => 'Mama Juma',
            'recipient_phone' => '+255754999888',
            'delivery_fee' => 3000,
            'status' => 'pending',
        ]);

        // Assign rider
        $assignResp = $this->actingAs($this->manager)->post("/manager/deliveries/{$delivery->id}/assign", [
            'rider_id' => $rider->id,
        ]);
        $assignResp->assertRedirect();

        $delivery->refresh();
        $this->assertEquals($rider->id, $delivery->rider_id);
        $this->assertEquals('assigned', $delivery->status);

        // Update status to delivered
        $statusResp = $this->actingAs($this->manager)->post("/manager/deliveries/{$delivery->id}/status", [
            'status' => 'delivered',
        ]);
        $statusResp->assertRedirect();

        $delivery->refresh();
        $this->assertEquals('delivered', $delivery->status);
        $this->assertNotNull($delivery->delivered_at);
    }

    /**
     * Test Super Admin Support Masquerade mode.
     */
    public function test_super_admin_support_masquerade(): void
    {
        // 1. Super admin starts masquerade into a store
        $response = $this->actingAs($this->superAdmin)->get("/super-admin/tenants/{$this->tenant->id}/support");
        $response->assertRedirect('/manager/dashboard');
        $response->assertSessionHas('masquerade_tenant_id', $this->tenant->id);

        // 2. End masquerade
        $endResp = $this->actingAs($this->superAdmin)
            ->withSession(['masquerade_tenant_id' => $this->tenant->id])
            ->get('/super-admin/end-support');

        $endResp->assertRedirect('/super-admin/dashboard');
        $endResp->assertSessionMissing('masquerade_tenant_id');
    }
}
