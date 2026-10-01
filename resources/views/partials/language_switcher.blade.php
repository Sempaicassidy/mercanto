@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp

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
                <div class="lang-desc">Lugha ya Kiswahili (Swahili)</div>
            </div>
            @if($isSwahili)
                <i class="bi bi-check2 text-success fw-bold"></i>
            @endif
        </a>

        <a href="{{ url('/switch-language/en') }}" class="lang-menu-item {{ !$isSwahili ? 'active' : '' }}" data-locale="en">
            <span class="lang-flag-large">🇬🇧</span>
            <div style="flex: 1; min-width: 0;">
                <div class="lang-title">English</div>
                <div class="lang-desc">English Language (Kiingereza)</div>
            </div>
            @if(!$isSwahili)
                <i class="bi bi-check2 text-primary fw-bold"></i>
            @endif
        </a>
    </div>
</div>

<style>
    .universal-lang-switcher {
        position: relative;
        display: inline-block;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .lang-switcher-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 11px;
        border-radius: 9999px;
        border: 1px solid var(--border-color, #e4e4e7);
        background-color: var(--card-bg, #ffffff);
        color: var(--text-dark, #09090b);
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .lang-switcher-btn:hover {
        background-color: var(--nav-active-bg, #f4f4f5);
        border-color: #a1a1aa;
        transform: translateY(-1px);
    }
    .lang-flag {
        font-size: 0.95rem;
        line-height: 1;
    }
    .lang-flag-large {
        font-size: 1.25rem;
        line-height: 1;
        margin-right: 2px;
    }
    .lang-label {
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.2px;
    }
    .lang-switcher-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 250px;
        background-color: var(--card-bg, #ffffff);
        border: 1px solid var(--border-color, #e4e4e7);
        border-radius: 12px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.18);
        padding: 8px;
        display: none;
        flex-direction: column;
        z-index: 9999;
        animation: langMenuAnim 0.15s ease-out;
    }
    @keyframes langMenuAnim {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .universal-lang-switcher.show .lang-switcher-menu {
        display: flex;
    }
    .lang-menu-header {
        padding: 4px 8px 8px 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color, #e4e4e7);
        margin-bottom: 4px;
    }
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
    .lang-menu-item:hover {
        background-color: var(--nav-active-bg, #f4f4f5);
        color: var(--text-dark, #09090b);
    }
    .lang-menu-item.active {
        background-color: var(--nav-active-bg, #f4f4f5);
        font-weight: 600;
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
</style>

<script>
    (function() {
        function initLangSwitcher() {
            const btn = document.getElementById('universalLangBtn');
            const switcher = document.getElementById('universalLangSwitcher');
            if (!btn || !switcher) return;

            btn.onclick = function(e) {
                e.stopPropagation();
                switcher.classList.toggle('show');
            };

            document.addEventListener('click', function(e) {
                if (!switcher.contains(e.target)) {
                    switcher.classList.remove('show');
                }
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initLangSwitcher);
        } else {
            initLangSwitcher();
        }
    })();
</script>
