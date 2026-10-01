@php
    $currentBusinessMode = session('business_mode', 'retailer'); // 'retailer' or 'wholesaler'
    $isWholesale = $currentBusinessMode === 'wholesaler';
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
    $swDictionary = file_exists(base_path('lang/sw.json')) ? json_decode((string) file_get_contents(base_path('lang/sw.json')), true) : [];
    $enDictionary = file_exists(base_path('lang/en.json')) ? json_decode((string) file_get_contents(base_path('lang/en.json')), true) : [];

    $currentRouteIsSuperAdmin = request()->is('super-admin*') || session('active_role') === 'super_admin';
    $currentRouteIsCashier = (request()->is('pos*') || request()->is('cashier*')) && !$currentRouteIsSuperAdmin;
    $currentRouteIsStorekeeper = request()->is('storekeeper*') && !$currentRouteIsSuperAdmin;
    $currentRouteIsManager = !$currentRouteIsCashier && !$currentRouteIsStorekeeper && !$currentRouteIsSuperAdmin;

    if ($currentRouteIsSuperAdmin) {
        $activeRoleLabel = $isSwahili ? 'Msimamizi Mkuu (SaaS)' : 'Super Admin (SaaS)';
        $activeRoleIcon = 'bi-shield-shaded';
        $activeRoleColor = '#dc2626';
    } elseif ($currentRouteIsCashier) {
        $activeRoleLabel = $isSwahili ? 'Muuzaji / POS' : 'Cashier / POS';
        $activeRoleIcon = 'bi-receipt';
        $activeRoleColor = '#16a34a';
    } elseif ($currentRouteIsStorekeeper) {
        $activeRoleLabel = $isSwahili ? 'Mtunza Stoo' : 'Storekeeper';
        $activeRoleIcon = 'bi-box-seam';
        $activeRoleColor = '#d97706';
    } else {
        $activeRoleLabel = $isSwahili ? 'Meneja wa Duka' : 'Store Manager';
        $activeRoleIcon = 'bi-shield-check';
        $activeRoleColor = '#2563eb';
    }
@endphp

@if(session('masquerade_tenant_id'))
    @php
        $supportTenant = \App\Models\Tenant::find(session('masquerade_tenant_id'));
    @endphp
    <div style="position: fixed; top: 0; left: 0; right: 0; z-index: 999999; background: #fef08a; border-bottom: 2px solid #eab308; color: #854d0e; padding: 7px 18px; font-size: 0.83rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
            <span>{{ $isSwahili ? 'MODI YA USAIDIZI WA KITEKNIKIA (Super Admin Support): Umeingia katika duka la' : 'SUPER ADMIN SUPPORT MASQUERADE: Managing store' }} <strong class="text-dark">{{ $supportTenant?->name ?? 'Store' }}</strong>. {{ $isSwahili ? 'Mabadiliko yote yanatekelezwa moja kwa moja kwenye duka hili.' : 'All changes are active on this store.' }}</span>
        </div>
        <a href="{{ route('super_admin.end-masquerade') }}" class="btn btn-sm btn-dark" style="font-size: 0.76rem; border-radius: 9999px; padding: 3px 12px; font-weight: 700;">
            <i class="bi bi-box-arrow-left me-1"></i> {{ $isSwahili ? 'Ondoka kwenye Usaidizi' : 'Exit Support Mode' }}
        </a>
    </div>
@endif

<div class="universal-header-controls" style="display: contents;">
    <!-- Universal Role & Business Mode Switcher -->
    <div class="universal-role-switcher" id="universalRoleSwitcher">
        <button type="button" class="role-switcher-btn" id="universalRoleBtn" title="{{ $isSwahili ? 'Badili Wadhifa au Aina ya Biashara' : 'Switch Role or Business Mode' }}">
            <i class="bi {{ $activeRoleIcon }}" style="color: {{ $activeRoleColor }}; font-size: 0.95rem;"></i>
            <span class="role-switcher-text">{{ $activeRoleLabel }}</span>
            <span class="mode-pill-badge {{ $currentRouteIsSuperAdmin ? 'badge-superadmin' : ($isWholesale ? 'badge-wholesale' : 'badge-retail') }}">
                {{ $currentRouteIsSuperAdmin ? 'SaaS HQ' : ($isWholesale ? ($isSwahili ? 'Jumla' : 'Wholesale') : ($isSwahili ? 'Rejareja' : 'Retail')) }}
            </span>
            <i class="bi bi-chevron-down text-muted" style="font-size: 0.65rem; margin-left: 2px;"></i>
        </button>

        <div class="role-switcher-menu" id="universalRoleMenu">
            <!-- Business Mode Isolation Toggle -->
            <div class="mode-section-header">
                <span class="menu-section-title">
                    <i class="bi bi-shop-window me-1"></i> {{ $isSwahili ? 'Aina ya Biashara' : 'Business Mode' }}
                </span>
                <span class="badge {{ $isWholesale ? 'bg-purple-subtle text-purple' : 'bg-primary-subtle text-primary' }}" style="font-size: 0.65rem;">
                    {{ $isWholesale ? ($isSwahili ? 'Jumla (Wholesale)' : 'Wholesaler') : ($isSwahili ? 'Rejareja (Retail)' : 'Retailer') }}
                </span>
            </div>
            <div class="mode-selector-grid">
                <a href="{{ url('/switch-business-mode/retailer') }}" class="mode-select-btn {{ !$isWholesale ? 'active' : '' }}" title="{{ $isSwahili ? 'Weka mfumo kuwa wa Rejareja (POS & Kaunta)' : 'Switch to Retail Mode (POS & Counter)' }}">
                    <i class="bi bi-cart3"></i>
                    <span>{{ $isSwahili ? 'Rejareja (Retail)' : 'Retail Store' }}</span>
                </a>
                <a href="{{ url('/switch-business-mode/wholesaler') }}" class="mode-select-btn {{ $isWholesale ? 'active' : '' }}" title="{{ $isSwahili ? 'Weka mfumo kuwa wa Jumla (Wholesale & Supplier)' : 'Switch to Wholesale & Supplier Mode' }}">
                    <i class="bi bi-boxes"></i>
                    <span>{{ $isSwahili ? 'Jumla (Supplier)' : 'Wholesale' }}</span>
                </a>
            </div>

            <div class="menu-divider"></div>

            <!-- Role Selection -->
            <div class="role-menu-header">
                <span class="menu-section-title">
                    <i class="bi bi-person-badge me-1"></i> {{ $isSwahili ? 'Wadhifa (Roles)' : 'User Roles' }}
                </span>
            </div>

            <!-- Super Admin (SaaS Platform) -->
            <a href="{{ url('/switch-role/super_admin') }}" class="role-menu-item {{ $currentRouteIsSuperAdmin ? 'active' : '' }}">
                <div class="role-icon-box" style="background: rgba(220, 38, 38, 0.12); color: #dc2626;">
                    <i class="bi bi-shield-shaded"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; font-size: 0.82rem; line-height: 1.2;">{{ $isSwahili ? 'Msimamizi Mkuu (SaaS)' : 'Super Admin (Platform)' }}</div>
                    <div style="font-size: 0.7rem; color: var(--text-muted, #71717a); line-height: 1.2;">{{ $isSwahili ? 'Tenants, Mikataba, Support' : 'Tenants, Leases, Support' }}</div>
                </div>
                @if($currentRouteIsSuperAdmin)
                    <i class="bi bi-check2 text-danger fw-bold"></i>
                @endif
            </a>

            <!-- Store Manager -->
            <a href="{{ url('/switch-role/manager') }}" class="role-menu-item {{ $currentRouteIsManager ? 'active' : '' }}">
                <div class="role-icon-box" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; font-size: 0.82rem; line-height: 1.2;">{{ $isSwahili ? 'Meneja wa Duka' : 'Store Manager' }}</div>
                    <div style="font-size: 0.7rem; color: var(--text-muted, #71717a); line-height: 1.2;">{{ $isSwahili ? 'Ripoti, Madeni, Usimamizi' : 'Reports, Receivables, Admin' }}</div>
                </div>
                @if($currentRouteIsManager)
                    <i class="bi bi-check2 text-primary fw-bold"></i>
                @endif
            </a>

            <!-- Cashier / POS -->
            <a href="{{ url('/switch-role/cashier') }}" class="role-menu-item {{ $currentRouteIsCashier ? 'active' : '' }}">
                <div class="role-icon-box" style="background: rgba(22, 163, 74, 0.12); color: #16a34a;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; font-size: 0.82rem; line-height: 1.2;">{{ $isSwahili ? 'Muuzaji / POS' : 'Cashier / POS' }}</div>
                    <div style="font-size: 0.7rem; color: var(--text-muted, #71717a); line-height: 1.2;">
                        {{ $isWholesale ? ($isSwahili ? 'Mauzo ya Jumla & Risiti' : 'Wholesale Orders & Invoices') : ($isSwahili ? 'Mauzo ya Kaunta & Zamu' : 'Counter Sales & Shifts') }}
                    </div>
                </div>
                @if($currentRouteIsCashier)
                    <i class="bi bi-check2 text-success fw-bold"></i>
                @endif
            </a>

            <!-- Storekeeper -->
            <a href="{{ url('/switch-role/storekeeper') }}" class="role-menu-item {{ $currentRouteIsStorekeeper ? 'active' : '' }}">
                <div class="role-icon-box" style="background: rgba(217, 119, 6, 0.12); color: #d97706;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; font-size: 0.82rem; line-height: 1.2;">{{ $isSwahili ? 'Mtunza Stoo' : 'Storekeeper' }}</div>
                    <div style="font-size: 0.7rem; color: var(--text-muted, #71717a); line-height: 1.2;">
                        {{ $isWholesale ? ($isSwahili ? 'Stoo Kuu & Ghala' : 'Main Warehouse & Bulk') : ($isSwahili ? 'Stoo ya Duka & Rafu' : 'Store Inventory & Shelves') }}
                    </div>
                </div>
                @if($currentRouteIsStorekeeper)
                    <i class="bi bi-check2 text-warning fw-bold"></i>
                @endif
            </a>

            <div class="menu-divider"></div>

            <!-- Language Quick Switcher in Menu -->
            <div class="mode-section-header">
                <span class="menu-section-title">
                    <i class="bi bi-translate me-1"></i> {{ $isSwahili ? 'Lugha (Language)' : 'Language' }}
                </span>
                <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">
                    {{ $isSwahili ? '🇹🇿 Kiswahili' : '🇬🇧 English' }}
                </span>
            </div>
            <div class="mode-selector-grid">
                <a href="{{ url('/switch-language/sw') }}" class="mode-select-btn {{ $isSwahili ? 'active' : '' }}" title="Tumia Lugha ya Kiswahili">
                    <span>🇹🇿 Kiswahili</span>
                </a>
                <a href="{{ url('/switch-language/en') }}" class="mode-select-btn {{ !$isSwahili ? 'active' : '' }}" title="Use English Language">
                    <span>🇬🇧 English</span>
                </a>
            </div>

            <div class="menu-divider"></div>
            <!-- PWA Install Action -->
            <div style="padding: 4px 8px 8px 8px;">
                <button type="button" class="btn btn-sm w-100 text-start d-flex align-items-center justify-content-between" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 10px; color: #10b981; font-weight: 600; font-size: 0.78rem; padding: 7px 10px; transition: all 0.15s ease;" onclick="if(window.installMercantoPwa){window.installMercantoPwa();}else if(window.installEdukaPwa){window.installEdukaPwa();}else{alert('Mercanto PWA');}">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-phone"></i>
                        <span>{{ $isSwahili ? 'Sakinisha App (PWA)' : 'Install App (PWA)' }}</span>
                    </span>
                    <i class="bi bi-download"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Standalone Top Bar Language Switcher Component -->
    <div class="universal-lang-switcher" id="universalLangSwitcher">
        <button type="button" class="lang-switcher-btn" id="universalLangBtn" title="{{ $isSwahili ? 'Badili Lugha (Kiswahili / Kiingereza)' : 'Switch Language (Swahili / English)' }}">
            <span class="lang-flag">{{ $isSwahili ? '🇹🇿' : '🇬🇧' }}</span>
            <span class="lang-label">{{ $isSwahili ? 'Kiswahili' : 'English' }}</span>
            <i class="bi bi-chevron-down text-muted" style="font-size: 0.65rem; margin-left: 2px;"></i>
        </button>

        <div class="lang-switcher-menu" id="universalLangMenu">
            <div class="lang-menu-header">
                <span class="menu-section-title">
                    <i class="bi bi-translate me-1"></i> {{ $isSwahili ? 'Chagua Lugha' : 'Select Language' }}
                </span>
                <span class="badge {{ $isSwahili ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }}" style="font-size: 0.65rem;">
                    {{ strtoupper($currentLocale) }}
                </span>
            </div>

            <a href="{{ url('/switch-language/sw') }}" class="lang-menu-item {{ $isSwahili ? 'active' : '' }}" data-locale="sw">
                <span class="lang-flag-large">🇹🇿</span>
                <div style="flex: 1; min-width: 0;">
                    <div class="lang-title">Kiswahili</div>
                    <div class="lang-desc">Lugha ya Kiswahili</div>
                </div>
                @if($isSwahili)
                    <i class="bi bi-check2 text-success fw-bold"></i>
                @endif
            </a>

            <a href="{{ url('/switch-language/en') }}" class="lang-menu-item {{ !$isSwahili ? 'active' : '' }}" data-locale="en">
                <span class="lang-flag-large">🇬🇧</span>
                <div style="flex: 1; min-width: 0;">
                    <div class="lang-title">English</div>
                    <div class="lang-desc">English Language</div>
                </div>
                @if(!$isSwahili)
                    <i class="bi bi-check2 text-primary fw-bold"></i>
                @endif
            </a>
        </div>
    </div>
    <!-- Mobile Slide-out Drawer Backdrop Overlay -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Mobile Bottom App Bar (Thumb-friendly navigation on screens <= 992px) -->
    <nav class="mobile-bottom-appbar d-lg-none" id="mobileBottomAppbar" aria-label="Mobile Navigation">
        @if($currentRouteIsSuperAdmin)
            <a href="{{ url('/super-admin/dashboard') }}" 
               class="bottom-appbar-item {{ request()->is('super-admin/dashboard') ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}">
                <i class="bi bi-speedometer2"></i>
                <span>{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}</span>
            </a>
            
            <a href="{{ url('/super-admin/tenants') }}" 
               class="bottom-appbar-item {{ request()->is('super-admin/tenants*') ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Maduka' : 'Tenants' }}">
                <i class="bi bi-shop-window"></i>
                <span>{{ $isSwahili ? 'Maduka' : 'Tenants' }}</span>
            </a>

            <a href="{{ url('/super-admin/contracts') }}" 
               class="bottom-appbar-item bottom-pos-fab {{ request()->is('super-admin/contracts*') ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Mikataba' : 'Contracts' }}">
                <div class="bottom-fab-circle" style="background: #2563eb;">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <span>{{ $isSwahili ? 'Mikataba' : 'Contracts' }}</span>
            </a>

            <a href="{{ url('/super-admin/support') }}" 
               class="bottom-appbar-item {{ request()->is('super-admin/support*') ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Msaada' : 'Support' }}">
                <i class="bi bi-headset"></i>
                <span>{{ $isSwahili ? 'Msaada' : 'Support' }}</span>
            </a>

            <button type="button" 
                    class="bottom-appbar-item" 
                    id="mobileMenuDrawerBtn" 
                    aria-label="{{ $isSwahili ? 'Fungua Menyu' : 'Open Menu' }}" 
                    title="{{ $isSwahili ? 'Menyu' : 'Menu' }}">
                <i class="bi bi-grid-fill"></i>
                <span>{{ $isSwahili ? 'Menyu' : 'Menu' }}</span>
            </button>
        @else
            <a href="{{ $currentRouteIsCashier ? url('/cashier/dashboard') : ($currentRouteIsStorekeeper ? url('/storekeeper/dashboard') : url('/manager/dashboard')) }}" 
               class="bottom-appbar-item {{ (request()->is('*dashboard*') && !request()->is('pos*')) ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}">
                <i class="bi bi-speedometer2"></i>
                <span>{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}</span>
            </a>
            
            <a href="{{ url('/pos') }}" 
               class="bottom-appbar-item bottom-pos-fab {{ request()->is('pos*') ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Kaunta ya Mauzo (POS)' : 'POS Checkout' }}">
                <div class="bottom-fab-circle">
                    <i class="bi bi-receipt"></i>
                </div>
                <span>POS</span>
            </a>

            <a href="{{ $currentRouteIsStorekeeper ? url('/storekeeper/stock') : url('/manager/stock') }}" 
               class="bottom-appbar-item {{ request()->is('*stock*') ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Stoo / Bidhaa' : 'Inventory Stock' }}">
                <i class="bi bi-boxes"></i>
                <span>{{ $isSwahili ? 'Bidhaa' : 'Stock' }}</span>
            </a>

            <a href="{{ $currentRouteIsCashier ? url('/shifts') : ($currentRouteIsStorekeeper ? url('/transfers') : url('/manager/auditing')) }}" 
               class="bottom-appbar-item {{ (request()->is('*audit*') || request()->is('*shift*') || request()->is('*report*') || request()->is('*expense*') || request()->is('*transfer*')) ? 'active' : '' }}" 
               title="{{ $isSwahili ? 'Ripoti' : 'Reports' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>{{ $isSwahili ? 'Ripoti' : 'Reports' }}</span>
            </a>

            <button type="button" 
                    class="bottom-appbar-item" 
                    id="mobileMenuDrawerBtn" 
                    aria-label="{{ $isSwahili ? 'Fungua Menyu' : 'Open Menu' }}" 
                    title="{{ $isSwahili ? 'Menyu' : 'Menu' }}">
                <i class="bi bi-grid-fill"></i>
                <span>{{ $isSwahili ? 'Menyu' : 'Menu' }}</span>
            </button>
        @endif
    </nav>
</div>

<style>
    /* Universal Header Alignment Guarantee across ALL pages */
    .top-nav-bar {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
        margin-bottom: 1.5rem !important;
        gap: 12px !important;
        flex-wrap: nowrap !important;
        box-sizing: border-box !important;
    }

    .top-nav-actions {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 8px !important;
        flex-wrap: nowrap !important;
        margin-left: auto !important;
        flex-shrink: 0 !important;
    }

    .universal-header-controls {
        display: contents !important;
    }

    .header-branch-pill,
    .branch-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        height: 36px !important;
        padding: 0 12px !important;
        border-radius: 9999px !important;
        border: 1px solid var(--border-color, #e4e4e7) !important;
        background-color: var(--card-bg, #ffffff) !important;
        color: var(--text-dark, #09090b) !important;
        font-size: 0.78rem !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        box-sizing: border-box !important;
        margin: 0 !important;
    }

    .branch-indicator-dot {
        width: 6px !important;
        height: 6px !important;
        border-radius: 50% !important;
        background-color: #10b981 !important;
        display: inline-block !important;
        flex-shrink: 0 !important;
    }

    .universal-role-switcher,
    .universal-lang-switcher {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        flex-shrink: 0 !important;
        margin: 0 !important;
    }

    .role-switcher-btn,
    .lang-switcher-btn {
        height: 36px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 0 12px !important;
        border-radius: 9999px !important;
        border: 1px solid var(--border-color, #e4e4e7) !important;
        background-color: var(--card-bg, #ffffff) !important;
        color: var(--text-dark, #09090b) !important;
        font-size: 0.78rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        box-sizing: border-box !important;
        margin: 0 !important;
    }

    .lang-switcher-btn {
        padding: 0 10px !important;
    }

    .role-switcher-btn:hover,
    .lang-switcher-btn:hover,
    .nav-icon-btn:hover,
    .header-profile-btn:hover {
        background-color: var(--nav-active-bg, #f4f4f5) !important;
        border-color: #a1a1aa !important;
        transform: translateY(-1px) !important;
    }

    .nav-icon-btn {
        width: 36px !important;
        height: 36px !important;
        min-width: 36px !important;
        max-width: 36px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 9999px !important;
        border: 1px solid var(--border-color, #e4e4e7) !important;
        background-color: var(--card-bg, #ffffff) !important;
        color: var(--text-dark, #09090b) !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
        padding: 0 !important;
        box-sizing: border-box !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
        font-size: 0.95rem !important;
    }

    .header-profile-dropdown {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        flex-shrink: 0 !important;
        margin: 0 !important;
    }

    .header-profile-btn {
        height: 36px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 3px 12px 3px 4px !important;
        border-radius: 9999px !important;
        border: 1px solid var(--border-color, #e4e4e7) !important;
        background-color: var(--card-bg, #ffffff) !important;
        color: var(--text-dark, #09090b) !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        box-sizing: border-box !important;
        margin: 0 !important;
    }

    .header-avatar {
        width: 28px !important;
        height: 28px !important;
        border-radius: 50% !important;
        background-color: #18181b !important;
        color: #ffffff !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }

    .header-user-meta {
        display: flex !important;
        flex-direction: column !important;
        text-align: left !important;
        line-height: 1.15 !important;
    }

    .header-user-name {
        font-size: 0.78rem !important;
        font-weight: 600 !important;
        color: var(--text-dark, #09090b) !important;
        white-space: nowrap !important;
    }

    .header-user-role {
        font-size: 0.68rem !important;
        color: var(--text-muted, #71717a) !important;
        white-space: nowrap !important;
    }

    .header-dropdown-arrow {
        font-size: 0.65rem !important;
        color: var(--text-muted, #71717a) !important;
        margin-left: 2px !important;
    }

    /* Responsive clean handling */
    @media (max-width: 1200px) {
        .header-branch-pill,
        .branch-pill {
            display: none !important;
        }
    }
    .role-switcher-menu,
    .lang-switcher-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 300px;
        background-color: var(--card-bg, #ffffff);
        border: 1px solid var(--border-color, #e4e4e7);
        border-radius: 12px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.18);
        padding: 8px;
        display: none;
        flex-direction: column;
        z-index: 9999;
        animation: roleMenuAnim 0.15s ease-out;
    }
    .lang-switcher-menu {
        width: 250px;
    }
    @keyframes roleMenuAnim {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .universal-role-switcher.show .role-switcher-menu,
    .universal-lang-switcher.show .lang-switcher-menu {
        display: flex;
    }
    .mode-section-header, .role-menu-header, .lang-menu-header {
        padding: 4px 6px 6px 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .lang-menu-header {
        border-bottom: 1px solid var(--border-color, #e4e4e7);
        margin-bottom: 4px;
        padding-bottom: 6px;
    }
    .menu-section-title {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted, #71717a);
        letter-spacing: 0.5px;
    }
    .mode-selector-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        padding: 2px 4px 6px 4px;
    }
    .mode-select-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 8px;
        border-radius: 8px;
        border: 1px solid var(--border-color, #e4e4e7);
        background: var(--card-bg, #ffffff);
        color: var(--text-dark, #09090b);
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .mode-select-btn:hover {
        background-color: var(--nav-active-bg, #f4f4f5);
        border-color: #a1a1aa;
    }
    .mode-select-btn.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
    .menu-divider {
        border-top: 1px solid var(--border-color, #e4e4e7);
        margin: 6px 0;
    }
    .role-menu-item,
    .lang-menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 8px;
        text-decoration: none;
        color: var(--text-dark, #09090b);
        transition: all 0.15s ease;
        font-size: 0.82rem;
    }
    .role-menu-item:hover,
    .lang-menu-item:hover {
        background-color: var(--nav-active-bg, #f4f4f5);
        color: var(--text-dark, #09090b);
    }
    .role-menu-item.active,
    .lang-menu-item.active {
        background-color: var(--nav-active-bg, #f4f4f5);
        font-weight: 600;
    }
    .role-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .lang-title {
        font-weight: 600;
        font-size: 0.82rem;
        line-height: 1.2;
    }
    .lang-desc {
        font-size: 0.7rem;
        color: var(--text-muted, #71717a);
        line-height: 1.2;
    }

    /* ========================================================
       MOBILE-FIRST RESPONSIVE STYLING & COMPONENT ENHANCEMENTS
       ======================================================== */
    
    /* Touch Target & Base Polish */
    html, body {
        overflow-x: hidden !important;
        -webkit-tap-highlight-color: transparent;
    }

    /* Backdrop for Mobile Drawer */
    .sidebar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 10040;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.25s ease;
    }
    .sidebar-backdrop.show {
        opacity: 1;
        visibility: visible;
    }

    body.mobile-drawer-open {
        overflow: hidden !important;
        touch-action: none;
    }

    /* Close Button inside Sidebar */
    .sidebar-drawer-close-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 8px;
        border: 1px solid var(--border-color, #e4e4e7);
        background: var(--card-bg, #ffffff);
        color: var(--text-dark, #09090b);
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.15s ease;
        margin-left: auto;
    }
    .sidebar-drawer-close-btn:hover {
        background-color: var(--nav-active-bg, #f4f4f5);
        border-color: #a1a1aa;
    }

    /* Mobile Header Brand & Hamburger */
    .mobile-nav-header-left {
        display: none;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .mobile-hamburger-btn {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 9999px;
        border: 1px solid var(--border-color, #e4e4e7);
        background-color: var(--card-bg, #ffffff);
        color: var(--text-dark, #09090b);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    .mobile-hamburger-btn:hover,
    .mobile-hamburger-btn:active {
        background-color: var(--nav-active-bg, #f4f4f5);
        border-color: #a1a1aa;
        transform: scale(0.97);
    }
    .mobile-header-brand {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        color: var(--text-dark, #09090b);
        font-weight: 800;
        font-size: 1.05rem;
        letter-spacing: -0.3px;
    }
    .mobile-brand-icon {
        width: 28px;
        height: 28px;
        background-color: #18181b;
        color: #ffffff;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }
    body.dark-mode .mobile-brand-icon {
        background-color: #fafafa;
        color: #18181b;
    }

    /* Mobile Bottom App Bar */
    .mobile-bottom-appbar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: var(--card-bg, #ffffff);
        border-top: 1px solid var(--border-color, #e4e4e7);
        display: none;
        align-items: center;
        justify-content: space-around;
        padding: 4px 6px calc(4px + env(safe-area-inset-bottom, 0px)) 6px;
        z-index: 10030;
        box-shadow: 0 -3px 16px rgba(0, 0, 0, 0.07);
        box-sizing: border-box;
    }
    .bottom-appbar-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        flex: 1;
        height: 100%;
        text-decoration: none;
        color: var(--text-muted, #71717a);
        font-size: 0.68rem;
        font-weight: 500;
        padding: 4px 2px;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }
    .bottom-appbar-item i {
        font-size: 1.15rem;
        line-height: 1;
        transition: transform 0.15s ease, color 0.15s ease;
    }
    .bottom-appbar-item:hover {
        color: var(--text-dark, #09090b);
    }
    .bottom-appbar-item.active {
        color: #2563eb;
        font-weight: 700;
    }
    .bottom-appbar-item.active i {
        transform: scale(1.12);
        color: #2563eb;
    }
    .bottom-fab-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #16a34a;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -12px;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
        transition: all 0.2s ease;
    }
    .bottom-appbar-item.bottom-pos-fab {
        color: #16a34a;
        font-weight: 700;
    }
    .bottom-appbar-item.bottom-pos-fab:hover .bottom-fab-circle,
    .bottom-appbar-item.bottom-pos-fab.active .bottom-fab-circle {
        transform: scale(1.08) translateY(-2px);
        box-shadow: 0 6px 16px rgba(22, 163, 74, 0.45);
    }

    /* Dark Mode Bottom App Bar */
    body.dark-mode .mobile-bottom-appbar {
        background-color: #111113;
        border-top-color: #27272a;
        box-shadow: 0 -3px 18px rgba(0, 0, 0, 0.45);
    }
    body.dark-mode .bottom-appbar-item {
        color: #a1a1aa;
    }
    body.dark-mode .bottom-appbar-item:hover {
        color: #fafafa;
    }
    body.dark-mode .bottom-appbar-item.active {
        color: #60a5fa;
    }
    body.dark-mode .bottom-appbar-item.active i {
        color: #60a5fa;
    }

    /* MEDIA QUERIES FOR SCREENS <= 992px */
    @media (max-width: 992px) {
        .mobile-nav-header-left {
            display: inline-flex !important;
        }

        .mobile-bottom-appbar {
            display: flex !important;
        }

        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 290px !important;
            max-width: 86vw !important;
            height: 100vh !important;
            height: 100dvh !important;
            z-index: 10050 !important;
            transform: translateX(-100%) !important;
            transition: transform 0.28s cubic-bezier(0.33, 1, 0.68, 1) !important;
            box-shadow: none !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            background-color: var(--sidebar-bg, #ffffff) !important;
        }

        .sidebar.mobile-open {
            transform: translateX(0) !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.45) !important;
        }

        .main-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100vw !important;
            padding: 0.85rem 0.85rem calc(5.5rem + env(safe-area-inset-bottom, 12px)) 0.85rem !important;
            box-sizing: border-box !important;
        }

        /* Top Nav Bar on Mobile */
        .top-nav-bar {
            flex-wrap: wrap !important;
            row-gap: 8px !important;
            margin-bottom: 1rem !important;
            width: 100% !important;
        }

        .pos-title-wrap {
            display: none !important;
        }

        .header-search-box {
            order: 10 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 4px !important;
        }

        .search-input {
            width: 100% !important;
            height: 40px !important;
            font-size: 0.9rem !important;
        }

        .top-nav-actions {
            margin-left: auto !important;
            gap: 6px !important;
        }

        /* Tables & Content Cards Auto-scroll */
        .content-card,
        .card,
        .table-responsive-wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            border-radius: 12px !important;
        }

        table {
            min-width: 100% !important;
        }

        /* Stat cards scaling */
        .stat-value {
            font-size: 1.45rem !important;
        }

        /* Dashboard tabs horizontal scrolling */
        .dashboard-tabs {
            display: flex !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
            flex-wrap: nowrap !important;
            gap: 6px !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
            padding-bottom: 4px !important;
            margin-bottom: 1rem !important;
        }
        .dashboard-tabs::-webkit-scrollbar {
            display: none !important;
        }

        /* Role & Lang Switcher Dropdown placement on mobile */
        .role-switcher-menu,
        .lang-switcher-menu {
            right: 0 !important;
            left: auto !important;
            max-width: 90vw !important;
        }
    }

    /* EXTRA COMPACT FOR PHONE SCREENS <= 576px */
    @media (max-width: 576px) {
        .main-wrapper {
            padding: 0.65rem 0.65rem calc(5.5rem + env(safe-area-inset-bottom, 12px)) 0.65rem !important;
        }

        .role-switcher-btn {
            padding: 0 8px !important;
            gap: 4px !important;
        }

        .role-switcher-text {
            display: none !important;
        }

        .mode-pill-badge {
            font-size: 0.65rem !important;
            padding: 2px 5px !important;
        }

        .lang-switcher-btn {
            padding: 0 8px !important;
        }

        .lang-label {
            display: none !important;
        }

        .header-profile-btn {
            padding: 2px !important;
        }

        .header-dropdown-arrow {
            display: none !important;
        }

        .role-switcher-menu {
            width: 280px !important;
        }
        
        .lang-switcher-menu {
            width: 240px !important;
        }

        .search-kbd {
            display: none !important;
        }
    }
</style>

<script>
    (function() {
        const SERVER_SW_DICT = @json($swDictionary);
        const SERVER_EN_DICT = @json($enDictionary);

        // Core UI Dictionary
        const DICTIONARY = {
            'Dashboard': { sw: 'Dashibodi', en: 'Dashboard' },
            'Manager Dashboard': { sw: 'Dashibodi ya Meneja', en: 'Manager Dashboard' },
            'Manage Store': { sw: 'Simamia Duka', en: 'Manage Store' },
            'Products & Stock': { sw: 'Bidhaa na Stoo', en: 'Products & Stock' },
            'POS / Cashier': { sw: 'POS / Kaunta ya Mauzo', en: 'POS / Cashier' },
            'Categories': { sw: 'Makundi ya Bidhaa', en: 'Categories' },
            'Suppliers': { sw: 'Wasambazaji', en: 'Suppliers' },
            'Customers & Credit': { sw: 'Wateja na Mikopo', en: 'Customers & Credit' },
            'Purchase Orders (LPO)': { sw: 'Maagizo ya Manunuzi (LPO)', en: 'Purchase Orders (LPO)' },
            'Branch Transfers': { sw: 'Uhamisho wa Matawi', en: 'Branch Transfers' },
            'Operations': { sw: 'Uendeshaji', en: 'Operations' },
            'Shift & Cash Register': { sw: 'Zamu na Droo ya Pesa', en: 'Shift & Cash Register' },
            'Returns & Refunds': { sw: 'Marejesho na Malipo', en: 'Returns & Refunds' },
            'Stock Audit & Wastage': { sw: 'Ukaguzi wa Stoo na Hasara', en: 'Stock Audit & Wastage' },
            'Manage Staff': { sw: 'Simamia Wafanyakazi', en: 'Manage Staff' },
            'Staff Shifts & Attendance': { sw: 'Zamu na Mahudhurio', en: 'Staff Shifts & Attendance' },
            'Staff Salary & Allowances': { sw: 'Mishahara na Posho', en: 'Staff Salary & Allowances' },
            'Permissions': { sw: 'Ruhusa na Mamlaka', en: 'Permissions' },
            'Permissions & Access': { sw: 'Ruhusa na Mamlaka', en: 'Permissions & Access' },
            'Reports': { sw: 'Ripoti', en: 'Reports' },
            'Sales Report': { sw: 'Ripoti ya Mauzo', en: 'Sales Report' },
            'Expense Report': { sw: 'Ripoti ya Matumizi', en: 'Expense Report' },
            'Inventory Report': { sw: 'Ripoti ya Hesabu ya Stoo', en: 'Inventory Report' },
            'Auditing': { sw: 'Ukaguzi wa Mfumo', en: 'Auditing' },
            'Activity Logs': { sw: 'Kumbukumbu za Shughuli', en: 'Activity Logs' },
            'Audit Trail & Alerts': { sw: 'Mwenendo wa Ukaguzi na Tahadhari', en: 'Audit Trail & Alerts' },
            'Auditing Settings & Roles': { sw: 'Mipangilio ya Ukaguzi na Wadhifa', en: 'Auditing Settings & Roles' },
            'Cashier Shift Reports': { sw: 'Ripoti za Zamu za Mauzo', en: 'Cashier Shift Reports' },
            'General': { sw: 'Ujumla', en: 'General' },
            'Business Mode': { sw: 'Aina ya Biashara', en: 'Business Mode' },
            'Retail': { sw: 'Rejareja', en: 'Retail' },
            'Wholesale': { sw: 'Jumla', en: 'Wholesale' },
            'Retailer': { sw: 'Rejareja', en: 'Retailer' },
            'Wholesaler': { sw: 'Jumla', en: 'Wholesaler' },
            'Main Branch (HQ)': { sw: 'Tawi Kuu (Makao Makuu)', en: 'Main Branch (HQ)' },
            'Main Branch': { sw: 'Tawi Kuu', en: 'Main Branch' },
            'Counter 03 • Main HQ': { sw: 'Kaunta Namba 03 • Tawi Kuu', en: 'Counter 03 • Main HQ' },
            'Terminal 03 • Counter': { sw: 'Kaunta Namba 03', en: 'Terminal 03 • Counter' },
            'Store Manager': { sw: 'Meneja wa Duka', en: 'Store Manager' },
            'Cashier / POS': { sw: 'Muuzaji / POS', en: 'Cashier / POS' },
            'Storekeeper': { sw: 'Mtunza Stoo', en: 'Storekeeper' },
            'Administrator': { sw: 'Msimamizi Mkuu', en: 'Administrator' },
            'Super Admin (SaaS)': { sw: 'Msimamizi Mkuu (SaaS)', en: 'Super Admin (SaaS)' },
            'Sign Out': { sw: 'Toka Kwenye Mfumo', en: 'Sign Out' },
            'Toggle theme': { sw: 'Badili Mwonekano', en: 'Toggle theme' },
            'Total Sales Today': { sw: 'Jumla ya Mauzo Leo', en: 'Total Sales Today' },
            'Wholesale Sales Today': { sw: 'Mauzo ya Jumla Leo', en: 'Wholesale Sales Today' },
            'Retail Sales Today': { sw: 'Mauzo ya Rejareja Leo', en: 'Retail Sales Today' },
            'Sales Today': { sw: 'Mauzo ya Leo', en: 'Sales Today' },
            'Net Profit': { sw: 'Faida Halisi', en: 'Net Profit' },
            'Today\'s Expenses': { sw: 'Matumizi ya Leo', en: 'Today\'s Expenses' },
            'Total Inventory': { sw: 'Hesabu ya Stoo', en: 'Total Inventory' },
            'Low Stock Alerts': { sw: 'Tahadhari ya Bidhaa Zinazoisha', en: 'Low Stock Alerts' },
            'Out of Stock': { sw: 'Bidhaa Zilizokwisha', en: 'Out of Stock' },
            'Trade Credit Issued': { sw: 'Mikopo ya Biashara Iliyotolewa', en: 'Trade Credit Issued' },
            'Pending Supplier Payments': { sw: 'Malipo ya Wasambazaji Yanayosubiri', en: 'Pending Supplier Payments' },
            'Bulk Orders In Queue': { sw: 'Maagizo ya Jumla Yanaosubiri', en: 'Bulk Orders In Queue' },
            'Sales Trend': { sw: 'Mwenendo wa Mauzo', en: 'Sales Trend' },
            'Top Selling Products': { sw: 'Bidhaa Zinazouzika Zaidi', en: 'Top Selling Products' },
            'Recent Orders': { sw: 'Maagizo ya Hivi Karibuni', en: 'Recent Orders' },
            'Recent Activity': { sw: 'Shughuli za Hivi Karibuni', en: 'Recent Activity' },
            'Fast Tap Catalog': { sw: 'Katalogi ya Mauzo ya Haraka', en: 'Fast Tap Catalog' },
            'Wholesale Bulk Catalog': { sw: 'Katalogi ya Mauzo ya Jumla', en: 'Wholesale Bulk Catalog' },
            'Tap item to add to basket': { sw: 'Bofya bidhaa kuongeza kwenye kikapu', en: 'Tap item to add to basket' },
            'Tap bulk carton / sack to add to wholesale invoice': { sw: 'Bofya boksi au gunia kuongeza kwenye ankara ya jumla', en: 'Tap bulk carton / sack to add to wholesale invoice' },
            'All Items': { sw: 'Bidhaa Zote', en: 'All Items' },
            'Grains & Flour': { sw: 'Nafaka na Unga', en: 'Grains & Flour' },
            'Cooking Oils': { sw: 'Mafuta ya Kupikia', en: 'Cooking Oils' },
            'Beverages': { sw: 'Vinywaji', en: 'Beverages' },
            'Snacks': { sw: 'Vitafunio', en: 'Snacks' },
            'Household': { sw: 'Vifaa vya Usafi', en: 'Household' },
            'Dairy & Fresh': { sw: 'Maziwa na Vyakula Vibichi', en: 'Dairy & Fresh' },
            'Vipimo': { sw: 'Vipimo', en: 'Units' },
            'Units': { sw: 'Vipimo', en: 'Units' },
            'Drawer Balance': { sw: 'Salio la Droo ya Pesa', en: 'Drawer Balance' },
            'Active Queue': { sw: 'Wateja Wanaosubiri', en: 'Active Queue' },
            'Orders': { sw: 'Maagizo', en: 'Orders' },
            'Opening:': { sw: 'Salio la Kuanzia:', en: 'Opening:' },
            'Verified': { sw: 'Imethibitishwa', en: 'Verified' },
            'Receipts': { sw: 'Resiti', en: 'Receipts' },
            'Register Balance': { sw: 'Salio la Rejista', en: 'Register Balance' },
            'Live': { sw: 'Mubashara', en: 'Live' },
            'Resiti za Leo': { sw: 'Resiti za Leo', en: 'Today\'s Receipts' },
            'Today\'s Receipts': { sw: 'Resiti za Leo', en: 'Today\'s Receipts' },
            'Recent Sales': { sw: 'Mauzo ya Hivi Karibuni', en: 'Recent Sales' },
            'Recent Wholesale Orders': { sw: 'Maagizo ya Hivi Karibuni ya Jumla', en: 'Recent Wholesale Orders' },
            'Active Ticket': { sw: 'Tiketi Inayoendelea', en: 'Active Ticket' },
            'Customer:': { sw: 'Mteja:', en: 'Customer:' },
            'Walk-in Customer': { sw: 'Mteja wa Kawaida (Mpita Njia)', en: 'Walk-in Customer' },
            'Walk-in Retail': { sw: 'Mteja wa Kawaida (Mpita Njia)', en: 'Walk-in Retail' },
            'Clear Cart': { sw: 'Futa Kikapu', en: 'Clear Cart' },
            'Clear': { sw: 'Safisha', en: 'Clear' },
            'Subtotal': { sw: 'Jumla Ndogo', en: 'Subtotal' },
            'VAT (Included 18%)': { sw: 'Kodi ya VAT (18% Imejumuishwa)', en: 'VAT (Included 18%)' },
            'Discount': { sw: 'Punguzo', en: 'Discount' },
            'Service Fee': { sw: 'Ada ya Huduma', en: 'Service Fee' },
            'Total Payable': { sw: 'Jumla ya Kulipa', en: 'Total Payable' },
            'Grand Total': { sw: 'Jumla Kuu', en: 'Grand Total' },
            'Payment Method': { sw: 'Njia ya Malipo', en: 'Payment Method' },
            'Cash': { sw: 'Pesa Taslimu', en: 'Cash' },
            'Card': { sw: 'Kadi ya Benki', en: 'Card' },
            'M-Pesa': { sw: 'M-Pesa', en: 'M-Pesa' },
            'Mobile Money': { sw: 'Pesa ya Simu', en: 'Mobile Money' },
            'Exact Cash': { sw: 'Pesa Kamili', en: 'Exact Cash' },
            'Exact': { sw: 'Kamili', en: 'Exact' },
            'Cash Tendered': { sw: 'Pesa Iliyotolewa', en: 'Cash Tendered' },
            'Pesa Iliyopokelewa (Tendered)': { sw: 'Pesa Iliyopokelewa', en: 'Cash Tendered' },
            'Change': { sw: 'Chenji', en: 'Change' },
            'Change Due': { sw: 'Chenji Inayotakiwa', en: 'Change Due' },
            'Complete Sale': { sw: 'Kamilisha Mauzo', en: 'Complete Sale' },
            'Complete & Print Receipt': { sw: 'Kamilisha & Chapisha Resiti', en: 'Complete & Print Receipt' },
            'Kamilisha & Chapisha Resiti': { sw: 'Kamilisha & Chapisha Resiti', en: 'Complete & Print Receipt' },
            'Hold Order': { sw: 'Sitisha Oda', en: 'Hold Order' },
            'Hold Ticket': { sw: 'Weka Tiketi Kiporo', en: 'Hold Ticket' },
            'Weka Tiketi Kiporo (Hold)': { sw: 'Weka Tiketi Kiporo (Hold)', en: 'Hold Ticket (Hold)' },
            'Print Receipt': { sw: 'Chapisha Resiti', en: 'Print Receipt' },
            'Actions': { sw: 'Vitendo', en: 'Actions' },
            'Action': { sw: 'Kitendo', en: 'Action' },
            'Status': { sw: 'Hali', en: 'Status' },
            'Active': { sw: 'Inafanya Kazi', en: 'Active' },
            'Inactive': { sw: 'Haifanyi Kazi', en: 'Inactive' },
            'Filter': { sw: 'Chuja', en: 'Filter' },
            'Search': { sw: 'Tafuta', en: 'Search' },
            'Reset': { sw: 'Weka Upya', en: 'Reset' },
            'Save Changes': { sw: 'Hifadhi Mabadiliko', en: 'Save Changes' },
            'Save': { sw: 'Hifadhi', en: 'Save' },
            'Cancel': { sw: 'Ghairi', en: 'Cancel' },
            'Delete': { sw: 'Futa', en: 'Delete' },
            'Edit': { sw: 'Hariri', en: 'Edit' },
            'View': { sw: 'Tazama', en: 'View' },
            'Close': { sw: 'Funga', en: 'Close' },
            'Export CSV': { sw: 'Pakua CSV', en: 'Export CSV' },
            'Export PDF': { sw: 'Pakua PDF', en: 'Export PDF' },
            'Add New': { sw: 'Ongeza Mpya', en: 'Add New' },
            'Product Name': { sw: 'Jina la Bidhaa', en: 'Product Name' },
            'Category': { sw: 'Kikundi', en: 'Category' },
            'Buying Price': { sw: 'Bei ya Kununua', en: 'Buying Price' },
            'Selling Price': { sw: 'Bei ya Kuuza', en: 'Selling Price' },
            'Current Stock': { sw: 'Idadi Iliyopo Stoo', en: 'Current Stock' },
            'Quantity': { sw: 'Idadi', en: 'Quantity' },
            'Date': { sw: 'Tarehe', en: 'Date' },
            'Amount': { sw: 'Kiasi', en: 'Amount' },
            'Description': { sw: 'Maelezo', en: 'Description' },
            // Products & Categories
            'Sukari ya Kilombero': { sw: 'Sukari ya Kilombero', en: 'Kilombero Sugar' },
            'Kilombero Sugar': { sw: 'Sukari ya Kilombero', en: 'Kilombero Sugar' },
            'Kilombero Super Rice': { sw: 'Mchele Safi wa Kilombero', en: 'Kilombero Super Rice' },
            'Mchele Safi wa Kilombero': { sw: 'Mchele Safi wa Kilombero', en: 'Kilombero Super Rice' },
            'Korie Cooking Oil': { sw: 'Mafuta ya Korie', en: 'Korie Cooking Oil' },
            'Mafuta ya Korie': { sw: 'Mafuta ya Korie', en: 'Korie Cooking Oil' },
            'Bakhresa Wheat Flour': { sw: 'Unga wa Ngano wa Bakhresa', en: 'Bakhresa Wheat Flour' },
            'Unga wa Ngano wa Bakhresa': { sw: 'Unga wa Ngano wa Bakhresa', en: 'Bakhresa Wheat Flour' },
            'Potato Crisps 100g': { sw: 'Krisi za Viazi 100g', en: 'Potato Crisps 100g' },
            'Krisi za Viazi 100g': { sw: 'Krisi za Viazi 100g', en: 'Potato Crisps 100g' },
            'Dishwashing Liquid': { sw: 'Sabuni ya Vyombo', en: 'Dishwashing Liquid' },
            'Sabuni ya Vyombo': { sw: 'Sabuni ya Vyombo', en: 'Dishwashing Liquid' },
            'Toothpaste Large': { sw: 'Dawa ya Meno Kubwa', en: 'Toothpaste Large' },
            'Dawa ya Meno Kubwa': { sw: 'Dawa ya Meno Kubwa', en: 'Toothpaste Large' },
            'Bottled Water 1L': { sw: 'Maji ya Chupa 1L', en: 'Bottled Water 1L' },
            'Maji ya Chupa 1L': { sw: 'Maji ya Chupa 1L', en: 'Bottled Water 1L' },
            'Milk Packet 1L': { sw: 'Maziwa ya Pakiti 1L', en: 'Milk Packet 1L' },
            'Maziwa ya Pakiti 1L': { sw: 'Maziwa ya Pakiti 1L', en: 'Milk Packet 1L' },
            'Grains & Sugar': { sw: 'Nafaka na Sukari', en: 'Grains & Sugar' },
            'Nafaka na Sukari': { sw: 'Nafaka na Sukari', en: 'Grains & Sugar' },
            // Units & Packaging
            'Gunia': { sw: 'Gunia', en: 'Sack' },
            'Sack': { sw: 'Gunia', en: 'Sack' },
            'Dumu': { sw: 'Dumu', en: 'Jerrycan' },
            'Jerrycan': { sw: 'Dumu', en: 'Jerrycan' },
            'Nusu': { sw: 'Nusu', en: 'Half' },
            'Half': { sw: 'Nusu', en: 'Half' },
            'Robo': { sw: 'Robo', en: 'Quarter' },
            'Quarter': { sw: 'Robo', en: 'Quarter' },
            'Glasi': { sw: 'Glasi', en: 'Glass' },
            'Glass': { sw: 'Glasi', en: 'Glass' },
            'Kibaba': { sw: 'Kibaba', en: 'Bowl' },
            'Bowl': { sw: 'Kibaba', en: 'Bowl' },
            'Bowl (Kibaba)': { sw: 'Kibaba', en: 'Bowl (Kibaba)' },
            'Pesa Iliyopokelewa (Tendered)': { sw: 'Pesa Iliyopokelewa', en: 'Cash Tendered' },
            'Pesa Iliyopokelewa': { sw: 'Pesa Iliyopokelewa', en: 'Cash Tendered' },
            'Cash Tendered': { sw: 'Pesa Iliyopokelewa', en: 'Cash Tendered' },
            'Chenji:': { sw: 'Chenji:', en: 'Change:' },
            'Change:': { sw: 'Chenji:', en: 'Change:' },
            'Kamili': { sw: 'Kamili', en: 'Exact' },
            'Exact': { sw: 'Kamili', en: 'Exact' }
        };

        // Determine current locale (server locale is single source of truth, synced to localStorage)
        let ACTIVE_LOCALE = '{{ $currentLocale }}';
        try {
            localStorage.setItem('eduka_locale', ACTIVE_LOCALE);
        } catch (e) {}
        window.__EDUKA_LOCALE__ = ACTIVE_LOCALE;

        // Build comprehensive bidirectional lookup
        const lookup = {};

        function registerPair(enStr, swStr) {
            if (!enStr || !swStr) return;
            const enClean = String(enStr).trim();
            const swClean = String(swStr).trim();
            if (!enClean || !swClean) return;

            const entry = { sw: swClean, en: enClean };
            lookup[enClean.toLowerCase()] = entry;
            lookup[swClean.toLowerCase()] = entry;
        }

        // Seed from DICTIONARY
        for (const [k, v] of Object.entries(DICTIONARY)) {
            const enVal = v.en || k;
            const swVal = v.sw || k;
            registerPair(enVal, swVal);
            lookup[k.toLowerCase()] = { sw: swVal, en: enVal };
        }

        // Seed from SERVER_SW_DICT & SERVER_EN_DICT
        for (const [k, swVal] of Object.entries(SERVER_SW_DICT || {})) {
            const enVal = (SERVER_EN_DICT && SERVER_EN_DICT[k]) ? SERVER_EN_DICT[k] : k;
            registerPair(enVal, swVal);
            lookup[k.toLowerCase()] = { sw: String(swVal), en: String(enVal) };
            lookup[String(swVal).toLowerCase()] = { sw: String(swVal), en: String(enVal) };
            lookup[String(enVal).toLowerCase()] = { sw: String(swVal), en: String(enVal) };
        }
        for (const [k, enVal] of Object.entries(SERVER_EN_DICT || {})) {
            const swVal = (SERVER_SW_DICT && SERVER_SW_DICT[k]) ? SERVER_SW_DICT[k] : k;
            registerPair(enVal, swVal);
            lookup[k.toLowerCase()] = { sw: String(swVal), en: String(enVal) };
            lookup[String(swVal).toLowerCase()] = { sw: String(swVal), en: String(enVal) };
            lookup[String(enVal).toLowerCase()] = { sw: String(swVal), en: String(enVal) };
        }

        // Seed with dynamic local storage cache
        try {
            const dynamicCached = JSON.parse(localStorage.getItem('eduka_dynamic_translations') || '{}');
            for (const [k, v] of Object.entries(dynamicCached)) {
                registerPair(k, v);
            }
        } catch (e) {}

        // Online API batch translation queue
        const pendingApiTexts = new Set();
        let apiBatchTimeout = null;

        function scheduleApiTranslate() {
            if (apiBatchTimeout) clearTimeout(apiBatchTimeout);
            apiBatchTimeout = setTimeout(fetchMissingTranslations, 700);
        }

        function fetchMissingTranslations() {
            if (pendingApiTexts.size === 0) return;
            const batch = Array.from(pendingApiTexts).slice(0, 20);
            pendingApiTexts.clear();

            fetch('/api/translate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    texts: batch,
                    source: ACTIVE_LOCALE === 'sw' ? 'en' : 'sw',
                    target: ACTIVE_LOCALE
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data && data.success && data.translations) {
                    let hasNew = false;
                    let currentCache = {};
                    try {
                        currentCache = JSON.parse(localStorage.getItem('eduka_dynamic_translations') || '{}');
                    } catch (e) {}

                    for (const [orig, trans] of Object.entries(data.translations)) {
                        if (trans && trans !== orig) {
                            registerPair(orig, trans);
                            currentCache[orig] = trans;
                            hasNew = true;
                        }
                    }

                    if (hasNew) {
                        try {
                            localStorage.setItem('eduka_dynamic_translations', JSON.stringify(currentCache));
                        } catch (e) {}
                        applyTranslations();
                    }
                }
            })
            .catch(() => {});
        }

        function translateString(str, targetLocale) {
            if (!str || typeof str !== 'string') return null;
            const match = str.match(/^(\s*)(.*?)(\s*)$/);
            if (!match) return null;
            const leading = match[1];
            const core = match[2];
            const trailing = match[3];
            if (!core) return null;

            // Skip pure numeric, price, currency, timestamp, SKU codes
            if (/^(\+|-)?(TSh|TSH|tsh|Tsh|\$|€|£)?\s*[0-9,\.]+(\s*%)?$/.test(core)
                || /^#[A-Za-z0-9\-_]+$/.test(core)
                || (/^[A-Za-z0-9\-_]{4,}$/.test(core) && /[0-9]/.test(core))) {
                return null;
            }

            const lower = core.toLowerCase();

            // 1. Direct match in dictionary
            if (lookup[lower]) {
                const targetText = targetLocale === 'sw' ? lookup[lower].sw : lookup[lower].en;
                if (targetText) {
                    return leading + targetText + trailing;
                }
            }

            // 2. Trailing punctuation stripped match (: or ...)
            const stripped = lower.replace(/[:\.\?!…]+$/, '').trim();
            if (stripped !== lower && lookup[stripped]) {
                const targetText = targetLocale === 'sw' ? lookup[stripped].sw : lookup[stripped].en;
                if (targetText) {
                    const punct = core.slice(stripped.length);
                    return leading + targetText + punct + trailing;
                }
            }

            // 3. Dynamic Unit & Badge Patterns (Vipimo 5 <-> 5 Units, Gunia (68k) <-> Sack (68k))
            const vipimoM = core.match(/^vipimo\s+(\d+)$/i);
            if (vipimoM) {
                return targetLocale === 'en' ? leading + vipimoM[1] + ' Units' + trailing : leading + 'Vipimo ' + vipimoM[1] + trailing;
            }
            const unitsM = core.match(/^(\d+)\s+units$/i);
            if (unitsM) {
                return targetLocale === 'sw' ? leading + 'Vipimo ' + unitsM[1] + trailing : leading + unitsM[1] + ' Units' + trailing;
            }

            const guniaM = core.match(/^gunia\s*(\(.*\))$/i);
            if (guniaM) {
                return targetLocale === 'en' ? leading + 'Sack ' + guniaM[1] + trailing : leading + 'Gunia ' + guniaM[1] + trailing;
            }
            const sackM = core.match(/^(sack|bag)\s*(\(.*\))$/i);
            if (sackM) {
                return targetLocale === 'sw' ? leading + 'Gunia ' + sackM[2] + trailing : leading + 'Sack ' + sackM[2] + trailing;
            }

            const nusuM = core.match(/^nusu\s*(\(.*\))$/i);
            if (nusuM) {
                return targetLocale === 'en' ? leading + 'Half ' + nusuM[1] + trailing : leading + 'Nusu ' + nusuM[1] + trailing;
            }
            const halfM = core.match(/^half\s*(\(.*\))$/i);
            if (halfM) {
                return targetLocale === 'sw' ? leading + 'Nusu ' + halfM[1] + trailing : leading + 'Half ' + halfM[1] + trailing;
            }

            const roboM = core.match(/^robo\s*(\(.*\))$/i);
            if (roboM) {
                return targetLocale === 'en' ? leading + 'Quarter ' + roboM[1] + trailing : leading + 'Robo ' + roboM[1] + trailing;
            }
            const quarterM = core.match(/^quarter\s*(\(.*\))$/i);
            if (quarterM) {
                return targetLocale === 'sw' ? leading + 'Robo ' + quarterM[1] + trailing : leading + 'Quarter ' + quarterM[1] + trailing;
            }

            const kibabaM = core.match(/^kibaba\s*(\(.*\))$/i);
            if (kibabaM) {
                return targetLocale === 'en' ? leading + 'Bowl ' + kibabaM[1] + trailing : leading + 'Kibaba ' + kibabaM[1] + trailing;
            }
            const bowlM = core.match(/^bowl\s*(\(.*\))$/i);
            if (bowlM) {
                return targetLocale === 'sw' ? leading + 'Kibaba ' + bowlM[1] + trailing : leading + 'Bowl ' + bowlM[1] + trailing;
            }

            const dumuM = core.match(/^dumu\s*(\(.*\))$/i);
            if (dumuM) {
                return targetLocale === 'en' ? leading + 'Jerrycan ' + dumuM[1] + trailing : leading + 'Dumu ' + dumuM[1] + trailing;
            }
            const jerryM = core.match(/^jerrycan\s*(\(.*\))$/i);
            if (jerryM) {
                return targetLocale === 'sw' ? leading + 'Dumu ' + jerryM[1] + trailing : leading + 'Jerrycan ' + jerryM[1] + trailing;
            }

            const glasiM = core.match(/^glasi\s*(\(.*\))$/i);
            if (glasiM) {
                return targetLocale === 'en' ? leading + 'Glass ' + glasiM[1] + trailing : leading + 'Glasi ' + glasiM[1] + trailing;
            }
            const glassM = core.match(/^glass\s*(\(.*\))$/i);
            if (glassM) {
                return targetLocale === 'sw' ? leading + 'Glasi ' + glassM[1] + trailing : leading + 'Glass ' + glassM[1] + trailing;
            }

            // 4. Common dynamic POS / stats phrase patterns
            if (targetLocale === 'sw') {
                if (core.startsWith('Opening:')) return leading + core.replace('Opening:', 'Salio la Kuanzia:') + trailing;
                if (core.startsWith('Avg checkout:')) return leading + core.replace('Avg checkout:', 'Muda wa wastani:') + trailing;
                if (core.includes('vs yesterday')) return leading + core.replace('vs yesterday', 'kulinganisha na jana') + trailing;
                if (/^[0-9]+\s+Orders$/i.test(core)) return leading + core.replace(/Orders/i, 'Maagizo') + trailing;
                if (core.startsWith('Search item')) return leading + 'Tafuta bidhaa, msimbo pau, SKU...' + trailing;
                if (core.startsWith('Search product')) return leading + 'Tafuta bidhaa, maagizo, wateja...' + trailing;
                if (core.startsWith('Search store')) return leading + 'Tafuta duka, barua pepe...' + trailing;

                if (core.includes('Stock') && core.includes('Bags')) {
                    return leading + core.replace(/Stock\s+(\d+)\s+Bags/i, 'Stoo: Mifuko $1') + trailing;
                }
                if (core.includes('Stock') && core.includes('Jerycans')) {
                    return leading + core.replace(/Stock\s+(\d+)\s+Jerycans/i, 'Stoo: Madumu $1') + trailing;
                }
                if (core.includes('Stock') && core.includes('Packs')) {
                    return leading + core.replace(/Stock\s+(\d+)\s+Packs/i, 'Stoo: Pakiti $1') + trailing;
                }
                if (core.includes('Stock')) {
                    return leading + core.replace(/Stock\s+(\d+)/i, 'Stoo: $1') + trailing;
                }
                if (core.includes('each')) {
                    return leading + core.replace(/\beach\b/i, 'kila moja') + trailing;
                }
                if (core.includes('Cash Tendered')) return leading + 'Pesa Iliyopokelewa' + trailing;
                if (core === 'Change:') return leading + 'Chenji:' + trailing;
                if (core === 'Exact') return leading + 'Kamili' + trailing;
                if (core.includes('Complete & Print Receipt')) return leading + 'Kamilisha & Chapisha Resiti' + trailing;
                if (core.includes('Hold Ticket')) return leading + 'Weka Tiketi Kiporo (Hold)' + trailing;
            } else {
                if (core.startsWith('Salio la Kuanzia:')) return leading + core.replace('Salio la Kuanzia:', 'Opening:') + trailing;
                if (core.startsWith('Muda wa wastani:')) return leading + core.replace('Muda wa wastani:', 'Avg checkout:') + trailing;
                if (core.includes('kulinganisha na jana')) return leading + core.replace('kulinganisha na jana', 'vs yesterday') + trailing;
                if (/^[0-9]+\s+Maagizo$/i.test(core)) return leading + core.replace(/Maagizo/i, 'Orders') + trailing;
                if (core.startsWith('Tafuta bidhaa, msimbo')) return leading + 'Search item, barcode, SKU...' + trailing;
                if (core.startsWith('Tafuta bidhaa, maagizo')) return leading + 'Search products, orders, customers...' + trailing;
                if (core.startsWith('Tafuta duka')) return leading + 'Search store name, email, phone...' + trailing;

                if (core.includes('Stoo') && core.includes('Mifuko')) {
                    return leading + core.replace(/Stoo:\s*Mifuko\s+(\d+)/i, 'Stock $1 Bags') + trailing;
                }
                if (core.includes('Stoo') && core.includes('Madumu')) {
                    return leading + core.replace(/Stoo:\s*Madumu\s+(\d+)/i, 'Stock $1 Jerycans') + trailing;
                }
                if (core.includes('Stoo') && core.includes('Pakiti')) {
                    return leading + core.replace(/Stoo:\s*Pakiti\s+(\d+)/i, 'Stock $1 Packs') + trailing;
                }
                if (core.includes('Stoo')) {
                    return leading + core.replace(/Stoo:\s*(\d+)/i, 'Stock $1') + trailing;
                }
                if (core.includes('kila moja')) {
                    return leading + core.replace(/\bkila moja\b/i, 'each') + trailing;
                }
                if (core.includes('Pesa Iliyopokelewa')) return leading + 'Cash Tendered' + trailing;
                if (core === 'Chenji:') return leading + 'Change:' + trailing;
                if (core === 'Kamili') return leading + 'Exact' + trailing;
                if (core.includes('Kamilisha & Chapisha Resiti')) return leading + 'Complete & Print Receipt' + trailing;
                if (core.includes('Weka Tiketi Kiporo')) return leading + 'Hold Ticket' + trailing;
            }

            // If not found in dictionary, queue for background API translation (for both languages)
            if (core.length > 2 && /[a-zA-Z]{3,}/.test(core)) {
                pendingApiTexts.add(core);
                scheduleApiTranslate();
            }

            return null;
        }

        function walkTextNodes(node, callback) {
            if (!node) return;
            const tag = node.tagName ? node.tagName.toLowerCase() : '';
            if (['script', 'style', 'code', 'pre', 'svg', 'noscript'].includes(tag)) {
                return;
            }
            if (node.id === 'universalRoleSwitcher' || node.id === 'universalLangSwitcher') {
                return;
            }
            if (node.classList && (node.classList.contains('universal-role-switcher') || node.classList.contains('universal-lang-switcher') || node.classList.contains('notranslate'))) {
                return;
            }

            if (node.nodeType === Node.TEXT_NODE) {
                callback(node);
            } else {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    if (node.placeholder) {
                        const tr = translateString(node.placeholder, ACTIVE_LOCALE);
                        if (tr) node.placeholder = tr;
                    }
                    if (node.title && !node.classList.contains('lang-switcher-btn') && !node.classList.contains('role-switcher-btn')) {
                        const tr = translateString(node.title, ACTIVE_LOCALE);
                        if (tr) node.title = tr;
                    }
                }
                for (let child = node.firstChild; child; child = child.nextSibling) {
                    walkTextNodes(child, callback);
                }
            }
        }

        function processTextNode(textNode) {
            const raw = textNode.nodeValue;
            if (!raw || !raw.trim()) return;

            const translated = translateString(raw, ACTIVE_LOCALE);
            if (translated && translated !== raw) {
                textNode.nodeValue = translated;
            }
        }

        function applyTranslations() {
            walkTextNodes(document.body, processTextNode);
        }

        function switchLocale(targetLocale) {
            targetLocale = String(targetLocale || '').trim().toLowerCase();
            if (targetLocale !== 'sw' && targetLocale !== 'en') return;
            try {
                localStorage.setItem('eduka_locale', targetLocale);
            } catch (e) {}

            // Immediate redirect to the switch-language route which sets Laravel session & reloads page
            window.location.href = '/switch-language/' + targetLocale;
        }

        function initMobileNavigation() {
            const backdrop = document.getElementById('sidebarBackdrop');
            if (backdrop && backdrop.parentElement !== document.body) {
                document.body.appendChild(backdrop);
            }
            const bottomAppbar = document.getElementById('mobileBottomAppbar');
            if (bottomAppbar && bottomAppbar.parentElement !== document.body) {
                document.body.appendChild(bottomAppbar);
            }

            const topNavBar = document.querySelector('.top-nav-bar');
            if (topNavBar && !document.getElementById('mobileNavHeaderLeft')) {
                const mobileLeft = document.createElement('div');
                mobileLeft.className = 'mobile-nav-header-left d-lg-none';
                mobileLeft.id = 'mobileNavHeaderLeft';
                mobileLeft.innerHTML = `
                    <button type="button" class="mobile-hamburger-btn" id="mobileHamburgerBtn" aria-label="Menyu" title="Fungua Menyu">
                        <i class="bi bi-list"></i>
                    </button>
                    <a href="{{ url('/') }}" class="mobile-header-brand" title="Mercanto Home">
                        <span class="mobile-brand-icon"><i class="bi bi-shop"></i></span>
                        <span class="mobile-brand-text">mercanto</span>
                    </a>
                `;
                topNavBar.prepend(mobileLeft);
            }

            const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
            const workspaceHeader = sidebar ? sidebar.querySelector('.workspace-header') : null;
            if (workspaceHeader && !document.getElementById('sidebarDrawerCloseBtn')) {
                const closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.className = 'sidebar-drawer-close-btn d-lg-none';
                closeBtn.id = 'sidebarDrawerCloseBtn';
                closeBtn.setAttribute('aria-label', 'Funga');
                closeBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                workspaceHeader.appendChild(closeBtn);
            }

            function openDrawer() {
                const sb = document.querySelector('.sidebar') || document.getElementById('sidebar');
                const bd = document.getElementById('sidebarBackdrop');
                if (sb) sb.classList.add('mobile-open');
                if (bd) bd.classList.add('show');
                document.body.classList.add('mobile-drawer-open');
            }

            function closeDrawer() {
                const sb = document.querySelector('.sidebar') || document.getElementById('sidebar');
                const bd = document.getElementById('sidebarBackdrop');
                if (sb) sb.classList.remove('mobile-open');
                if (bd) bd.classList.remove('show');
                document.body.classList.remove('mobile-drawer-open');
            }

            function toggleDrawer() {
                const sb = document.querySelector('.sidebar') || document.getElementById('sidebar');
                if (sb && sb.classList.contains('mobile-open')) {
                    closeDrawer();
                } else {
                    openDrawer();
                }
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('#mobileHamburgerBtn')) {
                    e.preventDefault();
                    toggleDrawer();
                    return;
                }

                if (e.target.closest('#mobileMenuDrawerBtn')) {
                    e.preventDefault();
                    toggleDrawer();
                    return;
                }

                if (e.target.closest('#sidebarDrawerCloseBtn') || e.target.closest('#sidebarBackdrop')) {
                    e.preventDefault();
                    closeDrawer();
                    return;
                }

                if (window.innerWidth <= 992 && e.target.closest('.nav-item-link:not(.nav-dropdown-toggle)')) {
                    closeDrawer();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDrawer();
                }
            });

            document.querySelectorAll('table').forEach(function(tbl) {
                if (!tbl.closest('.table-responsive') && !tbl.closest('.table-responsive-wrapper')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-responsive-wrapper';
                    tbl.parentNode.insertBefore(wrapper, tbl);
                    wrapper.appendChild(tbl);
                }
            });
        }

        function initSwitchers() {
            const roleBtn = document.getElementById('universalRoleBtn');
            const roleSwitcher = document.getElementById('universalRoleSwitcher');
            const langBtn = document.getElementById('universalLangBtn');
            const langSwitcher = document.getElementById('universalLangSwitcher');

            if (roleBtn && roleSwitcher) {
                roleBtn.onclick = function(e) {
                    e.stopPropagation();
                    if (langSwitcher) langSwitcher.classList.remove('show');
                    roleSwitcher.classList.toggle('show');
                };
            }

            if (langBtn && langSwitcher) {
                langBtn.onclick = function(e) {
                    e.stopPropagation();
                    if (roleSwitcher) roleSwitcher.classList.remove('show');
                    langSwitcher.classList.toggle('show');
                };
            }

            document.addEventListener('click', function(e) {
                if (roleSwitcher && !roleSwitcher.contains(e.target)) {
                    roleSwitcher.classList.remove('show');
                }
                if (langSwitcher && !langSwitcher.contains(e.target)) {
                    langSwitcher.classList.remove('show');
                }

                // Intercept language clicks for instantaneous transition
                const langItem = e.target.closest('a[href*="/switch-language/"]');
                if (langItem) {
                    const href = langItem.getAttribute('href') || '';
                    const parts = href.split('/switch-language/');
                    if (parts.length > 1) {
                        const targetLocale = parts[1].split('?')[0].trim().toLowerCase();
                        if (targetLocale === 'sw' || targetLocale === 'en') {
                            e.preventDefault();
                            switchLocale(targetLocale);
                        }
                    }
                }
            });

            // Run initial translation pass
            applyTranslations();

            // Run mobile navigation setup
            initMobileNavigation();

            // Observe dynamic mutations (e.g. cart updates, modals, tickets)
            const observer = new MutationObserver(function(mutations) {
                let shouldRun = false;
                for (const mutation of mutations) {
                    if (mutation.addedNodes.length > 0) {
                        shouldRun = true;
                        break;
                    }
                }
                if (shouldRun) {
                    applyTranslations();
                }
            });

            const mainContent = document.querySelector('main') || document.body;
            if (mainContent) {
                observer.observe(mainContent, { childList: true, subtree: true });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSwitchers);
        } else {
            initSwitchers();
        }
    })();
</script>
