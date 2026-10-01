<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenantA;

    protected Tenant $tenantB;

    protected User $managerA;

    protected User $managerB;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->tenantA = Tenant::first();
        $this->managerA = User::where('tenant_id', $this->tenantA->id)->where('role', 'manager')->first();

        $this->tenantB = Tenant::create([
            'name' => 'Bakhresa Hardware & Construction',
            'slug' => 'bakhresa-hardware',
            'business_type' => 'retailer',
            'status' => 'active',
            'phone' => '+255 711 222 333',
            'email' => 'hardware@bakhresa.com',
            'address' => 'Gerezani, Kariakoo',
            'tin_number' => '998-112-004',
            'currency' => 'TZS',
        ]);

        $this->managerB = User::create([
            'tenant_id' => $this->tenantB->id,
            'name' => 'Hardware Manager',
            'email' => 'manager@bakhresahardware.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
            'status' => 'active',
        ]);
    }

    public function test_manager_can_view_category_management_page(): void
    {
        $response = $this->withSession(['tenant_id' => $this->tenantA->id])
            ->actingAs($this->managerA)
            ->get('/manager/category');

        $response->assertStatus(200);
        $response->assertSee('Vitengo vya Bidhaa vya Duka Lako');
        $response->assertSee('addCategoryBtn');
        $response->assertSee('chainPresetModal');
    }

    public function test_manager_can_create_custom_product_category(): void
    {
        $payload = [
            'name' => 'Saruji na Chokaa',
            'code' => 'CAT-SRJ',
            'business_chain' => 'hardware_construction',
            'target_margin' => 18.5,
            'icon' => 'bi-box',
            'description' => 'Mifuko ya saruji ya Twiga, Simba na Dangote',
            'is_active' => 1,
        ];

        $response = $this->withSession(['tenant_id' => $this->tenantB->id])
            ->actingAs($this->managerB)
            ->postJson('/manager/category', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'category' => [
                'name' => 'Saruji na Chokaa',
                'code' => 'CAT-SRJ',
                'tenant_id' => $this->tenantB->id,
                'business_chain' => 'hardware_construction',
                'target_margin' => 18.5,
                'is_active' => true,
            ],
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Saruji na Chokaa',
            'code' => 'CAT-SRJ',
            'tenant_id' => $this->tenantB->id,
            'target_margin' => 18.5,
        ]);
    }

    public function test_manager_can_update_category(): void
    {
        $category = Category::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'Vifaa vya Umeme',
            'code' => 'CAT-ELE',
            'target_margin' => 20,
            'is_active' => true,
        ]);

        $response = $this->withSession(['tenant_id' => $this->tenantA->id])
            ->actingAs($this->managerA)
            ->putJson("/manager/category/{$category->id}", [
                'name' => 'Vifaa vya Umeme na Taa za LED',
                'code' => 'CAT-ELE-MOD',
                'target_margin' => 28,
                'is_active' => true,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Vifaa vya Umeme na Taa za LED',
            'code' => 'CAT-ELE-MOD',
            'target_margin' => 28,
        ]);
    }

    public function test_manager_can_toggle_category_status(): void
    {
        $category = Category::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'Vitafunio na Pipi',
            'code' => 'CAT-SNK',
            'is_active' => true,
        ]);

        $response = $this->withSession(['tenant_id' => $this->tenantA->id])
            ->actingAs($this->managerA)
            ->postJson("/manager/category/{$category->id}/toggle-status");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_active' => false,
        ]);

        $this->assertFalse($category->fresh()->is_active);
    }

    public function test_manager_can_delete_category(): void
    {
        $category = Category::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'Kitengo cha Muda',
            'code' => 'CAT-TMP',
            'is_active' => true,
        ]);

        $response = $this->withSession(['tenant_id' => $this->tenantA->id])
            ->actingAs($this->managerA)
            ->deleteJson("/manager/category/{$category->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_tenant_isolation_prevents_unauthorized_modification(): void
    {
        // Category belongs to Tenant B
        $categoryB = Category::create([
            'tenant_id' => $this->tenantB->id,
            'name' => 'Rangi za Mafuta',
            'code' => 'CAT-RNG',
            'is_active' => true,
        ]);

        // Manager of Tenant A tries to update it
        $response = $this->withSession(['tenant_id' => $this->tenantA->id])
            ->actingAs($this->managerA)
            ->putJson("/manager/category/{$categoryB->id}", [
                'name' => 'Hacked Category',
            ]);

        $response->assertStatus(403);

        // Manager of Tenant A tries to delete it
        $responseDelete = $this->withSession(['tenant_id' => $this->tenantA->id])
            ->actingAs($this->managerA)
            ->deleteJson("/manager/category/{$categoryB->id}");

        $responseDelete->assertStatus(403);
    }

    public function test_manager_can_apply_business_product_chain_preset(): void
    {
        // Apply hardware_construction preset to Tenant B
        $response = $this->withSession(['tenant_id' => $this->tenantB->id])
            ->actingAs($this->managerB)
            ->postJson('/manager/category/apply-chain-preset', [
                'chain_key' => 'hardware_construction',
                'mode' => 'replace',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'created_count' => 5,
        ]);

        $this->assertDatabaseHas('categories', [
            'tenant_id' => $this->tenantB->id,
            'business_chain' => 'hardware_construction',
            'name' => 'Nondo, Mabati & Misumari',
        ]);

        $this->assertDatabaseHas('categories', [
            'tenant_id' => $this->tenantB->id,
            'business_chain' => 'hardware_construction',
            'name' => 'Rangi, Brashi & Kemikali',
        ]);
    }

    public function test_api_categories_returns_active_categories_for_tenant(): void
    {
        Category::create([
            'tenant_id' => $this->tenantB->id,
            'name' => 'Mabati ya Mgongo 28G',
            'code' => 'CAT-MBT',
            'is_active' => true,
        ]);

        Category::create([
            'tenant_id' => $this->tenantB->id,
            'name' => 'Kitengo Kilichozimwa',
            'code' => 'CAT-ZMW',
            'is_active' => false,
        ]);

        $response = $this->withSession(['tenant_id' => $this->tenantB->id])
            ->actingAs($this->managerB)
            ->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $categoryNames = collect($response->json('categories'))->pluck('name')->all();
        $this->assertContains('Mabati ya Mgongo 28G', $categoryNames);
        $this->assertNotContains('Kitengo Kilichozimwa', $categoryNames);
    }
}
