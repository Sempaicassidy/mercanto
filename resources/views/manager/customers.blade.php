@php
    $businessMode = session('business_mode', 'retailer');
    $isWholesale = $businessMode === 'wholesaler';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers & Credit Ledger - mercanto</title>

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
        }

        /* Sidebar */
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
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 1rem 0 0.4rem 0.6rem;
            letter-spacing: 0.3px;
        }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.86rem;
            font-weight: 500;
            transition: all 0.15s ease;
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
            font-size: 1.02rem;
            color: var(--text-muted);
        }

        .nav-item-link.active .nav-item-left i {
            color: var(--text-dark);
        }

        .nav-dropdown-toggle {
            cursor: pointer;
            user-select: none;
        }

        .nav-chevron {
            transition: transform 0.2s ease;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .nav-dropdown-toggle.open .nav-chevron {
            transform: rotate(90deg);
            color: var(--text-dark);
        }

        .nav-submenu {
            list-style: none;
            padding: 0.2rem 0 0.2rem 0.85rem;
            margin: 2px 0 4px 0.85rem;
            display: none;
            flex-direction: column;
            gap: 2px;
            border-left: 1px solid var(--border-color);
        }

        .nav-submenu.open {
            display: flex;
        }

        .nav-subitem-link {
            display: block;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 500;
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
            text-decoration: none;
            border-top: 1px solid var(--border-color);
            padding-top: 0.85rem;
            cursor: pointer;
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
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
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-email {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        /* Top Nav Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 1.5rem;
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
            transition: border-color 0.15s ease;
        }

        .search-input:focus {
            border-color: #a1a1aa;
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

        .nav-icon-btn {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: var(--nav-active-bg);
        }

        /* Branch Tag & Profile Dropdown */
        .header-branch-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.78rem;
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

        .header-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #09090b;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
        }

        body.dark-mode .header-avatar {
            background-color: #fafafa;
            color: #09090b;
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

        /* Page Header */
        .page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            margin: 0;
        }

        .page-subtext {
            font-size: 0.84rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .page-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

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

        /* Stat Cards */
        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.2rem 1.3rem;
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
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
        }

        .stat-footer {
            font-size: 0.74rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Filter Tabs & Content Card */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .card-toolbar {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 12px;
        }

        .filter-tabs {
            display: flex;
            align-items: center;
            gap: 6px;
            background-color: var(--nav-active-bg);
            padding: 4px;
            border-radius: 8px;
        }

        .filter-tab {
            padding: 0.35rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            border-radius: 6px;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .filter-tab.active {
            background-color: var(--card-bg);
            color: var(--text-dark);
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        /* Table */
        .table-responsive {
            margin: 0;
            overflow-x: auto;
        }

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

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.74rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 9999px;
        }

        .badge-danger {
            background-color: var(--badge-danger-bg);
            color: var(--badge-danger-text);
        }

        .badge-warning {
            background-color: var(--badge-warning-bg);
            color: var(--badge-warning-text);
        }

        .badge-success {
            background-color: var(--badge-success-bg);
            color: var(--badge-success-text);
        }

        .badge-primary {
            background-color: var(--badge-primary-bg);
            color: var(--badge-primary-text);
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
        }

        .action-icon-btn:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45);
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
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: modalFadeIn 0.18s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header-custom {
            padding: 1.2rem 1.4rem;
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
            padding: 1.25rem 1.4rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-footer-custom {
            padding: 1rem 1.4rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-label-custom {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 0.8rem;
            font-size: 0.86rem;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-control-custom:focus {
            border-color: #a1a1aa;
        }

        /* Toast */
        .toast-notify {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: var(--primary-btn);
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            z-index: 2000;
        }

        body.dark-mode .toast-notify {
            color: #09090b;
        }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Workspace Header -->
            <div class="workspace-header" title="Mercanto Store Manager">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>Manager Panel</span>
                    </div>
                </div>
                <i class="bi bi-chevron-expand text-muted" style="font-size: 0.9rem;"></i>
            </div>

            <!-- Dynamic Nav Items -->
            <div id="sidebar-nav-container">
                <div class="nav-section-title">General</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/manager/dashboard') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </span>
                        </a>
                    </li>

                    <!-- Dropdown: Manage Store -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left">
                                <i class="bi bi-box-seam"></i>
                                <span>Manage Store</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu open">
                            <li><a href="{{ url('/manager/stock') }}" class="nav-subitem-link">Products & Stock</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">POS / Cashier</a></li>
                            <li><a href="{{ url('/manager/category') }}" class="nav-subitem-link">Categories</a></li>
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link">Suppliers</a></li>
                            <li><a href="{{ url('/manager/customers') }}" class="nav-subitem-link active">Customers & Credit</a></li>
                            <li><a href="{{ url('/manager/purchases') }}" class="nav-subitem-link">Purchase Orders (LPO)</a></li>
                            <li><a href="{{ url('/manager/transfers') }}" class="nav-subitem-link">Branch Transfers</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Operations -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-arrow-left-right"></i>
                                <span>Operations</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/shifts') }}" class="nav-subitem-link">Shift & Cash Register</a></li>
                            <li><a href="{{ url('/manager/returns') }}" class="nav-subitem-link">Returns & Refunds</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">Stock Audit & Wastage</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Manage Staff -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-people"></i>
                                <span>Manage Staff</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/staff_attendance') }}" class="nav-subitem-link">Staff Shifts & Attendance</a></li>
                            <li><a href="{{ url('/manager/staff_salary') }}" class="nav-subitem-link">Staff Salary & Allowances</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">Permissions</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Reports -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up"></i>
                                <span>Reports</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/analytics') }}" class="nav-subitem-link">Sales Report</a></li>
                            <li><a href="{{ url('/manager/expenses') }}" class="nav-subitem-link">Expense Report</a></li>
                            <li><a href="{{ url('/manager/inventory') }}" class="nav-subitem-link">Inventory Report</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Profile -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div class="profile-avatar">MN</div>
                <div class="profile-info">
                    <span class="profile-name">Store Manager</span>
                    <span class="profile-email">manager@eduka.co.tz</span>
                </div>
            </div>
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); font-size: 1.1rem; text-decoration: none; padding: 4px; border-radius: 6px; display: flex; align-items: center;">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-wrapper">
        <!-- Top Nav -->
        <header class="top-nav-bar">
            <!-- Search Box with Cmd+K -->
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search customers..." id="global-search-input">
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
                    <i class="bi bi-sun" id="themeIcon"></i>
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
                            <i class="bi bi-arrow-left-right"></i>
                            <span>Store Branches</span>
                        </a>
                        <div class="profile-dropdown-divider"></div>
                        <a href="{{ url('/login') }}" class="profile-dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Header -->
        <div class="page-header-row d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h1 class="page-title mb-0">{{ $isWholesale ? 'Wholesale Trade Clients & Debtors' : 'Customers & Credit Ledger' }}</h1>
                    @if($isWholesale)
                        <span class="badge" style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; padding: 4px 12px; border: 1px solid rgba(124, 58, 237, 0.25);">
                            <i class="bi bi-boxes me-1"></i> Wateja wa Maduka (Wholesale Accounts)
                        </span>
                    @else
                        <span class="badge" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; padding: 4px 12px; border: 1px solid rgba(37, 99, 235, 0.25);">
                            <i class="bi bi-cart3 me-1"></i> Wateja wa Rejareja (Retail Customers)
                        </span>
                    @endif
                </div>
                <p class="page-subtext">{{ $isWholesale ? 'Manage retail store trade credit, B2B invoices, payment terms, and wholesale client ledgers.' : 'Manage retail customer credit, track debtor balances, repayments, and credit limits.' }}</p>
            </div>
            <div class="page-header-actions d-flex align-items-center flex-wrap gap-2">
                <form action="{{ url('/tenant/toggle-business-mode') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="border-radius: 9999px; font-size: 0.76rem; font-weight: 600;" title="Badili mtazamo wa wateja kati ya Rejareja na Jumla">
                        <i class="bi bi-arrow-repeat me-1"></i> Badili: {{ $isWholesale ? 'Kuwa Rejareja (Retail)' : 'Kuwa Jumla (Wholesale)' }}
                    </button>
                </form>
                <button class="btn-outline-custom" id="exportBtn">
                    <i class="bi bi-download"></i> Export CSV
                </button>
                <button class="btn-dark-custom" id="addCustomerBtn">
                    <i class="bi bi-person-plus-fill"></i> {{ $isWholesale ? 'Add Retailer Account' : 'Add Customer' }}
                </button>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Jumla ya Madeni (Sokoni)</span>
                        <i class="bi bi-cash-stack stat-icon text-danger"></i>
                    </div>
                    <div class="stat-value text-danger" id="statTotalDebt">Tsh {{ number_format($totalDebt ?? 0) }}</div>
                    <div class="stat-footer">
                        <i class="bi bi-exclamation-circle text-danger"></i>
                        <span>{{ $owingCount ?? 0 }} Wateja wenye madeni</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Madeni Yaliyopitiliza</span>
                        <i class="bi bi-clock-history stat-icon text-warning"></i>
                    </div>
                    <div class="stat-value text-warning" id="statOverdue">Tsh {{ number_format($totalDebt ?? 0) }}</div>
                    <div class="stat-footer">
                        <i class="bi bi-arrow-up-right text-warning"></i>
                        <span>Kukumbushwa mara kwa mara</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Wateja Bila Deni</span>
                        <i class="bi bi-check2-circle stat-icon text-success"></i>
                    </div>
                    <div class="stat-value text-success" id="statCollected">{{ $cleanCount ?? 0 }}</div>
                    <div class="stat-footer">
                        <i class="bi bi-graph-up-arrow text-success"></i>
                        <span>Wateja wenye nidhamu nzuri</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Jumla ya Wateja</span>
                        <i class="bi bi-people stat-icon text-primary"></i>
                    </div>
                    <div class="stat-value text-primary" id="statTotalCust">{{ $totalCustomers ?? 0 }}</div>
                    <div class="stat-footer">
                        <span>Wateja waliosajiliwa dukani</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Card / Table -->
        <div class="content-card">
            <div class="card-toolbar">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">Wote ({{ $totalCustomers ?? 0 }})</button>
                    <button class="filter-tab" data-filter="owing">Wenye Madeni ({{ $owingCount ?? 0 }})</button>
                    <button class="filter-tab" data-filter="clean">Bila Deni ({{ $cleanCount ?? 0 }})</button>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted" style="font-size: 0.8rem;">Orodha ya wateja wa duka</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="customersTable">
                    <thead>
                        <tr>
                            <th>Mteja / Biashara</th>
                            <th>Namba ya Simu</th>
                            <th>Mahali</th>
                            <th>Kikomo Mkopo</th>
                            <th>Salio la Pochi (Wallet)</th>
                            <th>Pointi</th>
                            <th>Deni Lililopo</th>
                            <th class="text-end">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $cust)
                            @php
                                $wBal = (float) ($cust->wallet?->balance ?? 0);
                                $isOwing = $cust->balance_due > 0;
                            @endphp
                            <tr data-status="{{ $isOwing ? 'owing' : 'clean' }}" data-debt="{{ $cust->balance_due }}" data-id="{{ $cust->id }}">
                                <td>
                                    <strong>{{ $cust->name }}</strong><br>
                                    <span class="badge {{ $cust->customer_type === 'wholesale' ? 'bg-primary text-white' : 'bg-secondary' }}" style="font-size: 0.7rem;">
                                        {{ $cust->customer_type === 'wholesale' ? 'Jumla' : 'Rejareja' }}
                                    </span>
                                </td>
                                <td>{{ $cust->phone ?? '-' }}</td>
                                <td>{{ $cust->address ?? '-' }}</td>
                                <td>Tsh {{ number_format($cust->credit_limit) }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1">
                                        <i class="bi bi-wallet2 me-1"></i>Tsh {{ number_format($wBal) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                        <i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($cust->loyalty_points) }}
                                    </span>
                                </td>
                                <td>
                                    @if($isOwing)
                                        <strong class="text-danger">Tsh {{ number_format($cust->balance_due) }}</strong>
                                    @else
                                        <span class="text-success font-monospace">Tsh 0</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-success deposit-wallet-btn" title="Weka Salio la Pochi"
                                        data-id="{{ $cust->id }}"
                                        data-name="{{ $cust->name }}"
                                        data-balance="{{ number_format($wBal) }}">
                                        <i class="bi bi-wallet2"></i> Pochi
                                    </button>
                                    @if($cust->phone)
                                        <button type="button" class="btn btn-sm btn-outline-success whatsapp-btn" title="Tuma WhatsApp"
                                            data-id="{{ $cust->id }}"
                                            data-name="{{ $cust->name }}"
                                            data-phone="{{ $cust->phone }}"
                                            data-debt="{{ number_format($cust->balance_due) }}">
                                            <i class="bi bi-whatsapp"></i>
                                        </button>
                                    @endif
                                    @if($isOwing)
                                        <button type="button" class="btn btn-sm btn-outline-primary pay-btn" title="Lipa Deni"
                                            data-id="{{ $cust->id }}"
                                            data-name="{{ $cust->name }}"
                                            data-debt="{{ $cust->balance_due }}">
                                            <i class="bi bi-cash-stack"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-people display-6 d-block mb-2"></i>
                                    Hakuna wateja waliosajiliwa kwa sasa. Bonyeza kitufe hapo juu kuongeza mteja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($customers, 'hasPages') && $customers->hasPages())
                <div class="p-3 border-top">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </main>

    <!-- Modal: Record Debt Payment -->
    <div class="modal-overlay" id="recordPaymentModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Record Debt Repayment</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="recordPaymentModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="recordPaymentForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Customer Name</label>
                        <input type="text" class="form-control-custom" id="payCustomerName" readonly style="background-color: var(--nav-active-bg);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Current Outstanding Debt</label>
                        <input type="text" class="form-control-custom text-danger font-monospace" id="payCurrentDebt" readonly style="background-color: var(--nav-active-bg); font-weight: 700;">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Amount Paying (Tsh) *</label>
                            <input type="number" class="form-control-custom" id="payAmountInput" placeholder="e.g. 50000" required min="1000">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Payment Method</label>
                            <select class="form-control-custom" id="payMethod">
                                <option value="Cash">Cash (Pesa Taslimu)</option>
                                <option value="M-Pesa">M-Pesa Till / Lipa Namba</option>
                                <option value="Tigo Pesa">Tigo Pesa</option>
                                <option value="Airtel Money">Airtel Money</option>
                                <option value="Bank Transfer">Bank Transfer (NMB / CRDB)</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-2 mb-3 rounded" style="background-color: var(--nav-active-bg); font-size: 0.82rem;">
                        <span class="text-muted">Estimated Remaining Debt:</span>
                        <strong class="font-monospace text-danger float-end" id="payRemainingPreview">Tsh 0</strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Transaction Ref / Receipt No (Optional)</label>
                        <input type="text" class="form-control-custom" id="payRefNo" placeholder="e.g. QX981729381">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Notes / Maelezo</label>
                        <textarea class="form-control-custom" id="payNotes" rows="2" placeholder="Mfano: Malipo ya awamu ya kwanza ya bili ya wiki iliyopita..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="recordPaymentModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-circle"></i> Save Payment & Print Receipt</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Add New Customer -->
    <div class="modal-overlay" id="addCustomerModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-person-plus text-primary me-2"></i>Sajili Mteja Mpya (New Customer)</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="addCustomerModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="{{ route('manager.customers.store') }}" method="POST" id="addCustomerForm">
                @csrf
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Jina Kamili / Jina la Biashara *</label>
                        <input type="text" name="name" class="form-control-custom" id="custNewName" placeholder="Mfano: Juma Kassim au Duka la Juma" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Namba ya Simu *</label>
                            <input type="text" name="phone" class="form-control-custom" id="custNewPhone" placeholder="+255 7..." required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Mahali / Mtaa</label>
                            <input type="text" name="address" class="form-control-custom" id="custNewLocation" placeholder="Mfano: Sinza Kijiweni">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Aina ya Mteja *</label>
                            <select name="customer_type" class="form-control-custom" required>
                                <option value="retail" {{ !$isWholesale ? 'selected' : '' }}>Rejareja (Retail)</option>
                                <option value="wholesale" {{ $isWholesale ? 'selected' : '' }}>Jumla (Wholesale / Duka)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Kikomo cha Mkopo (TSh)</label>
                            <input type="number" name="credit_limit" class="form-control-custom" id="custNewLimit" placeholder="Mfano: 500000" value="200000" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="addCustomerModal">Ghairi</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-person-check-fill"></i> Hifadhi Mteja</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Deposit to Customer Wallet -->
    <div class="modal-overlay" id="depositWalletModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-wallet2 text-success me-2"></i>Weka Salio Kwenye Pochi ya Mteja</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="depositWalletModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="depositWalletForm" method="POST" action="">
                @csrf
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Mteja</label>
                        <input type="text" class="form-control-custom" id="depositCustName" readonly style="background-color: var(--nav-active-bg);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Salio la Sasa (Current Balance)</label>
                        <input type="text" class="form-control-custom font-monospace text-success fw-bold" id="depositCustCurrentBal" readonly style="background-color: var(--nav-active-bg);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Kiasi cha Kuweka (Amount TSh) *</label>
                        <input type="number" name="amount" class="form-control-custom" id="depositAmount" placeholder="Mfano: 50000" min="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Maelezo / Namba ya Muamala</label>
                        <input type="text" name="reference" class="form-control-custom" placeholder="Mfano: MPESA-78219...">
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="depositWalletModal">Ghairi</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-circle"></i> Weka Salio</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Send WhatsApp Message -->
    <div class="modal-overlay" id="whatsappModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-whatsapp text-success me-2"></i>Tuma Ujumbe wa WhatsApp</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="whatsappModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="whatsappForm" method="POST" action="" target="_blank">
                @csrf
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Mteja & Namba ya Simu</label>
                        <input type="text" class="form-control-custom" id="waCustInfo" readonly style="background-color: var(--nav-active-bg);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Aina ya Ujumbe *</label>
                        <select name="message_type" id="waMessageType" class="form-control-custom">
                            <option value="debt_reminder">Kukumbusha Deni (Debt Reminder)</option>
                            <option value="promo">Ofa Maalum za Duka (Promo Message)</option>
                            <option value="custom">Ujumbe Maalum (Custom Message)</option>
                        </select>
                    </div>
                    <div class="mb-3" id="waCustomMessageDiv" style="display: none;">
                        <label class="form-label-custom">Ujumbe Wako</label>
                        <textarea name="custom_message" class="form-control-custom" rows="3" placeholder="Andika ujumbe wako hapa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="whatsappModal">Ghairi</button>
                    <button type="submit" class="btn btn-success text-white"><i class="bi bi-whatsapp me-1"></i> Fungua WhatsApp & Tuma</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Send SMS Reminder -->
    <div class="modal-overlay" id="smsReminderModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Send Debt Reminder SMS</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="smsReminderModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="smsReminderForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Recipient</label>
                        <input type="text" class="form-control-custom" id="smsRecipient" readonly style="background-color: var(--nav-active-bg);">
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label-custom m-0">Message Preview (Swahili Template)</label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="smsCharCounter">0 / 160 (1 SMS)</span>
                        </div>
                        <textarea class="form-control-custom" id="smsMessageBody" rows="4"></textarea>
                        <small class="text-muted" style="font-size: 0.72rem;">SMS itatumwa mara moja kupitia gateway ya duka (Tigo/Vodacom).</small>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="smsReminderModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-send-fill"></i> Send SMS Reminder</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Customer Ledger History -->
    <div class="modal-overlay" id="ledgerModal">
        <div class="modal-box" style="max-width: 650px;">
            <div class="modal-header-custom">
                <h3 id="ledgerCustomerTitle">Customer Statement / Daftari</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="ledgerModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body-custom">
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background-color: var(--nav-active-bg);">
                    <div>
                        <span class="text-muted" style="font-size: 0.75rem;">Total Purchases on Credit</span>
                        <h6 class="m-0 font-monospace">Tsh 1,420,000</h6>
                    </div>
                    <div>
                        <span class="text-muted" style="font-size: 0.75rem;">Total Paid</span>
                        <h6 class="m-0 text-success font-monospace">Tsh 1,080,000</h6>
                    </div>
                    <div>
                        <span class="text-muted" style="font-size: 0.75rem;">Current Balance</span>
                        <h6 class="m-0 text-danger font-monospace" id="ledgerCurrentBalance">Tsh 340,000</h6>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered" style="font-size: 0.78rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Ref / Invoice</th>
                                <th>Type</th>
                                <th>Debit (Took Goods)</th>
                                <th>Credit (Paid)</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01 Sep 2026</td>
                                <td>INV-9021</td>
                                <td>Goods Credit</td>
                                <td class="text-danger font-monospace">Tsh 400,000</td>
                                <td>-</td>
                                <td class="font-monospace">Tsh 400,000</td>
                            </tr>
                            <tr>
                                <td>08 Sep 2026</td>
                                <td>REC-1044</td>
                                <td>Cash Repayment</td>
                                <td>-</td>
                                <td class="text-success font-monospace">Tsh 200,000</td>
                                <td class="font-monospace">Tsh 200,000</td>
                            </tr>
                            <tr>
                                <td>12 Sep 2026</td>
                                <td>INV-9150</td>
                                <td>Goods Credit</td>
                                <td class="text-danger font-monospace">Tsh 340,000</td>
                                <td>-</td>
                                <td class="font-monospace">Tsh 540,000</td>
                            </tr>
                            <tr>
                                <td>15 Sep 2026</td>
                                <td>REC-1102</td>
                                <td>M-Pesa Payment</td>
                                <td>-</td>
                                <td class="text-success font-monospace">Tsh 200,000</td>
                                <td class="font-monospace text-danger font-bold">Tsh 340,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-outline-custom" onclick="window.print()"><i class="bi bi-printer"></i> Print Statement</button>
                <button type="button" class="btn-dark-custom close-modal" data-modal="ledgerModal">Close</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastNotifyMsg">Action performed successfully</span>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Persistent Theme Logic
            if (localStorage.getItem('theme') === 'dark') {
                $('body').addClass('dark-mode');
                $('#theme-icon').removeClass('bi-moon-stars').addClass('bi-sun');
            } else {
                $('body').removeClass('dark-mode');
                $('#theme-icon').removeClass('bi-sun').addClass('bi-moon-stars');
            }

            $('#theme-toggle-btn').on('click', function() {
                $('body').toggleClass('dark-mode');
                const isDark = $('body').hasClass('dark-mode');
                $('#theme-icon').toggleClass('bi-sun bi-moon-stars');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });

            // Nav Dropdown Submenus
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.nav-submenu').toggleClass('open');
            });

            // Global Cmd+K Search
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#global-search-input').focus();
                }
            });

            // Realtime Search Filter
            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase();
                $('#customersTable tbody tr').each(function() {
                    $(this).toggle($(this).text().toLowerCase().includes(term));
                });
            });

            // Filter Tabs
            $('.filter-tab').on('click', function() {
                $('.filter-tab').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                if (filter === 'all') {
                    $('#customersTable tbody tr').show();
                } else if (filter === 'owing') {
                    $('#customersTable tbody tr').each(function() {
                        const status = $(this).data('status');
                        $(this).toggle(status === 'owing' || status === 'overdue');
                    });
                } else {
                    $('#customersTable tbody tr').each(function() {
                        $(this).toggle($(this).data('status') === filter);
                    });
                }
            });

            // Open Modals
            $('#addCustomerBtn').on('click', function() {
                $('#addCustomerModal').addClass('show');
            });

            // Debt Payment Workflow
            let activeCustomerRow = null;
            let currentCustomerDebt = 0;

            $(document).on('click', '.pay-btn', function() {
                activeCustomerRow = $(this).closest('tr');
                const name = $(this).data('name') || activeCustomerRow.find('strong').first().text();
                currentCustomerDebt = parseInt(activeCustomerRow.attr('data-debt')) || parseInt($(this).data('debt')) || 0;

                $('#payCustomerName').val(name);
                $('#payCurrentDebt').val('Tsh ' + currentCustomerDebt.toLocaleString());
                $('#payAmountInput').val('').attr('max', currentCustomerDebt);
                $('#payRemainingPreview').text('Tsh ' + currentCustomerDebt.toLocaleString()).removeClass('text-success').addClass('text-danger');
                $('#recordPaymentModal').addClass('show');
            });

            // Live preview of remaining debt
            $('#payAmountInput').on('input', function() {
                const payVal = parseInt($(this).val()) || 0;
                const remaining = Math.max(0, currentCustomerDebt - payVal);
                $('#payRemainingPreview').text('Tsh ' + remaining.toLocaleString());
                if (remaining === 0) {
                    $('#payRemainingPreview').removeClass('text-danger').addClass('text-success').text('Tsh 0 (Fully Cleared!)');
                } else {
                    $('#payRemainingPreview').removeClass('text-success').addClass('text-danger');
                }
            });

            // Record Payment Form Submit
            $('#recordPaymentForm').on('submit', function(e) {
                e.preventDefault();
                if (!activeCustomerRow) return;

                const payVal = parseInt($('#payAmountInput').val()) || 0;
                const method = $('#payMethod').val();
                const refNo = $('#payRefNo').val() || ('REC-2026-' + Math.floor(1000 + Math.random() * 9000));
                const custName = $('#payCustomerName').val();
                const newDebt = Math.max(0, currentCustomerDebt - payVal);

                // Update row data and visual cell
                activeCustomerRow.attr('data-debt', newDebt);
                const debtStrong = activeCustomerRow.find('td:nth-child(5) strong');
                if (newDebt <= 0) {
                    debtStrong.text('Tsh 0').removeClass('text-danger text-warning').addClass('text-success');
                    activeCustomerRow.attr('data-status', 'good');
                    activeCustomerRow.find('.status-badge').removeClass('badge-danger badge-warning').addClass('badge-success')
                        .html('<i class="bi bi-check-circle-fill"></i> Good Standing');
                    activeCustomerRow.find('.pay-btn').attr('disabled', true).css('opacity', '0.5');
                } else {
                    debtStrong.text('Tsh ' + newDebt.toLocaleString());
                }

                // Update stat cards
                let curDebtNum = parseInt($('#statTotalDebt').text().replace(/[^\d]/g, '')) || 3450000;
                curDebtNum = Math.max(0, curDebtNum - payVal);
                $('#statTotalDebt').text('Tsh ' + curDebtNum.toLocaleString());

                let curCollNum = parseInt($('#statCollected').text().replace(/[^\d]/g, '')) || 2150000;
                curCollNum += payVal;
                $('#statCollected').text('Tsh ' + curCollNum.toLocaleString());

                $('#recordPaymentModal').removeClass('show');
                this.reset();
                showToast(`Payment of Tsh ${payVal.toLocaleString()} via ${method} recorded! Ref: ${refNo}. Balance: Tsh ${newDebt.toLocaleString()}`);
            });

            // SMS Reminder Workflow
            $(document).on('click', '.sms-btn', function() {
                const name = $(this).data('name');
                const phone = $(this).data('phone');
                const row = $(this).closest('tr');
                const debt = parseInt(row.attr('data-debt')) || parseInt($(this).data('debt')) || 0;

                $('#smsRecipient').val(name + ' (' + phone + ')');
                const msg = `Habari Ndg ${name}, tunakukumbusha salio lako la deni la Tsh ${debt.toLocaleString()} katika duka la Mercanto. Tafadhali fanya marejesho kwa Lipa Namba 55214 (Mercanto Store). Ahsante!`;
                $('#smsMessageBody').val(msg);

                const len = msg.length;
                const segments = Math.ceil(len / 160) || 1;
                $('#smsCharCounter').text(`${len} / 160 (${segments} SMS segment${segments > 1 ? 's' : ''})`);

                $('#smsReminderModal').addClass('show');
            });

            $('#smsMessageBody').on('input', function() {
                const len = $(this).val().length;
                const segments = Math.ceil(len / 160) || 1;
                $('#smsCharCounter').text(`${len} / 160 (${segments} SMS segment${segments > 1 ? 's' : ''})`);
            });

            $('#smsReminderForm').on('submit', function(e) {
                e.preventDefault();
                $('#smsReminderModal').removeClass('show');
                showToast('SMS payment reminder queued and dispatched to telecom gateway!');
            });

            // Statement / Ledger Modal
            $(document).on('click', '.ledger-btn', function() {
                const name = $(this).data('name');
                const row = $(this).closest('tr');
                const currentDebt = parseInt(row.attr('data-debt')) || 340000;

                $('#ledgerCustomerTitle').html(`<i class="bi bi-person-badge text-primary me-2"></i>${name} - Statement & Ledger`);
                $('#ledgerCurrentBalance').text('Tsh ' + currentDebt.toLocaleString());
                $('#ledgerModal').addClass('show');
            });

            // Add Customer Modal Opener
            $('#addCustomerBtn').on('click', function() {
                $('#addCustomerModal').addClass('show');
            });

            // Deposit to Customer Wallet Handler
            $(document).on('click', '.deposit-wallet-btn', function() {
                const custId = $(this).data('id');
                const name = $(this).data('name');
                const bal = $(this).data('balance');
                $('#depositCustName').val(name);
                $('#depositCustCurrentBal').val('Tsh ' + bal);
                $('#depositWalletForm').attr('action', '/manager/customers/' + custId + '/deposit');
                $('#depositWalletModal').addClass('show');
            });

            // WhatsApp Modal Handler
            $(document).on('click', '.whatsapp-btn', function() {
                const custId = $(this).data('id');
                const name = $(this).data('name');
                const phone = $(this).data('phone');
                const debt = $(this).data('debt');
                $('#waCustInfo').val(name + ' (' + phone + ')');
                $('#whatsappForm').attr('action', '/manager/customers/' + custId + '/whatsapp');
                $('#whatsappModal').addClass('show');
            });

            $('#waMessageType').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#waCustomMessageDiv').show();
                } else {
                    $('#waCustomMessageDiv').hide();
                }
            });

            // Customer Filter Tabs
            $('.filter-tab').on('click', function() {
                $('.filter-tab').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                if (filter === 'all') {
                    $('#customersTable tbody tr').show();
                } else {
                    $('#customersTable tbody tr').each(function() {
                        if ($(this).data('status') === filter) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
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

            // Export CSV Action
            $('#exportBtn').on('click', function() {
                showToast('Generating official Customers & Debtors Ledger CSV report...');
            });

            // User Profile Dropdown Toggle
            $('#headerProfileBtn').on('click', function(e) {
                e.stopPropagation();
                $('#profileDropdownMenu').toggleClass('show');
                const isExpanded = $('#profileDropdownMenu').hasClass('show');
                $(this).attr('aria-expanded', isExpanded);
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#headerProfileDropdown').length) {
                    $('#profileDropdownMenu').removeClass('show');
                    $('#headerProfileBtn').attr('aria-expanded', 'false');
                }
            });

            function showToast(msg) {
                const toast = $('#toastNotify');
                $('#toastNotifyMsg').html(msg);
                toast.stop(true, true).fadeIn(180).delay(3200).fadeOut(200);
            }
        });
    </script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
