<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers - mercanto</title>

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

        /* Sidebar Profile */
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

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
        }

        /* Top Nav Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
        }

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .search-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.45rem 2.5rem 0.45rem 2.2rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            width: 220px;
            outline: none;
            transition: all 0.15s ease;
        }

        .search-input:focus {
            border-color: #a1a1aa;
            width: 280px;
        }

        .search-kbd {
            position: absolute;
            right: 8px;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 1px 6px;
            font-size: 0.7rem;
            color: var(--text-muted);
            font-family: monospace;
        }

        .nav-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: var(--nav-active-bg);
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

        .header-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #18181b;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        body.dark-mode .header-avatar {
            background-color: #f4f4f5;
            color: #18181b;
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
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            margin: 0;
        }

        .page-subtext {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 3px;
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

        .btn-dark-custom:hover {
            opacity: 0.9;
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
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-icon {
            font-size: 1.15rem;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .stat-subtext {
            font-size: 0.78rem;
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
            font-size: 0.75rem;
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
            font-size: 0.85rem;
            color: var(--text-dark);
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            transition: background-color 0.1s ease;
        }

        .custom-table tbody tr:hover td {
            background-color: var(--nav-active-bg);
        }

        .supplier-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
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
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        /* Modals */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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
            border-color: #a1a1aa;
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
                        <h4>mercanto</h4>
                        <span>Manager Panel</span>
                    </div>
                </div>
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
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link active">Suppliers</a></li>
                            <li><a href="{{ url('/manager/customers') }}" class="nav-subitem-link">Customers & Credit</a></li>
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
        <!-- Top Nav Bar -->
        <header class="top-nav-bar">
            <!-- Search Box with Cmd+K -->
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search suppliers, contacts..." id="global-search-input">
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

        <!-- Page Header -->
        <div class="page-header-row">
            <div>
                <h1 class="page-title">Suppliers & Vendors</h1>
                <p class="page-subtext">Manage manufacturer distributor relationships, payment terms, and purchase orders.</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ url('/manager/stock') }}" class="btn-outline-custom">
                    <i class="bi bi-box-seam"></i>
                    <span>Receive Intake (GRN)</span>
                </a>
                <button class="btn-dark-custom" id="addSupplierBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add Supplier</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Active Vendors</span>
                        <i class="bi bi-truck stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">12 Suppliers</div>
                        <div class="stat-subtext">Verified commercial distributors</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Monthly Purchases</span>
                        <i class="bi bi-credit-card-2-front stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">TSh 48.6M</div>
                        <div class="stat-subtext">September 2026 intake volume</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Pending Payables</span>
                        <i class="bi bi-hourglass-split stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">TSh 8.4M</div>
                        <div class="stat-subtext">Due within 15 business days</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">On-Time Fulfillment</span>
                        <i class="bi bi-check-all stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">94.8%</div>
                        <div class="stat-subtext">Average delivery SLA compliance</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suppliers Table Card -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--text-dark);">Vendor Directory</h3>
                <span style="font-size: 0.8rem; color: var(--text-muted);">4 primary wholesale partners</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="suppliersTable">
                    <thead>
                        <tr>
                            <th>Company / Supplier</th>
                            <th>Contact Person</th>
                            <th>Phone & Email</th>
                            <th>Primary Category</th>
                            <th>Payment Terms</th>
                            <th>Payables Due</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="supplier-avatar">BK</div>
                                    <div>
                                        <div style="font-weight: 600;">Said Salim Bakhresa & Co. Ltd</div>
                                        <span style="font-size: 0.74rem; color: var(--text-muted);">TIN: 100-241-890 • Dar es Salaam</span>
                                    </div>
                                </div>
                            </td>
                            <td>Khamis Said (Key Accounts)</td>
                            <td>+255 777 410 099<br><span class="text-muted" style="font-size:0.75rem;">sales@bakhresa.com</span></td>
                            <td><span class="badge bg-light text-dark border">Flour, Juices, Energy Drinks</span></td>
                            <td><span class="status-badge badge-primary">Net 14 Days</span></td>
                            <td><span class="font-monospace text-warning fw-bold">TSh 3,250,000</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-invoices-btn" title="View Invoices & Statement" data-company="Said Salim Bakhresa & Co. Ltd" data-tin="100-241-890" data-contact="Khamis Said" data-terms="Net 14 Days" data-due="3250000"><i class="bi bi-receipt"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="supplier-avatar">MT</div>
                                    <div>
                                        <div style="font-weight: 600;">Mohammed Enterprises (MeTL Group)</div>
                                        <span style="font-size: 0.74rem; color: var(--text-muted);">TIN: 101-382-771 • Morogoro Rd</span>
                                    </div>
                                </div>
                            </td>
                            <td>Farouk Dewji (Distributor Rep)</td>
                            <td>+255 784 990 122<br><span class="text-muted" style="font-size:0.75rem;">orders@metl.net</span></td>
                            <td><span class="badge bg-light text-dark border">Sugar, Cooking Oils, Detergents</span></td>
                            <td><span class="status-badge badge-primary">Net 30 Days</span></td>
                            <td><span class="font-monospace text-warning fw-bold">TSh 4,150,000</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-invoices-btn" title="View Invoices & Statement" data-company="Mohammed Enterprises (MeTL Group)" data-tin="101-382-771" data-contact="Farouk Dewji" data-terms="Net 30 Days" data-due="4150000"><i class="bi bi-receipt"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="supplier-avatar">TF</div>
                                    <div>
                                        <div style="font-weight: 600;">Tanga Fresh Dairy Limited</div>
                                        <span style="font-size: 0.74rem; color: var(--text-muted);">TIN: 104-551-019 • Tanga Depo</span>
                                    </div>
                                </div>
                            </td>
                            <td>Mary Mwambungu</td>
                            <td>+255 715 330 811<br><span class="text-muted" style="font-size:0.75rem;">supply@tangafresh.co.tz</span></td>
                            <td><span class="badge bg-light text-dark border">Fresh Milk, Butter, Yogurt</span></td>
                            <td><span class="status-badge badge-success">Cash on Delivery</span></td>
                            <td><span class="font-monospace text-success fw-bold">TSh 0 (Settled)</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-invoices-btn" title="View Invoices & Statement" data-company="Tanga Fresh Dairy Limited" data-tin="104-551-019" data-contact="Mary Mwambungu" data-terms="Cash on Delivery" data-due="0"><i class="bi bi-receipt"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="supplier-avatar">RG</div>
                                    <div>
                                        <div style="font-weight: 600;">Red Gold Food Products Ltd</div>
                                        <span style="font-size: 0.74rem; color: var(--text-muted);">TIN: 103-990-218 • Arusha</span>
                                    </div>
                                </div>
                            </td>
                            <td>Albert Mallya</td>
                            <td>+255 754 118 765<br><span class="text-muted" style="font-size:0.75rem;">albert@redgold.co.tz</span></td>
                            <td><span class="badge bg-light text-dark border">Tomato Paste, Chutneys, Spices</span></td>
                            <td><span class="status-badge badge-primary">Net 14 Days</span></td>
                            <td><span class="font-monospace text-warning fw-bold">TSh 1,000,000</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-invoices-btn" title="View Invoices & Statement" data-company="Red Gold Food Products Ltd" data-tin="103-990-218" data-contact="Albert Mallya" data-terms="Net 14 Days" data-due="1000000"><i class="bi bi-receipt"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: Add Supplier -->
    <div class="modal-overlay" id="addSupplierModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-truck text-primary" style="font-size: 1.25rem;"></i>
                    <h3 style="margin: 0;">Add New Supplier Vendor</h3>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="addSupplierModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="addSupplierForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Company / Business Name *</label>
                        <input type="text" class="form-control-custom" id="supName" placeholder="e.g. Serengeti Breweries Ltd" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Contact Person *</label>
                            <input type="text" class="form-control-custom" id="supContact" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Phone Number *</label>
                            <input type="text" class="form-control-custom" id="supPhone" placeholder="+255 7..." required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">TIN Number</label>
                            <input type="text" class="form-control-custom" id="supTin" placeholder="100-XXX-XXX">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Payment Terms</label>
                            <select class="form-control-custom" id="supTerms">
                                <option>Cash On Delivery (COD)</option>
                                <option>Net 7 Days</option>
                                <option selected>Net 14 Days</option>
                                <option>Net 30 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Supplied Category *</label>
                        <input type="text" class="form-control-custom" id="supCategory" placeholder="e.g. Beverages & Soft Drinks" required>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="addSupplierModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-circle"></i> Save Vendor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Supplier Statement & Invoices -->
    <div class="modal-overlay" id="supplierInvoicesModal">
        <div class="modal-box" style="max-width: 680px;">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-receipt-cutoff text-primary" style="font-size: 1.25rem;"></i>
                    <div>
                        <h3 style="margin: 0; font-size: 1.05rem;" id="supInvModalTitle">Supplier Account & Invoices</h3>
                        <span class="text-muted" style="font-size: 0.74rem;" id="supInvModalSub">Official Vendor Statement</span>
                    </div>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="supplierInvoicesModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body-custom">
                <div class="d-flex justify-content-between align-items-center p-3 mb-3 rounded" style="background-color: var(--nav-active-bg);">
                    <div>
                        <span class="text-muted" style="font-size: 0.74rem;">Vendor TIN & Contact:</span>
                        <div class="fw-bold font-monospace" style="font-size: 0.85rem;" id="supModalTin">TIN: 100-241-890</div>
                        <div class="text-muted" style="font-size: 0.74rem;" id="supModalContact">Contact: Khamis Said</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted" style="font-size: 0.74rem;">Outstanding Payables Balance:</span>
                        <h5 class="m-0 text-warning font-monospace fw-bold" id="supModalDue">TSh 3,250,000</h5>
                        <span class="badge bg-light text-dark border mt-1" style="font-size: 0.65rem;" id="supModalTerms">Net 14 Days</span>
                    </div>
                </div>

                <h6 style="font-size: 0.82rem; font-weight: 700; margin-bottom: 0.5rem;">Purchase Orders & Deliveries (LPO & GRN)</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered" style="font-size: 0.78rem; margin: 0;">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>PO Ref / Invoice</th>
                                <th>Intake Description</th>
                                <th>Invoice (Tsh)</th>
                                <th>Paid (Tsh)</th>
                                <th>Balance Due</th>
                            </tr>
                        </thead>
                        <tbody id="supInvoicesTableBody">
                            <tr>
                                <td>15 Sep 2026</td>
                                <td><span class="font-monospace fw-bold">#LPO-049</span></td>
                                <td>Azam Wheat Flour 2kg (100 Bales)</td>
                                <td class="font-monospace">4,200,000</td>
                                <td class="font-monospace text-success">2,000,000</td>
                                <td class="font-monospace text-warning fw-bold">2,200,000</td>
                            </tr>
                            <tr>
                                <td>02 Sep 2026</td>
                                <td><span class="font-monospace fw-bold">#LPO-038</span></td>
                                <td>Azam Energy Drinks (50 Crates)</td>
                                <td class="font-monospace">1,050,000</td>
                                <td class="font-monospace text-success">0</td>
                                <td class="font-monospace text-warning fw-bold">1,050,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Record Payment to Supplier Section -->
                <div class="p-3 rounded border" style="background-color: var(--card-bg);">
                    <h6 style="font-size: 0.82rem; font-weight: 700; margin-bottom: 0.5rem;"><i class="bi bi-wallet2 text-success me-1"></i> Record Payment to Vendor (Lipa Muuzaji)</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" class="form-control-custom" id="supPayAmount" placeholder="Enter amount to pay (TSh)" min="1000">
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn-dark-custom w-100 justify-content-center" id="btnPaySupplier"><i class="bi bi-check2-circle"></i> Settle Payment</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-outline-custom" onclick="window.print()"><i class="bi bi-printer"></i> Print Statement</button>
                <button type="button" class="btn-dark-custom close-modal" data-modal="supplierInvoicesModal">Close</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastNotifyMsg">Action performed</span>
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

            // Nav Dropdown Submenus Click Handler (Fixed)
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.nav-submenu').toggleClass('open');
            });

            // Profile Dropdown Toggle
            $('#headerProfileBtn').on('click', function(e) {
                e.stopPropagation();
                $('#headerProfileDropdown').toggleClass('show');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#headerProfileDropdown').length) {
                    $('#headerProfileDropdown').removeClass('show');
                }
            });

            // Cmd+K Shortcut
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#global-search-input').focus();
                }
            });

            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase();
                $('#suppliersTable tbody tr').each(function() {
                    $(this).toggle($(this).text().toLowerCase().includes(term));
                });
            });

            // Open Add Supplier Modal
            $('#addSupplierBtn').on('click', function() {
                $('#addSupplierModal').addClass('show');
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

            // View Supplier Statement & Invoices Workflow
            let activeSupplierRow = null;
            let currentSupDue = 0;

            $(document).on('click', '.view-invoices-btn', function() {
                activeSupplierRow = $(this).closest('tr');
                const company = $(this).data('company') || activeSupplierRow.find('td:first strong').text();
                const tin = $(this).data('tin') || '100-241-890';
                const contact = $(this).data('contact') || 'Sales Representative';
                const terms = $(this).data('terms') || 'Net 14 Days';
                currentSupDue = parseInt($(this).data('due')) || 0;

                $('#supInvModalTitle').text(company + ' - Statement');
                $('#supModalTin').text('TIN: ' + tin);
                $('#supModalContact').text('Contact: ' + contact);
                $('#supModalTerms').text(terms);
                $('#supModalDue').text('TSh ' + currentSupDue.toLocaleString());
                $('#supPayAmount').val('').attr('max', currentSupDue);

                $('#supplierInvoicesModal').addClass('show');
            });

            // Settle Payment to Supplier
            $('#btnPaySupplier').on('click', function() {
                const payAmount = parseInt($('#supPayAmount').val()) || 0;
                if (payAmount <= 0) {
                    alert('Tafadhali weka kiasi halali unachotaka kumlipa muuzaji.');
                    return;
                }

                currentSupDue = Math.max(0, currentSupDue - payAmount);
                $('#supModalDue').text('TSh ' + currentSupDue.toLocaleString());

                if (activeSupplierRow) {
                    activeSupplierRow.find('td:nth-child(6) span')
                        .text(currentSupDue > 0 ? ('TSh ' + currentSupDue.toLocaleString()) : 'TSh 0 (Settled)')
                        .removeClass('text-warning text-danger text-success')
                        .addClass(currentSupDue > 0 ? 'text-warning' : 'text-success');
                    activeSupplierRow.find('.view-invoices-btn').data('due', currentSupDue);
                }

                $('#supPayAmount').val('');
                showToast(`Payment of TSh ${payAmount.toLocaleString()} recorded and remitted to supplier!`);
            });

            // Add Supplier Form Submit
            $('#addSupplierForm').on('submit', function(e) {
                e.preventDefault();
                const name = $('#supName').val();
                const contact = $('#supContact').val();
                const phone = $('#supPhone').val();
                const tin = $('#supTin').val() || 'TIN: Pending';
                const terms = $('#supTerms').val();
                const cat = $('#supCategory').val();
                const initials = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();

                const newRow = `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="supplier-avatar">${initials}</div>
                                <div>
                                    <div style="font-weight: 600;">${name}</div>
                                    <span style="font-size: 0.74rem; color: var(--text-muted);">${tin}</span>
                                </div>
                            </div>
                        </td>
                        <td>${contact}</td>
                        <td>${phone}</td>
                        <td><span class="badge bg-light text-dark border">${cat}</span></td>
                        <td><span class="status-badge badge-primary">${terms}</span></td>
                        <td><span class="font-monospace text-success fw-bold">TSh 0 (New)</span></td>
                        <td style="text-align: right;">
                            <button class="action-icon-btn view-invoices-btn" title="View Invoices & Statement" data-company="${name}" data-tin="${tin}" data-contact="${contact}" data-terms="${terms}" data-due="0"><i class="bi bi-receipt"></i></button>
                        </td>
                    </tr>
                `;

                $('#suppliersTable tbody').prepend(newRow);

                $('#addSupplierModal').removeClass('show');
                this.reset();
                showToast(`Vendor partner "${name}" registered successfully!`);
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
