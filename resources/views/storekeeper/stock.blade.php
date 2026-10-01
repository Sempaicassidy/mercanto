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
    <title>{{ $isSwahili ? 'Bidhaa & Hesabu ya Stoo' : 'Products & Stock Inventory' }} - mercanto</title>

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

        /* Filters Toolbar */
        .filter-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 1.2rem;
        }

        .filter-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.42rem 0.75rem;
            font-size: 0.8rem;
            color: var(--text-dark);
            outline: none;
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

        .action-icon-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .action-icon-btn:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
            border-color: #a1a1aa;
        }

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
            max-width: 540px;
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

    <!-- Left Sidebar (Store Keeper) -->
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
                        <a href="{{ url('/storekeeper/dashboard') }}" class="nav-item-link">
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
                        <a href="{{ url('/storekeeper/stock') }}" class="nav-item-link active">
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
                    <input type="text" class="search-input" placeholder="{{ $isSwahili ? 'Tafuta bidhaa, barcode, SKU, rafu...' : 'Search product, barcode, SKU, shelf...' }}" id="global-search-input">
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
                <h1 class="h3 fw-bold mb-0" style="letter-spacing: -0.5px;">
                    {{ $isSwahili ? 'Orodha ya Bidhaa & Hesabu ya Stoo' : 'Products & Stock Inventory' }}
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.84rem;">
                    {{ $isSwahili ? 'Kagua idadi ya bidhaa halisi, maeneo ya rafu, bei za kununua na kuuza, na kufanya mapokezi.' : 'Catalog counts, warehouse bin locations, buying & selling prices, and reorder levels.' }}
                </p>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="{{ route('storekeeper.export-valuation') }}" class="btn-outline-custom" id="exportStockBtn" title="{{ $isSwahili ? 'Pakua Excel/CSV' : 'Export Stock CSV' }}">
                    <i class="bi bi-file-earmark-arrow-down text-success"></i>
                    <span>{{ $isSwahili ? 'Pakua Orodha (CSV)' : 'Export CSV' }}</span>
                </a>
                <button type="button" class="btn-outline-custom" id="quickIntakeBtn">
                    <i class="bi bi-box-arrow-in-down text-primary"></i>
                    <span>{{ $isSwahili ? 'Pokea Mzigo (GRN)' : 'Stock Intake (GRN)' }}</span>
                </button>
                <button type="button" class="btn-dark-custom" id="addProductBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>{{ $isSwahili ? 'Ongeza Bidhaa Mpya' : 'Add Product' }}</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Jumla ya Bidhaa (Catalog)' : 'Active Catalog Products' }}</span>
                        <i class="bi bi-boxes stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">{{ $totalProducts }} SKUs</div>
                        <div class="stat-subtext">{{ $categories->count() }} {{ $isSwahili ? 'vitengo vya biashara' : 'categories' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Bakaa ya Vipande Vyote' : 'Total Stock In Hand' }}</span>
                        <i class="bi bi-layers stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">{{ number_format($totalUnits) }} Units</div>
                        <div class="stat-subtext font-monospace">TSh {{ number_format($totalValuation) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Zilizo Chini ya Kiwango' : 'Low Stock Alerts' }}</span>
                        <i class="bi bi-exclamation-triangle stat-icon text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-value text-danger">{{ $lowStockCount }} {{ $isSwahili ? 'Bidhaa' : 'Items' }}</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Zinahitaji kuagizwa' : 'Under safety threshold' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Zinazoisha Ndani ya Siku 30' : 'Expiring in 30 Days' }}</span>
                        <i class="bi bi-calendar-event stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">{{ $expiringCount }} {{ $isSwahili ? 'Bidhaa' : 'Batches' }}</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Ufuatiliaji wa tarehe' : 'Expiry watch alert' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Management Table Card -->
        <div class="content-card">
            <!-- Filter Toolbar -->
            <div class="filter-toolbar">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <select class="filter-select" id="filterCategory">
                        <option value="all">-- {{ $isSwahili ? 'Vitengo Vyote' : 'All Categories' }} --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <select class="filter-select" id="filterStatus">
                        <option value="all">-- {{ $isSwahili ? 'Hali Yoyote ya Stoo' : 'All Stock Statuses' }} --</option>
                        <option value="in_stock">{{ $isSwahili ? 'Ipo Stoo (In Stock)' : 'In Stock' }}</option>
                        <option value="low_stock">{{ $isSwahili ? 'Inakaribia Kuisha (Low Stock)' : 'Low Stock' }}</option>
                        <option value="out_stock">{{ $isSwahili ? 'Imeisha Kabisa (Out of Stock)' : 'Out of Stock' }}</option>
                    </select>
                </div>

                <div style="font-size: 0.8rem; color: var(--text-muted);" id="visibleItemsCount">
                    {{ $isSwahili ? 'Inaonyesha' : 'Showing' }} <strong class="text-dark">{{ $products->count() }}</strong> {{ $isSwahili ? 'bidhaa' : 'products' }}
                </div>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5 border rounded-3 bg-light">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <h5 class="fw-bold">{{ $isSwahili ? 'Hakuna bidhaa kwenye orodha ya stoo bado!' : 'No products found in warehouse inventory!' }}</h5>
                    <p class="text-muted" style="font-size: 0.85rem;">{{ $isSwahili ? 'Bofya kitufe cha "Ongeza Bidhaa Mpya" hapo juu kuanza kuingiza bidhaa za duka hili.' : 'Click "Add Product" button above to add the first item to stock.' }}</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="custom-table" id="stockCatalogTable">
                        <thead>
                            <tr>
                                <th>{{ $isSwahili ? 'Jina la Bidhaa & SKU' : 'Product & SKU' }}</th>
                                <th>{{ $isSwahili ? 'Kitengo' : 'Category' }}</th>
                                <th>{{ $isSwahili ? 'Barcode' : 'Barcode' }}</th>
                                <th>{{ $isSwahili ? 'Eneo la Rafu' : 'Shelf / Bay' }}</th>
                                <th>{{ $isSwahili ? 'Idadi Stoo' : 'Stock Qty' }}</th>
                                <th>{{ $isSwahili ? 'Bei ya Kununua' : 'Cost Price' }}</th>
                                <th>{{ $isSwahili ? 'Bei ya Kuuza' : 'Retail Price' }}</th>
                                <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                                <th style="text-align: right;">{{ $isSwahili ? 'Kitendo' : 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $p)
                                @php
                                    $qty = $p->current_stock;
                                    $minAlert = $p->min_alert_qty ?: 15;
                                    $statusClass = 'badge-success';
                                    $statusText = $isSwahili ? 'Ipo Stoo' : 'In Stock';
                                    $statusKey = 'in_stock';

                                    if ($qty <= 0) {
                                        $statusClass = 'badge-danger';
                                        $statusText = $isSwahili ? 'Imeisha' : 'Out of Stock';
                                        $statusKey = 'out_stock';
                                    } elseif ($qty <= $minAlert) {
                                        $statusClass = 'badge-warning';
                                        $statusText = $isSwahili ? 'Inakaribia Kuisha' : 'Low Stock';
                                        $statusKey = 'low_stock';
                                    }
                                @endphp
                                <tr data-category="{{ $p->category_id }}" data-status="{{ $statusKey }}" data-search="{{ strtolower($p->name . ' ' . $p->sku . ' ' . $p->barcode . ' ' . $p->current_location) }}">
                                    <td>
                                        <div style="font-weight: 600;">{{ $p->name }}</div>
                                        <span style="font-size: 0.74rem; color: var(--text-muted);">SKU: {{ $p->sku }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $p->category?->name ?? ($isSwahili ? 'Jumla' : 'General') }}
                                        </span>
                                    </td>
                                    <td class="font-monospace text-muted" style="font-size: 0.78rem;">
                                        {{ $p->barcode ?: 'N/A' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-light border py-0 px-2 btn-edit-location" 
                                            data-id="{{ $p->id }}" 
                                            data-name="{{ $p->name }}"
                                            data-location="{{ $p->current_location }}"
                                            title="{{ $isSwahili ? 'Bofya kubadili rafu' : 'Click to change shelf' }}"
                                            style="font-size: 0.75rem;">
                                            <i class="bi bi-geo-alt me-1 text-primary"></i><span class="loc-text">{{ $p->current_location }}</span>
                                        </button>
                                    </td>
                                    <td>
                                        <strong class="{{ $qty <= 0 ? 'text-danger' : ($qty <= $minAlert ? 'text-warning' : 'text-dark') }} font-monospace">
                                            {{ number_format($qty) }} {{ $p->unit }}
                                        </strong>
                                    </td>
                                    <td class="font-monospace text-muted">
                                        TSh {{ number_format($p->cost_price) }}
                                    </td>
                                    <td class="font-monospace text-dark font-semibold">
                                        TSh {{ number_format($p->selling_price) }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            <i class="bi {{ $qty <= 0 ? 'bi-x-circle-fill' : ($qty <= $minAlert ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill') }}"></i>
                                            <span>{{ $statusText }}</span>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div class="d-inline-flex gap-1">
                                            <button type="button" class="btn btn-sm btn-dark py-1 px-2 btn-table-grn" 
                                                data-id="{{ $p->id }}"
                                                data-name="{{ $p->name }}"
                                                data-cost="{{ $p->cost_price }}"
                                                data-location="{{ $p->current_location }}"
                                                style="font-size: 0.74rem;" title="{{ $isSwahili ? 'Pokea mzigo wa bidhaa hii (GRN)' : 'Intake stock (GRN)' }}">
                                                <i class="bi bi-box-arrow-in-down me-1"></i>GRN
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Modal 1: Add New Product into Warehouse -->
    <div class="modal-overlay" id="addProductModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-plus-circle text-primary me-2"></i>{{ $isSwahili ? 'Ingiza Bidhaa Mpya Stoo' : 'Add New Catalog Product' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="addProductModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="addProductForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Jina Kamili la Bidhaa' : 'Product Name' }} *</label>
                        <input type="text" id="newProdName" class="form-control-custom" placeholder="e.g. Mchele wa Kyela Super 25kg" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Kitengo (Category)' : 'Category' }} *</label>
                            <select id="newProdCategory" class="form-control-custom" required>
                                <option value="">-- {{ $isSwahili ? 'Chagua Kitengo...' : 'Choose Category...' }} --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Kipimo (Unit)' : 'Unit of Measure' }}</label>
                            <select id="newProdUnit" class="form-control-custom">
                                <option value="pcs">Pcs / Vipande</option>
                                <option value="kg">Kg (Kilograms)</option>
                                <option value="bag">Bag / Gunia</option>
                                <option value="box">Box / Katoni</option>
                                <option value="litre">Litre / Lita</option>
                                <option value="crate">Crate / Kreni</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Bei ya Kununua (Cost TZS)' : 'Cost Price (TZS)' }} *</label>
                            <input type="number" id="newProdCost" class="form-control-custom" placeholder="e.g. 14000" min="0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Bei ya Kuuza Rejareja (Retail)' : 'Selling Price (TZS)' }} *</label>
                            <input type="number" id="newProdSelling" class="form-control-custom" placeholder="e.g. 17500" min="0" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Kiasi cha Kuanzia Stoo (Initial Stock)' : 'Initial Quantity' }}</label>
                            <input type="number" id="newProdInitialStock" class="form-control-custom" value="0" min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Kiwango cha Tahadhari (Min Alert)' : 'Min Alert Threshold' }}</label>
                            <input type="number" id="newProdMinAlert" class="form-control-custom" value="15" min="1">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Eneo la Rafu (Shelf Location)' : 'Shelf Location' }}</label>
                            <input type="text" id="newProdLocation" class="form-control-custom" placeholder="e.g. Bay A - Shelf 01">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Barcode / Msimbo Pau' : 'Barcode' }}</label>
                            <input type="text" id="newProdBarcode" class="form-control-custom" placeholder="Auto-generated if blank">
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="addProductModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-dark-custom" id="btnSubmitNewProduct">
                        <i class="bi bi-check2"></i> {{ $isSwahili ? 'Hifadhi Bidhaa' : 'Save Product' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Edit Shelf Location -->
    <div class="modal-overlay" id="editLocationModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-geo-alt text-primary me-2"></i>{{ $isSwahili ? 'Badili Eneo la Rafu / Ghala' : 'Update Shelf Location' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="editLocationModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="editLocationForm">
                <input type="hidden" id="locProdId">
                <div class="modal-body-custom">
                    <p style="font-size: 0.88rem; color: var(--text-dark);" id="locProdNameText"></p>
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Eneo Jipya la Rafu (Shelf / Bay / Pallet)' : 'New Shelf Location' }} *</label>
                        <input type="text" id="locNewShelf" class="form-control-custom" placeholder="e.g. Shelf B-04, Cold Room, Pallet 02" required>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="editLocationModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-primary-custom" id="btnSubmitLocation">
                        <i class="bi bi-check2"></i> {{ $isSwahili ? 'Hifadhi Eneo' : 'Save Location' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Goods Receiving (GRN) -->
    <div class="modal-overlay" id="receiveGoodsModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-box-arrow-in-down text-primary me-2"></i>{{ $isSwahili ? 'Mapokezi ya Mzigo Stoo (GRN Intake)' : 'Receive Inbound Shipment (GRN)' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="receiveGoodsModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="receiveGoodsForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Bidhaa' : 'Product' }} *</label>
                        <select id="grnProductSelect" class="form-control-custom" required>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-cost="{{ $p->cost_price }}" data-location="{{ $p->current_location }}">
                                    {{ $p->name }} ({{ $isSwahili ? 'Stoo sasa' : 'Current' }}: {{ $p->current_stock }} {{ $p->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Idadi Iliyopokelewa' : 'Quantity' }} *</label>
                            <input type="number" id="grnQuantity" class="form-control-custom" placeholder="e.g. 50" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Bei ya Kununua (Cost)' : 'Unit Cost' }}</label>
                            <input type="number" id="grnUnitCost" class="form-control-custom" placeholder="e.g. 3500">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Msambazaji (Supplier)' : 'Supplier' }}</label>
                            <input type="text" id="grnSupplierName" class="form-control-custom" placeholder="e.g. Bakhresa, METL">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Nambari ya Ankara' : 'Invoice #' }}</label>
                            <input type="text" id="grnInvoiceNo" class="form-control-custom" placeholder="e.g. INV-8921">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Eneo la Rafu (Shelf Location)' : 'Shelf Location' }}</label>
                        <input type="text" id="grnShelfLocation" class="form-control-custom" placeholder="e.g. Shelf A-02">
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="receiveGoodsModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-primary-custom" id="btnSubmitGRN">
                        <i class="bi bi-check2-circle"></i> {{ $isSwahili ? 'Thibitisha & Ongeza Stoo' : 'Confirm & Add Stock' }}
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

            function applyTableFilters() {
                const term = $('#global-search-input').val().toLowerCase().trim();
                const catFilter = $('#filterCategory').val();
                const statusFilter = $('#filterStatus').val();

                let visible = 0;
                $('#stockCatalogTable tbody tr').each(function() {
                    const rowSearch = $(this).data('search') || $(this).text().toLowerCase();
                    const rowCat = String($(this).data('category'));
                    const rowStatus = $(this).data('status');

                    const matchSearch = !term || rowSearch.includes(term);
                    const matchCat = catFilter === 'all' || rowCat === catFilter;
                    const matchStatus = statusFilter === 'all' || rowStatus === statusFilter;

                    if (matchSearch && matchCat && matchStatus) {
                        $(this).show();
                        visible++;
                    } else {
                        $(this).hide();
                    }
                });

                $('#visibleItemsCount').html(`{{ $isSwahili ? "Inaonyesha" : "Showing" }} <strong class="text-dark">${visible}</strong> {{ $isSwahili ? "bidhaa" : "products" }}`);
            }

            $('#global-search-input').on('keyup', applyTableFilters);
            $('#filterCategory, #filterStatus').on('change', applyTableFilters);

            // Modals Trigger
            $('#addProductBtn').on('click', function() {
                $('#addProductModal').addClass('show');
            });

            $('#quickIntakeBtn, #navReceiveGoodsBtn').on('click', function() {
                $('#receiveGoodsModal').addClass('show');
            });

            $(document).on('click', '.btn-table-grn', function() {
                const id = $(this).data('id');
                const cost = $(this).data('cost');
                const loc = $(this).data('location');
                $('#grnProductSelect').val(id);
                $('#grnUnitCost').val(cost);
                $('#grnShelfLocation').val(loc);
                $('#receiveGoodsModal').addClass('show');
            });

            $(document).on('click', '.btn-edit-location', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const loc = $(this).data('location');
                $('#locProdId').val(id);
                $('#locProdNameText').html('{{ $isSwahili ? "Badili rafu ya bidhaa:" : "Change shelf location for:" }} <strong>' + name + '</strong>');
                $('#locNewShelf').val(loc);
                $('#editLocationModal').addClass('show');
            });

            $('.close-modal').on('click', function() {
                const modalId = $(this).data('modal');
                $('#' + modalId).removeClass('show');
            });

            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).is('.modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });

            // Submit New Product
            $('#addProductForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $('#btnSubmitNewProduct');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inahifadhi...');

                const data = {
                    name: $('#newProdName').val().trim(),
                    category_id: $('#newProdCategory').val(),
                    unit: $('#newProdUnit').val(),
                    cost_price: $('#newProdCost').val(),
                    selling_price: $('#newProdSelling').val(),
                    initial_stock: $('#newProdInitialStock').val(),
                    min_alert_qty: $('#newProdMinAlert').val(),
                    shelf_location: $('#newProdLocation').val().trim(),
                    barcode: $('#newProdBarcode').val().trim()
                };

                $.ajax({
                    url: '{{ route("storekeeper.product.store") }}',
                    type: 'POST',
                    data: data,
                    success: function(resp) {
                        $('#addProductModal').removeClass('show');
                        showToast(resp.message || 'Bidhaa imeongezwa!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 700);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        alert(xhr.responseJSON?.message || 'Hitilafu imetokea.');
                    }
                });
            });

            // Submit Location Update
            $('#editLocationForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#locProdId').val();
                const $btn = $('#btnSubmitLocation');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inasasisha...');

                $.ajax({
                    url: '/storekeeper/product/' + id + '/location',
                    type: 'POST',
                    data: {
                        shelf_location: $('#locNewShelf').val().trim()
                    },
                    success: function(resp) {
                        $('#editLocationModal').removeClass('show');
                        showToast(resp.message || 'Eneo limesasishwa!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 600);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        alert(xhr.responseJSON?.message || 'Hitilafu wakati wa kubadili eneo.');
                    }
                });
            });

            // Submit GRN Intake
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
                    shelf_location: $('#grnShelfLocation').val()
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
                        alert(xhr.responseJSON?.message || 'Hitilafu wakati wa kupokea mzigo.');
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
