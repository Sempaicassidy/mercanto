<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Auditing & Activity Logs - mercanto</title>

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
            top: 0; left: 0; bottom: 0;
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
            background-color: var(--primary-btn);
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        body.dark-mode .workspace-icon {
            background-color: #fafafa;
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
            gap: 2px;
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
        }

        .nav-chevron {
            font-size: 0.75rem;
            transition: transform 0.2s ease;
        }

        .nav-dropdown-toggle.open .nav-chevron {
            transform: rotate(90deg);
        }

        .nav-submenu {
            list-style: none;
            padding: 0.25rem 0 0.25rem 2.2rem;
            margin: 0;
            display: none;
        }

        .nav-submenu.open {
            display: block;
        }

        .nav-subitem-link {
            display: block;
            padding: 0.38rem 0.5rem;
            border-radius: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .nav-subitem-link:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        .nav-subitem-link.active {
            color: var(--nav-active-text);
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
        }

        body.dark-mode .profile-avatar {
            background-color: #27272a;
            color: #f4f4f5;
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
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
        }

        /* Top Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            gap: 15px;
        }

        .header-search-box {
            position: relative;
            width: 320px;
        }

        .search-input {
            width: 100%;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.48rem 2.2rem 0.48rem 2.2rem;
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
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .search-kbd {
            position: absolute;
            right: 0.6rem;
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

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-branch-pill {
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

        .branch-indicator-dot {
            width: 7px;
            height: 7px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
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
        }

        /* Profile Dropdown */
        .header-profile-dropdown {
            position: relative;
        }

        .header-profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .header-profile-btn:hover {
            background-color: var(--nav-active-bg);
        }

        .header-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: var(--primary-btn);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        body.dark-mode .header-avatar {
            background-color: #fafafa;
            color: #09090b;
        }

        .header-user-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .header-user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .profile-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 230px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            padding: 0.5rem;
            display: none;
            z-index: 1000;
        }

        .profile-dropdown-menu.show {
            display: block;
        }

        .profile-dropdown-header {
            padding: 0.6rem 0.75rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 0.35rem;
        }

        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            color: var(--text-dark);
            font-size: 0.82rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .profile-dropdown-item:hover {
            background-color: var(--nav-active-bg);
        }

        /* Page Header */
        .page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-title {
            font-size: 1.55rem;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: var(--text-dark);
            margin: 0;
        }

        .page-subtext {
            font-size: 0.84rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .page-header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-custom {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            padding: 0.52rem 0.95rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--nav-active-bg);
            border-color: #a1a1aa;
        }

        .btn-dark-custom {
            background-color: var(--primary-btn);
            border: 1px solid var(--primary-btn);
            color: #ffffff;
            padding: 0.52rem 1.05rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        body.dark-mode .btn-dark-custom {
            background-color: #fafafa;
            color: #09090b;
            border-color: #fafafa;
        }

        .btn-dark-custom:hover {
            opacity: 0.9;
        }

        /* KPI Stat Cards */
        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.04);
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
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }

        .stat-subtext {
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        /* Color Utility Classes */
        .text-primary { color: #2563eb !important; }
        .text-success { color: #16a34a !important; }
        .text-warning { color: #d97706 !important; }
        .text-danger { color: #dc2626 !important; }

        body.dark-mode .text-primary { color: #60a5fa !important; }
        body.dark-mode .text-success { color: #4ade80 !important; }
        body.dark-mode .text-warning { color: #fbbf24 !important; }
        body.dark-mode .text-danger { color: #f87171 !important; }

        /* Filter Tabs */
        .tabs-header-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-tabs {
            display: flex;
            gap: 6px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            padding: 0.65rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .tab-btn:hover {
            color: var(--text-dark);
        }

        .tab-btn.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        body.dark-mode .tab-btn.active {
            color: #60a5fa;
            border-bottom-color: #60a5fa;
        }

        /* Content Card & Table */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .toolbar-row {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.84rem;
        }

        .table-custom th {
            text-align: left;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            color: var(--text-muted);
            background-color: var(--nav-active-bg);
            border-bottom: 1px solid var(--border-color);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-custom td {
            padding: 0.95rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-dark);
        }

        .table-custom tr:hover td {
            background-color: var(--nav-active-bg);
        }

        /* Pill Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 9999px;
            font-size: 0.74rem;
            font-weight: 700;
            border: none;
        }

        .badge-success {
            background-color: var(--badge-success-bg);
            color: var(--badge-success-text);
        }

        .badge-primary {
            background-color: var(--badge-primary-bg);
            color: var(--badge-primary-text);
        }

        .badge-warning {
            background-color: var(--badge-warning-bg);
            color: var(--badge-warning-text);
        }

        .badge-danger {
            background-color: var(--badge-danger-bg);
            color: var(--badge-danger-text);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-cell-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: var(--badge-primary-bg);
            color: var(--badge-primary-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.74rem;
        }

        .action-icon-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .action-icon-btn:hover {
            color: #2563eb;
            border-color: #2563eb;
            background-color: var(--nav-active-bg);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(9, 9, 11, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 1rem;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 100%;
            max-width: 580px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: modalFade 0.2s ease-out;
        }

        @keyframes modalFade {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header-custom {
            padding: 1.15rem 1.4rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-body-custom {
            padding: 1.4rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-footer-custom {
            padding: 1rem 1.4rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        /* Toast */
        .toast-notify {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #09090b;
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 3000;
        }

        body.dark-mode .toast-notify {
            background-color: #27272a;
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
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Workspace Brand Header -->
            <div class="workspace-header" title="Mercanto Management Portal">
                <div class="workspace-brand">
                    <div class="workspace-icon"><i class="bi bi-shield-check"></i></div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>Manager Panel</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <div id="sidebar-nav-container">
                <div class="nav-section-title">General</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/manager/dashboard') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-speedometer2"></i><span>Dashboard</span></span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left"><i class="bi bi-box-seam"></i><span>Manage Store</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/stock') }}" class="nav-subitem-link">Products & Stock</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">POS / Cashier</a></li>
                            <li><a href="{{ url('/manager/category') }}" class="nav-subitem-link">Categories</a></li>
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link">Suppliers</a></li>
                            <li><a href="{{ url('/manager/customers') }}" class="nav-subitem-link">Customers & Credit</a></li>
                            <li><a href="{{ url('/manager/purchases') }}" class="nav-subitem-link">Purchase Orders (LPO)</a></li>
                            <li><a href="{{ url('/manager/transfers') }}" class="nav-subitem-link">Branch Transfers</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left"><i class="bi bi-arrow-left-right"></i><span>Operations</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/shifts') }}" class="nav-subitem-link">Shift & Cash Register</a></li>
                            <li><a href="{{ url('/manager/returns') }}" class="nav-subitem-link">Returns & Refunds</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">Stock Audit & Wastage</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left"><i class="bi bi-people"></i><span>Manage Staff</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/staff_attendance') }}" class="nav-subitem-link">Staff Shifts & Attendance</a></li>
                            <li><a href="{{ url('/manager/staff_salary') }}" class="nav-subitem-link">Staff Salary & Allowances</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">Permissions</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left"><i class="bi bi-graph-up"></i><span>Reports</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/analytics') }}" class="nav-subitem-link">Sales Report</a></li>
                            <li><a href="{{ url('/manager/expenses') }}" class="nav-subitem-link">Expense Report</a></li>
                            <li><a href="{{ url('/manager/inventory') }}" class="nav-subitem-link">Inventory Report</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left"><i class="bi bi-shield-check"></i><span>Auditing</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu open">
                            <li><a href="{{ url('/manager/auditing') }}" class="nav-subitem-link active">Activity Logs</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">Stock Audit & Wastage</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">Security & Roles</a></li>
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
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); text-decoration: none;">
                <i class="bi bi-box-arrow-right" style="font-size: 1.05rem;"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Nav Bar -->
        <header class="top-nav-bar">
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search event, user, IP, or record..." id="auditSearchInput">
                <span class="search-kbd">⌘ K</span>
            </div>

            <div class="top-nav-actions">
                <div class="header-branch-pill d-none d-sm-inline-flex">
                    <span class="branch-indicator-dot"></span>
                    <span>Main Branch (HQ)</span>
                </div>

                <!-- Universal Role Switcher Component -->
                @include('partials.role_switcher')

                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme" aria-label="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>

                <div class="header-profile-dropdown" id="headerProfileDropdown">
                    <button type="button" class="header-profile-btn" id="headerProfileBtn" aria-expanded="false">
                        <div class="header-avatar">MN</div>
                        <div class="d-none d-md-flex flex-column text-start">
                            <span class="header-user-name">Store Manager</span>
                            <span class="header-user-role">Administrator</span>
                        </div>
                        <i class="bi bi-chevron-down" style="font-size: 0.75rem; color: var(--text-muted);"></i>
                    </button>

                    <div class="profile-dropdown-menu" id="profileDropdownMenu">
                        <div class="profile-dropdown-header">
                            <div class="fw-bold text-dark" style="font-size:0.85rem;">Store Manager</div>
                            <div class="text-muted" style="font-size:0.75rem;">manager@eduka.co.tz</div>
                        </div>
                        <div class="px-2 py-1 text-muted fw-bold" style="font-size:0.68rem;text-transform:uppercase;letter-spacing:0.5px;border-top:1px solid var(--border-color, #e4e4e7);margin-top:4px;padding-top:6px;">Switch Role</div>
                        <a href="{{ url('/switch-role/manager') }}" class="profile-dropdown-item"><i class="bi bi-shield-check text-primary"></i> <span>Store Manager</span></a>
                        <a href="{{ url('/switch-role/cashier') }}" class="profile-dropdown-item"><i class="bi bi-receipt text-success"></i> <span>Cashier / POS</span></a>
                        <a href="{{ url('/switch-role/storekeeper') }}" class="profile-dropdown-item"><i class="bi bi-box-seam text-warning"></i> <span>Storekeeper</span></a>
                        <div style="border-top:1px solid var(--border-color, #e4e4e7);margin:4px 0;"></div>
                        <a href="{{ url('/manager/permission') }}" class="profile-dropdown-item"><i class="bi bi-shield-lock"></i> Permissions</a>
                        <a href="{{ url('/manager/auditing') }}" class="profile-dropdown-item"><i class="bi bi-activity"></i> Audit Log</a>
                        <div style="border-top:1px solid var(--border-color, #e4e4e7);margin:4px 0;"></div>
                        <a href="{{ url('/login') }}" class="profile-dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Sign Out</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Header -->
        <div class="page-header-row">
            <div>
                <h1 class="page-title">System Auditing & Activity Logs</h1>
                <p class="page-subtext">Real-time ledger of POS cashier events, price overrides, stock reconciling, role modifications, and login security.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn-outline-custom" id="exportAuditBtn">
                    <i class="bi bi-download text-primary"></i> Export Audit Trail
                </button>
                <button type="button" class="btn-dark-custom" id="runAuditScanBtn">
                    <i class="bi bi-shield-check text-success"></i> Run Security Scan
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Events Logged Today</span>
                        <i class="bi bi-shield-check stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">1,248</div>
                        <div class="stat-subtext">Across 4 Cashiers & 2 Terminals</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Integrity Health Score</span>
                        <i class="bi bi-patch-check-fill stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">99.8%</div>
                        <div class="stat-subtext">Zero unauthorized access attempts</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Flagged High-Risk Actions</span>
                        <i class="bi bi-exclamation-triangle-fill stat-icon text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-value text-danger">3 Alerts</div>
                        <div class="stat-subtext">2 Voids &gt; TSh 50k • 1 Drawer Open</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Pending Reviews</span>
                        <i class="bi bi-hourglass-split stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">2 Items</div>
                        <div class="stat-subtext">Requires Manager Acknowledgment</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="tabs-header-wrap">
            <div class="filter-tabs">
                <button type="button" class="tab-btn active" data-filter="all"><i class="bi bi-list-ul"></i> All Events (12)</button>
                <button type="button" class="tab-btn" data-filter="pos"><i class="bi bi-upc-scan"></i> POS & Voids (4)</button>
                <button type="button" class="tab-btn" data-filter="stock"><i class="bi bi-box-seam"></i> Stock & Pricing (3)</button>
                <button type="button" class="tab-btn" data-filter="auth"><i class="bi bi-shield-lock"></i> Auth & Security (3)</button>
                <button type="button" class="tab-btn" data-filter="risk"><i class="bi bi-exclamation-octagon"></i> High Risk Alerts (2)</button>
            </div>
            <div>
                <a href="{{ url('/manager/damages') }}" class="btn-outline-custom" style="text-decoration:none;font-size:0.8rem;">
                    <i class="bi bi-arrow-right-circle text-primary"></i> Open Physical Stock Audits
                </a>
            </div>
        </div>

        <!-- Main Audit Ledger Table Card -->
        <div class="content-card">
            <!-- Toolbar Filters -->
            <div class="toolbar-row">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <select class="form-select form-select-sm" id="userFilter" style="width: 170px; font-size: 0.82rem; background-color: var(--card-bg); color: var(--text-dark); border-color: var(--border-color);">
                        <option value="all">All Personnel</option>
                        <option value="Baraka Msuya">Baraka Msuya (Cashier)</option>
                        <option value="Asha Ally">Asha Ally (Cashier)</option>
                        <option value="Store Manager">Store Manager (Admin)</option>
                        <option value="Juma Bakari">Juma Bakari (Storekeeper)</option>
                    </select>

                    <select class="form-select form-select-sm" id="severityFilter" style="width: 160px; font-size: 0.82rem; background-color: var(--card-bg); color: var(--text-dark); border-color: var(--border-color);">
                        <option value="all">All Severities</option>
                        <option value="Normal">Normal</option>
                        <option value="Sensitive">Sensitive</option>
                        <option value="High Alert">High Alert</option>
                    </select>
                </div>
                <div class="text-muted" style="font-size: 0.8rem;">
                    Showing <strong class="text-dark" id="eventCount">12</strong> verified cryptographic audit log entries
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-custom" id="auditTable">
                    <thead>
                        <tr>
                            <th>Ref / Time</th>
                            <th>Operator</th>
                            <th>Module & Event Description</th>
                            <th>Terminal / Channel</th>
                            <th>IP Address</th>
                            <th>Severity</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Record 1: High Alert Void -->
                        <tr data-cat="pos" data-user="Baraka Msuya" data-severity="High Alert">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9821</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 22:14:08</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar">BM</div>
                                    <div>
                                        <div class="fw-semibold">Baraka Msuya</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Cashier #01</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-danger"><i class="bi bi-trash3 me-1"></i> Post-Print Ticket Void: TSh 48,000</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Dishwashing Liquid (10 units) voided from active order #EDK-20498</div>
                            </td>
                            <td><span class="status-badge badge-primary">POS Terminal 01</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.102</td>
                            <td><span class="status-badge badge-danger"><i class="bi bi-exclamation-triangle-fill"></i> High Alert</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9821" data-time="Today, 22:14:08" data-user="Baraka Msuya (Cashier)"
                                    data-event="Post-Print Ticket Void: TSh 48,000 (Dishwashing Liquid x10)"
                                    data-module="POS Counter #01" data-ip="192.168.1.102" data-severity="High Alert"
                                    data-payload='{"ticket": "#EDK-20498", "reason": "Customer changed mind", "void_amount": 48000, "auth_by": "Manager PIN 1192"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 2: Sensitive Price Override -->
                        <tr data-cat="stock" data-user="Store Manager" data-severity="Sensitive">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9820</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 21:50:33</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#f0fdf4;color:#16a34a;">SM</div>
                                    <div>
                                        <div class="fw-semibold">Store Manager</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-warning"><i class="bi bi-tag me-1"></i> Retail Price Override</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Kilombero Super Rice 25kg selling price updated from TSh 65,000 to TSh 68,000</div>
                            </td>
                            <td><span class="status-badge badge-primary">Manager Portal</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.50</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-shield-exclamation"></i> Sensitive</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9820" data-time="Today, 21:50:33" data-user="Store Manager (Admin)"
                                    data-event="Retail Price Override (Kilombero Rice 25kg: 65k -> 68k)"
                                    data-module="Stock Catalog" data-ip="192.168.1.50" data-severity="Sensitive"
                                    data-payload='{"sku": "RCE-KLM-025", "old_price": 65000, "new_price": 68000, "margin_delta": "+4.6%"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 3: Normal Sale Payment -->
                        <tr data-cat="pos" data-user="Asha Ally" data-severity="Normal">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9819</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 21:30:19</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar">AA</div>
                                    <div>
                                        <div class="fw-semibold">Asha Ally</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Cashier #02</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-success"><i class="bi bi-check2-circle me-1"></i> M-Pesa Payment Received: TSh 64,000</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Transaction Code: QKH78921KL • Till 559012</div>
                            </td>
                            <td><span class="status-badge badge-primary">POS Terminal 02</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.103</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle"></i> Normal</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9819" data-time="Today, 21:30:19" data-user="Asha Ally (Cashier)"
                                    data-event="Mobile Payment Received: TSh 64,000"
                                    data-module="POS Mobile Till" data-ip="192.168.1.103" data-severity="Normal"
                                    data-payload='{"mpesa_code": "QKH78921KL", "amount": 64000, "phone": "0754***812"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 4: Sensitive Stock Adjustment -->
                        <tr data-cat="stock" data-user="Juma Bakari" data-severity="Sensitive">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9818</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 20:15:45</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#fffbeb;color:#d97706;">JB</div>
                                    <div>
                                        <div class="fw-semibold">Juma Bakari</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Storekeeper</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-warning"><i class="bi bi-arrow-repeat me-1"></i> Physical Stock Count Reconciled</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Azam Energy Drink 330ml adjusted (+12 cans discovered in pallet B2)</div>
                            </td>
                            <td><span class="status-badge badge-primary">Warehouse Bay</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.60</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-shield-exclamation"></i> Sensitive</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9818" data-time="Today, 20:15:45" data-user="Juma Bakari (Storekeeper)"
                                    data-event="Physical Stock Count Reconciled (+12 units)"
                                    data-module="Stocktake Ledger" data-ip="192.168.1.60" data-severity="Sensitive"
                                    data-payload='{"sku": "BEV-NRG-330", "system_count": 48, "physical_count": 60, "delta": "+12"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 5: High Alert Manual Drawer Open -->
                        <tr data-cat="pos" data-user="Baraka Msuya" data-severity="High Alert">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9817</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 19:40:11</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar">BM</div>
                                    <div>
                                        <div class="fw-semibold">Baraka Msuya</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Cashier #01</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-danger"><i class="bi bi-unlock-fill me-1"></i> Manual Cash Drawer Trigger (No Sale)</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Drawer kicked without active transaction. Reason: Cash Change Exchange</div>
                            </td>
                            <td><span class="status-badge badge-primary">POS Terminal 01</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.102</td>
                            <td><span class="status-badge badge-danger"><i class="bi bi-exclamation-triangle-fill"></i> High Alert</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9817" data-time="Today, 19:40:11" data-user="Baraka Msuya (Cashier)"
                                    data-event="Manual Cash Drawer Trigger (No Active Sale)"
                                    data-module="POS Hardware" data-ip="192.168.1.102" data-severity="High Alert"
                                    data-payload='{"drawer_pin": 12, "reason": "Change breakdown for customer", "balance_before": 894000}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 6: Auth Login Success -->
                        <tr data-cat="auth" data-user="Store Manager" data-severity="Normal">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9816</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 18:22:04</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#f0fdf4;color:#16a34a;">SM</div>
                                    <div>
                                        <div class="fw-semibold">Store Manager</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><i class="bi bi-box-arrow-in-right me-1"></i> Manager Authenticated (2FA Verified)</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Session started from office workstation • Session token #TK-8891</div>
                            </td>
                            <td><span class="status-badge badge-primary">Security Gate</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.50</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle"></i> Normal</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9816" data-time="Today, 18:22:04" data-user="Store Manager (Admin)"
                                    data-event="Manager Authenticated via 2FA"
                                    data-module="Auth Gate" data-ip="192.168.1.50" data-severity="Normal"
                                    data-payload='{"email": "manager@eduka.co.tz", "auth_method": "Passkey/PIN", "status": "Success"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 7: Permission Modified -->
                        <tr data-cat="auth" data-user="Store Manager" data-severity="Sensitive">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9815</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 17:15:20</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#f0fdf4;color:#16a34a;">SM</div>
                                    <div>
                                        <div class="fw-semibold">Store Manager</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-warning"><i class="bi bi-key me-1"></i> Staff Permission Policy Altered</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Role permission 'Allow Item Void' restricted to Supervisor Override</div>
                            </td>
                            <td><span class="status-badge badge-primary">Manager Portal</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.50</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-shield-exclamation"></i> Sensitive</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9815" data-time="Today, 17:15:20" data-user="Store Manager (Admin)"
                                    data-event="Staff Permission Policy Altered"
                                    data-module="Permissions" data-ip="192.168.1.50" data-severity="Sensitive"
                                    data-payload='{"perm_key": "pos_void", "old_val": "all_cashiers", "new_val": "supervisor_only"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 8: Cash Payout (Expenses) -->
                        <tr data-cat="pos" data-user="Baraka Msuya" data-severity="Normal">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9814</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 15:45:10</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar">BM</div>
                                    <div>
                                        <div class="fw-semibold">Baraka Msuya</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Cashier #01</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-warning"><i class="bi bi-cash-stack me-1"></i> Petty Cash Payout Recorded: TSh 45,000</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Expense Category: Store Cleaning Supplies • Voucher #EXP-092</div>
                            </td>
                            <td><span class="status-badge badge-primary">POS Terminal 01</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.102</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle"></i> Normal</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9814" data-time="Today, 15:45:10" data-user="Baraka Msuya (Cashier)"
                                    data-event="Petty Cash Payout Recorded: TSh 45,000"
                                    data-module="Shift Cash Drawer" data-ip="192.168.1.102" data-severity="Normal"
                                    data-payload='{"voucher": "EXP-092", "amount": 45000, "category": "Cleaning Supplies"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 9: Failed Login Attempt -->
                        <tr data-cat="auth" data-user="Baraka Msuya" data-severity="Sensitive">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9813</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 14:10:02</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#fef2f2;color:#dc2626;">??</div>
                                    <div>
                                        <div class="fw-semibold">Unknown Actor</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Terminal #03</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-danger"><i class="bi bi-shield-x me-1"></i> Invalid Cashier Passcode (Attempt 1/3)</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Failed pin attempt on terminal screen. Lockout threshold normal.</div>
                            </td>
                            <td><span class="status-badge badge-primary">POS Terminal 03</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.104</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-shield-exclamation"></i> Sensitive</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9813" data-time="Today, 14:10:02" data-user="Unknown (Terminal #03)"
                                    data-event="Invalid Cashier Passcode Entered"
                                    data-module="Security Gate" data-ip="192.168.1.104" data-severity="Sensitive"
                                    data-payload='{"attempt": 1, "terminal": "Counter 03", "action": "Challenged for PIN"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 10: Damaged Stock Write-off -->
                        <tr data-cat="stock" data-user="Juma Bakari" data-severity="Normal">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9812</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 11:32:15</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#fffbeb;color:#d97706;">JB</div>
                                    <div>
                                        <div class="fw-semibold">Juma Bakari</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Storekeeper</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-danger"><i class="bi bi-trash me-1"></i> Damaged Stock Write-off: 4 Bottles Expired</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Fresh Cow Milk 500ml removed from inventory to waste disposal bin</div>
                            </td>
                            <td><span class="status-badge badge-primary">Warehouse Bay</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.60</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle"></i> Normal</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9812" data-time="Today, 11:32:15" data-user="Juma Bakari (Storekeeper)"
                                    data-event="Damaged Stock Write-off (Fresh Milk x4)"
                                    data-module="Stocktake Ledger" data-ip="192.168.1.60" data-severity="Normal"
                                    data-payload='{"sku": "DRY-MLK-500", "loss_value": 4000, "disposition": "Dispose"}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 11: Shift Z-Report Closed -->
                        <tr data-cat="pos" data-user="Baraka Msuya" data-severity="Normal">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9811</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 09:30:00</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar">BM</div>
                                    <div>
                                        <div class="fw-semibold">Baraka Msuya</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Cashier #01</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-success"><i class="bi bi-receipt-cutoff me-1"></i> Register Shift Closed (Z-Report #091)</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Total cash balanced perfectly: TSh 1,420,000 • Variance: 0 Tsh</div>
                            </td>
                            <td><span class="status-badge badge-primary">POS Terminal 01</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.102</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle"></i> Normal</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9811" data-time="Today, 09:30:00" data-user="Baraka Msuya (Cashier)"
                                    data-event="Register Shift Closed (Z-Report #091)"
                                    data-module="Shift Reconcile" data-ip="192.168.1.102" data-severity="Normal"
                                    data-payload='{"shift_id": "#SHF-2026-091", "sales": 1420000, "variance": 0}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Record 12: Purchase Order Approved -->
                        <tr data-cat="stock" data-user="Store Manager" data-severity="Normal">
                            <td class="font-monospace">
                                <div class="fw-bold">#AUD-9810</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Today, 08:15:22</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar" style="background:#f0fdf4;color:#16a34a;">SM</div>
                                    <div>
                                        <div class="fw-semibold">Store Manager</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><i class="bi bi-cart-check me-1"></i> Purchase Order LPO #LPO-2026-088 Approved</div>
                                <div class="text-muted" style="font-size: 0.74rem;">Supplier: Bakhresa Grain Milling • Total PO Amount: TSh 4,850,000</div>
                            </td>
                            <td><span class="status-badge badge-primary">Manager Portal</span></td>
                            <td class="font-monospace text-muted" style="font-size: 0.76rem;">192.168.1.50</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle"></i> Normal</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-record-btn" title="View Audit Details"
                                    data-ref="#AUD-9810" data-time="Today, 08:15:22" data-user="Store Manager (Admin)"
                                    data-event="Purchase Order LPO-088 Approved"
                                    data-module="Procurement" data-ip="192.168.1.50" data-severity="Normal"
                                    data-payload='{"lpo": "LPO-2026-088", "vendor": "Bakhresa Milling", "value": 4850000}'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Audit Event Details Modal -->
    <div class="modal-overlay" id="auditDetailModal">
        <div class="modal-card">
            <div class="modal-header-custom">
                <div>
                    <h5 class="fw-bold mb-0" id="modalRefTitle">Audit Event Record</h5>
                    <span class="text-muted" style="font-size:0.75rem;" id="modalTimeSubtitle">Timestamp details</span>
                </div>
                <button type="button" class="btn-close close-modal" data-modal="auditDetailModal"></button>
            </div>
            <div class="modal-body-custom">
                <div class="mb-3 p-3 rounded" style="background:var(--nav-active-bg);border:1px solid var(--border-color);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold text-muted" style="font-size:0.78rem;">EVENT TYPE</span>
                        <span id="modalSeverityBadge" class="status-badge badge-primary">Normal</span>
                    </div>
                    <h6 class="fw-bold mb-1" id="modalEventName">Event Name</h6>
                    <div class="text-muted" style="font-size:0.78rem;" id="modalUserMeta">User information</div>
                </div>

                <div class="row g-2 mb-3" style="font-size:0.82rem;">
                    <div class="col-6">
                        <div class="text-muted">Originating Module:</div>
                        <div class="fw-bold" id="modalModule">Module</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted">Client IP Address:</div>
                        <div class="fw-bold font-monospace" id="modalIp">192.168.1.1</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold" style="font-size:0.75rem;text-transform:uppercase;">Cryptographic Payload & Parameters</label>
                    <pre class="p-3 rounded mb-0 font-monospace" id="modalPayload" style="background:var(--nav-active-bg);border:1px solid var(--border-color);font-size:0.75rem;max-height:180px;overflow-y:auto;color:var(--text-dark);"></pre>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-outline-custom close-modal" data-modal="auditDetailModal">Close</button>
                <button type="button" class="btn-dark-custom" id="acknowledgeBtn">
                    <i class="bi bi-check2-all"></i> Mark As Reviewed
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill" style="color:#4ade80"></i>
        <span id="toastNotifyMsg">Audit log action completed!</span>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Theme Toggle with LocalStorage
            let isLight = !$('body').hasClass('dark-mode');
            $('#theme-toggle-btn').on('click', function() {
                isLight = !isLight;
                $('body').toggleClass('dark-mode');
                $('#theme-icon').toggleClass('bi-sun bi-moon-stars');
                localStorage.setItem('theme', $('body').hasClass('dark-mode') ? 'dark' : 'light');
            });

            if (localStorage.getItem('theme') === 'dark') {
                $('body').addClass('dark-mode');
                $('#theme-icon').removeClass('bi-sun').addClass('bi-moon-stars');
            }

            // Dropdown Nav Toggle
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.nav-submenu').toggleClass('open');
            });

            // User Profile Menu
            $('#headerProfileBtn').on('click', function(e) {
                e.stopPropagation();
                $('#profileDropdownMenu').toggleClass('show');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#headerProfileDropdown').length) {
                    $('#profileDropdownMenu').removeClass('show');
                }
            });

            // Filter Tabs
            $('.tab-btn').on('click', function() {
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                const filter = $(this).data('filter');
                filterTable();
            });

            // Dropdown filters
            $('#userFilter, #severityFilter').on('change', function() {
                filterTable();
            });

            // Search input filter
            $('#auditSearchInput').on('keyup', function() {
                filterTable();
            });

            // Cmd+K shortcut
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#auditSearchInput').focus();
                }
            });

            function filterTable() {
                const activeTab = $('.tab-btn.active').data('filter');
                const selectedUser = $('#userFilter').val();
                const selectedSeverity = $('#severityFilter').val();
                const query = $('#auditSearchInput').val().toLowerCase();

                let visibleCount = 0;

                $('#auditTable tbody tr').each(function() {
                    const rowCat = $(this).data('cat');
                    const rowUser = $(this).data('user');
                    const rowSeverity = $(this).data('severity');
                    const rowText = $(this).text().toLowerCase();

                    let matchTab = (activeTab === 'all') || 
                                   (activeTab === 'pos' && rowCat === 'pos') ||
                                   (activeTab === 'stock' && rowCat === 'stock') ||
                                   (activeTab === 'auth' && rowCat === 'auth') ||
                                   (activeTab === 'risk' && rowSeverity === 'High Alert');

                    let matchUser = (selectedUser === 'all') || (rowUser === selectedUser);
                    let matchSeverity = (selectedSeverity === 'all') || (rowSeverity === selectedSeverity);
                    let matchQuery = !query || rowText.includes(query);

                    if (matchTab && matchUser && matchSeverity && matchQuery) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                });

                $('#eventCount').text(visibleCount);
            }

            // Inspect Modal
            $('.view-record-btn').on('click', function() {
                const ref = $(this).data('ref');
                const time = $(this).data('time');
                const user = $(this).data('user');
                const event = $(this).data('event');
                const module = $(this).data('module');
                const ip = $(this).data('ip');
                const severity = $(this).data('severity');
                const payload = $(this).data('payload');

                $('#modalRefTitle').text('Event Record: ' + ref);
                $('#modalTimeSubtitle').text(time);
                $('#modalEventName').text(event);
                $('#modalUserMeta').text('Logged by: ' + user);
                $('#modalModule').text(module);
                $('#modalIp').text(ip);

                let badgeClass = 'badge-primary';
                if (severity === 'Normal') badgeClass = 'badge-success';
                else if (severity === 'Sensitive') badgeClass = 'badge-warning';
                else if (severity === 'High Alert') badgeClass = 'badge-danger';

                $('#modalSeverityBadge').attr('class', 'status-badge ' + badgeClass).text(severity);
                $('#modalPayload').text(JSON.stringify(payload, null, 2));

                $('#auditDetailModal').addClass('show');
            });

            // Close modal
            $('.close-modal').on('click', function() {
                const modalId = $(this).data('modal');
                $('#' + modalId).removeClass('show');
            });

            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).is('.modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });

            // Acknowledge Button
            $('#acknowledgeBtn').on('click', function() {
                $('#auditDetailModal').removeClass('show');
                showToast('Audit record acknowledged and logged as supervisor reviewed!');
            });

            // Run Security Scan
            $('#runAuditScanBtn').on('click', function() {
                showToast('Running comprehensive cryptographic integrity scan on all active registers...');
            });

            // Export Audit Trail
            $('#exportAuditBtn').on('click', function() {
                showToast('Exporting timestamped audit trail spreadsheet (CSV / Excel)...');
            });

            function showToast(msg) {
                $('#toastNotifyMsg').text(msg);
                $('#toastNotify').fadeIn(200).delay(3500).fadeOut(200);
            }
        });
    </script>
</body>
</html>
