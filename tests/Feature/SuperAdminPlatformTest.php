<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\SupportTicket;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_super_admin_login_redirects_to_super_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin@eduka.co.tz',
            'password' => 'password',
        ]);

        $response->assertRedirect('/super-admin/dashboard');
        $response->assertSessionHas('active_role', 'super_admin');
    }

    public function test_super_admin_login_with_short_username_admin(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);

        $response->assertRedirect('/super-admin/dashboard');
        $response->assertSessionHas('active_role', 'super_admin');
    }

    public function test_super_admin_login_with_admin_password(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'admin',
        ]);

        $response->assertRedirect('/super-admin/dashboard');
        $response->assertSessionHas('active_role', 'super_admin');
    }

    public function test_super_admin_login_api_returns_super_admin_redirect(): void
    {
        $response = $this->postJson('/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'redirect' => url('/super-admin/dashboard'),
        ]);
    }

    public function test_role_switch_to_super_admin_redirects_to_super_admin_dashboard(): void
    {
        $response = $this->get('/switch-role/super_admin');

        $response->assertRedirect('/super-admin/dashboard');
        $response->assertSessionHas('active_role', 'super_admin');
    }

    public function test_super_admin_dashboard_renders_successfully(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $response = $this->get('/super-admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('SaaS');
    }

    public function test_super_admin_tenants_page_renders_and_shows_tenants(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $response = $this->get('/super-admin/tenants');

        $response->assertStatus(200);
        $response->assertSee('Afya Pharmacy');
    }

    public function test_super_admin_can_register_new_tenant_with_branch_manager_and_contract(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $response = $this->post('/super-admin/tenants', [
            'name' => 'Kariakoo Wholesalers Ltd',
            'business_type' => 'wholesaler',
            'status' => 'active',
            'email' => 'info@kariakoo-wholesalers.co.tz',
            'phone' => '+255712999888',
            'address' => 'Msimbazi St, Kariakoo, Dar es Salaam',
            'admin_name' => 'Rashid Mzee',
            'admin_email' => 'rashid@kariakoo-wholesalers.co.tz',
            'admin_phone' => '+255712999888',
            'admin_password' => 'Password123!',
            'lease_fee' => 1500000,
            'billing_cycle' => 'annual',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tenants', [
            'name' => 'Kariakoo Wholesalers Ltd',
            'business_type' => 'supplier',
            'status' => 'active',
        ]);

        $tenant = Tenant::where('name', 'Kariakoo Wholesalers Ltd')->first();
        $this->assertNotNull($tenant);

        // Verify HQ Branch created
        $this->assertDatabaseHas('branches', [
            'tenant_id' => $tenant->id,
            'code' => 'HQ-01',
            'is_main' => 1,
        ]);

        // Verify Manager user created
        $this->assertDatabaseHas('users', [
            'tenant_id' => $tenant->id,
            'email' => 'rashid@kariakoo-wholesalers.co.tz',
            'role' => 'manager',
        ]);

        // Verify starter lease contract created
        $this->assertDatabaseHas('contracts', [
            'tenant_id' => $tenant->id,
            'billing_cycle' => 'annually',
            'amount' => 1500000,
            'status' => 'active',
        ]);
    }

    public function test_super_admin_can_update_tenant_status(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $tenant = Tenant::first();
        $this->assertNotNull($tenant);

        $response = $this->post("/super-admin/tenants/{$tenant->id}/status", [
            'status' => 'suspended',
            'notes' => 'Non-payment of lease agreement',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'status' => 'suspended',
        ]);
    }

    public function test_super_admin_contracts_page_renders_successfully(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $response = $this->get('/super-admin/contracts');

        $response->assertStatus(200);
        $response->assertSee('TZS');
    }

    public function test_super_admin_can_create_and_renew_contract(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $tenant = Tenant::first();

        // 1. Create contract
        $response = $this->post('/super-admin/contracts', [
            'tenant_id' => $tenant->id,
            'title' => 'Enterprise SLA Expansion',
            'type' => 'lease',
            'billing_cycle' => 'annual',
            'amount' => 2400000,
            'currency' => 'TZS',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
            'payment_status' => 'paid',
            'sla_terms' => '99.9% Uptime with 1hr response time',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $contract = Contract::where('title', 'Enterprise SLA Expansion')->first();
        $this->assertNotNull($contract);

        // 2. Renew contract
        $oldEndDate = $contract->end_date;
        $renewResponse = $this->post("/super-admin/contracts/{$contract->id}/status", [
            'action' => 'renew',
        ]);

        $renewResponse->assertRedirect();
        $contract->refresh();
        $this->assertTrue($contract->end_date->gt($oldEndDate));
    }

    public function test_super_admin_support_page_renders_successfully(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $response = $this->get('/super-admin/support');

        $response->assertStatus(200);
    }

    public function test_super_admin_can_create_and_resolve_support_ticket(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $tenant = Tenant::first();

        // 1. Create ticket
        $response = $this->post('/super-admin/support', [
            'tenant_id' => $tenant->id,
            'subject' => 'Thermal Printer Connection Issue',
            'category' => 'hardware',
            'priority' => 'urgent',
            'description' => 'Thermal printer USB disconnecting during peak hours',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $ticket = SupportTicket::where('subject', 'Thermal Printer Connection Issue')->first();
        $this->assertNotNull($ticket);

        // 2. Resolve ticket
        $resolveResponse = $this->post("/super-admin/support/{$ticket->id}/status", [
            'status' => 'resolved',
            'resolution_notes' => 'Updated printer driver and replaced USB cable. Confirmed printing test receipts.',
        ]);

        $resolveResponse->assertRedirect();
        $ticket->refresh();
        $this->assertEquals('resolved', $ticket->status);
        $this->assertNotNull($ticket->resolved_at);
        $this->assertStringContainsString('Updated printer driver', $ticket->resolution_notes);
    }
}
