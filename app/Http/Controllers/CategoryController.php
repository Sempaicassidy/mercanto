<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display category listing and management dashboard for the store manager/owner.
     */
    public function index(Request $request): View
    {
        $tenantId = $this->resolveActiveTenantId();
        $tenant = Tenant::find($tenantId) ?? Tenant::first();

        $categories = Category::query()
            ->where('tenant_id', $tenant->id)
            ->withCount('products')
            ->with(['products.branchStocks'])
            ->orderBy('sort_order')
            ->orderBy('id', 'asc')
            ->get();

        // Calculate KPI values
        $totalCategories = $categories->count();
        $totalProducts = Product::where('tenant_id', $tenant->id)->count();

        // Calculate estimated stock value per category and overall
        $categories->each(function (Category $category) {
            $totalStockValue = 0;
            foreach ($category->products as $product) {
                $qty = $product->branchStocks->sum('quantity');
                $price = (float) ($product->selling_price ?: $product->cost_price ?: 0);
                $totalStockValue += ($qty > 0 ? $qty : 5) * $price;
            }
            $category->estimated_stock_value = $totalStockValue;
        });

        $totalEstimatedStock = $categories->sum('estimated_stock_value');
        $averageMargin = $totalCategories > 0 ? round($categories->avg('target_margin') ?: 25, 1) : 25.0;

        $topCategory = $categories->sortByDesc('products_count')->first();
        $topCategoryName = $topCategory ? $topCategory->name : 'N/A';

        $availableChains = $this->getAvailableChains();

        // Detect current dominant chain
        $dominantChainKey = $categories->whereNotNull('business_chain')
            ->groupBy('business_chain')
            ->sortByDesc(fn ($group) => $group->count())
            ->keys()
            ->first();

        return view('manager.category', [
            'tenant' => $tenant,
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
            'totalEstimatedStock' => $totalEstimatedStock,
            'averageMargin' => $averageMargin,
            'topCategoryName' => $topCategoryName,
            'availableChains' => $availableChains,
            'currentChainKey' => $dominantChainKey,
        ]);
    }

    /**
     * Store a new custom category tailored to the store owner's product chain.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'target_margin' => 'nullable|numeric|min:0|max:100',
            'business_chain' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $tenantId = $this->resolveActiveTenantId();

        $name = trim((string) $request->input('name'));
        $code = $request->filled('code')
            ? strtoupper(trim((string) $request->input('code')))
            : 'CAT-'.strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 4));

        $category = Category::create([
            'tenant_id' => $tenantId,
            'name' => $name,
            'code' => $code,
            'description' => $request->input('description'),
            'icon' => $request->input('icon') ?: 'bi-tags',
            'target_margin' => (float) ($request->input('target_margin') ?: 20.0),
            'business_chain' => $request->input('business_chain') ?: 'custom',
            'is_active' => $request->boolean('is_active', true),
        ]);

        $message = __('Kitengo cha bidhaa ":name" kimeundwa kikamilifu!', ['name' => $category->name]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'category' => $category,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, Category $category): JsonResponse|RedirectResponse
    {
        $tenantId = $this->resolveActiveTenantId();

        if ($category->tenant_id !== $tenantId) {
            abort(403, 'Unauthorized access to this category.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'target_margin' => 'nullable|numeric|min:0|max:100',
            'business_chain' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => trim((string) $request->input('name')),
            'code' => $request->filled('code') ? strtoupper(trim((string) $request->input('code'))) : $category->code,
            'description' => $request->input('description'),
            'icon' => $request->input('icon') ?: $category->icon,
            'target_margin' => (float) ($request->input('target_margin') ?: $category->target_margin),
            'business_chain' => $request->input('business_chain') ?: $category->business_chain,
            'is_active' => $request->boolean('is_active', $category->is_active),
        ]);

        $message = __('Kitengo cha ":name" kimesasishwa kikamilifu!', ['name' => $category->name]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'category' => $category,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Toggle category active/inactive status.
     */
    public function toggleStatus(Category $category): JsonResponse|RedirectResponse
    {
        $tenantId = $this->resolveActiveTenantId();

        if ($category->tenant_id !== $tenantId) {
            abort(403, 'Unauthorized access to this category.');
        }

        $category->is_active = ! $category->is_active;
        $category->save();

        $statusText = $category->is_active ? 'kimewashwa (Active)' : 'kimezimwa (Inactive)';
        $message = "Kitengo \"{$category->name}\" sasa {$statusText}.";

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $category->is_active,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Delete or archive a category.
     */
    public function destroy(Request $request, Category $category): JsonResponse|RedirectResponse
    {
        $tenantId = $this->resolveActiveTenantId();

        if ($category->tenant_id !== $tenantId) {
            abort(403, 'Unauthorized access to this category.');
        }

        $name = $category->name;

        // Disassociate products belonging to this category safely
        Product::where('category_id', $category->id)->update(['category_id' => null]);

        $category->delete();

        $message = __('Kitengo cha ":name" kimefutwa kikamilifu.', ['name' => $name]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Apply a tailored Business Product Chain Preset for this specific store.
     */
    public function applyChainPreset(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'chain_key' => 'required|string',
            'mode' => 'nullable|string|in:replace,append',
        ]);

        $tenantId = $this->resolveActiveTenantId();
        $chainKey = (string) $request->input('chain_key');
        $mode = (string) $request->input('mode', 'replace');

        $availableChains = $this->getAvailableChains();

        if (! isset($availableChains[$chainKey])) {
            return response()->json(['success' => false, 'message' => 'Msururu wa biashara uliouchagua haupo.'], 422);
        }

        $selectedChain = $availableChains[$chainKey];

        // If replace mode, delete empty categories or disassociate products from existing
        if ($mode === 'replace') {
            $existingCategories = Category::where('tenant_id', $tenantId)->get();
            foreach ($existingCategories as $existing) {
                Product::where('category_id', $existing->id)->update(['category_id' => null]);
                $existing->delete();
            }
        }

        $createdCount = 0;
        foreach ($selectedChain['categories'] as $index => $item) {
            Category::create([
                'tenant_id' => $tenantId,
                'name' => $item['name'],
                'code' => $item['code'],
                'icon' => $item['icon'],
                'description' => $item['description'],
                'target_margin' => (float) $item['margin'],
                'business_chain' => $chainKey,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
            $createdCount++;
        }

        $message = __("Msururu wa biashara wa ':chain' umewekwa na vitengo :count vimeundwa kikamilifu!", [
            'chain' => $selectedChain['name'],
            'count' => $createdCount,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'created_count' => $createdCount,
                'chain' => $selectedChain['name'],
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get JSON categories for AJAX select menus (e.g., in Stock and POS).
     */
    public function apiCategories(): JsonResponse
    {
        $tenantId = $this->resolveActiveTenantId();

        $categories = Category::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'code', 'icon', 'target_margin', 'business_chain']);

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }

    /**
     * Resolve the active tenant ID from session, authenticated user, or fallback.
     */
    protected function resolveActiveTenantId(): int
    {
        if (session()->has('tenant_id') && session('tenant_id')) {
            return (int) session('tenant_id');
        }

        if (Auth::check() && Auth::user()->tenant_id) {
            return (int) Auth::user()->tenant_id;
        }

        $fallbackTenant = Tenant::first();

        return $fallbackTenant ? (int) $fallbackTenant->id : 1;
    }

    /**
     * Defined Business Product Chains dictionary.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getAvailableChains(): array
    {
        return [
            'grains_grocery' => [
                'name' => 'Nafaka, Unga & Vyakula (Grain & Grocery Store)',
                'icon' => 'bi-box2-heart',
                'badge_color' => '#d97706',
                'description' => 'Msururu wa maduka ya nafaka, mchele, unga wa sembe/dona, maharage, sukari na viungo.',
                'categories' => [
                    ['name' => 'Mchele & Nafaka Safi', 'code' => 'CAT-MCH', 'icon' => 'bi-box2-heart', 'margin' => 18, 'description' => 'Mchele wa Kyela, Kilombero, Basmati, mtama, ulezi na mahindi'],
                    ['name' => 'Unga wa Sembe, Dona & Ngano', 'code' => 'CAT-UNG', 'icon' => 'bi-archive', 'margin' => 16, 'description' => 'Unga wa Azam, Bakhresa, lishe, ngano na muhogo'],
                    ['name' => 'Sukari, Chumvi & Viungo', 'code' => 'CAT-SUK', 'icon' => 'bi-droplet-half', 'margin' => 20, 'description' => 'Sukari nyeupe, ya kahawia, chumvi ya mawe/madini na pilipili manga'],
                    ['name' => 'Maharage, Dengu & Kunde', 'code' => 'CAT-LEG', 'icon' => 'bi-grid-fill', 'margin' => 22, 'description' => 'Maharage ya soya, njano, roko, dengu, mbaazi na kunde'],
                    ['name' => 'Mafuta ya Kupikia', 'code' => 'CAT-OIL', 'icon' => 'bi-droplet', 'margin' => 15, 'description' => 'Mafuta ya alizeti, mawese, pamba, Korie, Mo safi na dumu'],
                ],
            ],

            'hardware_construction' => [
                'name' => 'Vifaa vya Ujenzi & Hardware (Hardware & Construction)',
                'icon' => 'bi-hammer',
                'badge_color' => '#0284c7',
                'description' => 'Msururu wa maduka ya saruji, nondo, mabati, rangi, mabomba na zana za ujenzi.',
                'categories' => [
                    ['name' => 'Saruji, Chokaa & Vyakula vya Ujenzi', 'code' => 'CAT-SRJ', 'icon' => 'bi-box', 'margin' => 14, 'description' => 'Saruji ya Dangote, Twiga, Simba, chokaa na gundi ya vigae'],
                    ['name' => 'Nondo, Mabati & Misumari', 'code' => 'CAT-MET', 'icon' => 'bi-shield', 'margin' => 18, 'description' => 'Nondo mm10/12/16, mabati ya migongo, misumari na waya za kufungia'],
                    ['name' => 'Mabomba, Sinki & Vifaa vya Maji', 'code' => 'CAT-PLM', 'icon' => 'bi-water', 'margin' => 28, 'description' => 'Mabomba ya PVC, PPR, sinki, mabomba ya shaba, tepe na valves'],
                    ['name' => 'Rangi, Brashi & Kemikali', 'code' => 'CAT-PNT', 'icon' => 'bi-brush', 'margin' => 32, 'description' => 'Rangi za kuta, mafuta, gloss, thinner, na brashi za kisasa'],
                    ['name' => 'Vifaa vya Umeme & Waya', 'code' => 'CAT-ELE', 'icon' => 'bi-lightning-charge', 'margin' => 30, 'description' => 'Waya za umeme, swichi, soketi, taa za LED na circuit breakers'],
                ],
            ],

            'pharmacy_cosmetics' => [
                'name' => 'Duka la Dawa & Famasi (Pharmacy & Healthcare)',
                'icon' => 'bi-prescription2',
                'badge_color' => '#16a34a',
                'description' => 'Famasi, maduka ya dawa baridi, virutubisho na vifaa tiba vya afya.',
                'categories' => [
                    ['name' => 'Dawa za Maumivu & Homa (Analgesics)', 'code' => 'CAT-ANL', 'icon' => 'bi-capsule', 'margin' => 35, 'description' => 'Panadol, diclofenac, paracetamol, ibuprofen na dawa za homa'],
                    ['name' => 'Viua Sumu & Dawa za Mfumo', 'code' => 'CAT-ANT', 'icon' => 'bi-capsule-pill', 'margin' => 40, 'description' => 'Antibiotics, antacids, dawa za minyoo na malaria'],
                    ['name' => 'Virutubisho & Vitamini', 'code' => 'CAT-VIT', 'icon' => 'bi-heart-pulse', 'margin' => 45, 'description' => 'Multi-vitamins, Vitamin C, Zinc, Cod Liver Oil na lishe tiba'],
                    ['name' => 'Huduma ya Kwanza & Vifaa Tiba', 'code' => 'CAT-MED', 'icon' => 'bi-bandaid', 'margin' => 30, 'description' => 'Bandage, pamba, spirit, syringe, glavu na vipima joto'],
                    ['name' => 'Vipodozi Tiba & Usafi wa Mwili', 'code' => 'CAT-DER', 'icon' => 'bi-flower1', 'margin' => 35, 'description' => 'Mafuta ya ngozi, sabuni za dawa, miswaki, dawa za meno na pads'],
                ],
            ],

            'fashion_clothing' => [
                'name' => 'Nguo, Viatu & Mitindo (Fashion & Boutique)',
                'icon' => 'bi-bag-heart',
                'badge_color' => '#ec4899',
                'description' => 'Boutique ya nguo za kike na kiume, viatu, mabegi na vifaa vya urembo.',
                'categories' => [
                    ['name' => 'Mavazi ya Kiume', 'code' => 'CAT-MEN', 'icon' => 'bi-person', 'margin' => 50, 'description' => 'Shati, suruali za jeans na vitambaa, tisheti, suti na kaptura'],
                    ['name' => 'Mavazi ya Kike & Gauni', 'code' => 'CAT-WMN', 'icon' => 'bi-gender-female', 'margin' => 55, 'description' => 'Gauni, sketi, blauzi, madela, mitandio na magauni ya shughuli'],
                    ['name' => 'Mavazi ya Watoto', 'code' => 'CAT-KID', 'icon' => 'bi-balloon', 'margin' => 45, 'description' => 'Nguo za watoto wachanga, nguo za shule na mavazi ya sikukuu'],
                    ['name' => 'Viatu & Kandambili', 'code' => 'CAT-FOT', 'icon' => 'bi-tag', 'margin' => 40, 'description' => 'Viatu vya ngozi, raba/sneakers, sandals za kisasa na heels'],
                    ['name' => 'Mabegi, Mikanda & Vifaa', 'code' => 'CAT-ACC', 'icon' => 'bi-handbag', 'margin' => 50, 'description' => 'Mabegi ya mkononi, pochi, mikanda ya ngozi, saa na kofia'],
                ],
            ],

            'electronics_appliances' => [
                'name' => 'Elektroniki & Simu (Electronics & Phones)',
                'icon' => 'bi-phone',
                'badge_color' => '#8b5cf6',
                'description' => 'Maduka ya simu, kompyuta, mifumo ya sauti, TV, sola na vifaa vya umeme.',
                'categories' => [
                    ['name' => 'Simu Janja & Tablets', 'code' => 'CAT-PHN', 'icon' => 'bi-phone', 'margin' => 15, 'description' => 'Smartphones za Samsung, iPhone, Tecno, Infinix na tablets'],
                    ['name' => 'Accessories za Simu & Kompyuta', 'code' => 'CAT-ACS', 'icon' => 'bi-usb-symbol', 'margin' => 50, 'description' => 'Chargers, USB cables, earphones, covers, powerbanks na screen protectors'],
                    ['name' => 'Mifumo ya Sauti & Smart TVs', 'code' => 'CAT-AUD', 'icon' => 'bi-speaker', 'margin' => 25, 'description' => 'Smart TVs, subwoofers, soundbars na radio za kisasa'],
                    ['name' => 'Vifaa vya Umeme wa Jua (Sola)', 'code' => 'CAT-SOL', 'icon' => 'bi-sun', 'margin' => 20, 'description' => 'Solar panels, inverters, betri za kuhifadhi umeme na taa za sola'],
                    ['name' => 'Kompyuta, Laptops & Printa', 'code' => 'CAT-CMP', 'icon' => 'bi-laptop', 'margin' => 22, 'description' => 'Laptops, mouse, keyboards, flash drives na wino wa printers'],
                ],
            ],

            'butchery_fresh' => [
                'name' => 'Nyama, Samaki & Machinjio (Butchery & Fresh Foods)',
                'icon' => 'bi-egg-fried',
                'badge_color' => '#ef4444',
                'description' => 'Mabucha ya nyama, samaki wabichi, kuku na vyakula freshi vya sokoni.',
                'categories' => [
                    ['name' => 'Nyama ya Ng\'ombe & Mbuzi', 'code' => 'CAT-BEEF', 'icon' => 'bi-egg', 'margin' => 25, 'description' => 'Minofu, mifupa, maini, ulimi, figo na nyama ya kusaga'],
                    ['name' => 'Kuku wa Kienyeji & Kisasa', 'code' => 'CAT-CHK', 'icon' => 'bi-egg-fill', 'margin' => 22, 'description' => 'Kuku wazima, mapaja, vifua, maini na trey za mayai freshi'],
                    ['name' => 'Samaki & Vyakula vya Baharini', 'code' => 'CAT-FSH', 'icon' => 'bi-water', 'margin' => 28, 'description' => 'Sato, sangara, nguru, pweza, kamba na dagaa wa kukaanga'],
                    ['name' => 'Mbogamboga & Matunda Freshi', 'code' => 'CAT-VEG', 'icon' => 'bi-tree', 'margin' => 35, 'description' => 'Nyanya, vitunguu, karoti, hoho, ndizi na parachichi'],
                ],
            ],

            'general_supermarket' => [
                'name' => 'Supermarket & Rejareja ya Jumla (General Supermarket)',
                'icon' => 'bi-cart-check',
                'badge_color' => '#10b981',
                'description' => 'Maduka ya jumla na rejareja ya bidhaa mchanganyiko za familia na nyumbani.',
                'categories' => [
                    ['name' => 'Vyakula & Nafaka za Kila Siku', 'code' => 'CAT-GRC', 'icon' => 'bi-box2-heart', 'margin' => 18, 'description' => 'Mchele, unga wa ngano/sembe, sukari, pasta na mikate'],
                    ['name' => 'Vinywaji & Maji ya Kunywa', 'code' => 'CAT-BEV', 'icon' => 'bi-cup-straw', 'margin' => 24, 'description' => 'Soda, maji ya chupa, juisi za pakiti na energy drinks'],
                    ['name' => 'Dawa & Usafi wa Nyumbani', 'code' => 'CAT-CLN', 'icon' => 'bi-stars', 'margin' => 28, 'description' => 'Sabuni za unga, kuogea, dawa ya meno, bleaches na brushes'],
                    ['name' => 'Mafuta & Viungo vya Jikoni', 'code' => 'CAT-SPN', 'icon' => 'bi-droplet', 'margin' => 22, 'description' => 'Mafuta ya kula, michuzi, chumvi, pilipili na viungo'],
                    ['name' => 'Vitafunio & Pipi', 'code' => 'CAT-SNK', 'icon' => 'bi-cookie', 'margin' => 35, 'description' => 'Biskuti, crisps, pipi, chokoleti na vitafunio vya watoto'],
                ],
            ],
        ];
    }
}
