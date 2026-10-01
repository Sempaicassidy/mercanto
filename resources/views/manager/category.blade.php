@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
    $tenantName = $tenant ? $tenant->name : session('tenant_name', 'Mangi Supermarket Ltd');
    $tenantType = $tenant ? $tenant->business_type : session('tenant_type', 'retailer');
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isSwahili ? 'Vitengo vya Bidhaa (Categories)' : 'Product Categories' }} - mercanto</title>

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

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.74rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .status-badge:hover {
            opacity: 0.85;
            transform: scale(1.02);
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
            transition: background-color 0.2s ease, color 0.2s ease;
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

        .nav-chevron {
            font-size: 0.65rem;
            transition: transform 0.2s ease;
        }

        .nav-dropdown-toggle.open .nav-chevron {
            transform: rotate(90deg);
        }

        .nav-submenu {
            list-style: none;
            padding-left: 28px;
            margin-top: 2px;
            display: none;
            flex-direction: column;
            gap: 2px;
        }

        .nav-submenu.open {
            display: flex;
        }

        .nav-subitem-link {
            display: block;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.15s ease;
        }

        .nav-subitem-link:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        .nav-subitem-link.active {
            color: var(--text-dark);
            font-weight: 600;
            background-color: var(--nav-active-bg);
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
                padding: 1rem 1rem;
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
        }

        .header-search-box {
            position: relative;
            width: 340px;
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
            padding: 0.45rem 2.2rem 0.45rem 2.2rem;
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
            gap: 12px;
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

        /* Business Chain Hero Card */
        .chain-hero-card {
            background: linear-gradient(135deg, rgba(37,99,235,0.06) 0%, rgba(139,92,246,0.06) 100%);
            border: 1px solid rgba(37,99,235,0.18);
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        body.dark-mode .chain-hero-card {
            background: linear-gradient(135deg, rgba(37,99,235,0.12) 0%, rgba(139,92,246,0.12) 100%);
            border-color: rgba(37,99,235,0.3);
        }

        .chain-hero-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .chain-hero-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #2563eb;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }

        .chain-hero-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .chain-hero-sub {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .chain-hero-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
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
            min-height: 125px;
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
            margin-bottom: 0.6rem;
        }

        .stat-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-icon {
            font-size: 1.15rem;
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
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Content Card */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
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

        .cat-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--text-dark);
        }

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

        .action-icon-btn.btn-delete:hover {
            color: #dc2626;
            background-color: var(--badge-danger-bg);
            border-color: #fca5a5;
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
            z-index: 1050;
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

        .modal-box.modal-lg {
            max-width: 820px;
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

        /* Preset Chain Cards in Modal */
        .chain-preset-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.15s ease;
            background-color: var(--card-bg);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .chain-preset-card:hover {
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.1);
        }

        .chain-preset-card.selected {
            border-color: #2563eb;
            background-color: rgba(37,99,235,0.04);
            box-shadow: 0 0 0 2px #2563eb;
        }

        /* Toast Notifications */
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

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Workspace Header -->
            <div class="workspace-header" title="Mercanto Store System">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>{{ $tenantName }}</h4>
                        <span>{{ strtoupper($tenantType) }} • {{ $isSwahili ? 'Msimamizi' : 'Manager Panel' }}</span>
                    </div>
                </div>
                <i class="bi bi-chevron-expand text-muted" style="font-size: 0.9rem;"></i>
            </div>

            <!-- Dynamic Nav Items -->
            <div id="sidebar-nav-container">
                <div class="nav-section-title">{{ $isSwahili ? 'Menyu Kuu' : 'General' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/manager/dashboard') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-speedometer2"></i>
                                <span>{{ $isSwahili ? 'Dashibodi' : 'Dashboard' }}</span>
                            </span>
                        </a>
                    </li>

                    <!-- Dropdown: Manage Store (Active) -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left">
                                <i class="bi bi-box-seam"></i>
                                <span>{{ $isSwahili ? 'Simamia Duka' : 'Manage Store' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu open">
                            <li><a href="{{ url('/manager/stock') }}" class="nav-subitem-link">{{ $isSwahili ? 'Bidhaa & Stoo' : 'Products & Stock' }}</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">{{ $isSwahili ? 'Kaunta ya Mauzo (POS)' : 'POS / Cashier' }}</a></li>
                            <li><a href="{{ url('/manager/category') }}" class="nav-subitem-link active">{{ $isSwahili ? 'Vitengo vya Bidhaa' : 'Categories' }}</a></li>
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link">{{ $isSwahili ? 'Wauzaji / Suppliers' : 'Suppliers' }}</a></li>
                            <li><a href="{{ url('/manager/customers') }}" class="nav-subitem-link">{{ $isSwahili ? 'Wateja & Mikopo' : 'Customers & Credit' }}</a></li>
                            <li><a href="{{ url('/manager/purchases') }}" class="nav-subitem-link">{{ $isSwahili ? 'Oda za Manunuzi (LPO)' : 'Purchase Orders' }}</a></li>
                            <li><a href="{{ url('/manager/transfers') }}" class="nav-subitem-link">{{ $isSwahili ? 'Uhamisho wa Stoo' : 'Branch Transfers' }}</a></li>
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
                            <li><a href="{{ url('/manager/shifts') }}" class="nav-subitem-link">{{ $isSwahili ? 'Shifiti & Sanduku la Pesa' : 'Shifts & Register' }}</a></li>
                            <li><a href="{{ url('/manager/returns') }}" class="nav-subitem-link">{{ $isSwahili ? 'Bidhaa Zilizorudishwa' : 'Returns & Refunds' }}</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">{{ $isSwahili ? 'Uharibifu & Upotevu' : 'Damages & Wastage' }}</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Reports -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up"></i>
                                <span>{{ $isSwahili ? 'Ripoti za Duka' : 'Reports' }}</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/analytics') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ripoti ya Mauzo' : 'Sales Report' }}</a></li>
                            <li><a href="{{ url('/manager/expenses') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ripoti ya Matumizi' : 'Expense Report' }}</a></li>
                            <li><a href="{{ url('/manager/inventory') }}" class="nav-subitem-link">{{ $isSwahili ? 'Ripoti ya Mali (Stoo)' : 'Inventory Report' }}</a></li>
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
                    <span class="profile-name" id="sidebarProfileName">{{ session('user_name', 'Store Manager') }}</span>
                    <span class="profile-email" id="sidebarProfileEmail">{{ session('user_email', 'manager@eduka.co.tz') }}</span>
                </div>
            </div>
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); text-decoration: none; padding: 4px; display: flex; align-items: center;">
                <i class="bi bi-box-arrow-right" style="font-size: 1.05rem;"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Nav Bar -->
        <header class="top-nav-bar">
            <!-- Search Box with Cmd+K -->
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="{{ $isSwahili ? 'Tafuta vitengo kwa jina au kodi...' : 'Search categories...' }}" id="global-search-input">
                <span class="search-kbd">⌘ K</span>
            </div>

            <div class="top-nav-actions">
                <!-- Branch Tag -->
                <div class="header-branch-pill d-none d-sm-inline-flex">
                    <span class="branch-indicator-dot"></span>
                    <span class="branch-name">{{ session('branch_name', 'Main Branch (HQ)') }}</span>
                </div>

                <!-- Universal Role Switcher Component -->
                @include('partials.role_switcher')

                <!-- Theme Toggle Button -->
                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme" aria-label="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>
            </div>
        </header>

        <!-- Business Product Chain Banner -->
        <div class="chain-hero-card">
            <div class="chain-hero-left">
                <div class="chain-hero-icon">
                    <i class="bi {{ $currentChainKey && isset($availableChains[$currentChainKey]) ? $availableChains[$currentChainKey]['icon'] : 'bi-diagram-3-fill' }}"></i>
                </div>
                <div>
                    <div class="chain-hero-title">
                        {{ $isSwahili ? 'Msururu wa Biashara wa Duka Lako' : 'Store Product Chain Configuration' }}:
                        <span class="badge bg-primary text-white ms-1" style="font-size: 0.76rem; font-weight: 600;">
                            {{ $currentChainKey && isset($availableChains[$currentChainKey]) ? $availableChains[$currentChainKey]['name'] : ($isSwahili ? 'Violezo Maalum (Custom)' : 'Custom Chain') }}
                        </span>
                    </div>
                    <div class="chain-hero-sub">
                        {{ $isSwahili ? 'Unda na panga vitengo vya bidhaa vinavyoendana na biashara yako (k.m. Nafaka, Vifaa vya Ujenzi, Dawa, Mitindo, n.k.) badala ya kutumia vile vya default tu.' : 'Organize and tailor product categories to match your exact retail line (e.g. Grains, Hardware, Pharmacy, Fashion, Electronics) instead of generic defaults.' }}
                    </div>
                </div>
            </div>
            <div class="chain-hero-actions">
                <button type="button" class="btn-outline-custom" id="btnOpenChainPresetsModal">
                    <i class="bi bi-magic text-primary"></i>
                    <span>{{ $isSwahili ? 'Badili Msururu (Preset Chains)' : 'Change Business Chain' }}</span>
                </button>
                <button type="button" class="btn-dark-custom" id="addCategoryBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>{{ $isSwahili ? 'Ongeza Kitengo Kipya' : 'Add Custom Category' }}</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Jumla ya Vitengo' : 'Total Categories' }}</span>
                        <i class="bi bi-tags stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary" id="kpiTotalCategories">{{ $totalCategories }} {{ $isSwahili ? 'Vitengo' : 'Categories' }}</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Vya duka hili (Active)' : 'Active store departments' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Bidhaa Zilizopo' : 'Classified Products' }}</span>
                        <i class="bi bi-box-seam stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">{{ $totalProducts }} SKUs</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Zimepangwa kwa vitengo' : 'Categorized catalog items' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Kitengo Kikubwa' : 'Dominant Category' }}</span>
                        <i class="bi bi-trophy stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning text-truncate" style="max-width: 100%; font-size: 1.25rem;" title="{{ $topCategoryName }}">{{ $topCategoryName }}</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Kina bidhaa nyingi zaidi' : 'Highest SKU count' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Wastani wa Faida (Margin)' : 'Average Margin Target' }}</span>
                        <i class="bi bi-graph-up stat-icon text-info"></i>
                    </div>
                    <div>
                        <div class="stat-value text-info">{{ $averageMargin }}%</div>
                        <div class="stat-subtext">{{ $isSwahili ? 'Lengo la faida kwa bidhaa' : 'Target departmental markup' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table Card -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--text-dark);">
                        {{ $isSwahili ? 'Vitengo vya Bidhaa vya Duka Lako' : 'Store Departments & Categories' }}
                    </h3>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin: 0;">
                        {{ $isSwahili ? 'Vitengo hivi vitatumika wakati wa kuingiza bidhaa mpya stoo na kwenye mashine ya mauzo (POS).' : 'These categories apply across stock inventory and POS cashier counter desk.' }}
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size: 0.8rem; color: var(--text-muted);" id="tableCountBadge">
                        {{ $categories->count() }} {{ $isSwahili ? 'vitengo vinavyopatikana' : 'categories found' }}
                    </span>
                </div>
            </div>

            @if($categories->isEmpty())
                <div class="text-center py-5 border rounded-3 bg-light" id="emptyCategoriesWrap">
                    <i class="bi bi-diagram-3 fs-1 text-muted d-block mb-2"></i>
                    <h4 class="fw-bold text-dark mb-1">{{ $isSwahili ? 'Bado hujaweka vitengo vya bidhaa!' : 'No product categories configured yet!' }}</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 480px; font-size: 0.88rem;">
                        {{ $isSwahili ? 'Unaweza kuanza kwa kuchagua msururu wa biashara yako (k.m. Nafaka, Vifaa vya Ujenzi, Dawa, Mitindo, au Elektroniki) au kutengeneza vitengo vyako mwenyewe kimoja baada ya kingine.' : 'You can quickly initialize your store product chain (e.g. Grain Store, Hardware, Pharmacy, Fashion, or Electronics) or build your custom categories manually.' }}
                    </p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-primary" id="btnEmptyChainPresets">
                            <i class="bi bi-magic me-1"></i> {{ $isSwahili ? 'Chagua Msururu wa Biashara (1-Click Setup)' : 'Choose Business Chain Presets' }}
                        </button>
                        <button type="button" class="btn btn-dark" id="btnEmptyAddCustom">
                            <i class="bi bi-plus-lg me-1"></i> {{ $isSwahili ? 'Unda Kitengo cha Kwanza' : 'Create Custom Category' }}
                        </button>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="custom-table" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>{{ $isSwahili ? 'Jina la Kitengo' : 'Category Name' }}</th>
                                <th>{{ $isSwahili ? 'Msururu wa Biashara' : 'Product Chain' }}</th>
                                <th>{{ $isSwahili ? 'Maelezo' : 'Description' }}</th>
                                <th>{{ $isSwahili ? 'Idadi ya Bidhaa' : 'Products' }}</th>
                                <th>{{ $isSwahili ? 'Thamani ya Stoo' : 'Est. Stock Value' }}</th>
                                <th>{{ $isSwahili ? 'Lengo la Faida' : 'Target Margin' }}</th>
                                <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                                <th style="text-align: right;">{{ $isSwahili ? 'Vitendo' : 'Action' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr id="catRow-{{ $category->id }}" data-search="{{ strtolower($category->name . ' ' . $category->code . ' ' . $category->business_chain . ' ' . $category->description) }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="cat-icon-box">
                                                <i class="bi {{ $category->icon ?: 'bi-tags' }}"></i>
                                            </div>
                                            <div>
                                                <div style="font-weight: 600;" class="cat-name-display">{{ $category->name }}</div>
                                                <span style="font-size: 0.74rem; color: var(--text-muted);" class="cat-code-display">Code: {{ $category->code }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $chainInfo = $category->business_chain && isset($availableChains[$category->business_chain]) 
                                                ? $availableChains[$category->business_chain] 
                                                : null;
                                        @endphp
                                        @if($chainInfo)
                                            <span class="badge" style="background-color: rgba(37,99,235,0.08); color: #2563eb; font-weight: 600; font-size: 0.72rem;">
                                                <i class="bi {{ $chainInfo['icon'] }} me-1"></i>{{ explode('(', $chainInfo['name'])[0] }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.72rem;">
                                                {{ ucfirst($category->business_chain ?: ($isSwahili ? 'Maalum' : 'Custom')) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="max-width: 260px;" class="cat-desc-display text-muted">
                                        {{ $category->description ?: ($isSwahili ? 'Bila maelezo' : 'No description') }}
                                    </td>
                                    <td>
                                        <strong>{{ $category->products_count }} {{ $isSwahili ? 'Bidhaa' : 'Products' }}</strong>
                                    </td>
                                    <td class="font-monospace text-success font-semibold">
                                        TSh {{ number_format($category->estimated_stock_value) }}
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: var(--badge-primary-bg); color: var(--badge-primary-text);">
                                            {{ $category->target_margin ?: 20 }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }} btn-toggle-status" data-id="{{ $category->id }}" title="{{ $isSwahili ? 'Bofya kubadili hali' : 'Click to toggle status' }}">
                                            <i class="bi {{ $category->is_active ? 'bi-check-circle-fill' : 'bi-dash-circle-fill' }}"></i>
                                            <span>{{ $category->is_active ? ($isSwahili ? 'Inafanya Kazi' : 'Active') : ($isSwahili ? 'Imezimwa' : 'Inactive') }}</span>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div class="d-inline-flex gap-1">
                                            <button type="button" class="action-icon-btn btn-edit-category" 
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}"
                                                data-code="{{ $category->code }}"
                                                data-chain="{{ $category->business_chain }}"
                                                data-margin="{{ $category->target_margin }}"
                                                data-icon="{{ $category->icon }}"
                                                data-desc="{{ $category->description }}"
                                                data-active="{{ $category->is_active ? '1' : '0' }}"
                                                title="{{ $isSwahili ? 'Hariri Kitengo' : 'Edit Category' }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="action-icon-btn btn-delete btn-delete-category" 
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}"
                                                title="{{ $isSwahili ? 'Futa Kitengo' : 'Delete Category' }}">
                                                <i class="bi bi-trash"></i>
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

    <!-- Modal 1: Add Custom Category -->
    <div class="modal-overlay" id="addCategoryModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>{{ $isSwahili ? 'Ongeza Kitengo Kipya cha Bidhaa' : 'Add Product Category' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="addCategoryModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="addCategoryForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Jina la Kitengo (Category Title)' : 'Category Title' }} *</label>
                        <input type="text" id="newCatTitle" class="form-control-custom" placeholder="{{ $isSwahili ? 'k.m. Saruji na Mchanga, au Dawa za Maumivu' : 'e.g. Cement & Aggregates, or Pain Relief' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Msururu wa Biashara (Product Chain)' : 'Business Product Chain' }}</label>
                        <select id="newCatChain" class="form-control-custom">
                            <option value="custom">{{ $isSwahili ? 'Msururu Maalum (Custom Retail Chain)' : 'Custom Retail Chain' }}</option>
                            @foreach($availableChains as $cKey => $cVal)
                                <option value="{{ $cKey }}">{{ $cVal['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Kodi ya Kitengo (Code)' : 'Category Code' }}</label>
                            <input type="text" id="newCatCode" class="form-control-custom" placeholder="e.g. CAT-BLD">
                            <span class="text-muted" style="font-size: 0.7rem;">{{ $isSwahili ? 'Ukiacha wazi itatengenezwa moja kwa moja.' : 'Auto-generated if left empty.' }}</span>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Lengo la Faida (%)' : 'Target Margin (%)' }} *</label>
                            <input type="number" id="newCatMargin" class="form-control-custom" value="25" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Aikoni (Bootstrap Icon Class)' : 'Icon Class' }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light" id="newCatIconPreview"><i class="bi bi-tags"></i></span>
                            <input type="text" id="newCatIcon" class="form-control-custom" value="bi-tags" placeholder="bi-box, bi-hammer, bi-capsule">
                        </div>
                        <div class="d-flex gap-2 mt-1">
                            <span class="badge bg-light text-dark border p-1 icon-pick" style="cursor:pointer;" data-icon="bi-box2-heart"><i class="bi bi-box2-heart"></i> Grains</span>
                            <span class="badge bg-light text-dark border p-1 icon-pick" style="cursor:pointer;" data-icon="bi-hammer"><i class="bi bi-hammer"></i> Hardware</span>
                            <span class="badge bg-light text-dark border p-1 icon-pick" style="cursor:pointer;" data-icon="bi-capsule"><i class="bi bi-capsule"></i> Pharmacy</span>
                            <span class="badge bg-light text-dark border p-1 icon-pick" style="cursor:pointer;" data-icon="bi-bag-heart"><i class="bi bi-bag-heart"></i> Fashion</span>
                            <span class="badge bg-light text-dark border p-1 icon-pick" style="cursor:pointer;" data-icon="bi-phone"><i class="bi bi-phone"></i> Phones</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Maelezo ya Kitengo' : 'Description' }}</label>
                        <textarea id="newCatDesc" class="form-control-custom" rows="2" placeholder="{{ $isSwahili ? 'Aina za bidhaa zinazoingia chini ya kitengo hiki...' : 'Items classified under this category...' }}"></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="newCatActive" checked>
                        <label class="form-check-label" for="newCatActive" style="font-size: 0.82rem; font-weight: 500;">
                            {{ $isSwahili ? 'Washa kitengo hiki mara moja (Active)' : 'Enable category immediately (Active)' }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="addCategoryModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-dark-custom" id="btnSubmitAddCat">
                        <i class="bi bi-check-lg"></i> {{ $isSwahili ? 'Hifadhi Kitengo' : 'Save Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Edit Category -->
    <div class="modal-overlay" id="editCategoryModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>{{ $isSwahili ? 'Hariri Kitengo cha Bidhaa' : 'Edit Product Category' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="editCategoryModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="editCategoryForm">
                <input type="hidden" id="editCatId">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Jina la Kitengo' : 'Category Title' }} *</label>
                        <input type="text" id="editCatTitle" class="form-control-custom" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Msururu wa Biashara (Product Chain)' : 'Business Product Chain' }}</label>
                        <select id="editCatChain" class="form-control-custom">
                            <option value="custom">{{ $isSwahili ? 'Msururu Maalum (Custom Chain)' : 'Custom Chain' }}</option>
                            @foreach($availableChains as $cKey => $cVal)
                                <option value="{{ $cKey }}">{{ $cVal['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Kodi ya Kitengo (Code)' : 'Category Code' }}</label>
                            <input type="text" id="editCatCode" class="form-control-custom" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">{{ $isSwahili ? 'Lengo la Faida (%)' : 'Target Margin (%)' }}</label>
                            <input type="number" id="editCatMargin" class="form-control-custom" min="0" max="100">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Aikoni (Icon Class)' : 'Icon Class' }}</label>
                        <input type="text" id="editCatIcon" class="form-control-custom">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">{{ $isSwahili ? 'Maelezo' : 'Description' }}</label>
                        <textarea id="editCatDesc" class="form-control-custom" rows="2"></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editCatActive">
                        <label class="form-check-label" for="editCatActive" style="font-size: 0.82rem; font-weight: 500;">
                            {{ $isSwahili ? 'Inafanya Kazi (Active)' : 'Active Status' }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="editCategoryModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                    <button type="submit" class="btn-primary-custom" id="btnSubmitEditCat">
                        <i class="bi bi-check2"></i> {{ $isSwahili ? 'Sasisha Mabadiliko' : 'Update Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Business Product Chain Preset Selector -->
    <div class="modal-overlay" id="chainPresetModal">
        <div class="modal-box modal-lg">
            <div class="modal-header-custom">
                <div>
                    <h3>{{ $isSwahili ? 'Chagua Msururu wa Biashara wa Duka Lako' : 'Select Store Business Product Chain' }}</h3>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin: 0;">
                        {{ $isSwahili ? 'Badili muundo wa vitengo vyote kuendana moja kwa moja na bidhaa halisi za biashara yako.' : 'Align all catalog categories with your real retail product chain and industry standards.' }}
                    </p>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="chainPresetModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body-custom">
                <div class="row g-3 mb-4">
                    @foreach($availableChains as $cKey => $chain)
                        <div class="col-12 col-md-6">
                            <div class="chain-preset-card {{ $currentChainKey === $cKey ? 'selected' : '' }}" data-key="{{ $cKey }}">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(37,99,235,0.1); color: #2563eb; display:flex; align-items:center; justify-content:center; font-size:1.15rem;">
                                            <i class="bi {{ $chain['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; font-size: 0.92rem; color: var(--text-dark);">{{ $chain['name'] }}</div>
                                            <span style="font-size: 0.72rem; color: var(--text-muted);">{{ count($chain['categories']) }} {{ $isSwahili ? 'vitengo vya kuanzia' : 'built-in categories' }}</span>
                                        </div>
                                    </div>
                                    <p style="font-size: 0.78rem; color: var(--text-muted); margin-bottom: 0.5rem;">{{ $chain['description'] }}</p>
                                    
                                    <!-- Mini list preview -->
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($chain['categories'], 0, 4) as $catItem)
                                            <span class="badge bg-light text-dark border" style="font-size: 0.68rem; font-weight: 500;">
                                                {{ $catItem['name'] }} ({{ $catItem['margin'] }}%)
                                            </span>
                                        @endforeach
                                        @if(count($chain['categories']) > 4)
                                            <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">+{{ count($chain['categories']) - 4 }} zaidi</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <span class="badge text-primary" style="font-size: 0.75rem; font-weight: 600;">
                                        <i class="bi bi-check2-circle me-1"></i>{{ $isSwahili ? 'Bofya Kuchagua' : 'Click to Select' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-3 bg-light rounded-3 border">
                    <label class="form-label-custom mb-1">{{ $isSwahili ? 'Chaguo la Utaratibu (Setup Option)' : 'Application Mode' }}</label>
                    <div class="d-flex gap-4 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="chainApplyMode" id="modeReplace" value="replace" checked>
                            <label class="form-check-label" for="modeReplace" style="font-size: 0.82rem;">
                                <strong>{{ $isSwahili ? 'Badili Kabisa (Replace Defaults)' : 'Replace Defaults' }}</strong>
                                <span class="text-muted d-block" style="font-size: 0.74rem;">{{ $isSwahili ? 'Futa vitengo vya zamani visivyo na bidhaa na weka vitengo vya msururu huu mpya.' : 'Replaces unused defaults with this chain\'s categories.' }}</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="chainApplyMode" id="modeAppend" value="append">
                            <label class="form-check-label" for="modeAppend" style="font-size: 0.82rem;">
                                <strong>{{ $isSwahili ? 'Ongeza kwenye Vilivyopo (Append)' : 'Add to Existing (Append)' }}</strong>
                                <span class="text-muted d-block" style="font-size: 0.74rem;">{{ $isSwahili ? 'Baki na vitengo vya sasa na ongeza hivi vipya vya msururu.' : 'Keeps current categories and appends this chain.' }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-outline-custom close-modal" data-modal="chainPresetModal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                <button type="button" class="btn-primary-custom" id="btnConfirmApplyChain" disabled>
                    <i class="bi bi-magic"></i> {{ $isSwahili ? 'Weka Msururu Huu Sasa' : 'Apply Business Chain' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 4: Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteCategoryModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3 class="text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $isSwahili ? 'Thibitisha Kufuta Kitengo' : 'Confirm Category Deletion' }}</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="deleteCategoryModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body-custom">
                <input type="hidden" id="deleteCatId">
                <p style="font-size: 0.88rem; color: var(--text-dark);" id="deleteCatPromptText">
                    {{ $isSwahili ? 'Je, una uhakika unataka kufuta kitengo hiki?' : 'Are you sure you want to delete this category?' }}
                </p>
                <div class="alert alert-warning py-2 mb-0" style="font-size: 0.78rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    {{ $isSwahili ? 'Bidhaa zote zilizokuwa kwenye kitengo hiki hazitafutwa, zitawekwa bila kitengo ili uweze kuzipanga upya stoo.' : 'Products under this category will remain safe in stock and become unassigned for easy re-categorization.' }}
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-outline-custom close-modal" data-modal="deleteCategoryModal">{{ $isSwahili ? 'Hapana, Ghairi' : 'Cancel' }}</button>
                <button type="button" class="btn btn-danger btn-sm px-3" id="btnConfirmDeleteCat">
                    <i class="bi bi-trash me-1"></i> {{ $isSwahili ? 'Ndio, Futa' : 'Yes, Delete' }}
                </button>
            </div>
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

            // Sidebar Dropdown Toggle Handler
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                const $toggle = $(this);
                const $submenu = $toggle.next('.nav-submenu');
                const isCurrentlyOpen = $toggle.hasClass('open');

                if (isCurrentlyOpen) {
                    $toggle.removeClass('open').attr('aria-expanded', 'false');
                    $submenu.removeClass('open');
                } else {
                    $toggle.addClass('open').attr('aria-expanded', 'true');
                    $submenu.addClass('open');
                }
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

            // Cmd+K Shortcut for search
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#global-search-input').focus();
                }
            });

            // Live Search Filter
            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase().trim();
                let visibleCount = 0;
                $('#categoriesTable tbody tr').each(function() {
                    const searchData = $(this).data('search') || $(this).text().toLowerCase();
                    const match = searchData.includes(term);
                    $(this).toggle(match);
                    if (match) visibleCount++;
                });
                $('#tableCountBadge').text(`${visibleCount} {{ $isSwahili ? 'vitengo vinavyopatikana' : 'categories found' }}`);
            });

            // Modal Controls
            $('#addCategoryBtn, #btnEmptyAddCustom').on('click', function() {
                $('#addCategoryModal').addClass('show');
            });

            $('#btnOpenChainPresetsModal, #btnEmptyChainPresets').on('click', function() {
                $('#chainPresetModal').addClass('show');
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

            // Icon Quick Pick in Add Modal
            $('.icon-pick').on('click', function() {
                const icon = $(this).data('icon');
                $('#newCatIcon').val(icon);
                $('#newCatIconPreview i').attr('class', 'bi ' + icon);
            });

            $('#newCatIcon').on('input', function() {
                $('#newCatIconPreview i').attr('class', 'bi ' + $(this).val());
            });

            // Chain Preset Selection
            let selectedChainKey = '{{ $currentChainKey }}' || null;
            if (selectedChainKey) {
                $('#btnConfirmApplyChain').prop('disabled', false);
            }

            $('.chain-preset-card').on('click', function() {
                $('.chain-preset-card').removeClass('selected');
                $(this).addClass('selected');
                selectedChainKey = $(this).data('key');
                $('#btnConfirmApplyChain').prop('disabled', false);
            });

            // Apply Business Product Chain Preset
            $('#btnConfirmApplyChain').on('click', function() {
                if (!selectedChainKey) return;

                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inatekeleza...');

                const mode = $('input[name="chainApplyMode"]:checked').val() || 'replace';

                $.ajax({
                    url: '{{ route("manager.category.apply-chain") }}',
                    type: 'POST',
                    data: {
                        chain_key: selectedChainKey,
                        mode: mode
                    },
                    success: function(resp) {
                        $('#chainPresetModal').removeClass('show');
                        showToast(resp.message || 'Msururu wa bidhaa umewekwa kikamilifu!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 700);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(originalHtml);
                        const msg = xhr.responseJSON?.message || 'Hitilafu imetokea wakati wa kuweka msururu.';
                        alert(msg);
                    }
                });
            });

            // Add Category Form Handler
            $('#addCategoryForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $('#btnSubmitAddCat');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inahifadhi...');

                const data = {
                    name: $('#newCatTitle').val().trim(),
                    code: $('#newCatCode').val().trim().toUpperCase(),
                    business_chain: $('#newCatChain').val(),
                    target_margin: parseFloat($('#newCatMargin').val()) || 20,
                    icon: $('#newCatIcon').val().trim() || 'bi-tags',
                    description: $('#newCatDesc').val().trim(),
                    is_active: $('#newCatActive').is(':checked') ? 1 : 0
                };

                $.ajax({
                    url: '{{ route("manager.category.store") }}',
                    type: 'POST',
                    data: data,
                    success: function(resp) {
                        $('#addCategoryModal').removeClass('show');
                        showToast(resp.message || 'Kitengo kimeundwa!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 600);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        const msg = xhr.responseJSON?.message || 'Hitilafu imetokea.';
                        alert(msg);
                    }
                });
            });

            // Open Edit Modal
            $(document).on('click', '.btn-edit-category', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const code = $(this).data('code');
                const chain = $(this).data('chain') || 'custom';
                const margin = $(this).data('margin');
                const icon = $(this).data('icon');
                const desc = $(this).data('desc');
                const active = $(this).data('active') == '1';

                $('#editCatId').val(id);
                $('#editCatTitle').val(name);
                $('#editCatCode').val(code);
                $('#editCatChain').val(chain);
                $('#editCatMargin').val(margin);
                $('#editCatIcon').val(icon);
                $('#editCatDesc').val(desc);
                $('#editCatActive').prop('checked', active);

                $('#editCategoryModal').addClass('show');
            });

            // Edit Category Form Handler
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#editCatId').val();
                const $btn = $('#btnSubmitEditCat');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inasasisha...');

                const data = {
                    name: $('#editCatTitle').val().trim(),
                    code: $('#editCatCode').val().trim().toUpperCase(),
                    business_chain: $('#editCatChain').val(),
                    target_margin: parseFloat($('#editCatMargin').val()) || 20,
                    icon: $('#editCatIcon').val().trim() || 'bi-tags',
                    description: $('#editCatDesc').val().trim(),
                    is_active: $('#editCatActive').is(':checked') ? 1 : 0
                };

                $.ajax({
                    url: '/manager/category/' + id,
                    type: 'PUT',
                    data: data,
                    success: function(resp) {
                        $('#editCategoryModal').removeClass('show');
                        showToast(resp.message || 'Kitengo kimesasishwa!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 600);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        const msg = xhr.responseJSON?.message || 'Hitilafu wakati wa kusasisha.';
                        alert(msg);
                    }
                });
            });

            // Toggle Category Status (Active / Inactive)
            $(document).on('click', '.btn-toggle-status', function() {
                const id = $(this).data('id');
                const $badge = $(this);

                $.ajax({
                    url: '/manager/category/' + id + '/toggle-status',
                    type: 'POST',
                    success: function(resp) {
                        showToast(resp.message);
                        if (resp.is_active) {
                            $badge.removeClass('badge-danger').addClass('badge-success');
                            $badge.find('i').attr('class', 'bi bi-check-circle-fill');
                            $badge.find('span').text('{{ $isSwahili ? "Inafanya Kazi" : "Active" }}');
                        } else {
                            $badge.removeClass('badge-success').addClass('badge-danger');
                            $badge.find('i').attr('class', 'bi bi-dash-circle-fill');
                            $badge.find('span').text('{{ $isSwahili ? "Imezimwa" : "Inactive" }}');
                        }
                    },
                    error: function(xhr) {
                        alert('Hitilafu wakati wa kubadili hali.');
                    }
                });
            });

            // Open Delete Modal
            $(document).on('click', '.btn-delete-category', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#deleteCatId').val(id);
                $('#deleteCatPromptText').html('{{ $isSwahili ? "Je, una uhakika unataka kufuta kitengo cha" : "Are you sure you want to delete" }} "<strong>' + name + '</strong>"?');
                $('#deleteCategoryModal').addClass('show');
            });

            // Confirm Delete Category
            $('#btnConfirmDeleteCat').on('click', function() {
                const id = $('#deleteCatId').val();
                const $btn = $(this);
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Inafuta...');

                $.ajax({
                    url: '/manager/category/' + id,
                    type: 'DELETE',
                    success: function(resp) {
                        $('#deleteCategoryModal').removeClass('show');
                        $('#catRow-' + id).fadeOut(300, function() { $(this).remove(); });
                        showToast(resp.message || 'Kitengo kimefutwa.');
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(origHtml);
                        alert('Hitilafu wakati wa kufuta kitengo.');
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
