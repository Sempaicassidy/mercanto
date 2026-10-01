<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewsAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test all core optimized views render successfully with status 200.
     */
    public function test_all_optimized_views_render_successfully(): void
    {
        $routes = [
            '/',
            '/login',
            '/manager/dashboard',
            '/manager/analytics',
            '/manager/category',
            '/manager/suppliers',
            '/manager/expenses',
            '/manager/inventory',
            '/manager/staff_attendance',
            '/manager/staff_salary',
            '/manager/permission',
            '/manager/stock',
            '/manager/customers',
            '/manager/shifts',
            '/manager/returns',
            '/manager/damages',
            '/manager/transfers',
            '/manager/purchases',
            '/manager/auditing',
            '/pos',
            '/cashier/dashboard',
            '/storekeeper/dashboard',
            '/storekeeper/stock',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_role_switch_endpoints_redirect_correctly(): void
    {
        // Retailer switch
        $respRetail = $this->get('/switch-role/retailer');
        $respRetail->assertRedirect('/manager/dashboard');
        $this->assertEquals('retailer', session('business_mode'));

        // Wholesaler / Supplier switch
        $respWholesale = $this->get('/switch-role/wholesaler');
        $respWholesale->assertRedirect('/manager/dashboard');
        $this->assertEquals('wholesaler', session('business_mode'));

        // Manager switch
        $respManager = $this->get('/switch-role/manager');
        $respManager->assertRedirect('/manager/dashboard');

        // Cashier / POS switch
        $respCashier = $this->get('/switch-role/cashier');
        $respCashier->assertRedirect('/pos');

        // Storekeeper switch
        $respStorekeeper = $this->get('/switch-role/storekeeper');
        $respStorekeeper->assertRedirect('/storekeeper/dashboard');
    }

    public function test_business_mode_switch_endpoint(): void
    {
        $respRetail = $this->get('/switch-business-mode/retailer');
        $this->assertEquals('retailer', session('business_mode'));

        $respWholesale = $this->get('/switch-business-mode/wholesaler');
        $this->assertEquals('wholesaler', session('business_mode'));
    }

    public function test_login_authenticates_from_database_and_identifies_role_and_tenant(): void
    {
        // 1. Wholesaler manager login -> identifies wholesale tenant & manager role
        $respWholesale = $this->post('/login', [
            'username' => 'wholesale@eduka.co.tz',
            'password' => 'password',
        ]);
        $respWholesale->assertRedirect('/manager/dashboard');
        $this->assertEquals('wholesaler', session('business_mode'));
        $this->assertEquals('manager', session('active_role'));
        $this->assertStringContainsString('Wholesale', session('tenant_name'));

        // 2. Retail Cashier login -> identifies cashier role & routes to POS
        $respCashier = $this->post('/login', [
            'username' => 'cashier@eduka.co.tz',
            'password' => 'password',
        ]);
        $respCashier->assertRedirect('/pos');
        $this->assertEquals('cashier', session('active_role'));
        $this->assertEquals('retailer', session('business_mode'));

        // 3. Retail Storekeeper login -> routes to storekeeper dashboard
        $respStorekeeper = $this->post('/login', [
            'username' => 'storekeeper@eduka.co.tz',
            'password' => 'password',
        ]);
        $respStorekeeper->assertRedirect('/storekeeper/dashboard');
        $this->assertEquals('storekeeper', session('active_role'));

        // 4. Retail Manager login -> routes to manager dashboard
        $respManager = $this->post('/login', [
            'username' => 'manager@eduka.co.tz',
            'password' => 'password',
        ]);
        $respManager->assertRedirect('/manager/dashboard');
        $this->assertEquals('manager', session('active_role'));
        $this->assertEquals('retailer', session('business_mode'));

        // 5. AJAX JSON Login verification
        $respAjax = $this->postJson('/login', [
            'username' => 'wholesale@eduka.co.tz',
            'password' => 'password',
        ]);
        $respAjax->assertStatus(200);
        $respAjax->assertJson([
            'success' => true,
            'user' => [
                'role' => 'manager',
                'business_mode' => 'wholesaler',
            ],
        ]);

        // 6. Invalid credentials rejected
        $respInvalid = $this->postJson('/login', [
            'username' => 'nonexistent@eduka.co.tz',
            'password' => 'wrongpassword',
        ]);
        $respInvalid->assertStatus(422);
    }

    public function test_tenant_business_mode_toggle_endpoint(): void
    {
        session(['business_mode' => 'retailer']);
        $response = $this->post('/tenant/toggle-business-mode');
        $response->assertSessionHas('success');
        $this->assertEquals('wholesaler', session('business_mode'));

        // Toggle back
        $response2 = $this->post('/tenant/toggle-business-mode');
        $response2->assertSessionHas('success');
        $this->assertEquals('retailer', session('business_mode'));
    }
}
