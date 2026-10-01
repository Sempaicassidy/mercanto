@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
    $businessMode = session('business_mode', 'retailer');
    $isWholesale = $businessMode === 'wholesaler';
    $tenantName = $tenant ? $tenant->name : session('tenant_name', 'Mangi Supermarket Ltd');
    $branchName = $branch ? $branch->name : session('branch_name', 'Main Branch (HQ)');
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isSwahili ? 'Dashibodi ya Stoo & Ghala' : 'Storekeeper & Warehouse Dashboard' }} - mercanto</title>

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
            --nav-active-bg: #f4f4f5;
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
            --badge-in-bg: #f0fdf4;
            --badge-in-text: #16a34a;
            --badge-out-bg: #eff6ff;
            --badge-out-text: #2563eb;
            --badge-adjust-bg: #fffbeb;
            --badge-adjust-text: #d97706;
        }

        body.dark-mode {
            --bg-page: #09090b;
            --sidebar-bg: #111113;
            --border-color: #27272a;
            --text-dark: #f4f4f5;
            --text-muted: #a1a1aa;
            --nav-active-bg: #1f1f23;
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
            --badge-in-bg: #052e16;
            --badge-in-text: #4ade80;
            --badge-out-bg: #172554;
            --badge-out-text: #60a5fa;
            --badge-adjust-bg: #451a03;
            --badge-adjust-text: #fbbf24;
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
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
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
            z-index: 1050;
            transition: transform 0.25s ease;
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }

        .workspace-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.6rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s ease;
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
            background-color: var(--primary-btn);
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        body.dark-mode .workspace-icon {
            color: #09090b;
        }

        .workspace-info h4 {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
        }

        .workspace-info span {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .nav-section-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin: 1.2rem 0 0.4rem 0.6rem;
        }

        .nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.48rem 0.65rem;
            border-radius: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .nav-item-link:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        .nav-item-link.active {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
            font-weight: 600;
        }

        .nav-item-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-item-left i {
            font-size: 1rem;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem;
            border-radius: 8px;
            border-top: 1px solid var(--border-color);
            padding-top: 0.85rem;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-btn);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            margin-right: 10px;
        }

        body.dark-mode .profile-avatar {
            color: #09090b;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .profile-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-email {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.5rem 2rem;
            min-height: 100vh;
            background-color: var(--bg-page);
            max-width: 100%;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .sidebar-backdrop.show {
                display: block;
            }
            .main-wrapper {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Top Nav Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .header-search-box {
            position: relative;
            width: 320px;
            max-width: 100%;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .search-input {
            width: 100%;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.45rem 2.2rem;
            font-size: 0.82rem;
            color: var(--text-dark);
            outline: none;
            transition: all 0.15s ease;
        }

        .search-input:focus {
            border-color: #a1a1aa;
            box-shadow: 0 0 0 2px rgba(0,0,0,0.04);
        }

        .search-kbd {
            position: absolute;
            right: 8px;
            font-size: 0.65rem;
            color: var(--text-muted);
            background: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 1px 5px;
            font-weight: 600;
        }

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-icon-btn {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        .header-branch-pill {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .branch-indicator-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #22c55e;
        }

        /* Stat Cards */
        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.25rem 1.4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-icon {
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .stat-subtext {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Content Card */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Custom Table */
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table th {
            font-size: 0.74rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--card-bg);
            text-align: left;
            white-space: nowrap;
        }

        .custom-table td {
            font-size: 0.84rem;
            color: var(--text-dark);
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            transition: background-color 0.1s ease;
        }

        .custom-table tbody tr:hover td {
            background-color: var(--nav-active-bg);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.74rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 9999px;
        }
        .badge-danger { background-color: var(--badge-danger-bg); color: var(--badge-danger-text); }
        .badge-warning { background-color: var(--badge-warning-bg); color: var(--badge-warning-text); }
        .badge-success { background-color: var(--badge-success-bg); color: var(--badge-success-text); }
        .badge-primary { background-color: var(--badge-primary-bg); color: var(--badge-primary-text); }

        .movement-badge {
            font-size: 0.74rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .movement-badge.inbound { background-color: var(--badge-in-bg); color: var(--badge-in-text); }
        .movement-badge.outbound { background-color: var(--badge-out-bg); color: var(--badge-out-text); }
        .movement-badge.adjustment { background-color: var(--badge-adjust-bg); color: var(--badge-adjust-text); }

        /* Buttons */
        .btn-outline-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.45rem 0.85rem;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-dark);
            font-size: 0.84rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        .btn-dark-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.45rem 1rem;
            background-color: var(--primary-btn);
            color: #ffffff;
            border: 1px solid var(--primary-btn);
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        body.dark-mode .btn-dark-custom {
            color: #09090b;
        }

        .btn-dark-custom:hover {
            opacity: 0.9;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.45rem 1rem;
            background-color: #2563eb;
            color: #ffffff;
            border: 1px solid #2563eb;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            color: #ffffff;
        }

        /* Modals */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-box {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            overflow: hidden;
            animation: modalFadeIn 0.18s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header-custom {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header-custom h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .modal-body-custom {
            padding: 1.5rem;
            max-height: 75vh;
            overflow-y: auto;
        }

        .modal-footer-custom {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            background-color: var(--card-bg);
        }

        .form-label-custom {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.35rem;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-control-custom:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
        }

        .toast-notify {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #09090b;
            color: #ffffff;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 0.84rem;
            font-weight: 500;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
            z-index: 2000;
        }
    </style>
</head>
<body>

    <!-- Sidebar Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Left Sidebar (Store Keeper Persona) -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Workspace Brand Header -->
            <div class="workspace-header">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>{{ $tenantName }}</h4>
                        <span>{{ $isSwahili ? 'Stoo & Ghala Kuu' : 'Storekeeper / Warehouse' }}</span>
                    </div>
                </div>
            </div>

            <!-- Dynamic Nav Items -->
            <div id="sidebar-nav-container">
                <div class="nav-section-title">{{ $isSwahili ? 'Ujumla' : 'General' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/storekeeper/dashboard') }}" class="nav-item-link active">
                            <span class="nav-item-left">
                                <i class="bi bi-speedometer2"></i>
                                <span>{{ $isSwahili ? 'Dashibodi ya Stoo' : 'Warehouse Dashboard' }}</span>
                            </span>
                        </a>
                    </li>
                </ul>

                <div class="nav-section-title">{{ $isSwahili ? 'Mali & Stoo' : 'Warehouse & Inventory' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/storekeeper/stock') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-boxes"></i>
                                <span>{{ $isSwahili ? 'Bidhaa & Hesabu ya Stoo' : 'Products & Stock' }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="nav-item-link" id="navReceiveGoodsBtn">
                            <span class="nav-item-left">
                                <i class="bi bi-box-arrow-in-down"></i>
                                <span>{{ $isSwahili ? 'Mapokezi ya Mzigo (GRN)' : 'Goods Receiving (GRN)' }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="nav-item-link" id="navStockAdjustmentBtn">
                            <span class="nav-item-left">
                                <i class="bi bi-sliders"></i>
                                <span>{{ $isSwahili ? 'Marekebisho ya Stoo' : 'Stock Adjustments' }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/manager/category') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-tags"></i>
                                <span>{{ $isSwahili ? 'Vitengo vya Bidhaa' : 'Product Categories' }}</span>
                            </span>
                        </a>
                    </li>
                </ul>

                <div class="nav-section-title">{{ $isSwahili ? 'Milango ya Haraka' : 'Quick Access' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/pos') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-cart3"></i>
                                <span>{{ $isSwahili ? 'Fungua Kaunta (POS)' : 'Open POS Terminal' }}</span>
                            </span>
                            <i class="bi bi-arrow-up-right text-muted" style="font-size: 0.75rem;"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/manager/dashboard') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-shop"></i>
                                <span>{{ $isSwahili ? 'Muhtasari wa Meneja' : 'Manager Overview' }}</span>
                            </span>
                            <i class="bi bi-arrow-up-right text-muted" style="font-size: 0.75rem;"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Bottom Profile Section -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center;">
                <div class="profile-avatar" id="sidebarAvatarInitial">SK</div>
                <div class="profile-info">
                    <span class="profile-name" id="sidebarProfileName">{{ session('user_name', 'Store Keeper') }}</span>
                    <span class="profile-email" id="sidebarProfileEmail">{{ session('user_email', 'storekeeper@eduka.co.tz') }}</span>
                </div>
            </div>
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); font-size: 1.1rem; text-decoration: none; padding: 4px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Nav Bar -->
        <header class="top-nav-bar">
            <div class="d-flex align-items-center gap-2">
                <button class="nav-icon-btn d-lg-none" id="mobileSidebarToggle" title="Open Menu">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="header-search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="{{ $isSwahili ? 'Tafuta SKU, jina, eneo la stoo...' : 'Search SKU, item, bin location...' }}" id="global-search-input">
                    <span class="search-kbd">⌘ K</span>
                </div>
            </div>

            <div class="top-nav-actions">
                <!-- Branch Indicator Pill -->
                <div class="header-branch-pill d-none d-sm-inline-flex">
                    <span class="branch-indicator-dot"></span>
                    <span>{{ $branchName }}</span>
                </div>

                <!-- Universal Role & Language Switcher Component -->
                @include('partials.role_switcher')

                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>
            </div>
        </header>

        <!-- Page Header -->
        <div class="page-header-row d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h1 class="h3 fw-bold mb-0" style="letter-spacing: -0.5px;">
                        {{ $isWholesale ? ($isSwahili ? 'Ghala Kuu la Jumla (Warehouse)' : 'Wholesale Distribution Warehouse') : ($isSwahili ? 'Stoo ya Bidhaa za Duka' : 'Store Inventory & Stockroom') }}
                    </h1>
                    @if($isWholesale)
                        <span class="badge" style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; padding: 4px 12px; border: 1px solid rgba(124, 58, 237, 0.25);">
                            <i class="bi bi-boxes me-1"></i> {{ $isSwahili ? 'Storekeeper wa Jumla' : 'Wholesale Storekeeper' }}
                        </span>
                    @else
                        <span class="badge" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; padding: 4px 12px; border: 1px solid rgba(37, 99, 235, 0.25);">
                            <i class="bi bi-cart3 me-1"></i> {{ $isSwahili ? 'Storekeeper wa Rejareja' : 'Retail Storekeeper' }}
                        </span>
                    @endif
                </div>
                <p class="text-muted mb-0" style="font-size: 0.84rem;">
                    {{ $isWholesale ? ($isSwahili ? 'Mapokezi ya mikatoni, magunia, na uhamishaji wa mzigo kati ya stoo na matawi.' : 'Bulk receiving, cartons, sacks intake, and dispatch ledger.') : ($isSwahili ? 'Usimamizi wa bakaa ya bidhaa stoo, kutoa mzigo kwenda rafu za duka, na kuweka rekodi za mapokezi.' : 'Retail stockroom counts, shelf replenishment, goods intake (GRN), and physical audit.') }}
                </p>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="{{ route('storekeeper.export-valuation') }}" class="btn-outline-custom" id="printValuationBtn" title="{{ $isSwahili ? 'Pakua faili la Excel/CSV la thamani ya stoo' : 'Download inventory valuation CSV' }}">
                    <i class="bi bi-file-earmark-arrow-down text-success"></i>
                    <span>{{ $isSwahili ? 'Ripoti ya Thamani (CSV)' : 'Valuation Export' }}</span>
                </a>
                <button type="button" class="btn-outline-custom" id="triggerAdjustmentBtn">
                    <i class="bi bi-sliders text-warning"></i>
                    <span>{{ $isSwahili ? 'Marekebisho ya Stoo' : 'Stock Adjustment' }}</span>
                </button>
                <button type="button" class="btn-dark-custom" id="triggerReceiveGoodsBtn">
                    <i class="bi bi-box-arrow-in-down text-primary"></i>
                    <span>{{ $isSwahili ? 'Pokea Mzigo (GRN)' : 'Receive Goods (GRN)' }}</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Jumla ya Bidhaa (Catalog)' : 'Total Catalog SKUs' }}</span>
                        <i class="bi bi-boxes stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">{{ $totalProducts }} SKUs</div>
                        <div class="stat-subtext">{{ $totalUnits }} {{ $isSwahili ? 'vipande/vifurushi stoo' : 'physical units on hand' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Thamani Halisi ya Stoo' : 'Warehouse Stock Value' }}</span>
                        <i class="bi bi-cash-stack stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success font-monospace" style="font-size: 1.35rem;">
                            TSh {{ number_format($totalStockValue) }}
                        </div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Kulingana na bei za kununulia' : 'Calculated at cost prices' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Bidhaa Zinazoisha (Low Stock)' : 'Low Stock Alerts' }}</span>
                        <i class="bi bi-exclamation-octagon stat-icon text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-value text-danger">{{ $lowStockCount }} SKUs</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Chini ya kiwango salama' : 'Below reorder threshold' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Mapokezi ya Hivi Karibuni' : 'Recent GRN Intakes' }}</span>
                        <i class="bi bi-truck stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">{{ $recentPurchases->count() }} {{ $isSwahili ? 'Oda' : 'Orders' }}</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Zilizothibitishwa stoo' : 'Verified warehouse intakes' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Urgent Replenishment Table -->
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--text-dark);">
                        {{ $isSwahili ? 'Tahadhari ya Bidhaa Zinazoisha Haraka (Urgent Reorder List)' : 'Low Stock Reorder List' }}
                    </h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 2px 0 0 0;">
                        {{ $isSwahili ? 'Bidhaa hizi zimekaribia kuisha, zinahitaji kuagizwa mara moja kuzuia kukwama kwa mauzo ya kaunta.' : 'Immediate intake required to prevent retail checkout stock-outs.' }}
                    </p>
                </div>
                <span class="status-badge badge-danger px-3 py-1">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>{{ $lowStockCount }} {{ $isSwahili ? 'Zinazohitaji Mzigo' : 'Critical Items' }}</span>
                </span>
            </div>

            @if($lowStockItems->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle fs-3 text-success d-block mb-1"></i>
                    <span>{{ $isSwahili ? 'Stoo ipo salama! Hakuna bidhaa iliyo chini ya kiwango cha tahadhari kwa sasa.' : 'All stock levels are optimal! No items below minimum threshold.' }}</span>
                </div>
            @else
                <div class="table-responsive">
                    <table class="custom-table" id="lowStockTable">
                        <thead>
                            <tr>
                                <th>{{ $isSwahili ? 'Jina la Bidhaa & SKU' : 'Product Name & SKU' }}</th>
                                <th>{{ $isSwahili ? 'Kitengo' : 'Category' }}</th>
                                <th>{{ $isSwahili ? 'Kiasi Kilichopo' : 'Current Stock' }}</th>
                                <th>{{ $isSwahili ? 'Kiwango cha Tahadhari' : 'Safety Min' }}</th>
                                <th>{{ $isSwahili ? 'Eneo la Stoo (Shelf)' : 'Shelf Location' }}</th>
                                <th style="text-align: right;">{{ $isSwahili ? 'Kitendo' : 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockItems as $item)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600;">{{ $item->name }}</div>
                                        <span style="font-size: 0.74rem; color: var(--text-muted);">SKU: {{ $item->sku }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $item->category?->name ?? ($isSwahili ? 'Jumla' : 'General') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-danger font-monospace">
                                            {{ $item->current_stock }} {{ $item->unit }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $item->min_alert_qty ?: 15 }} {{ $item->unit }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $item->current_location }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <button type="button" class="btn btn-sm btn-dark btn-quick-grn" 
                                            data-id="{{ $item->id }}" 
                                            data-name="{{ $item->name }}"
                                            data-cost="{{ $item->cost_price }}"
                                            data-location="{{ $item->current_location }}"
                                            style="font-size: 0.76rem; border-radius: 6px;">
                                            <i class="bi bi-box-arrow-in-down me-1"></i> {{ $isSwahili ? 'Pokea Mzigo (GRN)' : 'Intake GRN' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Recent Stock Movement Ledger Card -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--text-dark);">
                        {{ $isSwahili ? 'Kumbukumbu za Mienendo ya Stoo (Stock Ledger)' : 'Recent Stock Movement Ledger' }}
                    </h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 2px 0 0 0;">
                        {{ $isSwahili ? 'Orodha halisi ya mizigo iliyopokelewa kutoka viwandani/wasambazaji na marekebisho ya ukaguzi.' : 'Real-time intake receipts from suppliers and recorded audit adjustments.' }}
                    </p>
                </div>
                <a href="{{ route('storekeeper.stock') }}" class="btn-outline-custom" style="font-size: 0.8rem;">
                    <span>{{ $isSwahili ? 'Tazama Orodha Kamili ya Stoo' : 'View Full Stock Catalog' }}</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="stockMovementTable">
                    <thead>
                        <tr>
                            <th>{{ $isSwahili ? 'Nambari ya Rejea' : 'Ref #' }}</th>
                            <th>{{ $isSwahili ? 'Aina ya Shughuli' : 'Movement Type' }}</th>
                            <th>{{ $isSwahili ? 'Bidhaa / Maelezo' : 'Item / Details' }}</th>
                            <th>{{ $isSwahili ? 'Kiasi' : 'Quantity' }}</th>
                            <th>{{ $isSwahili ? 'Thamani / Hasara' : 'Amount / Loss' }}</th>
                            <th>{{ $isSwahili ? 'Tarehe' : 'Date' }}</th>
                            <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPurchases as $purchase)
                            <tr>
                                <td><strong>#{{ $purchase->po_number }}</strong></td>
                                <td>
                                    <span class="movement-badge inbound">
                                        <i class="bi bi-box-arrow-in-down"></i> Inbound GRN
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">
                                        {{ $purchase->supplier?->name ?? 'Wholesale Supplier' }}
                                    </div>
                                    <span style="font-size: 0.74rem; color: var(--text-muted);">
                                        {{ $purchase->items->count() }} {{ $isSwahili ? 'aina za bidhaa zimepokelewa' : 'item lines received' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-success font-monospace">
                                    +{{ $purchase->items->sum('quantity') }}
                                </td>
                                <td class="font-monospace text-dark font-semibold">
                                    TSh {{ number_format($purchase->total_amount) }}
                                </td>
                                <td class="text-muted" style="font-size: 0.76rem;">
                                    {{ $purchase->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <span class="status-badge badge-success"><i class="bi bi-check2"></i> Verified</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3 text-muted">
                                    {{ $isSwahili ? 'Hakuna rekodi za mapokezi bado. Bofya "Pokea Mzigo (GRN)" kuingiza mzigo mpya.' : 'No recent intakes recorded yet. Click "Receive Goods (GRN)" to log intake.' }}
                                </td>
                            </tr>
                        @endforelse

                        @foreach($recentDamages as $damage)
                            <tr>
                                <td><strong>#ADJ-{{ $damage->id }}</strong></td>
                                <td>
                                    <span class="movement-badge adjustment">
                                        <i class="bi bi-exclamation-triangle"></i> {{ ucfirst($damage->reason) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $damage->product?->name ?? 'Product Item' }}</div>
                                    <span style="font-size: 0.74rem; color: var(--text-muted);">{{ $damage->notes ?: 'Audit adjustment' }}</span>
                                </td>
                                <td class="fw-bold text-danger font-monospace">
                                    -{{ $damage->quantity }}
                                </td>
                                <td class="font-monospace text-danger font-semibold">
                                    TSh {{ number_format($damage->total_loss) }}
                                </td>
                                <td class="text-muted" style="font-size: 0.76rem;">
                                    {{ $damage->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <span class="status-badge badge-warning"><i class="bi bi-sliders"></i> Adjusted</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal 1: Goods Receiving (GRN) -->
    <div class="modal-overlay" id="receiveGoodsModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-box-arrow-in-down text-primary me-2"></i>{{ $isSwahili ? 'Mapokezi ya Mzigo Stoo (GRN Intake)' : 'Receive Inbound Shipment (GRN)' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="receiveGoodsModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="receiveGoodsForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Chagua Bidhaa ya Kupokea' : 'Select Product to Intake' }} *</label>
                        <select id="grnProductSelect" class="form-control-custom" required>
                            <option value="">-- {{ $isSwahili ? 'Chagua Bidhaa...' : 'Choose item...' }} --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-cost="{{ $p->cost_price }}" data-location="{{ $p->current_location }}">
                                    {{ $p->name }} ({{ $isSwahili ? 'Stoo sasa' : 'Current stock' }}: {{ $p->current_stock }} {{ $p->unit }}) - SKU: {{ $p->sku }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Idadi Iliyopokelewa (Qty)' : 'Received Quantity' }} *</label>
                            <input type="number" id="grnQuantity" class="form-control-custom" placeholder="e.g. 50" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Bei ya Kununua kwa Kipande (Cost)' : 'Unit Cost (TZS)' }}</label>
                            <input type="number" id="grnUnitCost" class="form-control-custom" placeholder="e.g. 3500">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Msambazaji (Supplier)' : 'Supplier Name' }}</label>
                            <input type="text" id="grnSupplierName" class="form-control-custom" list="suppliersList" placeholder="{{ $isSwahili ? 'k.m. Bakhresa, METL' : 'e.g. Bakhresa, METL' }}">
                            <datalist id="suppliersList">
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->name }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Nambari ya Ankara / Delivery Note' : 'Delivery Note / Invoice #' }}</label>
                            <input type="text" id="grnInvoiceNo" class="form-control-custom" placeholder="e.g. INV-8921">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Eneo la Rafu / Ghala (Shelf Location)' : 'Storage Shelf / Bay Location' }}</label>
                        <input type="text" id="grnShelfLocation" class="form-control-custom" placeholder="e.g. Shelf A-02, Cold Room, Bay B">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Maelezo ya Ziada (Notes)' : 'Notes' }}</label>
                        <textarea id="grnNotes" class="form-control-custom" rows="2" placeholder="{{ $isSwahili ? 'Maelezo kuhusu hali ya mzigo...' : 'Notes on batch, delivery condition...' }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="receiveGoodsModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-primary-custom" id="btnSubmitGRN">
                        <i class="bi bi-check2-circle"></i> {{ $isSwahili ? 'Hifadhi & Ongeza Stoo' : 'Confirm & Increase Stock' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Stock Adjustment (Damages / Shrinkage / Audit Recount) -->
    <div class="modal-overlay" id="stockAdjustmentModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-sliders text-warning me-2"></i>{{ $isSwahili ? 'Marekebisho ya Hesabu ya Stoo' : 'Stock Adjustment & Audit' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="stockAdjustmentModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="stockAdjustmentForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Chagua Bidhaa ya Kurekebisha' : 'Select Product' }} *</label>
                        <select id="adjProductSelect" class="form-control-custom" required>
                            <option value="">-- {{ $isSwahili ? 'Chagua bidhaa...' : 'Choose product...' }} --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->name }} ({{ $isSwahili ? 'Iliyopo' : 'Current' }}: {{ $p->current_stock }} {{ $p->unit }}) - SKU: {{ $p->sku }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Aina ya Marekebisho' : 'Adjustment Type' }} *</label>
                            <select id="adjType" class="form-control-custom" required>
                                <option value="damage">{{ $isSwahili ? 'Bidhaa Zilizoharibika (Damages)' : 'Damages / Broken' }}</option>
                                <option value="shortage">{{ $isSwahili ? 'Upungufu / Upotevu (Shortage)' : 'Shrinkage / Lost' }}</option>
                                <option value="surplus">{{ $isSwahili ? 'Ziada ya Hesabu (Surplus)' : 'Audit Surplus' }}</option>
                                <option value="recount">{{ $isSwahili ? 'Weka Hesabu Kamili (Recount)' : 'Set Physical Count' }}</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Idadi ya Vipande (Quantity)' : 'Quantity' }} *</label>
                            <input type="number" id="adjQuantity" class="form-control-custom" placeholder="e.g. 5" min="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Sababu Kuu (Reason)' : 'Reason' }}</label>
                        <input type="text" id="adjReason" class="form-control-custom" placeholder="{{ $isSwahili ? 'k.m. Chupa zilivunjika wakati wa kushusha mzigo' : 'e.g. Dropped during forklift handling' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Maelezo ya Ziada' : 'Audit Notes' }}</label>
                        <textarea id="adjNotes" class="form-control-custom" rows="2" placeholder="{{ $isSwahili ? 'Maelezo ya ziada ya ukaguzi wa stoo...' : 'Additional audit explanation...' }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="stockAdjustmentModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-dark-custom" id="btnSubmitAdjustment">
                        <i class="bi bi-check-lg"></i> {{ $isSwahili ? 'Hifadhi Marekebisho' : 'Apply Adjustment' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill" style="color: #4ade80;"></i>
        <span id="toastNotifyMsg">Action performed</span>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Setup CSRF header for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                }
            });

            // Mobile Sidebar Toggle
            $('#mobileSidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('mobile-open');
                $('#sidebarBackdrop').toggleClass('show');
            });

            $('#sidebarBackdrop').on('click', function() {
                $('#sidebar').removeClass('mobile-open');
                $('#sidebarBackdrop').removeClass('show');
            });

            // Theme Toggle & Persistence
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                $('body').addClass('dark-mode');
                $('#theme-icon').removeClass('bi-sun').addClass('bi-moon-stars');
            } else {
                $('body').removeClass('dark-mode');
                $('#theme-icon').removeClass('bi-moon-stars').addClass('bi-sun');
            }

            $('#theme-toggle-btn').on('click', function() {
                $('body').toggleClass('dark-mode');
                const isDark = $('body').hasClass('dark-mode');
                if (isDark) {
                    $('#theme-icon').removeClass('bi-sun').addClass('bi-moon-stars');
                    localStorage.setItem('theme', 'dark');
                } else {
                    $('#theme-icon').removeClass('bi-moon-stars').addClass('bi-sun');
                    localStorage.setItem('theme', 'light');
                }
            });

            // Live Search (Cmd+K)
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#global-search-input').focus();
                }
            });

            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase().trim();
                $('#lowStockTable tbody tr, #stockMovementTable tbody tr').each(function() {
                    $(this).toggle($(this).text().toLowerCase().includes(term));
                });
            });

            // Open GRN Modal
            $('#triggerReceiveGoodsBtn, #navReceiveGoodsBtn').on('click', function() {
                $('#receiveGoodsModal').addClass('show');
            });

            // Pre-select product when clicking Quick GRN from low stock table
            $(document).on('click', '.btn-quick-grn', function() {
                const id = $(this).data('id');
                const cost = $(this).data('cost');
                const location = $(this).data('location');
                $('#grnProductSelect').val(id);
                $('#grnUnitCost').val(cost);
                $('#grnShelfLocation').val(location);
                $('#receiveGoodsModal').addClass('show');
            });

            // Open Stock Adjustment Modal
            $('#triggerAdjustmentBtn, #navStockAdjustmentBtn').on('click', function() {
                $('#stockAdjustmentModal').addClass('show');
            });

            // Close Modals
            $('.close-modal').on('click', function() {
                const modalId = $(this).data('modal');
                $('#' + modalId).removeClass('show');
            });

            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).is('.modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });

            // Update unit cost when selecting product in GRN
            $('#grnProductSelect').on('change', function() {
                const selectedOpt = $(this).find('option:selected');
                const cost = selectedOpt.data('cost');
                const location = selectedOpt.data('location');
                if (cost) $('#grnUnitCost').val(cost);
                if (location) $('#grnShelfLocation').val(location);
            });

            // Submit GRN Goods Receiving
            $('#receiveGoodsForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $('#btnSubmitGRN');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inapokea...');

                const data = {
                    product_id: $('#grnProductSelect').val(),
                    quantity: $('#grnQuantity').val(),
                    unit_cost: $('#grnUnitCost').val(),
                    supplier_name: $('#grnSupplierName').val(),
                    invoice_no: $('#grnInvoiceNo').val(),
                    shelf_location: $('#grnShelfLocation').val(),
                    notes: $('#grnNotes').val()
                };

                $.ajax({
                    url: '{{ route("storekeeper.receive-goods") }}',
                    type: 'POST',
                    data: data,
                    success: function(resp) {
                        $('#receiveGoodsModal').removeClass('show');
                        showToast(resp.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 700);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        const msg = xhr.responseJSON?.message || 'Hitilafu imetokea wakati wa kupokea mzigo.';
                        alert(msg);
                    }
                });
            });

            // Submit Stock Adjustment
            $('#stockAdjustmentForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $('#btnSubmitAdjustment');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inarekebisha...');

                const data = {
                    product_id: $('#adjProductSelect').val(),
                    adjustment_type: $('#adjType').val(),
                    quantity: $('#adjQuantity').val(),
                    reason: $('#adjReason').val(),
                    notes: $('#adjNotes').val()
                };

                $.ajax({
                    url: '{{ route("storekeeper.adjust-stock") }}',
                    type: 'POST',
                    data: data,
                    success: function(resp) {
                        $('#stockAdjustmentModal').removeClass('show');
                        showToast(resp.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 700);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        const msg = xhr.responseJSON?.message || 'Hitilafu wakati wa kurekebisha stoo.';
                        alert(msg);
                    }
                });
            });

            function showToast(msg) {
                const toast = $('#toastNotify');
                $('#toastNotifyMsg').html(msg);
                toast.stop(true, true).fadeIn(180).delay(3200).fadeOut(200);
            }
        });
    </script>
</body>
</html>
