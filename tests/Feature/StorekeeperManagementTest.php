<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorekeeperManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenant;

    protected Branch $branch;

    protected User $storekeeper;

    protected Category $category;

    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->tenant = Tenant::first();
        $this->branch = Branch::where('tenant_id', $this->tenant->id)->first();

        $this->storekeeper = User::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'name' => 'Rashid Mzee',
            'email' => 'storekeeper@eduka.tz',
            'password' => bcrypt('password'),
            'role' => 'storekeeper',
            'status' => 'active',
        ]);

        $this->category = Category::where('tenant_id', $this->tenant->id)->first() ?? Category::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Beverages',
            'business_chain' => 'fmcg_grocery',
            'margin_percentage' => 20,
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'tenant_id' => $this->tenant->id,
            'category_id' => $this->category->id,
            'name' => 'Coca Cola 500ml',
            'barcode' => '616111222333',
            'sku' => 'SKU-COC-500',
            'cost_price' => 800,
            'selling_price' => 1200,
            'wholesale_price' => 1000,
            'min_alert_qty' => 20,
            'unit' => 'pcs',
            'is_active' => true,
        ]);

        BranchStock::create([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'quantity' => 10,
            'shelf_location' => 'Aisle 3 - Shelf B',
        ]);
    }

    public function test_storekeeper_can_view_dashboard_with_live_kpis(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->get('/storekeeper/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Ghala');
        $response->assertSee('Coca Cola 500ml');
        $response->assertSee('Aisle 3 - Shelf B');
    }

    public function test_storekeeper_can_view_stock_inventory_catalog(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->get('/storekeeper/stock');

        $response->assertStatus(200);
        $response->assertSee('Orodha ya Bidhaa');
        $response->assertSee('Coca Cola 500ml');
        $response->assertSee('SKU-COC-500');
    }

    public function test_storekeeper_can_receive_goods_and_increment_stock(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->post('/storekeeper/receive-goods', [
                'product_id' => $this->product->id,
                'quantity' => 50,
                'supplier_name' => 'Bakhresa Group Ltd',
                'invoice_no' => 'INV-2026-091',
                'unit_cost' => 800,
                'shelf_location' => 'Bay 4 - Rack A',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verify stock incremented: 10 + 50 = 60
        $stock = BranchStock::where('product_id', $this->product->id)
            ->where('branch_id', $this->branch->id)
            ->first();

        $this->assertEquals(60, $stock->quantity);
        $this->assertEquals('Bay 4 - Rack A', $stock->shelf_location);

        // Verify Purchase GRN record created
        $this->assertDatabaseHas('purchases', [
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'po_number' => 'INV-2026-091',
            'status' => 'received',
            'total_amount' => 40000,
        ]);
    }

    public function test_storekeeper_can_adjust_stock_for_damage_and_shortage(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->postJson('/storekeeper/adjust-stock', [
                'product_id' => $this->product->id,
                'adjustment_type' => 'damage',
                'quantity' => 3,
                'reason' => 'Broken bottles during handling',
                'notes' => 'Dropped pallet in Aisle 3',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'new_stock' => 7, // 10 - 3
        ]);

        $stock = BranchStock::where('product_id', $this->product->id)
            ->where('branch_id', $this->branch->id)
            ->first();

        $this->assertEquals(7, $stock->quantity);

        $this->assertDatabaseHas('damages', [
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'quantity' => 3,
            'reason' => 'broken',
        ]);
    }

    public function test_storekeeper_can_adjust_stock_surplus_and_recount(): void
    {
        // Test surplus (+5)
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->postJson('/storekeeper/adjust-stock', [
                'product_id' => $this->product->id,
                'adjustment_type' => 'surplus',
                'quantity' => 5,
                'reason' => 'Found uncounted box',
            ]);

        $response->assertStatus(200);
        $this->assertEquals(15, $response->json('new_stock')); // 10 + 5 = 15

        // Test recount audit to exact quantity (e.g. 12)
        $response2 = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->postJson('/storekeeper/adjust-stock', [
                'product_id' => $this->product->id,
                'adjustment_type' => 'recount',
                'quantity' => 12,
                'reason' => 'Quarterly physical audit',
            ]);

        $response2->assertStatus(200);
        $this->assertEquals(12, $response2->json('new_stock'));

        // Shortage of 3 should be recorded in damages
        $this->assertDatabaseHas('damages', [
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'quantity' => 3,
            'reason' => 'other',
        ]);
    }

    public function test_storekeeper_can_store_new_product_from_storekeeper_panel(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->post('/storekeeper/product', [
                'name' => 'Fanta Orange 350ml',
                'category_id' => $this->category->id,
                'barcode' => '616999888777',
                'sku' => 'SKU-FAN-350',
                'cost_price' => 700,
                'selling_price' => 1000,
                'initial_stock' => 45,
                'min_alert_qty' => 10,
                'unit' => 'pcs',
                'shelf_location' => 'Main Hall - Shelf 2',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'tenant_id' => $this->tenant->id,
            'name' => 'Fanta Orange 350ml',
            'sku' => 'SKU-FAN-350',
            'cost_price' => 700,
        ]);

        $newProduct = Product::where('sku', 'SKU-FAN-350')->first();
        $this->assertDatabaseHas('branch_stocks', [
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'product_id' => $newProduct->id,
            'quantity' => 45,
            'shelf_location' => 'Main Hall - Shelf 2',
        ]);
    }

    public function test_storekeeper_can_update_product_shelf_location(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->postJson("/storekeeper/product/{$this->product->id}/location", [
                'shelf_location' => 'Cold Room - Rack C2',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'shelf_location' => 'Cold Room - Rack C2',
        ]);

        $stock = BranchStock::where('product_id', $this->product->id)
            ->where('branch_id', $this->branch->id)
            ->first();

        $this->assertEquals('Cold Room - Rack C2', $stock->shelf_location);
    }

    public function test_storekeeper_can_export_inventory_valuation_csv(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->get('/storekeeper/export-valuation');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('attachment; filename="mercanto_warehouse_inventory_', (string) $response->headers->get('Content-Disposition'));
    }

    public function test_storekeeper_pages_contain_mobile_drawer_and_bilingual_toggle(): void
    {
        $response = $this->withSession([
            'tenant_id' => $this->tenant->id,
            'branch_id' => $this->branch->id,
            'active_role' => 'storekeeper',
        ])
            ->actingAs($this->storekeeper)
            ->get('/storekeeper/dashboard');

        $response->assertStatus(200);
        // Mobile sidebar drawer trigger and backdrop
        $response->assertSee('mobileSidebarToggle');
        $response->assertSee('sidebarBackdrop');

        // Bilingual toggle link
        $response->assertSee('/switch-language/');
    }
}
