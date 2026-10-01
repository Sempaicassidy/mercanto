@php
    $businessMode = session('business_mode', 'retailer');
    $isWholesale = $businessMode === 'wholesaler';
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercanto</title>

    @include('partials.pwa_meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --bg-page: #fbfbfb;
            --sidebar-bg: #ffffff;
            --border-color: #e4e4e7;
            --text-dark: #09090b;
            --text-muted: #71717a;
            --nav-active-bg: #eff6ff;
            --nav-active-text: #2563eb;
            --card-border: #e4e4e7;
            --primary-btn: #09090b;
            --card-bg: #ffffff;
            --input-bg: #ffffff;
            --badge-danger-bg: #fef2f2;
            --badge-danger-text: #dc2626;
            --badge-warning-bg: #fffbeb;
            --badge-warning-text: #d97706;
            --badge-success-bg: #f0fdf4;
            --badge-success-text: #16a34a;
            --badge-primary-bg: #eff6ff;
            --badge-primary-text: #2563eb;
        }

        body.dark-mode {
            --bg-page: #09090b;
            --sidebar-bg: #111113;
            --border-color: #27272a;
            --text-dark: #f4f4f5;
            --text-muted: #a1a1aa;
            --nav-active-bg: #172554;
            --nav-active-text: #60a5fa;
            --card-border: #27272a;
            --primary-btn: #fafafa;
            --card-bg: #18181b;
            --input-bg: #1f1f23;
            --badge-danger-bg: #450a0a;
            --badge-danger-text: #f87171;
            --badge-warning-bg: #451a03;
            --badge-warning-text: #fbbf24;
            --badge-success-bg: #052e16;
            --badge-success-text: #4ade80;
            --badge-primary-bg: #172554;
            --badge-primary-text: #60a5fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Sidebar Styling (Clean Shadcn Style) */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
            padding: 1.25rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .workspace-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.6rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
        }

        .workspace-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .workspace-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #16a34a, #059669);
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.25);
        }

        .workspace-info h4 {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
        }

        .workspace-info span {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 1.25rem 0 0.5rem 0.6rem;
            letter-spacing: 0.3px;
        }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .nav-item-link:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        .nav-item-link.active {
            background-color: var(--nav-active-bg);
            color: var(--nav-active-text);
            font-weight: 600;
        }

        .nav-item-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-item-left i {
            font-size: 1.05rem;
            color: var(--text-muted);
        }

        .nav-item-link.active .nav-item-left i {
            color: var(--nav-active-text);
        }

        .live-badge {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 9999px;
            background-color: var(--badge-success-bg);
            color: var(--badge-success-text);
            display: inline-flex;
            align-items: center;
        }

        /* Sidebar Profile Section */
        .sidebar-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem;
            border-radius: 8px;
            text-decoration: none;
            border-top: 1px solid var(--border-color);
            padding-top: 0.85rem;
            transition: background 0.15s ease;
        }

        .sidebar-profile:hover {
            background-color: var(--nav-active-bg);
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: var(--badge-primary-bg);
            color: var(--badge-primary-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 700;
            margin-right: 10px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .profile-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-email {
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        /* Main Content Layout */
        .main-wrapper {
            margin-left: 250px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 250px);
            transition: all 0.2s ease;
        }

        /* Top Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pos-title-wrap h1 {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-dark);
            margin: 0;
        }

        .pos-title-wrap p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-search-box {
            position: relative;
            width: 280px;
        }

        .search-input {
            width: 100%;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.45rem 2.2rem 0.45rem 2rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            outline: none;
            transition: all 0.15s ease;
        }

        .search-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .search-kbd {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.68rem;
            font-weight: 600;
            background-color: var(--nav-active-bg);
            color: var(--text-muted);
            padding: 2px 5px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
        }

        .branch-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.42rem 0.85rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .nav-icon-btn {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        .header-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.45rem 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-dark);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
        }

        .header-role-pill:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        /* Stat Cards */
        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.15rem 1.3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.65rem;
        }

        .stat-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .stat-icon {
            font-size: 1.15rem;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.4px;
            margin-bottom: 0.2rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }

        .stat-subtext {
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        .stat-icon.text-success, .stat-value.text-success { color: #16a34a !important; }
        .stat-icon.text-primary, .stat-value.text-primary { color: #2563eb !important; }
        .stat-icon.text-warning, .stat-value.text-warning { color: #d97706 !important; }
        body.dark-mode .stat-icon.text-success, body.dark-mode .stat-value.text-success { color: #4ade80 !important; }
        body.dark-mode .stat-icon.text-primary, body.dark-mode .stat-value.text-primary { color: #60a5fa !important; }
        body.dark-mode .stat-icon.text-warning, body.dark-mode .stat-value.text-warning { color: #fbbf24 !important; }

        /* POS Catalog & Bill Cards */
        .pos-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.4rem;
            height: 100%;
            transition: all 0.2s ease;
        }

        .pos-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .pos-panel-header h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .category-filters {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 1.2rem;
        }

        .cat-btn {
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-muted);
            padding: 0.4rem 0.95rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .cat-btn:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .cat-btn.active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        }

        /* Product Cards Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
            max-height: 520px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            background: var(--card-bg);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        .product-card:hover {
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.08);
        }

        .product-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            width: fit-content;
            margin-bottom: 8px;
            display: inline-block;
        }

        .product-badge.badge-beverages {
            background-color: var(--badge-primary-bg);
            color: var(--badge-primary-text);
        }

        .product-badge.badge-dairy {
            background-color: var(--badge-success-bg);
            color: var(--badge-success-text);
        }

        .product-badge.badge-snacks {
            background-color: var(--badge-warning-bg);
            color: var(--badge-warning-text);
        }

        .product-badge.badge-household {
            background-color: #f5f3ff;
            color: #7c3aed;
        }
        body.dark-mode .product-badge.badge-household {
            background-color: #2e1065;
            color: #c084fc;
        }

        .product-badge.badge-staples {
            background-color: #fef3c7;
            color: #b45309;
        }
        body.dark-mode .product-badge.badge-staples {
            background-color: #451a03;
            color: #fcd34d;
        }

        .product-badge.badge-oils {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        body.dark-mode .product-badge.badge-oils {
            background-color: #082f49;
            color: #7dd3fc;
        }

        .unit-chip {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: var(--nav-active-bg);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-block;
        }

        .unit-chip:hover, .unit-chip.active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .product-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            line-height: 1.25;
        }

        .product-sku {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .product-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 6px;
            border-top: 1px solid var(--border-color);
            padding-top: 8px;
        }

        .product-price {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.98rem;
            font-weight: 800;
            color: #16a34a;
        }
        body.dark-mode .product-price {
            color: #4ade80;
        }

        .btn-add-item {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: var(--badge-success-bg);
            border: 1px solid transparent;
            color: var(--badge-success-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .product-card:hover .btn-add-item {
            background: #16a34a;
            color: #ffffff;
            border-color: #16a34a;
            transform: scale(1.08);
        }

        /* Cart / Bill Section */
        .cart-ticket-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0.95rem;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .cart-ticket-title {
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .cart-items-wrap {
            min-height: 220px;
            max-height: 280px;
            overflow-y: auto;
            margin-bottom: 1rem;
            padding-right: 4px;
        }

        .cart-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .cart-row:last-child {
            border-bottom: none;
        }

        .cart-item-title {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .cart-item-unit {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .qty-ctrl {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            background: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            font-size: 0.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .qty-btn:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .qty-val {
            font-size: 0.82rem;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
            color: var(--text-dark);
        }

        .cart-item-price {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.92rem;
            font-weight: 700;
            color: #16a34a;
            min-width: 78px;
            text-align: right;
        }
        body.dark-mode .cart-item-price {
            color: #4ade80;
        }

        .btn-remove-item {
            background: transparent;
            border: none;
            color: #a1a1aa;
            cursor: pointer;
            padding: 2px 6px;
            font-size: 0.85rem;
            border-radius: 4px;
            transition: all 0.15s ease;
        }

        .btn-remove-item:hover {
            color: #dc2626;
            background-color: var(--badge-danger-bg);
        }

        /* Breakdown Table */
        .bill-breakdown {
            background: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.85rem;
            margin-bottom: 1rem;
        }

        .breakdown-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .breakdown-row.total-row {
            border-top: 1px dashed var(--border-color);
            padding-top: 8px;
            margin-top: 8px;
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-dark);
            align-items: center;
        }

        #billTotal {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 1.35rem;
            font-weight: 800;
            color: #16a34a;
        }
        body.dark-mode #billTotal {
            color: #4ade80;
        }

        /* Payment Selectors */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-bottom: 1rem;
        }

        .pay-btn {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.6rem 0.35rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            text-align: center;
            transition: all 0.15s ease;
        }

        .pay-btn:hover {
            border-color: #16a34a;
            color: var(--text-dark);
        }

        .pay-btn.active {
            background: #16a34a;
            color: #ffffff;
            border-color: #16a34a;
            box-shadow: 0 3px 10px rgba(22, 163, 74, 0.25);
        }

        .btn-complete-sale {
            width: 100%;
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #ffffff;
            border: none;
            padding: 0.82rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.3);
            transition: all 0.2s ease;
        }

        .btn-complete-sale:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(22, 163, 74, 0.35);
            filter: brightness(1.06);
        }

        .btn-hold-sale {
            width: 100%;
            background: var(--card-bg);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 0.6rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            transition: all 0.15s ease;
        }

        .btn-hold-sale:hover {
            background: var(--badge-warning-bg);
            color: var(--badge-warning-text);
            border-color: #fde68a;
        }

        /* Toast notification */
        .pos-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #18181b;
            color: #ffffff;
            padding: 0.65rem 1.1rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 500;
            display: none;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 2000;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 1.25rem;
            }
        }

        /* Modal Overlay & Thermal Receipt Box */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            padding: 1rem;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-box {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            animation: modalPop 0.18s ease-out;
            overflow: hidden;
        }
        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }
        .thermal-receipt-paper {
            background: #ffffff;
            color: #000000;
            padding: 22px 18px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.35;
            max-height: 68vh;
            overflow-y: auto;
        }
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            body > *:not(.modal-overlay.show) {
                display: none !important;
            }
            .modal-overlay.show {
                position: static !important;
                display: block !important;
                background: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 78mm !important;
            }
            .modal-box {
                border: none !important;
                box-shadow: none !important;
                width: 78mm !important;
                max-width: 78mm !important;
                margin: 0 auto !important;
                padding: 0 !important;
                background: #ffffff !important;
            }
            .no-print, header, nav, aside, footer, .sidebar, .top-nav-bar {
                display: none !important;
            }
            .thermal-receipt-paper {
                width: 78mm !important;
                max-height: none !important;
                overflow: visible !important;
                padding: 6mm 3mm !important;
                margin: 0 auto !important;
                font-family: 'Courier New', Courier, monospace !important;
                color: #000000 !important;
                background: #ffffff !important;
                font-size: 11px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Left Sidebar (Clean Shadcn Style) -->
    <aside class="sidebar">
        <div>
            <!-- Workspace Brand Header -->
            <div class="workspace-header">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-upc-scan"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>POS Panel</span>
                    </div>
                </div>
            </div>

            <!-- Nav Items -->
            <div class="nav-section-title">Quick Access</div>
            <ul class="nav-list">
                <li>
                    <a href="{{ url('/manager/dashboard') }}" class="nav-item-link">
                        <span class="nav-item-left">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/pos') }}" class="nav-item-link active">
                        <span class="nav-item-left">
                            <i class="bi bi-display"></i>
                            <span>POS</span>
                        </span>
                        <span class="live-badge"><i class="bi bi-circle-fill me-1" style="font-size:0.35rem;vertical-align:middle;"></i>Live</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item-link">
                        <span class="nav-item-left">
                            <i class="bi bi-boxes"></i>
                            <span>Products</span>
                        </span>
                        
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item-link open-receipts-history-btn" id="navOpenReceiptsHistory" title="Historia ya Resiti za Leo">
                        <span class="nav-item-left">
                            <i class="bi bi-receipt"></i>
                            <span>Receipts</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item-link">
                        <span class="nav-item-left">
                            <i class="bi bi-cash-stack"></i>
                            <span>Register Balance</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Profile Section -->
        <a href="{{ url('/manager/dashboard') }}" class="sidebar-profile" title="Switch to Manager View">
            <div style="display: flex; align-items: center;">
                <div class="profile-avatar">CS</div>
                <div class="profile-info">
                    <span class="profile-name">Cashier Shift A</span>
                    <span class="profile-email">Terminal 03 • Counter</span>
                </div>
            </div>
            <i class="bi bi-arrow-left-right text-muted" style="font-size: 0.85rem;"></i>
        </a>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Bar Header -->
        <div class="top-nav-bar">
            <div class="pos-title-wrap">
                <h1>POS / Counter Desk</h1>
                <p>Fast retail checkout, item barcode search, and ticket billing.</p>
            </div>
            <div class="top-nav-actions">
                <button type="button" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center gap-1 open-receipts-history-btn" title="Historia ya Resiti za Leo" style="border-radius: 9999px; font-size: 0.8rem; padding: 6px 12px; font-weight: 600;">
                    <i class="bi bi-clock-history"></i> <span class="d-none d-sm-inline">Resiti za Leo</span>
                </button>
                <div class="header-search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search item, barcode, SKU..." id="product-search-input">
                    <span class="search-kbd">⌘ K</span>
                </div>
                <div class="branch-pill d-none d-md-inline-flex">
                    <span style="width: 7px; height: 7px; background-color: #10b981; border-radius: 50%; display: inline-block;"></span>
                    <span>Counter 03 • Main HQ</span>
                </div>
                <!-- Universal Role Switcher Component -->
                @include('partials.role_switcher')

                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme" aria-label="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>
            </div>
        </div>

        <!-- Metric Cards (3 Cards) -->
        <div class="row g-3 mb-4">
            @if($isWholesale)
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Wholesale Sales Today</span>
                            <i class="bi bi-receipt-cutoff stat-icon" style="color: #7c3aed;"></i>
                        </div>
                        <div>
                            <div class="stat-value" style="color: #7c3aed;">TSh 18,450,000</div>
                            <div class="stat-subtext"><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight:700; padding:2px 7px; border-radius:9999px;">14 Bulk Invoices</span> • 380 Cartons Dispatched</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Trade Credit Issued</span>
                            <i class="bi bi-clock-history stat-icon text-warning"></i>
                        </div>
                        <div>
                            <div class="stat-value text-warning">TSh 5,200,000</div>
                            <div class="stat-subtext">3 Retail Stores • <span class="fw-semibold text-warning">Payment due in 14 days</span></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Bulk Orders In Queue</span>
                            <i class="bi bi-truck stat-icon text-primary"></i>
                        </div>
                        <div>
                            <div class="stat-value text-primary">2 Invoices</div>
                            <div class="stat-subtext">Packing & dispatch bay ready</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Sales Today</span>
                            <i class="bi bi-currency-dollar stat-icon text-success"></i>
                        </div>
                        <div>
                            <div class="stat-value text-success">TSh 6,820,000</div>
                            <div class="stat-subtext"><span class="badge" style="background:var(--badge-success-bg);color:var(--badge-success-text);font-weight:700;padding:2px 7px;border-radius:9999px;">+12.4%</span> vs yesterday • 126 sales</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Droo ya Pesa (Shift Register)' : 'Drawer Balance' }}</span>
                            <i class="bi bi-safe2 stat-icon text-primary"></i>
                        </div>
                        <div>
                            @if(isset($activeShift) && $activeShift)
                                <div class="stat-value text-primary">TSh {{ number_format($activeShift->opening_float + $activeShift->cash_sales) }}</div>
                                <div class="stat-subtext d-flex justify-content-between align-items-center mt-1">
                                    <span>Zamu: <strong class="text-success">{{ $activeShift->shift_code }}</strong> (Float: {{ number_format($activeShift->opening_float) }})</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="btnTriggerCloseShift" style="font-size:0.68rem; padding: 2px 8px; border-radius: 9999px; font-weight: 700;">
                                        <i class="bi bi-door-closed"></i> {{ $isSwahili ? 'Funga Zamu' : 'Close Shift' }}
                                    </button>
                                </div>
                            @else
                                <div class="stat-value text-warning">{{ $isSwahili ? 'Imefungwa' : 'Closed' }}</div>
                                <div class="stat-subtext d-flex justify-content-between align-items-center mt-1">
                                    <span class="text-danger fw-semibold">{{ $isSwahili ? 'Hakuna zamu hai' : 'No active shift' }}</span>
                                    <button type="button" class="btn btn-sm btn-success text-white" id="btnTriggerOpenShift" style="font-size:0.68rem; padding: 2px 8px; border-radius: 9999px; font-weight: 700;">
                                        <i class="bi bi-door-open"></i> {{ $isSwahili ? 'Fungua Zamu' : 'Open Shift' }}
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Active Queue</span>
                            <i class="bi bi-people stat-icon text-warning"></i>
                        </div>
                        <div>
                            <div class="stat-value text-warning">3 Orders</div>
                            <div class="stat-subtext">Avg checkout: <span class="fw-semibold">45s per basket</span></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- POS Workspace: Catalog (Left) & Ticket/Bill (Right) -->
        <div class="row g-4">
            <!-- Left: Fast Product Catalog (7 Cols) -->
            <div class="col-12 col-xl-7">
                <div class="pos-panel">
                    <div class="pos-panel-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $isWholesale ? 'Wholesale Bulk Catalog' : 'Fast Tap Catalog' }}</h3>
                            <span class="text-muted" style="font-size: 0.8rem;">{{ $isWholesale ? 'Tap bulk carton / sack to add to wholesale invoice' : 'Tap item to add to basket' }}</span>
                        </div>
                        @if($isWholesale)
                            <span class="badge" style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.72rem; font-weight: 700; border-radius: 9999px; padding: 4px 10px;">
                                <i class="bi bi-boxes me-1"></i> Jumla Pricing
                            </span>
                        @endif
                    </div>

                    <!-- Category Filters -->
                    <div class="category-filters">
                        <button type="button" class="cat-btn active" data-cat="all">All Items</button>
                        <button type="button" class="cat-btn" data-cat="staples">Grains & Flour</button>
                        <button type="button" class="cat-btn" data-cat="oils">Cooking Oils</button>
                        <button type="button" class="cat-btn" data-cat="beverages">Beverages</button>
                        <button type="button" class="cat-btn" data-cat="snacks">Snacks</button>
                        <button type="button" class="cat-btn" data-cat="household">Household</button>
                        <button type="button" class="cat-btn" data-cat="dairy">Dairy & Fresh</button>
                    </div>

                    <!-- Product Grid -->
                    <div class="product-grid" id="productGrid">
                        <!-- Retail Product with Sub-Units: Kilombero Super Rice -->
                        <div class="product-card" data-cat="staples" data-name="{{ $isSwahili ? 'Mchele Safi wa Kilombero' : 'Kilombero Super Rice' }}" data-price="68000" data-selected-unit="{{ $isSwahili ? 'Gunia 25kg' : '25kg Sack' }}" data-selected-price="68000">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="product-badge badge-staples mb-0">{{ $isSwahili ? 'Nafaka na Unga' : 'Grains & Flour' }}</span>
                                    <span class="badge" style="background: rgba(37,99,235,0.1); color: #2563eb; font-size: 0.65rem; font-weight: 700;">{{ $isSwahili ? 'Vipimo 5' : '5 Units' }}</span>
                                </div>
                                <div class="product-name">{{ $isSwahili ? 'Mchele Safi wa Kilombero' : 'Kilombero Super Rice' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: RCE-KLM-025 • Stoo: Mifuko 120' : 'SKU: RCE-KLM-025 • Stock 120 Bags' }}</div>

                                <!-- Sub-unit Chips -->
                                <div class="unit-selector-chips mt-1 mb-2 d-flex flex-wrap gap-1">
                                    <span class="unit-chip active" data-unit="{{ $isSwahili ? 'Gunia 25kg' : '25kg Sack' }}" data-price="68000">{{ $isSwahili ? 'Gunia (68k)' : 'Sack (68k)' }}</span>
                                    <span class="unit-chip" data-unit="1 Kg" data-price="3200">1kg (3.2k)</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Nusu Kilo (500g)' : 'Half Kilo (500g)' }}" data-price="1650">{{ $isSwahili ? 'Nusu (1.65k)' : 'Half (1.65k)' }}</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Robo Kilo (250g)' : 'Quarter Kilo (250g)' }}" data-price="850">{{ $isSwahili ? 'Robo (850)' : 'Quarter (850)' }}</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Kibaba' : 'Bowl (Kibaba)' }}" data-price="2300">{{ $isSwahili ? 'Kibaba (2.3k)' : 'Bowl (2.3k)' }}</span>
                                </div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 68,000</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Retail Product with Sub-Units: Korie Cooking Oil -->
                        <div class="product-card" data-cat="oils" data-name="{{ $isSwahili ? 'Mafuta ya Korie' : 'Korie Cooking Oil' }}" data-price="28500" data-selected-unit="{{ $isSwahili ? 'Dumu 5L' : '5L Jerrycan' }}" data-selected-price="28500">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="product-badge badge-oils mb-0">{{ $isSwahili ? 'Mafuta ya Kupikia' : 'Cooking Oils' }}</span>
                                    <span class="badge" style="background: rgba(37,99,235,0.1); color: #2563eb; font-size: 0.65rem; font-weight: 700;">{{ $isSwahili ? 'Vipimo 5' : '5 Units' }}</span>
                                </div>
                                <div class="product-name">{{ $isSwahili ? 'Mafuta ya Korie' : 'Korie Cooking Oil' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: MET-OIL-005 • Stoo: Madumu 6' : 'SKU: MET-OIL-005 • Stock 6 Jerycans' }}</div>

                                <!-- Sub-unit Chips -->
                                <div class="unit-selector-chips mt-1 mb-2 d-flex flex-wrap gap-1">
                                    <span class="unit-chip active" data-unit="{{ $isSwahili ? 'Dumu 5L' : '5L Jerrycan' }}" data-price="28500">{{ $isSwahili ? 'Dumu (28.5k)' : 'Jerrycan (28.5k)' }}</span>
                                    <span class="unit-chip" data-unit="1 Lita (1L)" data-price="6500">1L (6.5k)</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Nusu Lita (500ml)' : 'Half Liter (500ml)' }}" data-price="3300">{{ $isSwahili ? '500ml (3.3k)' : '500ml (3.3k)' }}</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Robo Lita (250ml)' : 'Quarter Liter (250ml)' }}" data-price="1700">{{ $isSwahili ? '250ml (1.7k)' : '250ml (1.7k)' }}</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Glasi / Kibaba' : 'Glass' }}" data-price="1000">{{ $isSwahili ? 'Glasi (1k)' : 'Glass (1k)' }}</span>
                                </div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 28,500</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Retail Product with Sub-Units: Sukari ya Kilombero -->
                        <div class="product-card" data-cat="staples" data-name="{{ $isSwahili ? 'Sukari ya Kilombero' : 'Kilombero Sugar' }}" data-price="3200" data-selected-unit="1 Kg" data-selected-price="3200">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="product-badge badge-staples mb-0">{{ $isSwahili ? 'Nafaka na Sukari' : 'Grains & Sugar' }}</span>
                                    <span class="badge" style="background: rgba(37,99,235,0.1); color: #2563eb; font-size: 0.65rem; font-weight: 700;">{{ $isSwahili ? 'Vipimo 3' : '3 Units' }}</span>
                                </div>
                                <div class="product-name">{{ $isSwahili ? 'Sukari ya Kilombero' : 'Kilombero Sugar' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: SUK-01K • Stoo: 350 Kg' : 'SKU: SUK-01K • Stock 350 Kg' }}</div>

                                <!-- Sub-unit Chips -->
                                <div class="unit-selector-chips mt-1 mb-2 d-flex flex-wrap gap-1">
                                    <span class="unit-chip active" data-unit="1 Kg" data-price="3200">1 Kg (3.2k)</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Nusu Kilo (500g)' : 'Half Kilo (500g)' }}" data-price="1650">{{ $isSwahili ? 'Nusu (1.65k)' : 'Half (1.65k)' }}</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Robo Kilo (250g)' : 'Quarter Kilo (250g)' }}" data-price="850">{{ $isSwahili ? 'Robo (850)' : 'Quarter (850)' }}</span>
                                </div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 3,200</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Retail Product with Sub-Units: Bakhresa Wheat Flour -->
                        <div class="product-card" data-cat="staples" data-name="{{ $isSwahili ? 'Unga wa Ngano wa Bakhresa' : 'Bakhresa Wheat Flour' }}" data-price="3700" data-selected-unit="{{ $isSwahili ? 'Pakiti 2kg' : '2kg Pack' }}" data-selected-price="3700">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="product-badge badge-staples mb-0">{{ $isSwahili ? 'Nafaka na Unga' : 'Grains & Flour' }}</span>
                                    <span class="badge" style="background: rgba(37,99,235,0.1); color: #2563eb; font-size: 0.65rem; font-weight: 700;">{{ $isSwahili ? 'Vipimo 3' : '3 Units' }}</span>
                                </div>
                                <div class="product-name">{{ $isSwahili ? 'Unga wa Ngano wa Bakhresa' : 'Bakhresa Wheat Flour' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: BKH-WHT-002 • Stoo: Pakiti 14' : 'SKU: BKH-WHT-002 • Stock 14 Packs' }}</div>

                                <!-- Sub-unit Chips -->
                                <div class="unit-selector-chips mt-1 mb-2 d-flex flex-wrap gap-1">
                                    <span class="unit-chip active" data-unit="{{ $isSwahili ? 'Pakiti 2kg' : '2kg Pack' }}" data-price="3700">2kg (3.7k)</span>
                                    <span class="unit-chip" data-unit="1 Kg" data-price="1900">1kg (1.9k)</span>
                                    <span class="unit-chip" data-unit="{{ $isSwahili ? 'Nusu Kilo (500g)' : 'Half Kilo (500g)' }}" data-price="1000">{{ $isSwahili ? 'Nusu (1k)' : 'Half (1k)' }}</span>
                                </div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 3,700</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Product 1 -->
                        <div class="product-card" data-cat="beverages" data-name="Coca-Cola 500ml" data-price="1500">
                            <div>
                                <span class="product-badge badge-beverages">{{ $isSwahili ? 'Vinywaji' : 'Beverages' }}</span>
                                <div class="product-name">Coca-Cola 500ml</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: BEV-102 • Stoo: 84' : 'SKU: BEV-102 • Stock 84' }}</div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 1,500</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="product-card" data-cat="dairy" data-name="{{ $isSwahili ? 'Maziwa ya Pakiti 1L' : 'Milk Packet 1L' }}" data-price="3200">
                            <div>
                                <span class="product-badge badge-dairy">{{ $isSwahili ? 'Maziwa' : 'Dairy' }}</span>
                                <div class="product-name">{{ $isSwahili ? 'Maziwa ya Pakiti 1L' : 'Milk Packet 1L' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: DRY-087 • Stoo: 36' : 'SKU: DRY-087 • Stock 36' }}</div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 3,200</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="product-card" data-cat="snacks" data-name="{{ $isSwahili ? 'Krisi za Viazi 100g' : 'Potato Crisps 100g' }}" data-price="2500">
                            <div>
                                <span class="product-badge badge-snacks">{{ $isSwahili ? 'Vitafunio' : 'Snacks' }}</span>
                                <div class="product-name">{{ $isSwahili ? 'Krisi za Viazi 100g' : 'Potato Crisps 100g' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: SNK-221 • Stoo: 49' : 'SKU: SNK-221 • Stock 49' }}</div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 2,500</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="product-card" data-cat="household" data-name="{{ $isSwahili ? 'Sabuni ya Vyombo' : 'Dishwashing Liquid' }}" data-price="4800">
                            <div>
                                <span class="product-badge badge-household">{{ $isSwahili ? 'Vifaa vya Usafi' : 'Household' }}</span>
                                <div class="product-name">{{ $isSwahili ? 'Sabuni ya Vyombo' : 'Dishwashing Liquid' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: HSE-012 • Stoo: 21' : 'SKU: HSE-012 • Stock 21' }}</div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 4,800</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="product-card" data-cat="household" data-name="{{ $isSwahili ? 'Dawa ya Meno Kubwa' : 'Toothpaste Large' }}" data-price="3700">
                            <div>
                                <span class="product-badge badge-household">{{ $isSwahili ? 'Vifaa vya Usafi' : 'Household' }}</span>
                                <div class="product-name">{{ $isSwahili ? 'Dawa ya Meno Kubwa' : 'Toothpaste Large' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: HYG-455 • Stoo: 57' : 'SKU: HYG-455 • Stock 57' }}</div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 3,700</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="product-card" data-cat="beverages" data-name="{{ $isSwahili ? 'Maji ya Chupa 1L' : 'Bottled Water 1L' }}" data-price="1000">
                            <div>
                                <span class="product-badge badge-beverages">{{ $isSwahili ? 'Vinywaji' : 'Beverages' }}</span>
                                <div class="product-name">{{ $isSwahili ? 'Maji ya Chupa 1L' : 'Bottled Water 1L' }}</div>
                                <div class="product-sku">{{ $isSwahili ? 'SKU: BEV-010 • Stoo: 116' : 'SKU: BEV-010 • Stock 116' }}</div>
                            </div>
                            <div class="product-foot">
                                <span class="product-price">TSh 1,000</span>
                                <button type="button" class="btn-add-item"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Active Ticket / Bill (5 Cols) -->
            <div class="col-12 col-xl-5">
                <div class="pos-panel">
                    <div class="cart-ticket-banner">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="cart-ticket-title">Ticket #EDK-20498</span>
                                <span class="badge" style="background:var(--badge-success-bg);color:var(--badge-success-text);font-size:0.68rem;padding:2px 6px;border-radius:9999px;font-weight:700;"><i class="bi bi-circle-fill me-1" style="font-size:0.35rem;vertical-align:middle;"></i>Active Ticket</span>
                            </div>
                            <span class="text-muted d-block" style="font-size:0.75rem;">Customer: <span class="fw-semibold text-dark" id="displayCustName">Walk-in Retail</span></span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="clearCartBtn" style="font-size:0.75rem;padding:3px 10px;border-radius:6px;font-weight:600;"><i class="bi bi-trash3 me-1"></i>Clear</button>
                    </div>

                    <!-- Customer Selection & Digital Wallet Bar -->
                    <div class="customer-selection-wrap mb-3 p-2 rounded" style="background: var(--nav-active-bg); border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label style="font-size: 0.74rem; font-weight: 600; color: var(--text-muted); margin: 0;">
                                <i class="bi bi-person-badge me-1"></i> {{ $isSwahili ? 'Mteja / Pochi ya Kidigitali' : 'Customer & Wallet' }}
                            </label>
                            <span id="custWalletBadge" class="badge" style="display: none; background: #ecfdf5; color: #059669; font-size: 0.72rem; font-weight: 700; border-radius: 9999px;">
                                <i class="bi bi-wallet2 me-1"></i> Pochi: <span id="custWalletAmt">TSh 0</span>
                            </span>
                        </div>
                        <select class="form-select form-select-sm" id="posCustomerSelect" style="font-size: 0.82rem; font-weight: 600; background-color: var(--card-bg); color: var(--text-dark); border-color: var(--border-color);">
                            <option value="" data-name="Walk-in Retail" data-phone="" data-wallet="0" data-points="0" data-debt="0">Walk-in Retail (Mteja wa Kawaida)</option>
                            @if(isset($customers) && $customers->count() > 0)
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-phone="{{ $c->phone }}" data-wallet="{{ (float) ($c->wallet?->balance ?? 0) }}" data-points="{{ $c->loyalty_points }}" data-debt="{{ (float) $c->balance_due }}">
                                        {{ $c->name }} ({{ $c->phone ?? 'Bila Simu' }}) • Pochi: TSh {{ number_format($c->wallet?->balance ?? 0) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div id="custMetaRow" class="d-none justify-content-between align-items-center mt-2 pt-1 border-top" style="font-size: 0.73rem;">
                            <span class="text-muted"><i class="bi bi-award-fill text-warning me-1"></i>Pointi: <strong id="custPointsDisplay">0</strong></span>
                            <span class="text-muted"><i class="bi bi-exclamation-circle-fill text-danger me-1"></i>Deni Analodaiwa: <strong id="custDebtDisplay" class="text-danger">TSh 0</strong></span>
                        </div>
                    </div>

                    <!-- Cart Item Rows -->
                    <div class="cart-items-wrap" id="cartItemsWrap">
                        <!-- Row 1 -->
                        <div class="cart-row" data-id="1" data-name="Coca-Cola 500ml" data-price="1500" data-qty="4">
                            <div>
                                <div class="cart-item-title">Coca-Cola 500ml</div>
                                <div class="cart-item-unit">TSh 1,500 each</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="qty-ctrl">
                                    <button type="button" class="qty-btn btn-qty-minus">-</button>
                                    <span class="qty-val">4</span>
                                    <button type="button" class="qty-btn btn-qty-plus">+</button>
                                </div>
                                <span class="cart-item-price">TSh 6,000</span>
                                <button type="button" class="btn-remove-item"><i class="bi bi-x"></i></button>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="cart-row" data-id="2" data-name="Milk Packet 1L" data-price="3200" data-qty="5">
                            <div>
                                <div class="cart-item-title">Milk Packet 1L</div>
                                <div class="cart-item-unit">TSh 3,200 each</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="qty-ctrl">
                                    <button type="button" class="qty-btn btn-qty-minus">-</button>
                                    <span class="qty-val">5</span>
                                    <button type="button" class="qty-btn btn-qty-plus">+</button>
                                </div>
                                <span class="cart-item-price">TSh 16,000</span>
                                <button type="button" class="btn-remove-item"><i class="bi bi-x"></i></button>
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="cart-row" data-id="3" data-name="Dishwashing Liquid" data-price="4800" data-qty="10">
                            <div>
                                <div class="cart-item-title">Dishwashing Liquid</div>
                                <div class="cart-item-unit">TSh 4,800 each</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="qty-ctrl">
                                    <button type="button" class="qty-btn btn-qty-minus">-</button>
                                    <span class="qty-val">10</span>
                                    <button type="button" class="qty-btn btn-qty-plus">+</button>
                                </div>
                                <span class="cart-item-price">TSh 48,000</span>
                                <button type="button" class="btn-remove-item"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Bill Breakdown -->
                    <div class="bill-breakdown">
                        <div class="breakdown-row">
                            <span>Subtotal</span>
                            <span id="billSubtotal">TSh 70,000</span>
                        </div>
                        <div class="breakdown-row">
                            <span>VAT (Included 18%)</span>
                            <span id="billTax">TSh 4,500</span>
                        </div>
                        <div class="breakdown-row">
                            <span>Discount</span>
                            <span>TSh 0</span>
                        </div>
                        <div class="breakdown-row">
                            <span>Service Fee</span>
                            <span>TSh 10,000</span>
                        </div>
                        <div class="breakdown-row total-row">
                            <span>Total Payable</span>
                            <span id="billTotal">TSh 84,500</span>
                        </div>
                    </div>

                    <!-- Payment Mode Selector -->
                    <div class="payment-methods">
                        <button type="button" class="pay-btn active" data-mode="Cash"><i class="bi bi-cash me-1"></i> Cash</button>
                        <button type="button" class="pay-btn" data-mode="Card"><i class="bi bi-credit-card me-1"></i> Card</button>
                        <button type="button" class="pay-btn" data-mode="M-Pesa"><i class="bi bi-phone me-1"></i> M-Pesa</button>
                        <button type="button" class="pay-btn" data-mode="Wallet" id="btnPayWallet"><i class="bi bi-wallet2 me-1"></i> Pochi</button>
                        <button type="button" class="pay-btn" data-mode="Credit" id="btnPayCredit"><i class="bi bi-journal-text me-1"></i> Mkopo</button>
                    </div>

                    <!-- Cash Tendered & Change Calculation -->
                    <div class="mb-3 p-2 rounded" style="background:var(--nav-active-bg);border:1px solid var(--border-color);" id="cashTenderedGroup">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label style="font-size:0.75rem;font-weight:600;color:var(--text-muted);margin:0;">{{ $isSwahili ? 'Pesa Iliyopokelewa' : 'Cash Tendered' }}</label>
                            <span style="font-size:0.75rem;color:var(--text-muted);">{{ $isSwahili ? 'Chenji:' : 'Change:' }} <strong id="changeDueDisplay" class="text-success font-monospace">TSh 0</strong></span>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" style="background:var(--card-bg);border-color:var(--border-color);color:var(--text-muted);font-size:0.75rem;">TSh</span>
                            <input type="number" id="cashTenderedInput" class="form-control" style="background:var(--card-bg);border-color:var(--border-color);color:var(--text-dark);font-size:0.85rem;font-weight:700;" placeholder="0">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnExactCash" style="font-size:0.72rem;">{{ $isSwahili ? 'Kamili' : 'Exact' }}</button>
                        </div>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-light btn-sm flex-fill quick-cash-btn" data-amt="10000" style="font-size:0.68rem;padding:2px 4px;border:1px solid var(--border-color);">+10k</button>
                            <button type="button" class="btn btn-light btn-sm flex-fill quick-cash-btn" data-amt="20000" style="font-size:0.68rem;padding:2px 4px;border:1px solid var(--border-color);">+20k</button>
                            <button type="button" class="btn btn-light btn-sm flex-fill quick-cash-btn" data-amt="50000" style="font-size:0.68rem;padding:2px 4px;border:1px solid var(--border-color);">50,000</button>
                            <button type="button" class="btn btn-light btn-sm flex-fill quick-cash-btn" data-amt="100000" style="font-size:0.68rem;padding:2px 4px;border:1px solid var(--border-color);">100,000</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <button type="button" class="btn-complete-sale" id="btnCompleteSale">
                        <i class="bi bi-check2-circle me-1"></i> {{ $isSwahili ? 'Kamilisha & Chapisha Resiti' : 'Complete & Print Receipt' }}
                    </button>
                    <button type="button" class="btn-hold-sale" id="btnHoldSale">
                        <i class="bi bi-pause-circle me-1"></i> {{ $isSwahili ? 'Weka Tiketi Kiporo (Hold)' : 'Hold Ticket' }}
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast Notification -->
    <div class="pos-toast" id="posToast">
        <i class="bi bi-check-circle-fill" style="color:#4ade80"></i>
        <span id="posToastMsg">Sale completed successfully! Receipt printed.</span>
    </div>

    <!-- Official EFD Thermal Receipt Modal Component -->
    @include('partials.receipt_modal')

    <!-- Receipts History Modal (Today's Completed Sales) -->
    <div class="modal-overlay" id="receiptsHistoryModal" role="dialog" aria-modal="true" aria-labelledby="receiptsHistoryTitle">
        <div class="modal-box" style="max-width: 520px; border-radius: 16px; overflow: hidden; background: #ffffff;">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <span id="receiptsHistoryTitle" style="font-size:0.95rem; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:8px;">
                    <i class="bi bi-clock-history text-primary fs-5"></i> Historia ya Resiti za Leo (Today's Receipts)
                </span>
                <button type="button" class="btn-close" id="btnCloseReceiptsHistory"></button>
            </div>
            <div class="p-3" style="max-height: 65vh; overflow-y: auto; background:#f8fafc;">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchReceiptHistoryInput" class="form-control border-start-0" placeholder="Tafuta namba ya resiti (#EDK...) au mteja...">
                </div>
                <div id="receiptsHistoryList" class="d-flex flex-column gap-2">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
            <div class="p-2 text-center border-top bg-white">
                <small class="text-muted"><i class="bi bi-printer me-1"></i> Bofya resiti yoyote kuitazama na kuichapisha upya (Re-print).</small>
            </div>
        </div>
    </div>

    <!-- Modal: Open Shift (Float Count) -->
    <div class="modal-overlay" id="openShiftModal" role="dialog" aria-modal="true" style="{{ (!isset($activeShift) || !$activeShift) ? 'display: flex;' : 'display: none;' }}">
        <div class="modal-box" style="max-width: 440px; border-radius: 16px; background: #ffffff; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="text-center mb-3">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 12px;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $isSwahili ? 'Fungua Zamu ya Keshia' : 'Open Cashier Shift' }}</h4>
                <p class="text-muted" style="font-size: 0.82rem;">{{ $isSwahili ? 'Weka kiasi cha fedha taslimu zilizopo kwenye droo wakati wa kuanza mauzo (Float).' : 'Enter starting cash float in drawer to begin checkout.' }}</p>
            </div>
            <form id="formOpenShift">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem;">{{ $isSwahili ? 'Pesa ya Kuanzia Drooni (Float TSh)' : 'Opening Float (TSh)' }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light fw-bold">TSh</span>
                        <input type="number" class="form-control" id="shiftOpeningFloat" value="50000" min="0" step="1000" required style="font-size: 1.05rem; font-weight: 700;">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100" style="padding: 10px; border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-unlock-fill me-1"></i> {{ $isSwahili ? 'Thibitisha & Fungua Zamu' : 'Confirm & Open Shift' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Close Shift (Reconciliation & Cash Count) -->
    <div class="modal-overlay" id="closeShiftModal" role="dialog" aria-modal="true" style="display: none;">
        <div class="modal-box" style="max-width: 480px; border-radius: 16px; background: #ffffff; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-door-closed text-danger me-2"></i>{{ $isSwahili ? 'Funga Zamu & Hesabu ya Droo' : 'Close Shift & Drawer Audit' }}</h5>
                <button type="button" class="btn-close" id="btnCloseShiftModalClose"></button>
            </div>
            <form id="formCloseShift">
                @csrf
                <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.82rem;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Pesa ya Kuanzia (Float):</span>
                        <strong id="closeFloatDisplay">TSh {{ number_format($activeShift?->opening_float ?? 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Mauzo ya Taslimu (Cash Sales):</span>
                        <strong id="closeCashSalesDisplay" class="text-success">+ TSh {{ number_format($activeShift?->cash_sales ?? 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between pt-1 border-top">
                        <span class="fw-bold">Jumla Inayotarajiwa Drooni:</span>
                        <strong id="closeExpectedCash" class="text-primary font-monospace" style="font-size: 0.95rem;">TSh {{ number_format(($activeShift?->opening_float ?? 0) + ($activeShift?->cash_sales ?? 0)) }}</strong>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem;">{{ $isSwahili ? 'Pesa Halisi Zilizopo Drooni (Physical Count)' : 'Physical Cash Count (TSh)' }} *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light fw-bold">TSh</span>
                        <input type="number" class="form-control" id="shiftPhysicalCash" placeholder="0" min="0" required style="font-size: 1.05rem; font-weight: 700;">
                    </div>
                </div>

                <div class="p-2 mb-3 rounded" id="shiftVarianceBox" style="background: #f1f5f9; font-size: 0.82rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Tofauti ya Droo (Variance):</span>
                        <strong id="shiftVarianceDisplay" class="font-monospace">TSh 0</strong>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem;">{{ $isSwahili ? 'Maelezo ya Kufunga / Sababu ya Tofauti' : 'Closing Notes' }}</label>
                    <textarea class="form-control" id="shiftCloseNotes" rows="2" placeholder="Mfano: Chenji imekamilika bila upungufu..." style="font-size: 0.82rem;"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary w-50" id="btnCancelCloseShift">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn btn-danger w-50" style="font-weight: 600;">
                        <i class="bi bi-check2-circle me-1"></i> {{ $isSwahili ? 'Thibitisha Kufunga' : 'Finalize & Close' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- POS Scripts -->
    <script>
        $(document).ready(function() {
            let ticketCounter = 20498;
            let currentShiftExpected = {{ (float)(($activeShift?->opening_float ?? 0) + ($activeShift?->cash_sales ?? 0)) }};
            let isShiftOpen = {{ (isset($activeShift) && $activeShift) ? 'true' : 'false' }};

            // Customer Selection handler
            $('#posCustomerSelect').on('change', function() {
                const opt = $(this).find(':selected');
                const name = opt.data('name') || 'Walk-in Retail';
                const wallet = parseFloat(opt.data('wallet')) || 0;
                const points = parseInt(opt.data('points')) || 0;
                const debt = parseFloat(opt.data('debt')) || 0;
                const custId = $(this).val();

                $('#displayCustName').text(name);

                if (custId) {
                    $('#custWalletBadge').show();
                    $('#custWalletAmt').text('TSh ' + wallet.toLocaleString());
                    $('#custMetaRow').removeClass('d-none').addClass('d-flex');
                    $('#custPointsDisplay').text(points);
                    $('#custDebtDisplay').text('TSh ' + debt.toLocaleString());
                } else {
                    $('#custWalletBadge').hide();
                    $('#custMetaRow').removeClass('d-flex').addClass('d-none');
                }
            });

            // Shift Open Trigger
            $('#btnTriggerOpenShift').on('click', function() {
                $('#openShiftModal').css('display', 'flex');
            });

            $('#formOpenShift').on('submit', function(e) {
                e.preventDefault();
                const floatAmt = parseFloat($('#shiftOpeningFloat').val()) || 0;

                $.ajax({
                    url: '{{ route("pos.open-shift") }}',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: { opening_float: floatAmt },
                    success: function(res) {
                        $('#openShiftModal').hide();
                        isShiftOpen = true;
                        $('#posToastMsg').text('Zamu imefunguliwa kikamilifu! Float: TSh ' + floatAmt.toLocaleString());
                        $('#posToast').fadeIn(200).delay(2500).fadeOut(200);
                        setTimeout(() => window.location.reload(), 800);
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Hitilafu ya kufungua zamu.');
                    }
                });
            });

            // Shift Close Trigger
            $('#btnTriggerCloseShift').on('click', function() {
                $('#closeShiftModal').css('display', 'flex');
            });

            $('#btnCloseShiftModalClose, #btnCancelCloseShift').on('click', function() {
                $('#closeShiftModal').hide();
            });

            $('#shiftPhysicalCash').on('input', function() {
                const count = parseFloat($(this).val()) || 0;
                const diff = count - currentShiftExpected;

                if (diff < 0) {
                    $('#shiftVarianceDisplay').removeClass('text-success').addClass('text-danger').text('Upungufu: TSh ' + Math.abs(diff).toLocaleString());
                } else if (diff > 0) {
                    $('#shiftVarianceDisplay').removeClass('text-danger').addClass('text-success').text('Ziada: +TSh ' + diff.toLocaleString());
                } else {
                    $('#shiftVarianceDisplay').removeClass('text-danger text-success').text('TSh 0 (Kamili)');
                }
            });

            $('#formCloseShift').on('submit', function(e) {
                e.preventDefault();
                const count = parseFloat($('#shiftPhysicalCash').val()) || 0;
                const notes = $('#shiftCloseNotes').val();

                $.ajax({
                    url: '{{ route("pos.close-shift") }}',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: {
                        physical_cash: count,
                        notes: notes
                    },
                    success: function(res) {
                        $('#closeShiftModal').hide();
                        isShiftOpen = false;
                        alert('Zamu imefungwa kikamilifu!\nTofauti ya Droo: TSh ' + (res.variance || 0).toLocaleString());
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Hitilafu ya kufunga zamu.');
                    }
                });
            });

            // Category Filter
            $('.cat-btn').on('click', function() {
                $('.cat-btn').removeClass('active');
                $(this).addClass('active');

                const selectedCat = $(this).data('cat');
                if (selectedCat === 'all') {
                    $('.product-card').show();
                } else {
                    $('.product-card').each(function() {
                        if ($(this).data('cat') === selectedCat || $(this).data('cat') == selectedCat) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });

            // Search Input Filter
            $('#product-search-input').on('keyup', function() {
                const query = $(this).val().toLowerCase();
                $('.product-card').each(function() {
                    const name = ($(this).data('name') || '').toLowerCase();
                    if (name.includes(query)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Cmd+K shortcut
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#product-search-input').focus();
                }
            });

            // Get total numerical value
            function getNumericalTotal() {
                let subtotal = 0;
                $('.cart-row').each(function() {
                    const price = parseInt($(this).data('price')) || 0;
                    const qty = parseInt($(this).data('qty')) || 0;
                    subtotal += (price * qty);
                });
                return subtotal + (subtotal > 0 ? 10000 : 0);
            }

            // Update Change calculation
            function updateChangeCalculation() {
                const total = getNumericalTotal();
                const tendered = parseInt($('#cashTenderedInput').val()) || 0;
                const change = Math.max(0, tendered - total);
                $('#changeDueDisplay').text('TSh ' + change.toLocaleString());
            }

            $('#cashTenderedInput').on('input', updateChangeCalculation);

            $('#btnExactCash').on('click', function() {
                const total = getNumericalTotal();
                $('#cashTenderedInput').val(total);
                updateChangeCalculation();
            });

            $('.quick-cash-btn').on('click', function() {
                const addAmt = parseInt($(this).data('amt')) || 0;
                const current = parseInt($('#cashTenderedInput').val()) || 0;
                if (addAmt === 50000 || addAmt === 100000) {
                    $('#cashTenderedInput').val(addAmt);
                } else {
                    $('#cashTenderedInput').val(current + addAmt);
                }
                updateChangeCalculation();
            });

            // Recalculate bill
            function recalculateBill() {
                let subtotal = 0;
                $('.cart-row').each(function() {
                    const price = parseInt($(this).data('price')) || 0;
                    const qty = parseInt($(this).data('qty')) || 0;
                    subtotal += (price * qty);
                });

                const tax = Math.round(subtotal * 0.06);
                const total = subtotal + (subtotal > 0 ? 10000 : 0);

                $('#billSubtotal').text('TSh ' + subtotal.toLocaleString());
                $('#billTax').text('TSh ' + tax.toLocaleString());
                $('#billTotal').text('TSh ' + total.toLocaleString());
                updateChangeCalculation();
            }

            // Helper: Add Item to Cart Ticket
            function addItemToCart(name, price, id = null) {
                let existingRow = null;
                $('.cart-row').each(function() {
                    if ($(this).data('name') === name) {
                        existingRow = $(this);
                    }
                });

                if (existingRow) {
                    let currentQty = parseInt(existingRow.data('qty')) + 1;
                    existingRow.data('qty', currentQty);
                    existingRow.find('.qty-val').text(currentQty);
                    existingRow.find('.cart-item-price').text('TSh ' + (price * currentQty).toLocaleString());
                } else {
                    const newRow = `
                        <div class="cart-row" data-id="${id || 1}" data-name="${name}" data-price="${price}" data-qty="1">
                            <div>
                                <div class="cart-item-title">${name}</div>
                                <div class="cart-item-unit">TSh ${price.toLocaleString()} each</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="qty-ctrl">
                                    <button type="button" class="qty-btn btn-qty-minus">-</button>
                                    <span class="qty-val">1</span>
                                    <button type="button" class="qty-btn btn-qty-plus">+</button>
                                </div>
                                <span class="cart-item-price">TSh ${price.toLocaleString()}</span>
                                <button type="button" class="btn-remove-item"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    `;
                    $('#cartItemsWrap').append(newRow);
                }
                recalculateBill();
            }

            // Unit Chip Click on Product Card
            $(document).on('click', '.unit-chip', function(e) {
                e.stopPropagation();
                const chip = $(this);
                const card = chip.closest('.product-card');
                const baseName = card.data('name');
                const unitName = chip.data('unit');
                const unitPrice = parseInt(chip.data('price')) || 0;
                const prodId = card.data('id') || 1;

                card.find('.unit-chip').removeClass('active');
                chip.addClass('active');

                card.find('.product-price').text('TSh ' + unitPrice.toLocaleString());
                card.data('selected-unit', unitName);
                card.data('selected-price', unitPrice);

                addItemToCart(baseName + ' (' + unitName + ')', unitPrice, prodId);
            });

            // Add Product from card click
            $(document).on('click', '.product-card', function(e) {
                if ($(e.target).closest('.unit-chip').length) {
                    return;
                }
                const name = $(this).data('name');
                const selectedUnit = $(this).data('selected-unit');
                const price = parseInt($(this).data('selected-price') || $(this).data('price'));
                const prodId = $(this).data('id') || 1;
                const fullName = selectedUnit ? `${name} (${selectedUnit})` : name;

                addItemToCart(fullName, price, prodId);
            });

            // Quantity Plus / Minus
            $(document).on('click', '.btn-qty-plus', function() {
                const row = $(this).closest('.cart-row');
                const price = parseInt(row.data('price'));
                let qty = parseInt(row.data('qty')) + 1;
                row.data('qty', qty);
                row.find('.qty-val').text(qty);
                row.find('.cart-item-price').text('TSh ' + (price * qty).toLocaleString());
                recalculateBill();
            });

            $(document).on('click', '.btn-qty-minus', function() {
                const row = $(this).closest('.cart-row');
                const price = parseInt(row.data('price'));
                let qty = parseInt(row.data('qty')) - 1;
                if (qty <= 0) {
                    row.remove();
                } else {
                    row.data('qty', qty);
                    row.find('.qty-val').text(qty);
                    row.find('.cart-item-price').text('TSh ' + (price * qty).toLocaleString());
                }
                recalculateBill();
            });

            // Remove item
            $(document).on('click', '.btn-remove-item', function() {
                $(this).closest('.cart-row').remove();
                recalculateBill();
            });

            // Clear cart
            $('#clearCartBtn').on('click', function() {
                $('#cartItemsWrap').empty();
                $('#cashTenderedInput').val('');
                recalculateBill();
            });

            // Payment Method selection
            $('.pay-btn').on('click', function() {
                const mode = $(this).data('mode');

                if (mode === 'Wallet') {
                    const cust = $('#posCustomerSelect').find(':selected');
                    const custId = $('#posCustomerSelect').val();
                    if (!custId) {
                        alert('Tafadhali chagua mteja aliyesajiliwa mwenye pochi (Customer Wallet) kwanza.');
                        return;
                    }
                    const walletBal = parseFloat(cust.data('wallet')) || 0;
                    const totalPayable = getNumericalTotal();
                    if (walletBal < totalPayable) {
                        alert('Salio la pochi (TSh ' + walletBal.toLocaleString() + ') halitoshi kulipa jumla ya TSh ' + totalPayable.toLocaleString());
                        return;
                    }
                    $('#cashTenderedInput').val(totalPayable);
                    updateChangeCalculation();
                }

                $('.pay-btn').removeClass('active');
                $(this).addClass('active');
            });

            // Real in-memory sales history for today's receipts
            let todaysReceipts = [
                {
                    receiptNumber: '#EDK-20498',
                    dateTime: '27/09/2026 09:56 PM',
                    cashier: '{{ session("user_name", "Asha Mwamba") }}',
                    terminal: 'POS-01',
                    customer: 'Walk-in Retail',
                    storeName: '{{ session("tenant_name") ? strtoupper(session("tenant_name")) : "MERCANTO SUPERMARKET & WHOLESALE" }}',
                    branchAddress: '{{ session("branch_name") ? session("branch_name") . ", " : "Kariakoo Branch, " }}Msimbazi Street',
                    items: [
                        { name: 'Coca-Cola 500ml', qty: 4, price: 1500, total: 6000 },
                        { name: 'Milk Packet 1L', qty: 5, price: 3200, total: 16000 },
                        { name: 'Dishwashing Liquid', qty: 10, price: 4800, total: 48000 }
                    ],
                    subtotal: 70000,
                    tax: 4200,
                    fee: 10000,
                    total: 80000,
                    paymentMode: 'Card',
                    tendered: 80000,
                    change: 0,
                    fiscalCode: '9A48-E71B-33C9-92F1'
                }
            ];

            // Render Receipts History list
            function renderReceiptsHistory(searchQuery) {
                const listWrap = $('#receiptsHistoryList');
                listWrap.empty();
                
                let filtered = todaysReceipts;
                if (searchQuery) {
                    const q = searchQuery.toLowerCase().trim();
                    filtered = todaysReceipts.filter(function(r) {
                        return r.receiptNumber.toLowerCase().includes(q) ||
                               (r.customer && r.customer.toLowerCase().includes(q)) ||
                               r.paymentMode.toLowerCase().includes(q);
                    });
                }

                if (filtered.length === 0) {
                    listWrap.html('<div class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-1"></i>{{ $isSwahili ? "Hakuna resiti inayolingana na utafutaji wako." : "No receipt matches your search." }}</div>');
                    return;
                }

                filtered.forEach(function(r, index) {
                    const itemCount = r.items ? r.items.length : 0;
                    const card = $(`
                        <div class="card p-2 border shadow-sm rounded-3 bg-white receipt-history-card" style="cursor: pointer; transition: all 0.15s ease;" data-index="${index}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark font-monospace" style="font-size: 0.88rem;">${r.receiptNumber}</span>
                                <span class="badge bg-success-subtle text-success font-monospace" style="font-size: 0.82rem;">TSh ${Number(r.total).toLocaleString()}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted" style="font-size: 0.76rem;">
                                <span><i class="bi bi-person me-1"></i>${r.customer || 'Walk-in'} • ${itemCount} {{ $isSwahili ? 'bidhaa' : 'items' }}</span>
                                <span><i class="bi bi-credit-card me-1"></i>${r.paymentMode} • ${r.dateTime}</span>
                            </div>
                            <div class="text-end mt-1 pt-1 border-top" style="font-size: 0.74rem;">
                                <span class="text-primary fw-semibold"><i class="bi bi-printer me-1"></i>{{ $isSwahili ? 'Bofya kutazama & kuchapisha' : 'Click to view & print' }} &rarr;</span>
                            </div>
                        </div>
                    `);
                    card.on('click', function() {
                        $('#receiptsHistoryModal').removeClass('show');
                        window.openEfdReceipt(r);
                    });
                    listWrap.append(card);
                });
            }

            $('.open-receipts-history-btn').on('click', function(e) {
                e.preventDefault();
                renderReceiptsHistory('');
                $('#searchReceiptHistoryInput').val('');
                $('#receiptsHistoryModal').addClass('show');
            });

            $('#btnCloseReceiptsHistory').on('click', function() {
                $('#receiptsHistoryModal').removeClass('show');
            });

            $('#searchReceiptHistoryInput').on('input', function() {
                renderReceiptsHistory($(this).val());
            });

            // Start New Sale / Reset Cart
            function startNewSale() {
                $('#receiptModal').removeClass('show');
                $('#cartItemsWrap').empty();
                $('#cashTenderedInput').val('');
                ticketCounter++;
                $('.cart-ticket-title').text('Ticket #EDK-' + ticketCounter);
                recalculateBill();
                $('#posToastMsg').text(`Mauzo yamekamilika! Tiketi mpya #EDK-${ticketCounter} imeanza.`);
                $('#posToast').fadeIn(200).delay(3000).fadeOut(200);
            }

            // Complete sale & Checkout via /api/pos/checkout
            $('#btnCompleteSale').on('click', function() {
                if ($('.cart-row').length === 0) {
                    $('#posToastMsg').text('Kikapu cha manunuzi ni kitupu! Ongeza bidhaa kwanza.');
                    $('#posToast').fadeIn(200).delay(2500).fadeOut(200);
                    return;
                }

                if (!isShiftOpen) {
                    $('#openShiftModal').css('display', 'flex');
                    return;
                }

                const totalVal = getNumericalTotal();
                let tendered = parseInt($('#cashTenderedInput').val()) || 0;
                if (tendered < totalVal) {
                    tendered = totalVal;
                }
                const change = Math.max(0, tendered - totalVal);
                const mode = $('.pay-btn.active').data('mode') || 'Cash';
                const custId = $('#posCustomerSelect').val() || null;
                const custName = $('#posCustomerSelect').find(':selected').data('name') || 'Walk-in Retail';

                // Build cart items array
                let cartItemsPayload = [];
                let receiptItems = [];
                let subtotalVal = 0;

                $('.cart-row').each(function() {
                    const id = parseInt($(this).data('id')) || 1;
                    const name = $(this).data('name');
                    const price = parseInt($(this).data('price')) || 0;
                    const qty = parseInt($(this).data('qty')) || 0;
                    const lineTotal = price * qty;
                    subtotalVal += lineTotal;

                    cartItemsPayload.push({
                        id: id,
                        name: name,
                        price: price,
                        qty: qty,
                        batch_id: null
                    });

                    receiptItems.push({
                        name: name,
                        qty: qty,
                        price: price,
                        total: lineTotal
                    });
                });

                const taxVal = Math.round(subtotalVal * 0.06);
                const feeVal = 10000;
                const grandTotal = subtotalVal + taxVal + feeVal;

                // Send Checkout Request
                $('#btnCompleteSale').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

                $.ajax({
                    url: '{{ route("pos.checkout") }}',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        cart: cartItemsPayload,
                        payment_method: mode.toLowerCase(),
                        customer_id: custId,
                        tendered_amount: tendered,
                        discount: 0
                    }),
                    success: function(res) {
                        $('#btnCompleteSale').prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i> {{ $isSwahili ? "Kamilisha & Chapisha Resiti" : "Complete & Print Receipt" }}');

                        const invoiceNo = res.invoice_no || ('#EDK-' + ticketCounter);
                        const dateStr = new Date().toLocaleDateString('en-GB') + ' ' + new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                        const newReceipt = {
                            receiptNumber: invoiceNo,
                            dateTime: dateStr,
                            cashier: '{{ session("user_name", "Asha Mwamba") }}',
                            terminal: 'POS-01',
                            customer: custName,
                            storeName: '{{ session("tenant_name") ? strtoupper(session("tenant_name")) : "MERCANTO SUPERMARKET & WHOLESALE" }}',
                            branchAddress: '{{ session("branch_name") ? session("branch_name") . ", " : "Kariakoo Branch, " }}Msimbazi Street',
                            items: receiptItems,
                            subtotal: subtotalVal,
                            tax: taxVal,
                            fee: feeVal,
                            total: grandTotal,
                            paymentMode: mode,
                            tendered: tendered,
                            change: change,
                            fiscalCode: '9A' + Math.random().toString(36).substring(2, 6).toUpperCase() + '-TRA-' + Date.now().toString().slice(-4),
                            onNewSale: startNewSale
                        };

                        todaysReceipts.unshift(newReceipt);
                        window.openEfdReceipt(newReceipt);

                        // If WhatsApp digital receipt is available, show WhatsApp button
                        if (res.whatsapp_url) {
                            $('#posToastMsg').html(`Mauzo yamekamilika! <a href="${res.whatsapp_url}" target="_blank" class="btn btn-xs btn-success text-white ms-2" style="font-size:0.75rem;padding:2px 8px;border-radius:9999px;"><i class="bi bi-whatsapp"></i> Tuma WhatsApp</a>`);
                        } else {
                            $('#posToastMsg').text(`Mauzo yamekamilika! Risiti ${invoiceNo} imechapishwa.`);
                        }
                        $('#posToast').fadeIn(200).delay(5000).fadeOut(200);
                    },
                    error: function(xhr) {
                        $('#btnCompleteSale').prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i> {{ $isSwahili ? "Kamilisha & Chapisha Resiti" : "Complete & Print Receipt" }}');
                        const errorMsg = xhr.responseJSON?.message || 'Hitilafu ya kukamilisha mauzo.';
                        alert(errorMsg);
                    }
                });
            });

            $('#btnReceiptNewSale').on('click', startNewSale);

            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).is('.modal-overlay')) {
                    $('#receiptModal').removeClass('show');
                }
            });

            // Hold sale
            $('#btnHoldSale').on('click', function() {
                if ($('.cart-row').length === 0) {
                    $('#posToastMsg').text('Hakuna bidhaa kwenye kikapu za kuweka kiporo.');
                } else {
                    $('#posToastMsg').text(`Tiketi #EDK-${ticketCounter} imewekwa kiporo (Hold) kikamilifu.`);
                }
                $('#posToast').fadeIn(200).delay(2500).fadeOut(200);
            });

            // Theme Toggle with LocalStorage
            let isLight = !$('body').hasClass('dark-mode');
            $('#theme-toggle-btn').on('click', function() {
                isLight = !isLight;
                $('body').toggleClass('dark-mode');
                $('#theme-icon').toggleClass('bi-sun bi-moon-stars');
                localStorage.setItem('theme', $('body').hasClass('dark-mode') ? 'dark' : 'light');
            });

            // Auto apply saved theme
            if (localStorage.getItem('theme') === 'dark') {
                $('body').addClass('dark-mode');
                $('#theme-icon').removeClass('bi-sun').addClass('bi-moon-stars');
            }
        });
    </script>
</body>
</html>
