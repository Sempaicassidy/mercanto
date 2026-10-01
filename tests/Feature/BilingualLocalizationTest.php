<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\App;
use Tests\TestCase;

class BilingualLocalizationTest extends TestCase
{
    public function test_default_locale_is_swahili(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        // Without session, default is Kiswahili ('sw')
        $this->assertEquals('sw', App::getLocale());
    }

    public function test_can_switch_language_to_english(): void
    {
        $response = $this->get('/switch-language/en');
        $response->assertSessionHas('locale', 'en');
        $response->assertSessionHas('language_switched', 'en');

        // Next request inherits session locale
        $responseLogin = $this->withSession(['locale' => 'en'])->get('/login');
        $responseLogin->assertStatus(200);
        $this->assertEquals('en', App::getLocale());
    }

    public function test_can_switch_language_to_swahili(): void
    {
        $response = $this->get('/switch-language/sw');
        $response->assertSessionHas('locale', 'sw');
        $response->assertSessionHas('language_switched', 'sw');

        $responseLogin = $this->withSession(['locale' => 'sw'])->get('/login');
        $responseLogin->assertStatus(200);
        $this->assertEquals('sw', App::getLocale());
    }

    public function test_switch_language_via_json_api(): void
    {
        $response = $this->getJson('/switch-language/en');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'locale' => 'en',
            'message' => 'Language changed to English.',
        ]);

        $responseSw = $this->getJson('/switch-language/sw');
        $responseSw->assertStatus(200);
        $responseSw->assertJson([
            'success' => true,
            'locale' => 'sw',
            'message' => 'Lugha imebadilishwa kuwa Kiswahili.',
        ]);
    }

    public function test_locale_alias_redirects(): void
    {
        $response = $this->get('/locale/en');
        $response->assertRedirect('/switch-language/en');
    }

    public function test_switch_language_handles_unsupported_locale_gracefully(): void
    {
        $response = $this->get('/switch-language/french');
        // Falls back to 'sw'
        $response->assertSessionHas('locale', 'sw');
    }

    public function test_translations_resolve_correctly_per_locale(): void
    {
        App::setLocale('sw');
        $this->assertEquals('Dashibodi', __('Dashboard'));
        $this->assertEquals('Simamia Duka', __('Manage Store'));

        App::setLocale('en');
        $this->assertEquals('Dashboard', __('Dashboard'));
        $this->assertEquals('Manage Store', __('Manage Store'));
    }

    public function test_query_parameter_lang_overrides_locale(): void
    {
        $this->get('/login?lang=en');
        $this->assertEquals('en', App::getLocale());

        $this->get('/login?lang=sw');
        $this->assertEquals('sw', App::getLocale());
    }

    public function test_login_page_renders_in_selected_language(): void
    {
        // Swahili render
        $respSw = $this->withSession(['locale' => 'sw'])->get('/login');
        $respSw->assertStatus(200);
        $respSw->assertSee('🇹🇿 Kiswahili');
        $respSw->assertSee('Barua Pepe au Jina la Mtumiaji');
        $respSw->assertSee('INGIA (LOGIN)');

        // English render
        $respEn = $this->withSession(['locale' => 'en'])->get('/login');
        $respEn->assertStatus(200);
        $respEn->assertSee('🇬🇧 English');
        $respEn->assertSee('Email or Username');
        $respEn->assertSee('SIGN IN (LOGIN)');
    }

    public function test_core_dashboards_render_language_switcher(): void
    {
        // Manager dashboard
        $respManager = $this->get('/manager/dashboard');
        $respManager->assertStatus(200);
        $respManager->assertSee('universalLangSwitcher');
        $respManager->assertSee('/switch-language/sw');
        $respManager->assertSee('/switch-language/en');

        // Cashier POS dashboard
        $respCashier = $this->get('/pos');
        $respCashier->assertStatus(200);
        $respCashier->assertSee('universalLangSwitcher');

        // Storekeeper dashboard
        $respStorekeeper = $this->get('/storekeeper/dashboard');
        $respStorekeeper->assertStatus(200);
        $respStorekeeper->assertSee('universalLangSwitcher');
    }

    public function test_get_translation_dictionary_api(): void
    {
        $responseSw = $this->getJson('/api/translations/sw');
        $responseSw->assertStatus(200)
            ->assertJson([
                'success' => true,
                'locale' => 'sw',
            ])
            ->assertJsonStructure([
                'success',
                'locale',
                'count',
                'dictionary',
            ]);

        $this->assertGreaterThan(50, $responseSw->json('count'));

        $responseEn = $this->getJson('/api/translations/en');
        $responseEn->assertStatus(200)
            ->assertJson([
                'success' => true,
                'locale' => 'en',
            ]);
    }

    public function test_translate_single_text_api(): void
    {
        $response = $this->postJson('/api/translate', [
            'text' => 'Fast Tap Catalog',
            'source' => 'en',
            'target' => 'sw',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'source' => 'en',
                'target' => 'sw',
                'original' => 'Fast Tap Catalog',
                'translated' => 'Katalogi ya Mauzo ya Haraka',
            ]);
    }

    public function test_translate_batch_texts_api(): void
    {
        $response = $this->postJson('/api/translate', [
            'texts' => [
                'Drawer Balance',
                'Active Queue',
                'Exact Cash',
            ],
            'source' => 'en',
            'target' => 'sw',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'source' => 'en',
                'target' => 'sw',
            ]);

        $translations = $response->json('translations');
        $this->assertEquals('Salio la Droo ya Pesa', $translations['Drawer Balance']);
        $this->assertEquals('Wateja Wanaosubiri', $translations['Active Queue']);
        $this->assertEquals('Pesa Kamili', $translations['Exact Cash']);
    }

    public function test_translate_reverse_swahili_to_english_api(): void
    {
        $response = $this->postJson('/api/translate', [
            'text' => 'Dashibodi',
            'source' => 'sw',
            'target' => 'en',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'source' => 'sw',
                'target' => 'en',
                'original' => 'Dashibodi',
                'translated' => 'Dashboard',
            ]);
    }

    public function test_translate_skips_numeric_and_currency_tokens(): void
    {
        $response = $this->postJson('/api/translate', [
            'text' => 'TSh 150,000',
            'source' => 'en',
            'target' => 'sw',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'original' => 'TSh 150,000',
                'translated' => 'TSh 150,000',
            ]);
    }

    public function test_pos_dashboard_renders_products_and_units_bilingually(): void
    {
        // 1. English POS Dashboard
        $respEn = $this->withSession(['locale' => 'en'])->get('/pos');
        $respEn->assertStatus(200);
        $respEn->assertSee('<div class="product-name">Kilombero Sugar</div>', false);
        $respEn->assertSee('5 Units');
        $respEn->assertSee('Sack (68k)');
        $respEn->assertSee('Half (1.65k)');
        $respEn->assertSee('Jerrycan (28.5k)');
        $respEn->assertSee('Grains & Sugar');
        $respEn->assertSee('Stock 120 Bags');
        $respEn->assertSee('Cash Tendered');
        $respEn->assertSee('Change:');
        $respEn->assertSee('Complete &amp; Print Receipt', false);
        $respEn->assertDontSee('<div class="product-name">Sukari ya Kilombero</div>', false);

        // 2. Kiswahili POS Dashboard
        $respSw = $this->withSession(['locale' => 'sw'])->get('/pos');
        $respSw->assertStatus(200);
        $respSw->assertSee('<div class="product-name">Sukari ya Kilombero</div>', false);
        $respSw->assertSee('Vipimo 5');
        $respSw->assertSee('Gunia (68k)');
        $respSw->assertSee('Nusu (1.65k)');
        $respSw->assertSee('Dumu (28.5k)');
        $respSw->assertSee('Nafaka na Sukari');
        $respSw->assertSee('Stoo: Mifuko 120');
        $respSw->assertSee('Pesa Iliyopokelewa');
        $respSw->assertSee('Chenji:');
        $respSw->assertSee('Kamilisha &amp; Chapisha Resiti', false);
        $respSw->assertDontSee('<div class="product-name">Kilombero Sugar</div>', false);
    }

    public function test_manager_dashboard_renders_bilingually(): void
    {
        // 1. English Manager Dashboard
        $respEn = $this->withSession(['locale' => 'en'])->get('/manager/dashboard');
        $respEn->assertStatus(200);
        $respEn->assertSee('Manager Dashboard');
        $respEn->assertSee('Overview');
        $respEn->assertSee('Analytics');
        $respEn->assertSee('Total Retail Sales');

        // 2. Kiswahili Manager Dashboard
        $respSw = $this->withSession(['locale' => 'sw'])->get('/manager/dashboard');
        $respSw->assertStatus(200);
        $respSw->assertSee('Dashibodi ya Meneja');
        $respSw->assertSee('Muhtasari');
        $respSw->assertSee('Uchambuzi');
        $respSw->assertSee('Jumla ya Mauzo ya Rejareja');
    }

    public function test_storekeeper_dashboard_renders_bilingually(): void
    {
        // 1. English Storekeeper Dashboard
        $respEn = $this->withSession(['locale' => 'en'])->get('/storekeeper/dashboard');
        $respEn->assertStatus(200);
        $respEn->assertSee('Storekeeper &amp; Warehouse Dashboard', false);
        $respEn->assertSee('Total Catalog SKUs');
        $respEn->assertSee('Warehouse Stock Value');

        // 2. Kiswahili Storekeeper Dashboard
        $respSw = $this->withSession(['locale' => 'sw'])->get('/storekeeper/dashboard');
        $respSw->assertStatus(200);
        $respSw->assertSee('Dashibodi ya Stoo &amp; Ghala', false);
        $respSw->assertSee('Jumla ya Bidhaa (Catalog)');
        $respSw->assertSee('Thamani Halisi ya Stoo');
    }
}
