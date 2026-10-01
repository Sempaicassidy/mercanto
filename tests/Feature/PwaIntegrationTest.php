<?php

namespace Tests\Feature;

use Tests\TestCase;

class PwaIntegrationTest extends TestCase
{
    /**
     * Test that manifest.json is valid and contains standard PWA specifications.
     */
    public function test_manifest_json_is_valid_and_contains_pwa_specifications(): void
    {
        $manifestPath = public_path('manifest.json');
        $this->assertFileExists($manifestPath, 'manifest.json must exist in public directory.');

        $manifestContent = file_get_contents($manifestPath);
        $manifest = json_decode($manifestContent, true);

        $this->assertIsArray($manifest, 'manifest.json must be valid JSON.');
        $this->assertArrayHasKey('name', $manifest);
        $this->assertArrayHasKey('short_name', $manifest);
        $this->assertEquals('Mercanto', $manifest['short_name']);
        $this->assertEquals('/login', $manifest['start_url']);
        $this->assertEquals('standalone', $manifest['display']);
        $this->assertEquals('#10b981', $manifest['theme_color']);
        $this->assertEquals('#09090b', $manifest['background_color']);

        // Check icons
        $this->assertArrayHasKey('icons', $manifest);
        $this->assertNotEmpty($manifest['icons']);

        foreach ($manifest['icons'] as $icon) {
            $this->assertArrayHasKey('src', $icon);
            $this->assertArrayHasKey('sizes', $icon);
            $this->assertArrayHasKey('type', $icon);

            $relativeIconPath = ltrim($icon['src'], '/');
            $this->assertFileExists(public_path($relativeIconPath), "Icon file {$icon['src']} must exist on disk.");
        }

        // Check shortcuts
        $this->assertArrayHasKey('shortcuts', $manifest);
        $shortcutsUrls = array_column($manifest['shortcuts'], 'url');
        $this->assertContains('/pos', $shortcutsUrls);
        $this->assertContains('/manager/dashboard', $shortcutsUrls);
        $this->assertContains('/storekeeper/dashboard', $shortcutsUrls);
    }

    /**
     * Test that manifest.webmanifest exists and is synced.
     */
    public function test_manifest_webmanifest_exists_and_is_valid(): void
    {
        $webmanifestPath = public_path('manifest.webmanifest');
        $this->assertFileExists($webmanifestPath, 'manifest.webmanifest must exist.');

        $content = file_get_contents($webmanifestPath);
        $data = json_decode($content, true);
        $this->assertIsArray($data);
        $this->assertEquals('Mercanto', $data['short_name']);
    }

    /**
     * Test that sw.js exists and implements caching strategies.
     */
    public function test_service_worker_file_exists_and_implements_caching_strategies(): void
    {
        $swPath = public_path('sw.js');
        $this->assertFileExists($swPath, 'sw.js must exist at public root.');

        $swContent = file_get_contents($swPath);
        $this->assertStringContainsString('CACHE_NAME', $swContent);
        $this->assertStringContainsString('/offline', $swContent);
        $this->assertStringContainsString('/manifest.json', $swContent);
        $this->assertStringContainsString('addEventListener(\'install\'', $swContent);
        $this->assertStringContainsString('addEventListener(\'activate\'', $swContent);
        $this->assertStringContainsString('addEventListener(\'fetch\'', $swContent);
        $this->assertStringContainsString('request.mode === \'navigate\'', $swContent);
    }

    /**
     * Test that the offline fallback view renders with bilingual support.
     */
    public function test_offline_fallback_page_renders_bilingually(): void
    {
        // 1. Swahili test
        $responseSw = $this->withSession(['locale' => 'sw'])->get('/offline');
        $responseSw->assertStatus(200);

        $contentSw = $responseSw->getContent();
        $this->assertStringContainsString('Mercanto PWA', $contentSw);
        $this->assertStringContainsString('Huna Mtandao wa Intaneti', $contentSw);
        $this->assertStringContainsString('Jaribu Tena Sasa', $contentSw);
        $this->assertStringContainsString('rel="manifest"', $contentSw);

        // 2. English test
        $responseEn = $this->withSession(['locale' => 'en'])->get('/offline');
        $responseEn->assertStatus(200);

        $contentEn = $responseEn->getContent();
        $this->assertStringContainsString('Mercanto PWA', $contentEn);
        $this->assertStringContainsString('You are Currently Offline', $contentEn);
        $this->assertStringContainsString('Retry Connection', $contentEn);
    }

    /**
     * Test that the login page includes PWA meta tags and installation elements.
     */
    public function test_login_page_includes_pwa_meta_tags_and_service_worker(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('<link rel="manifest" href="/manifest.json">', $content);
        $this->assertStringContainsString('<meta name="theme-color" content="#10b981">', $content);
        $this->assertStringContainsString('<meta name="apple-mobile-web-app-capable" content="yes">', $content);
        $this->assertStringContainsString('/sw.js', $content);
        $this->assertStringContainsString('eduka-pwa-install-banner', $content);
        $this->assertStringContainsString('installEdukaPwa', $content);
    }

    /**
     * Test that manager dashboard includes universal PWA integration.
     */
    public function test_manager_dashboard_includes_pwa_integration(): void
    {
        $response = $this->get('/manager/dashboard');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('/manifest.json', $content);
        $this->assertStringContainsString('/sw.js', $content);
        $this->assertStringContainsString('eduka-pwa-install-banner', $content);
        $this->assertStringContainsString('installEdukaPwa', $content);
    }

    /**
     * Test that POS and storekeeper views include universal PWA integration.
     */
    public function test_pos_and_storekeeper_views_include_pwa_integration(): void
    {
        $responsePos = $this->get('/pos');
        $responsePos->assertStatus(200);
        $this->assertStringContainsString('/manifest.json', $responsePos->getContent());
        $this->assertStringContainsString('eduka-pwa-install-banner', $responsePos->getContent());

        $responseStore = $this->get('/storekeeper/dashboard');
        $responseStore->assertStatus(200);
        $this->assertStringContainsString('/manifest.json', $responseStore->getContent());
        $this->assertStringContainsString('eduka-pwa-install-banner', $responseStore->getContent());
    }

    /**
     * Test that all generated PWA icons exist and have valid file sizes.
     */
    public function test_all_pwa_icons_exist_with_valid_files(): void
    {
        $icons = [
            'icons/icon-192x192.png',
            'icons/icon-512x512.png',
            'icons/icon-maskable-192x192.png',
            'icons/icon-maskable-512x512.png',
            'icons/apple-touch-icon.png',
            'icons/icon.svg',
            'icons/screenshot-desktop.png',
            'icons/screenshot-mobile.png',
        ];

        foreach ($icons as $icon) {
            $path = public_path($icon);
            $this->assertFileExists($path, "Icon {$icon} should exist.");
            $this->assertGreaterThan(500, filesize($path), "Icon {$icon} should not be empty.");
        }

        $faviconPath = public_path('favicon.ico');
        $this->assertFileExists($faviconPath);
        $this->assertGreaterThan(100, filesize($faviconPath));
    }

    /**
     * Test that manifest and sw HTTP routes respond with correct content type and PWA headers.
     */
    public function test_pwa_routes_serve_correct_content_type_headers(): void
    {
        $responseManifest = $this->get('/manifest.json');
        $responseManifest->assertStatus(200);
        $this->assertStringContainsString('application/manifest+json', (string) $responseManifest->headers->get('Content-Type'));

        $responseWebmanifest = $this->get('/manifest.webmanifest');
        $responseWebmanifest->assertStatus(200);
        $this->assertStringContainsString('application/manifest+json', (string) $responseWebmanifest->headers->get('Content-Type'));

        $responseSw = $this->get('/sw.js');
        $responseSw->assertStatus(200);
        $this->assertStringContainsString('application/javascript', (string) $responseSw->headers->get('Content-Type'));
        $this->assertEquals('/', $responseSw->headers->get('Service-Worker-Allowed'));
    }

    /**
     * Test that manifest includes W3C PWA features: id, display_override, screenshots, and maskable icons.
     */
    public function test_manifest_contains_w3c_pwa_features(): void
    {
        $manifest = json_decode((string) file_get_contents(public_path('manifest.json')), true);

        $this->assertEquals('/?source=pwa', $manifest['id'] ?? null);
        $this->assertArrayHasKey('display_override', $manifest);
        $this->assertContains('standalone', $manifest['display_override']);
        $this->assertArrayHasKey('screenshots', $manifest);
        $this->assertNotEmpty($manifest['screenshots']);
    }
}
