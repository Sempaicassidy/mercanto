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
    <title>{{ $isSwahili ? 'Dashibodi ya Meneja' : 'Manager Dashboard' }} - Mercanto</title>

    @include('partials.pwa_meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js for Overview bar chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --bar-color: #10b981;
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
            --bar-color: #10b981;
            --badge-danger-bg: #450a0a;
            --badge-danger-text: #f87171;
            --badge-warning-bg: #451a03;
            --badge-warning-text: #fbbf24;
            --badge-success-bg: #052e16;
            --badge-success-text: #4ade80;
            --badge-primary-bg: #172554;
            --badge-primary-text: #60a5fa;
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
        }

        /* Sidebar Styling (Shadcn Style) */
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
            z-index: 100;
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

        .workspace-header:hover {
            background-color: var(--nav-active-bg);
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
            color: #3f3f46;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .nav-item-link:hover {
            background-color: #f4f4f5;
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
            font-size: 1.05rem;
            color: #71717a;
        }

        .nav-item-link.active .nav-item-left i {
            color: var(--text-dark);
        }

        .badge-subtle {
            background-color: #18181b;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 9999px;
        }

        /* Collapsible Submenu Styles */
        .nav-dropdown-toggle {
            cursor: pointer;
            user-select: none;
        }

        .nav-chevron {
            transition: transform 0.2s ease;
            font-size: 0.75rem;
            color: #a1a1aa;
        }

        .nav-dropdown-toggle.open .nav-chevron,
        .nav-dropdown-toggle[aria-expanded="true"] .nav-chevron {
            transform: rotate(90deg);
            color: var(--text-dark);
        }

        .nav-submenu {
            list-style: none;
            padding: 0.25rem 0 0.25rem 0.85rem;
            margin: 2px 0 6px 0.85rem;
            display: none;
            flex-direction: column;
            gap: 2px;
            border-left: 1px solid #e4e4e7;
        }

        .nav-subitem-link {
            display: block;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            color: #71717a;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .nav-subitem-link:hover {
            color: var(--text-dark);
            background-color: #f4f4f5;
        }

        .sidebar-role-pill {
            font-size: 0.7rem;
            font-weight: 600;
            color: #09090b;
            background-color: #f4f4f5;
            padding: 2px 8px;
            border-radius: 9999px;
            border: 1px solid #e4e4e7;
        }

        /* Sidebar Profile Section */
        .sidebar-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s ease;
            border-top: 1px solid var(--border-color);
            padding-top: 0.85rem;
        }

        .sidebar-profile:hover {
            background-color: var(--nav-active-bg);
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: #e4e4e7;
            color: #18181b;
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
            max-width: 130px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Main Content Layout */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
        }

        /* Top Bar Actions */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            gap: 12px;
            width: 100%;
        }

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .header-search-box {
            position: relative;
            width: 250px;
        }

        .search-input {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.45rem 2.2rem 0.45rem 2rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .search-input:focus {
            border-color: #a1a1aa;
            box-shadow: 0 0 0 1px #a1a1aa;
        }

        .search-icon {
            position: absolute;
            left: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a1a1aa;
            font-size: 0.85rem;
        }

        .search-kbd {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.68rem;
            font-weight: 600;
            background-color: #f4f4f5;
            color: #71717a;
            padding: 2px 5px;
            border-radius: 4px;
            border: 1px solid #e4e4e7;
        }

        .nav-icon-btn {
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3f3f46;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: #f4f4f5;
            color: var(--text-dark);
        }

        .header-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.45rem 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-dark);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .header-role-pill:hover {
            background-color: #f4f4f5;
        }

        .header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #e4e4e7;
            color: #09090b;
            font-weight: 700;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Dashboard Header */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .dashboard-title {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--text-dark);
            margin: 0;
        }

        /* Dashboard Tabs */
        .dashboard-tabs {
            display: flex;
            align-items: center;
            background-color: #f4f4f5;
            padding: 3px;
            border-radius: 8px;
            width: fit-content;
            margin-bottom: 1.75rem;
        }

        .tab-btn {
            border: none;
            background: transparent;
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #71717a;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .tab-btn:hover {
            color: var(--text-dark);
        }

        .tab-btn.active {
            background-color: #ffffff;
            color: var(--text-dark);
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        /* Stat Cards */
        .stat-card {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.25rem 1.4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            transition: border-color 0.15s ease;
        }

        .stat-card:hover {
            border-color: #a1a1aa;
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .stat-icon {
            font-size: 1rem;
            color: #71717a;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }

        .stat-subtext {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* Large Sections Grid */
        .content-card {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            height: 100%;
        }

        .card-header-clean {
            margin-bottom: 1.25rem;
        }

        .card-header-clean h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .card-header-clean p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin: 3px 0 0 0;
        }

        /* Recent Sales Item */
        .sale-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 0;
            border-bottom: 1px solid #f4f4f5;
        }

        .sale-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .btn-receipt-action {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #0d6efd;
            border-radius: 7px;
            padding: 4px 8px;
            font-size: 0.82rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-receipt-action:hover {
            background: #0d6efd;
            color: #ffffff;
            border-color: #0d6efd;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.35);
        }

        .sale-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sale-avatar {
            width: 38px;
            height: 38px;
            background-color: #f4f4f5;
            color: #27272a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .sale-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .sale-email {
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        .sale-amount {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* User Profile Dropdown & Header Nav */
        .header-branch-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            font-size: 0.76rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .branch-indicator-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .header-profile-dropdown {
            position: relative;
        }

        .header-profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 4px 10px 4px 5px;
            border-radius: 9999px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .header-profile-btn:hover {
            background-color: var(--nav-active-bg);
            border-color: var(--text-muted);
        }

        .header-user-meta {
            display: flex;
            flex-direction: column;
            text-align: left;
            line-height: 1.15;
        }

        .header-user-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .header-user-role {
            font-size: 0.68rem;
            color: var(--text-muted);
        }

        .header-dropdown-arrow {
            font-size: 0.65rem;
            color: var(--text-muted);
            transition: transform 0.2s ease;
        }

        .header-profile-dropdown.show .header-dropdown-arrow {
            transform: rotate(180deg);
        }

        .profile-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 250px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.1);
            padding: 6px;
            display: none;
            flex-direction: column;
            z-index: 1050;
            animation: dropdownFadeIn 0.15s ease-out;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-profile-dropdown.show .profile-dropdown-menu {
            display: flex;
        }

        .profile-dropdown-header {
            padding: 8px 10px 10px 10px;
        }

        .profile-dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 4px 0;
        }

        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .profile-dropdown-item:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        .profile-dropdown-item.text-danger {
            color: #ef4444 !important;
        }

        .profile-dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626 !important;
        }

        body.dark-mode .profile-dropdown-item.text-danger:hover {
            background-color: #450a0a;
            color: #f87171 !important;
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            padding: 0.4rem 0.95rem;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-apply-role {
            background: var(--primary-btn);
            border: 1px solid var(--primary-btn);
            color: #ffffff;
            padding: 0.4rem 1.1rem;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        /* Toast notification */
        .toast-notify {
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
                transition: transform 0.25s ease;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>

    <!-- Left Sidebar (Clean Shadcn Style) -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Workspace Brand Header -->
            <div class="workspace-header" title="Mercanto Management Portal">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>{{ $isWholesale ? 'Wholesale & Supplier' : 'Retail Store Panel' }}</span>
                    </div>
                </div>
            </div>

            <!-- DYNAMIC NAV ITEMS -->
            <div id="sidebar-nav-container">
                <div class="nav-section-title">{{ $isSwahili ? 'Ujumla' : 'General' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/manager/dashboard') }}" class="nav-item-link active">
                            <span class="nav-item-left">
                                <i class="bi bi-speedometer2"></i>
                                <span>{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}</span>
                            </span>
                        </a>
                    </li>

                    <!-- Dropdown: Manage Store -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-box-seam"></i>
                                <span>{{ $isSwahili ? 'Simamia Duka' : 'Manage Store' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{url('/manager/stock')}}" class="nav-subitem-link">{{ $isSwahili ? 'Bidhaa na Stoo' : 'Products & Stock' }}</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">{{ $isSwahili ? 'Kaunta ya Mauzo (POS)' : 'POS / Cashier' }}</a></li>
                            <li><a href="{{url('/manager/category')}}" class="nav-subitem-link">{{ $isSwahili ? 'Makundi ya Bidhaa' : 'Categories' }}</a></li>
                            <li><a href="{{url('/manager/suppliers')}}" class="nav-subitem-link">{{ $isSwahili ? 'Wasambazaji' : 'Suppliers' }}</a></li>
                            <li><a href="{{ url('/manager/customers') }}" class="nav-subitem-link">{{ $isSwahili ? 'Wateja na Mikopo' : 'Customers & Credit' }}</a></li>
                            <li><a href="{{ url('/manager/purchases') }}" class="nav-subitem-link">{{ $isSwahili ? 'Maagizo ya Manunuzi (LPO)' : 'Purchase Orders (LPO)' }}</a></li>
                            <li><a href="{{ url('/manager/transfers') }}" class="nav-subitem-link">{{ $isSwahili ? 'Uhamisho wa Matawi' : 'Branch Transfers' }}</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Operations -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-arrow-left-right"></i>
                                <span>{{ $isSwahili ? 'Uendeshaji' : 'Operations' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/shifts') }}" class="nav-subitem-link">{{ $isSwahili ? 'Zamu na Droo ya Pesa' : 'Shift & Cash Register' }}</a></li>
                            <li><a href="{{ url('/manager/returns') }}" class="nav-subitem-link">{{ $isSwahili ? 'Marejesho na Malipo' : 'Returns & Refunds' }}</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ukaguzi wa Stoo na Hasara' : 'Stock Audit & Wastage' }}</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Manage Staff -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-people"></i>
                                <span>{{ $isSwahili ? 'Simamia Wafanyakazi' : 'Manage Staff' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/staff_attendance') }}" class="nav-subitem-link">{{ $isSwahili ? 'Zamu na Mahudhurio' : 'Staff Shifts & Attendance' }}</a></li>
                            <li><a href="{{ url('/manager/staff_salary') }}" class="nav-subitem-link">{{ $isSwahili ? 'Mishahara na Posho' : 'Staff Salary & Allowances' }}</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ruhusa na Mamlaka' : 'Permissions' }}</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Reports -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up"></i>
                                <span>{{ $isSwahili ? 'Ripoti' : 'Reports' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/analytics') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ripoti ya Mauzo' : 'Sales Report' }}</a></li>
                            <li><a href="{{url('/manager/expenses')}}" class="nav-subitem-link">{{ $isSwahili ? 'Ripoti ya Matumizi' : 'Expense Report' }}</a></li>
                            <li><a href="{{url('/manager/inventory')}}" class="nav-subitem-link">{{ $isSwahili ? 'Ripoti ya Hesabu ya Stoo' : 'Inventory Report' }}</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Auditing -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-shield-check"></i>
                                <span>{{ $isSwahili ? 'Ukaguzi wa Mfumo' : 'Auditing' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/auditing') }}" class="nav-subitem-link">{{ $isSwahili ? 'Kumbukumbu za Shughuli' : 'Activity Logs' }}</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ukaguzi wa Stoo na Hasara' : 'Stock Audit & Wastage' }}</a></li>
                            <li><a href="{{ url('/manager/auditing?tab=alerts') }}" class="nav-subitem-link">{{ $isSwahili ? 'Mwenendo wa Ukaguzi na Tahadhari' : 'Audit Trail & Alerts' }}</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">{{ $isSwahili ? 'Mipangilio ya Ukaguzi na Wadhifa' : 'Auditing Settings & Roles' }}</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>

        <!-- Sidebar Bottom Profile Section -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center;">
                <div class="profile-avatar" id="sidebarAvatarInitial">MN</div>
                <div class="profile-info">
                    <span class="profile-name" id="sidebarProfileName">Store Manager</span>
                    <span class="profile-email" id="sidebarProfileEmail">manager@eduka.co.tz</span>
                </div>
            </div>
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); text-decoration: none; padding: 4px; display: flex; align-items: center;">
                <i class="bi bi-box-arrow-right" style="font-size: 1.05rem;"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Utility Header -->
        <header class="top-nav-bar">
            <!-- Search Box with Cmd+K -->
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search products, orders, customers..." id="global-search-input">
                <span class="search-kbd">⌘ K</span>
            </div>

            <div class="top-nav-actions">
                <!-- Branch Tag -->
                <div class="header-branch-pill d-none d-sm-inline-flex">
                    <span class="branch-indicator-dot"></span>
                    <span class="branch-name">Main Branch (HQ)</span>
                </div>

                <!-- Universal Role Switcher Component -->
                @include('partials.role_switcher')

                <!-- Theme Toggle Button -->
                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme" aria-label="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>

                <!-- User Profile Dropdown -->
                <div class="header-profile-dropdown" id="headerProfileDropdown">
                    <button type="button" class="header-profile-btn" id="headerProfileBtn" aria-expanded="false" title="User Account">
                        <div class="header-avatar">MN</div>
                        <div class="header-user-meta d-none d-md-flex">
                            <span class="header-user-name">Store Manager</span>
                            <span class="header-user-role">Administrator</span>
                        </div>
                        <i class="bi bi-chevron-down header-dropdown-arrow"></i>
                    </button>

                    <div class="profile-dropdown-menu" id="profileDropdownMenu">
                        <div class="profile-dropdown-header">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-semibold text-dark">Store Manager</span>
                                <span class="badge" style="background:#18181b; color:#fff; font-size:0.65rem;">Active</span>
                            </div>
                            <div class="text-muted" style="font-size: 0.76rem;">manager@eduka.co.tz</div>
                            <div class="text-muted mt-1" style="font-size: 0.72rem;"><i class="bi bi-geo-alt me-1"></i>Main Branch (HQ)</div>
                        </div>
                        <div class="profile-dropdown-divider"></div>
                        <div class="px-2 py-1 text-muted fw-bold" style="font-size:0.68rem;text-transform:uppercase;letter-spacing:0.5px;">Switch Role</div>
                        <a href="{{ url('/switch-role/manager') }}" class="profile-dropdown-item"><i class="bi bi-shield-check text-primary"></i> <span>Store Manager</span></a>
                        <a href="{{ url('/switch-role/cashier') }}" class="profile-dropdown-item"><i class="bi bi-receipt text-success"></i> <span>Cashier / POS</span></a>
                        <a href="{{ url('/switch-role/storekeeper') }}" class="profile-dropdown-item"><i class="bi bi-box-seam text-warning"></i> <span>Storekeeper</span></a>
                        <div class="profile-dropdown-divider"></div>
                        <a href="{{ url('/manager/permission') }}" class="profile-dropdown-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Permissions & Access</span>
                        </a>
                        <a href="{{ url('/manager/shifts') }}" class="profile-dropdown-item">
                            <i class="bi bi-clock-history"></i>
                            <span>Cashier Shift Reports</span>
                        </a>
                        <a href="{{ url('/manager/transfers') }}" class="profile-dropdown-item">
                            <i class="bi bi-buildings"></i>
                            <span>Store Branches</span>
                        </a>
                        <div class="profile-dropdown-divider"></div>
                        <a href="{{ url('/login') }}" class="profile-dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out (Logout)</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Top Bar Title -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <h1 class="dashboard-title mb-0">{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}</h1>
                @if($isWholesale)
                    <span class="badge" style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.8rem; font-weight: 700; border-radius: 9999px; padding: 5px 14px; border: 1px solid rgba(124, 58, 237, 0.25);">
                        <i class="bi bi-boxes me-1"></i> {{ $isSwahili ? 'Aina ya Jumla (Wholesale & Supplier)' : 'Wholesale & Supplier Mode' }}
                    </span>
                @else
                    <span class="badge" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-size: 0.8rem; font-weight: 700; border-radius: 9999px; padding: 5px 14px; border: 1px solid rgba(37, 99, 235, 0.25);">
                        <i class="bi bi-cart3 me-1"></i> {{ $isSwahili ? 'Aina ya Rejareja (Retail Mode)' : 'Retail Store Mode' }}
                    </span>
                @endif
            </div>
            <div>
                <form action="{{ url('/tenant/toggle-business-mode') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="border-radius: 9999px; font-size: 0.76rem; font-weight: 600;" title="{{ $isSwahili ? 'Badili muundo wa duka kuwa Rejareja au Jumla' : 'Toggle store business mode between Retail and Wholesale' }}">
                        <i class="bi bi-arrow-repeat me-1"></i> {{ $isSwahili ? 'Badili:' : 'Switch:' }} {{ $isWholesale ? ($isSwahili ? 'Kuwa Rejareja (Retail)' : 'To Retail Store') : ($isSwahili ? 'Kuwa Jumla (Supplier)' : 'To Wholesale / Supplier') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Tab Controls -->
        <div class="dashboard-tabs">
            <a href="{{ url('/manager/dashboard') }}" class="tab-btn active">{{ $isSwahili ? 'Muhtasari' : 'Overview' }}</a>
            <a href="{{ url('/manager/analytics') }}" class="tab-btn">{{ $isSwahili ? 'Uchambuzi' : 'Analytics' }}</a>
            <button class="tab-btn">{{ $isSwahili ? 'Ripoti' : 'Reports' }}</button>
            <button class="tab-btn">{{ $isSwahili ? 'Taarifa' : 'Notifications' }}</button>
        </div>

        <!-- Stat Cards Row -->
        <div class="row g-4 mb-4">
            @if($isWholesale)
                <!-- 1. Total Wholesale Sales Card -->
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Jumla ya Mauzo ya Jumla' : 'Total Wholesale Sales' }}</span>
                            <i class="bi bi-receipt-cutoff stat-icon" style="color: #7c3aed;"></i>
                        </div>
                        <div>
                            <div class="stat-value" style="color: #7c3aed;">TSh 128,450,000</div>
                            <div class="stat-subtext"><span class="text-success"><i class="bi bi-arrow-up-right"></i> +24.4%</span> {{ $isSwahili ? 'kutoka mwezi uliopita • Ankara Zinazoendelea:' : 'from last month • Active Invoices:' }} <strong>{{ $isSwahili ? 'Oda 38 za Jumla' : '38 Bulk Orders' }}</strong></div>
                        </div>
                    </div>
                </div>

                <!-- 2. Warehouse Bulk Stock Card -->
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Bakaa ya Stoo ya Jumla' : 'Bulk Warehouse Stock' }}</span>
                            <i class="bi bi-boxes stat-icon text-primary"></i>
                        </div>
                        <div>
                            <div class="stat-value text-primary">2,840 {{ $isSwahili ? 'Maboksi / Magunia' : 'Cartons / Bales' }}</div>
                            <div class="stat-subtext">{{ $isSwahili ? 'Vifurushi vya Jumla • Thamani ya Stoo:' : 'Wholesale Packaging • Stock Value:' }} <strong>TSh 348.5M</strong></div>
                        </div>
                    </div>
                </div>

                <!-- 3. Trade Receivables / Retailer Debt Card -->
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Madeni ya Wateja wa Jumla' : 'Retailer Trade Receivables' }}</span>
                            <i class="bi bi-cash-coin stat-icon text-warning"></i>
                        </div>
                        <div>
                            <div class="stat-value text-warning">TSh 14,200,000</div>
                            <div class="stat-subtext"><span class="text-warning"><i class="bi bi-clock-history"></i> {{ $isSwahili ? 'Maduka 9 ya Rejareja Yanasubiri' : '9 Retail Stores Pending' }}</span> • {{ $isSwahili ? 'Yanaiva wiki hii:' : 'Due this week:' }} <strong class="text-danger">TSh 4.8M</strong></div>
                        </div>
                    </div>
                </div>
            @else
                <!-- 1. Total Sales Card -->
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Jumla ya Mauzo ya Rejareja' : 'Total Retail Sales' }}</span>
                            <i class="bi bi-currency-dollar stat-icon text-success"></i>
                        </div>
                        <div>
                            <div class="stat-value text-success">TSh 48,250,000</div>
                            <div class="stat-subtext"><span class="text-success"><i class="bi bi-arrow-up-right"></i> +18.4%</span> {{ $isSwahili ? 'kutoka mwezi uliopita • Leo:' : 'from last month • Today:' }} <strong>TSh 2.4M</strong></div>
                        </div>
                    </div>
                </div>

                <!-- 2. Available Stock Card -->
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Bidhaa Zilizopo Rafuni' : 'Available Shelf Stock' }}</span>
                            <i class="bi bi-boxes stat-icon text-primary"></i>
                        </div>
                        <div>
                            <div class="stat-value text-primary">18,450 {{ $isSwahili ? 'Vipande' : 'Units' }}</div>
                            <div class="stat-subtext">{{ $isSwahili ? 'Makundi Yote 12 • Thamani:' : 'All 12 Categories • Value:' }} <strong>TSh 142.8M</strong></div>
                        </div>
                    </div>
                </div>

                <!-- 3. Stock Alerts & Risk Card -->
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">{{ $isSwahili ? 'Tahadhari ya Bidhaa Zinazoisha' : 'Stock Alerts & Risk' }}</span>
                            <i class="bi bi-exclamation-triangle stat-icon text-warning"></i>
                        </div>
                        <div>
                            <div class="stat-value text-warning">14 {{ $isSwahili ? 'Zimepungua' : 'Items Low' }}</div>
                            <div class="stat-subtext"><span class="text-warning"><i class="bi bi-exclamation-circle"></i> {{ $isSwahili ? 'Agizo Linahitajika' : 'Reorder Needed' }}</span> • {{ $isSwahili ? 'Zinazoisha muda:' : 'Near Expiry:' }} <strong class="text-danger">3 {{ $isSwahili ? 'Bidhaa' : 'Items' }}</strong></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Overview Chart & Recent Sales Row -->
        <div class="row g-4">
            <!-- Overview Chart (8 Cols) -->
            <div class="col-12 col-xl-8">
                <div class="content-card">
                    <div class="card-header-clean">
                        <h3>{{ $isWholesale ? ($isSwahili ? 'Mapato ya Jumla na Oda' : 'Wholesale Revenue & Orders') : ($isSwahili ? 'Muhtasari wa Mauzo' : 'Overview') }}</h3>
                        <p>{{ $isWholesale ? ($isSwahili ? 'Mwenendo wa mauzo ya jumla na usambazaji kwa mwezi.' : 'Monthly wholesale distribution and bulk sales turnover.') : ($isSwahili ? 'Mwenendo wa mauzo na mapato ya duka kwa mwezi.' : 'Monthly store revenue and sales performance overview.') }}</p>
                    </div>
                    <div style="height: 350px; width: 100%; position: relative;">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Sales Card (4 Cols) -->
            <div class="col-12 col-xl-4">
                <div class="content-card">
                    <div class="card-header-clean">
                        <h3>{{ $isWholesale ? ($isSwahili ? 'Oda za Hivi Karibuni za Jumla' : 'Recent Wholesale Orders') : ($isSwahili ? 'Mauzo ya Hivi Karibuni' : 'Recent Sales') }}</h3>
                        <p>{{ $isWholesale ? ($isSwahili ? 'Ankara na mizigo iliyotoka hivi karibuni.' : 'Latest retailer store dispatches & invoices.') : ($isSwahili ? 'Miamala ya wateja na kiasi cha malipo.' : 'Latest customer transactions and payment amounts.') }}</p>
                    </div>
                    <div class="sales-list-wrap">
                        @if($isWholesale)
                            <!-- Wholesale Order 1 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">KM</div>
                                    <div>
                                        <div class="sale-name">Kariakoo Mini-Supermarket Ltd</div>
                                        <div class="sale-email">TIN: 102-498-112 • 20 Cartons Azam</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace" style="color: #7c3aed;">+TSh 4,850,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="w1" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Wholesale Order 2 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">MA</div>
                                    <div>
                                        <div class="sale-name">Mama Asha Store - Mwenge</div>
                                        <div class="sale-email">TIN: 104-882-901 • 35 Bags Rice 25kg</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace" style="color: #7c3aed;">+TSh 7,420,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="w2" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Wholesale Order 3 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">MC</div>
                                    <div>
                                        <div class="sale-name">Mbezi Central Grocery & Retail</div>
                                        <div class="sale-email">TIN: 109-122-340 • 15 Cartons Mo Oil</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace" style="color: #7c3aed;">+TSh 2,150,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="w3" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Wholesale Order 4 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">SC</div>
                                    <div>
                                        <div class="sale-name">Sinza Corner Retailers Duka</div>
                                        <div class="sale-email">TIN: 103-771-455 • 18 Boxes Soap</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace" style="color: #7c3aed;">+TSh 3,890,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="w4" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Wholesale Order 5 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">AW</div>
                                    <div>
                                        <div class="sale-name">Arusha Wholesale Agents Co.</div>
                                        <div class="sale-email">TIN: 111-900-221 • Bulk Foodstuffs</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace" style="color: #7c3aed;">+TSh 14,200,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="w5" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- Sale Item 1 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar">OM</div>
                                    <div>
                                        <div class="sale-name">Olivia Martin</div>
                                        <div class="sale-email">olivia.martin@email.com</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace text-success">+TSh 1,999,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="r1" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Sale Item 2 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar">JL</div>
                                    <div>
                                        <div class="sale-name">Jackson Lee</div>
                                        <div class="sale-email">jackson.lee@email.com</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace text-success">+TSh 39,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="r2" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Sale Item 3 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar">IN</div>
                                    <div>
                                        <div class="sale-name">Isabella Nguyen</div>
                                        <div class="sale-email">isabella.nguyen@email.com</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace text-success">+TSh 299,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="r3" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Sale Item 4 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar">WK</div>
                                    <div>
                                        <div class="sale-name">William Kim</div>
                                        <div class="sale-email">will@email.com</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace text-success">+TSh 99,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="r4" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Sale Item 5 -->
                            <div class="sale-item">
                                <div class="sale-user">
                                    <div class="sale-avatar">SD</div>
                                    <div>
                                        <div class="sale-name">Sofia Davis</div>
                                        <div class="sale-email">sofia.davis@email.com</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="sale-amount font-monospace text-success">+TSh 39,000</div>
                                    <button type="button" class="btn-receipt-action view-dashboard-receipt-btn" data-sale-idx="r5" title="Tazama & Chapisha Resiti">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Chart Configuration
            const chartCanvas = document.getElementById('overviewChart');
            if (chartCanvas) {
                const ctx = chartCanvas.getContext('2d');
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const values = [1600000, 3400000, 2900000, 4100000, 4600000, 5200000, 1650000, 1500000, 5600000, 5300000, 3500000, 4700000];

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            data: values,
                            backgroundColor: '#10b981',
                            hoverBackgroundColor: '#059669',
                            borderRadius: 6,
                            borderSkipped: false,
                            barPercentage: 0.65,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#09090b',
                                padding: 10,
                                titleFont: { size: 12 },
                                bodyFont: { size: 12 },
                                callbacks: {
                                    label: function(context) {
                                        return ' TSh ' + context.raw.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: { color: '#71717a', font: { size: 12 } }
                            },
                            y: {
                                border: { display: false },
                                grid: { color: '#f4f4f5' },
                                ticks: {
                                    color: '#71717a',
                                    font: { size: 12 },
                                    stepSize: 1500000,
                                    callback: function(val) {
                                        return (val / 1000000) + 'M';
                                    }
                                },
                                min: 0,
                                max: 6000000
                            }
                        }
                    }
                });
            }

            // Tab click interactive switcher
            $('.tab-btn').on('click', function() {
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');
            });

            // Cmd+K or Ctrl+K shortcut to focus search bar
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#global-search-input').focus();
                }
            });

            // Theme toggle button interaction
            let isLight = true;
            $('#theme-toggle-btn').on('click', function() {
                isLight = !isLight;
                $('body').toggleClass('dark-mode');
                const icon = $('#theme-icon');
                if (isLight) {
                    icon.removeClass('bi-moon-stars').addClass('bi-sun');
                } else {
                    icon.removeClass('bi-sun').addClass('bi-moon-stars');
                }
            });

            // Interactive Dropdowns for all nav items with chevron-right
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                const btn = $(this);
                const subMenu = btn.next('.nav-submenu');
                subMenu.stop(true, true).slideToggle(200);
                btn.toggleClass('open');
                const isOpen = btn.hasClass('open');
                btn.attr('aria-expanded', isOpen);
            });

            // User Profile Dropdown Toggle
            $('#headerProfileBtn').on('click', function(e) {
                e.stopPropagation();
                $('#headerProfileDropdown').toggleClass('show');
                $('#profileDropdownMenu').toggleClass('show');
                const isExpanded = $('#headerProfileDropdown').hasClass('show');
                $(this).attr('aria-expanded', isExpanded);
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#headerProfileDropdown').length) {
                    $('#headerProfileDropdown').removeClass('show');
                    $('#profileDropdownMenu').removeClass('show');
                    $('#headerProfileBtn').attr('aria-expanded', 'false');
                }
            });

            // Recent Sales Receipt Data & Handler
            const recentSalesData = {
                r1: {
                    receiptNumber: '#EDK-20498',
                    dateTime: '27/09/2026 09:56 PM',
                    cashier: 'Asha Mwamba',
                    terminal: 'POS-01',
                    customer: 'Olivia Martin',
                    items: [
                        { name: 'Smartphone Samsung A15', qty: 1, price: 450000, total: 450000 },
                        { name: 'Smart TV 43" 4K UHD', qty: 1, price: 1200000, total: 1200000 },
                        { name: 'Soundbar Bluetooth 120W', qty: 1, price: 349000, total: 349000 }
                    ],
                    subtotal: 1694068,
                    tax: 304932,
                    fee: 0,
                    total: 1999000,
                    paymentMode: 'Card (Visa)',
                    tendered: 1999000,
                    change: 0,
                    fiscalCode: '9A48-E71B-33C9-92F1',
                    hideNewSale: true
                },
                r2: {
                    receiptNumber: '#EDK-20497',
                    dateTime: '27/09/2026 09:30 PM',
                    cashier: 'Baraka Msuya',
                    terminal: 'POS-02',
                    customer: 'Jackson Lee',
                    items: [
                        { name: 'Coca-Cola 500ml', qty: 4, price: 1500, total: 6000 },
                        { name: 'Milk Packet 1L', qty: 5, price: 3200, total: 16000 },
                        { name: 'Sugar 1kg (Kilombero)', qty: 5, price: 3400, total: 17000 }
                    ],
                    subtotal: 33051,
                    tax: 5949,
                    fee: 0,
                    total: 39000,
                    paymentMode: 'Cash',
                    tendered: 40000,
                    change: 1000,
                    fiscalCode: '7F31-98B2-A410-6C23',
                    hideNewSale: true
                },
                r3: {
                    receiptNumber: '#EDK-20496',
                    dateTime: '27/09/2026 08:45 PM',
                    cashier: 'Asha Mwamba',
                    terminal: 'POS-01',
                    customer: 'Isabella Nguyen',
                    items: [
                        { name: 'Super Basmati Rice 25kg', qty: 2, price: 120000, total: 240000 },
                        { name: 'Sunflower Oil 5L Pure', qty: 1, price: 59000, total: 59000 }
                    ],
                    subtotal: 253390,
                    tax: 45610,
                    fee: 0,
                    total: 299000,
                    paymentMode: 'M-Pesa',
                    tendered: 299000,
                    change: 0,
                    fiscalCode: '6B19-89EF-45D2-811C',
                    hideNewSale: true
                },
                r4: {
                    receiptNumber: '#EDK-20495',
                    dateTime: '27/09/2026 08:12 PM',
                    cashier: 'Baraka Msuya',
                    terminal: 'POS-02',
                    customer: 'William Kim',
                    items: [
                        { name: 'Powder Detergent 5kg', qty: 2, price: 24000, total: 48000 },
                        { name: 'Cooking Oil 3L', qty: 1, price: 36000, total: 36000 },
                        { name: 'Table Salt 1kg', qty: 3, price: 5000, total: 15000 }
                    ],
                    subtotal: 83898,
                    tax: 15102,
                    fee: 0,
                    total: 99000,
                    paymentMode: 'Airtel Money',
                    tendered: 100000,
                    change: 1000,
                    fiscalCode: '4D22-C891-3E55-90A7',
                    hideNewSale: true
                },
                r5: {
                    receiptNumber: '#EDK-20494',
                    dateTime: '27/09/2026 07:50 PM',
                    cashier: 'Asha Mwamba',
                    terminal: 'POS-01',
                    customer: 'Sofia Davis',
                    items: [
                        { name: 'Baby Diapers Jumbo Pack', qty: 1, price: 25000, total: 25000 },
                        { name: 'Gentle Baby Wipes 80s', qty: 2, price: 7000, total: 14000 }
                    ],
                    subtotal: 33051,
                    tax: 5949,
                    fee: 0,
                    total: 39000,
                    paymentMode: 'Cash',
                    tendered: 50000,
                    change: 11000,
                    fiscalCode: '3C11-B780-2D44-89E6',
                    hideNewSale: true
                },
                w1: {
                    receiptNumber: '#EDK-W20490',
                    dateTime: '27/09/2026 07:15 PM',
                    cashier: 'Hassan Juma',
                    terminal: 'WHOLESALE-01',
                    customer: 'Kariakoo Mini-Supermarket Ltd (TIN: 102-498-112)',
                    items: [
                        { name: 'Azam Wheat Flour 25kg', qty: 50, price: 42000, total: 2100000 },
                        { name: 'Sugar Bags 50kg White', qty: 20, price: 137500, total: 2750000 }
                    ],
                    subtotal: 4110169,
                    tax: 739831,
                    fee: 0,
                    total: 4850000,
                    paymentMode: 'Bank Transfer',
                    tendered: 4850000,
                    change: 0,
                    fiscalCode: '8E44-90B1-12C4-77A9',
                    hideNewSale: true
                },
                w2: {
                    receiptNumber: '#EDK-W20489',
                    dateTime: '27/09/2026 06:40 PM',
                    cashier: 'Hassan Juma',
                    terminal: 'WHOLESALE-01',
                    customer: 'Mama Asha Store - Mwenge (TIN: 104-882-901)',
                    items: [
                        { name: 'Super Rice Kyela 25kg', qty: 70, price: 75000, total: 5250000 },
                        { name: 'Cooking Oil 20L Jerrycans', qty: 15, price: 144667, total: 2170000 }
                    ],
                    subtotal: 6288136,
                    tax: 1131864,
                    fee: 0,
                    total: 7420000,
                    paymentMode: 'Bank Transfer',
                    tendered: 7420000,
                    change: 0,
                    fiscalCode: '7A33-89C0-01D3-66E8',
                    hideNewSale: true
                },
                w3: {
                    receiptNumber: '#EDK-W20488',
                    dateTime: '27/09/2026 05:20 PM',
                    cashier: 'Hassan Juma',
                    terminal: 'WHOLESALE-01',
                    customer: 'Mbezi Central Grocery (TIN: 109-122-340)',
                    items: [
                        { name: 'Mo Oil 5L x30 Cartons', qty: 30, price: 60000, total: 1800000 },
                        { name: 'Table Salt Boxes (50ct)', qty: 10, price: 35000, total: 350000 }
                    ],
                    subtotal: 1822034,
                    tax: 327966,
                    fee: 0,
                    total: 2150000,
                    paymentMode: 'Cheque',
                    tendered: 2150000,
                    change: 0,
                    fiscalCode: '6F22-78A9-90C2-55D7',
                    hideNewSale: true
                },
                w4: {
                    receiptNumber: '#EDK-W20487',
                    dateTime: '27/09/2026 04:10 PM',
                    cashier: 'Hassan Juma',
                    terminal: 'WHOLESALE-01',
                    customer: 'Sinza Corner Retailers (TIN: 103-771-455)',
                    items: [
                        { name: 'Laundry Bar Soap 50ct', qty: 25, price: 90000, total: 2250000 },
                        { name: 'Toothpaste 144ct', qty: 5, price: 328000, total: 1640000 }
                    ],
                    subtotal: 3296610,
                    tax: 593390,
                    fee: 0,
                    total: 3890000,
                    paymentMode: 'Cash',
                    tendered: 3890000,
                    change: 0,
                    fiscalCode: '5E11-67B8-89B1-44C6',
                    hideNewSale: true
                },
                w5: {
                    receiptNumber: '#EDK-W20486',
                    dateTime: '27/09/2026 02:45 PM',
                    cashier: 'Hassan Juma',
                    terminal: 'WHOLESALE-01',
                    customer: 'Arusha Wholesale Agents Co. (TIN: 111-900-221)',
                    items: [
                        { name: 'Bulk Foodstuffs & Grains', qty: 1, price: 14200000, total: 14200000 }
                    ],
                    subtotal: 12033898,
                    tax: 2166102,
                    fee: 0,
                    total: 14200000,
                    paymentMode: 'Bank Transfer',
                    tendered: 14200000,
                    change: 0,
                    fiscalCode: '4D00-56A7-78A0-33B5',
                    hideNewSale: true
                }
            };

            $('.view-dashboard-receipt-btn').on('click', function(e) {
                e.stopPropagation();
                const saleIdx = $(this).data('sale-idx');
                const saleData = recentSalesData[saleIdx];
                if (saleData && typeof window.openEfdReceipt === 'function') {
                    window.openEfdReceipt(saleData);
                }
            });
        });
    </script>

    @include('partials.receipt_modal')
</body>
</html>
