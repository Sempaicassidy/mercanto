<?php

namespace Tests\Feature;

use Tests\TestCase;

class MobileFirstDesignTest extends TestCase
{
    /**
     * Test that login page contains mobile viewport and responsive elements.
     */
    public function test_login_page_has_mobile_first_viewport_and_elements(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('<meta name="viewport" content="width=device-width, initial-scale=1.0">', $content);
        $this->assertStringContainsString('max-width: 480px', $content);
        $this->assertStringContainsString('login-card', $content);
    }

    /**
     * Test manager dashboard contains mobile slide-out drawer backdrop, hamburger button, and mobile bottom app bar.
     */
    public function test_manager_dashboard_contains_mobile_navigation_components(): void
    {
        $response = $this->get('/manager/dashboard');
        $response->assertStatus(200);

        $content = $response->getContent();
        // Viewport meta
        $this->assertStringContainsString('<meta name="viewport" content="width=device-width, initial-scale=1.0">', $content);

        // Mobile drawer overlay & bottom app bar
        $this->assertStringContainsString('id="sidebarBackdrop"', $content);
        $this->assertStringContainsString('id="mobileBottomAppbar"', $content);
        $this->assertStringContainsString('mobile-bottom-appbar', $content);
        $this->assertStringContainsString('bottom-pos-fab', $content);
        $this->assertStringContainsString('mobileMenuDrawerBtn', $content);

        // Mobile first responsive css rules
        $this->assertStringContainsString('@media (max-width: 992px)', $content);
        $this->assertStringContainsString('.sidebar.mobile-open', $content);
        $this->assertStringContainsString('.sidebar-backdrop', $content);
        $this->assertStringContainsString('initMobileNavigation', $content);
    }

    /**
     * Test cashier / POS dashboard contains mobile navigation components.
     */
    public function test_cashier_pos_contains_mobile_navigation_components(): void
    {
        $response = $this->get('/pos');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('id="sidebarBackdrop"', $content);
        $this->assertStringContainsString('id="mobileBottomAppbar"', $content);
        $this->assertStringContainsString('initMobileNavigation', $content);
        $this->assertStringContainsString('/pos', $content);
    }

    /**
     * Test storekeeper dashboard contains mobile navigation components.
     */
    public function test_storekeeper_dashboard_contains_mobile_navigation_components(): void
    {
        $response = $this->get('/storekeeper/dashboard');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('id="sidebarBackdrop"', $content);
        $this->assertStringContainsString('id="mobileBottomAppbar"', $content);
        $this->assertStringContainsString('initMobileNavigation', $content);
    }
}
