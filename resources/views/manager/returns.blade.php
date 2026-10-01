<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns & Refunds - mercanto</title>

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
            --badge-info-bg: #eff6ff;
            --badge-info-text: #2563eb;
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
            --badge-info-bg: #172554;
            --badge-info-text: #60a5fa;
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
        }

        .workspace-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.6rem;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 1.25rem;
        }

        .workspace-header:hover { background-color: var(--nav-active-bg); }

        .workspace-brand { display: flex; align-items: center; gap: 12px; }

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

        body.dark-mode .workspace-icon { color: #09090b; }

        .workspace-info h4 {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
        }

        .workspace-info span { font-size: 0.75rem; color: var(--text-muted); }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 1rem 0 0.4rem 0.6rem;
            letter-spacing: 0.3px;
        }

        .nav-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }

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

        .nav-item-link:hover { background-color: var(--nav-active-bg); color: var(--text-dark); }
        .nav-item-link.active { background-color: var(--nav-active-bg); color: var(--text-dark); font-weight: 600; }

        .nav-item-left { display: flex; align-items: center; gap: 10px; }
        .nav-item-left i { font-size: 1.02rem; color: var(--text-muted); }
        .nav-item-link.active .nav-item-left i { color: var(--text-dark); }

        .nav-dropdown-toggle { cursor: pointer; user-select: none; }
        .nav-chevron { transition: transform 0.2s ease; font-size: 0.75rem; color: var(--text-muted); }
        .nav-dropdown-toggle.open .nav-chevron { transform: rotate(90deg); color: var(--text-dark); }

        .nav-submenu {
            list-style: none;
            padding: 0.2rem 0 0.2rem 0.85rem;
            margin: 2px 0 4px 0.85rem;
            display: none;
            flex-direction: column;
            gap: 2px;
            border-left: 1px solid var(--border-color);
        }

        .nav-submenu.open { display: flex; }

        .nav-subitem-link {
            display: block;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 500;
        }

        .nav-subitem-link:hover, .nav-subitem-link.active {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
            font-weight: 600;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem;
            border-radius: 8px;
            border-top: 1px solid var(--border-color);
            padding-top: 0.85rem;
            cursor: pointer;
        }

        .profile-avatar {
            width: 34px; height: 34px;
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

        .profile-info { display: flex; flex-direction: column; line-height: 1.2; }
        .profile-name { font-size: 0.84rem; font-weight: 600; color: var(--text-dark); }
        .profile-email { font-size: 0.72rem; color: var(--text-muted); }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .header-search-box { position: relative; width: 280px; }
        .search-input {
            width: 100%;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.45rem 2.2rem 0.45rem 2rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            outline: none;
        }

        .search-icon {
            position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 0.85rem;
        }

        .search-kbd {
            position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%);
            font-size: 0.68rem; font-weight: 600;
            background-color: var(--nav-active-bg);
            color: var(--text-muted);
            padding: 2px 5px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
        }

        .nav-icon-btn {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            cursor: pointer;
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

        .page-subtext { font-size: 0.84rem; color: var(--text-muted); margin-top: 2px; }

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
        }

        body.dark-mode .btn-dark-custom { color: #09090b; }

        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.2rem 1.3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .stat-label { font-size: 0.82rem; font-weight: 500; color: var(--text-muted); }
        .stat-icon { font-size: 1.1rem; color: var(--text-muted); }
        .stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-dark); letter-spacing: -0.5px; }
        .stat-footer { font-size: 0.74rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }

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

        .filter-tabs { display: flex; align-items: center; gap: 6px; background-color: var(--nav-active-bg); padding: 4px; border-radius: 8px; }
        .filter-tab {
            padding: 0.35rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            border-radius: 6px;
            border: none;
            background: transparent;
            cursor: pointer;
        }
        .filter-tab.active { background-color: var(--card-bg); color: var(--text-dark); font-weight: 600; }

        .custom-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .custom-table th {
            font-size: 0.74rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px;
            color: var(--text-muted); padding: 0.75rem 1rem; border-bottom: 1px solid var(--border-color);
            background-color: var(--card-bg); text-align: left;
        }
        .custom-table td {
            font-size: 0.84rem; color: var(--text-dark); padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border-color); vertical-align: middle;
        }
        .custom-table tbody tr:hover td { background-color: var(--nav-active-bg); }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.74rem; font-weight: 600; padding: 3px 8px; border-radius: 9999px;
        }

        .badge-danger { background-color: var(--badge-danger-bg); color: var(--badge-danger-text); }
        .badge-warning { background-color: var(--badge-warning-bg); color: var(--badge-warning-text); }
        .badge-success { background-color: var(--badge-success-bg); color: var(--badge-success-text); }
        .badge-info, .badge-primary { background-color: var(--badge-info-bg); color: var(--badge-info-text); }

        .action-icon-btn {
            background: transparent; border: 1px solid var(--border-color); border-radius: 6px;
            width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;
            color: var(--text-muted); cursor: pointer;
        }
        .action-icon-btn:hover { color: var(--text-dark); background-color: var(--nav-active-bg); }

        /* Modal */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(4px);
            z-index: 1050; display: none; align-items: center; justify-content: center; padding: 1rem;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background-color: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 14px; width: 100%; max-width: 540px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .modal-header-custom {
            padding: 1.2rem 1.4rem; border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-header-custom h3 { font-size: 1.05rem; font-weight: 700; margin: 0; }
        .modal-body-custom { padding: 1.25rem 1.4rem; max-height: 70vh; overflow-y: auto; }
        .modal-footer-custom {
            padding: 1rem 1.4rem; border-top: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        }
        .form-label-custom { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.35rem; display: block; }
        .form-control-custom {
            width: 100%; background-color: var(--input-bg); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 0.5rem 0.8rem; font-size: 0.86rem; color: var(--text-dark); outline: none;
        }

        .toast-notify {
            position: fixed; bottom: 2rem; right: 2rem; background-color: var(--primary-btn);
            color: #ffffff; padding: 0.75rem 1.25rem; border-radius: 10px; display: none;
            align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; z-index: 2000;
        }
        body.dark-mode .toast-notify { color: #09090b; }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div>
            <div class="workspace-header" title="Mercanto Store Manager">
                <div class="workspace-brand">
                    <div class="workspace-icon"><i class="bi bi-shop"></i></div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>Manager Panel</span>
                    </div>
                </div>
                <i class="bi bi-chevron-expand text-muted" style="font-size: 0.9rem;"></i>
            </div>

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
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left"><i class="bi bi-arrow-left-right"></i><span>Operations</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu open">
                            <li><a href="{{ url('/manager/shifts') }}" class="nav-subitem-link">Shift & Cash Register</a></li>
                            <li><a href="{{ url('/manager/returns') }}" class="nav-subitem-link active">Returns & Refunds</a></li>
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

                    <!-- Dropdown: Auditing -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left"><i class="bi bi-shield-check"></i><span>Auditing</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/auditing') }}" class="nav-subitem-link">Activity Logs</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">Stock Audit & Wastage</a></li>
                            <li><a href="{{ url('/manager/auditing?tab=alerts') }}" class="nav-subitem-link">Audit Trail & Alerts</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">Auditing Settings & Roles</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

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
        <header class="top-nav-bar">
            <!-- Search Box with Cmd+K -->
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search return orders or invoices..." id="global-search-input">
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

        <div class="page-header-row">
            <div>
                <h1 class="page-title">Returns, Refunds & Exchanges</h1>
                <p class="page-subtext">Process returned goods from customers, issue cash refunds, vouchers, or product exchanges.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-dark-custom" id="createReturnBtn">
                    <i class="bi bi-arrow-return-left"></i> New Return Request
                </button>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Returns (Month)</span>
                        <i class="bi bi-arrow-repeat stat-icon text-warning"></i>
                    </div>
                    <div class="stat-value text-warning">14 Orders</div>
                    <div class="stat-footer">
                        <span>0.8% of total monthly sales</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Refund Value</span>
                        <i class="bi bi-currency-exchange stat-icon text-danger"></i>
                    </div>
                    <div class="stat-value text-danger">Tsh 385,000</div>
                    <div class="stat-footer">
                        <span>Paid out in cash & vouchers</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Restocked to Inventory</span>
                        <i class="bi bi-box-arrow-in-down-left stat-icon text-success"></i>
                    </div>
                    <div class="stat-value text-success">11 Items</div>
                    <div class="stat-footer">
                        <span>Inspected & returned to shelf</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Written Off (Damaged)</span>
                        <i class="bi bi-trash stat-icon text-danger"></i>
                    </div>
                    <div class="stat-value text-danger">3 Items</div>
                    <div class="stat-footer">
                        <span>Sent to damaged goods ledger</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Returns Table -->
        <div class="content-card">
            <div class="card-toolbar">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">All Returns (14)</button>
                    <button class="filter-tab" data-filter="restocked">Restocked (11)</button>
                    <button class="filter-tab" data-filter="damaged">Damaged/Waste (3)</button>
                </div>
                <span class="text-muted" style="font-size: 0.8rem;">Showing recent returns</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="returnsTable">
                    <thead>
                        <tr>
                            <th>Return Ref / Date</th>
                            <th>Original Invoice</th>
                            <th>Customer Name</th>
                            <th>Item Returned</th>
                            <th>Reason</th>
                            <th>Item Condition</th>
                            <th>Refund Method</th>
                            <th>Refund Amount</th>
                            <th>Status</th>
                            <th class="text-end">Voucher</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-filter="restocked">
                            <td>
                                <strong>#RET-2026-042</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">23 Sep 2026, 11:20</span>
                            </td>
                            <td><span class="font-monospace">#INV-9410</span></td>
                            <td>Fatma Salim</td>
                            <td>
                                <strong>Super Basmati Rice 5kg</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">Qty: 1 Bag</span>
                            </td>
                            <td>Wrong Item Taken</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check2"></i> Good (Restocked)</span></td>
                            <td>Store Voucher</td>
                            <td class="font-monospace font-bold">Tsh 22,000</td>
                            <td><span class="status-badge badge-success">Completed</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn view-voucher-btn" title="Tazama / Chapisha Vocha ya Duka" data-code="VCHR-9812-44" data-amt="22,000" data-cust="Fatma Salim" data-inv="#INV-9410" data-type="Store Credit Voucher"><i class="bi bi-ticket-perforated"></i></button>
                            </td>
                        </tr>
                        <tr data-filter="damaged">
                            <td>
                                <strong>#RET-2026-041</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">22 Sep 2026, 16:45</span>
                            </td>
                            <td><span class="font-monospace">#INV-9388</span></td>
                            <td>Hamis Baraka</td>
                            <td>
                                <strong>Brookside Milk 1L Pack</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">Qty: 2 Packets</span>
                            </td>
                            <td>Leaking / Defective Cap</td>
                            <td><span class="status-badge badge-danger"><i class="bi bi-x-circle"></i> Damaged (Disposed)</span></td>
                            <td>Cash Refund</td>
                            <td class="font-monospace font-bold text-danger">Tsh 7,600</td>
                            <td><span class="status-badge badge-success">Refunded</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn view-voucher-btn" title="Tazama / Chapisha Vocha ya Fedha Taslimu" data-code="REF-CASH-7600" data-amt="7,600" data-cust="Hamis Baraka" data-inv="#INV-9388" data-type="Cash Refund Voucher"><i class="bi bi-cash"></i></button>
                            </td>
                        </tr>
                        <tr data-filter="restocked">
                            <td>
                                <strong>#RET-2026-040</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">21 Sep 2026, 09:10</span>
                            </td>
                            <td><span class="font-monospace">#INV-9290</span></td>
                            <td>Salum Omar</td>
                            <td>
                                <strong>Kangaroo Cooking Oil 5L</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">Qty: 1 Gallon</span>
                            </td>
                            <td>Exchange for Sunflower Oil</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check2"></i> Good (Restocked)</span></td>
                            <td>Product Exchange</td>
                            <td class="font-monospace font-bold">Tsh 34,000</td>
                            <td><span class="status-badge badge-info">Exchanged</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn view-voucher-btn" title="Tazama / Chapisha Vocha ya Kubadilishana Bidhaa" data-code="EXC-2026-040" data-amt="34,000" data-cust="Salum Omar" data-inv="#INV-9290" data-type="Exchange Credit Note"><i class="bi bi-arrow-left-right"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: New Return Request -->
    <div class="modal-overlay" id="createReturnModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>New Customer Return / Exchange</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="createReturnModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="createReturnForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Receipt / Invoice Number *</label>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control-custom" placeholder="e.g. INV-9410" required>
                            <button type="button" class="btn-outline-custom" id="verifyInvBtn"><i class="bi bi-search"></i> Check</button>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Customer Name</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. John Doe">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Customer Phone</label>
                            <input type="text" class="form-control-custom" placeholder="+255 7...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Select Product Being Returned</label>
                        <select class="form-control-custom">
                            <option>Super Basmati Rice 5kg (Tsh 22,000)</option>
                            <option>Brookside Fresh Milk 1L (Tsh 3,800)</option>
                            <option>Kangaroo Cooking Oil 5L (Tsh 34,000)</option>
                            <option>Other / Unlisted Item</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Return Quantity *</label>
                            <input type="number" class="form-control-custom" value="1" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Item Condition & Stoo Action</label>
                            <select class="form-control-custom">
                                <option value="restock">Good -> Restock to Shelves</option>
                                <option value="waste">Damaged -> Write-off (Hasara)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Reason for Return</label>
                        <select class="form-control-custom">
                            <option>Wrong Item Purchased / Customer Mind Change</option>
                            <option>Defective / Factory Fault</option>
                            <option>Expired or Near Expiry</option>
                            <option>Damaged Packaging</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Resolution / Refund Type</label>
                            <select class="form-control-custom">
                                <option>Store Credit Voucher (Kuponi)</option>
                                <option>Cash Refund (Pesa Taslimu)</option>
                                <option>Product Exchange (Badilisha Bidhaa)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Refund Amount (Tsh)</label>
                            <input type="number" class="form-control-custom" value="22000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="createReturnModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-circle"></i> Approve & Issue Refund</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: View Voucher / Credit Note -->
    <div class="modal-overlay" id="voucherModal">
        <div class="modal-box" style="max-width: 440px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);">
            <div class="modal-header-custom d-flex justify-content-between align-items-center p-3 border-bottom" style="background:#ffffff;">
                <h3 style="font-size:0.95rem; font-weight:700; margin:0; display:flex; align-items:center; gap:6px;">
                    <i class="bi bi-ticket-perforated text-primary"></i> Hati ya Mkopo / Vocha (TRA Credit Note)
                </h3>
                <button type="button" class="btn-close close-modal" data-modal="voucherModal" aria-label="Funga"></button>
            </div>
            <div class="modal-body-custom" style="padding:0; background:#ffffff;">
                <div id="voucherReceiptPrintArea" class="thermal-receipt-paper" style="background:#ffffff; color:#000000; padding:20px 18px; font-family:'Courier New', Courier, monospace; font-size:12px; line-height:1.35; max-height:65vh; overflow-y:auto;">
                    <div class="text-center mb-2">
                        <h5 style="margin:0; font-weight:800; font-size:14px; letter-spacing:0.5px; color:#000000;">
                            {{ session('tenant_name') ? strtoupper(session('tenant_name')) : 'MERCANTO SUPERMARKET & WHOLESALE' }}
                        </h5>
                        <div style="font-size:11px;">Kariakoo Branch, Msimbazi Street</div>
                        <div style="font-size:11px;">Dar es Salaam, Tanzania</div>
                        <div style="font-size:11px;">Simu: +255 754 123 456</div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div style="font-size:11px; font-weight:700;">TIN: 142-998-310 | VRN: 40019283-Z</div>
                        <div style="font-size:11px;">EFD Serial: TZ-EFD-88219</div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div style="font-weight:800; font-size:13px; letter-spacing:0.5px;" id="vchrDocTitle">TRA CREDIT NOTE / STORE VOUCHER</div>
                        <div style="font-size:10px;">(NOTI YA MKOPO / REJESHO LA BIDHAA)</div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                    </div>
                    <div style="font-size:11px;">
                        <div class="d-flex justify-content-between">
                            <span>Tarehe:</span>
                            <span id="vchrDate">27/09/2026 09:15 PM</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Namba ya Vocha:</span>
                            <strong class="font-monospace" id="vchrCode">VCHR-9812-44</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Rejea ya Resiti (Inv):</span>
                            <strong class="font-monospace" id="vchrInv">#INV-9410</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Mteja:</span>
                            <strong id="vchrCust">Fatma Salim</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Aina ya Malipo:</span>
                            <span id="vchrType">Store Credit Voucher</span>
                        </div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div class="d-flex justify-content-between" style="font-size:13px; font-weight:800; border-top:1px solid #000; margin-top:4px; padding-top:4px;">
                            <span>KIASI CHA MKOPO / REJESHO:</span>
                            <span class="font-monospace" id="vchrAmt" style="color:#059669;">TSh 22,000</span>
                        </div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div class="text-center mt-2" style="font-size:10px;">
                            <div>Mteja anaweza kutumia namba hii kulipia ununuzi wake POS.</div>
                            <div style="font-weight:700; margin-top:4px;">TRA EFD FISCAL VERIFIED</div>
                            <div>Uthibitisho: 9A48-E71B-33C9-92F1</div>
                            <div style="letter-spacing:1px; margin:4px 0; font-weight:bold;">[ ||||||||||||||||||||||||||||||||||||||||||| ]</div>
                            <div style="font-weight:700; margin-top:4px;">*** ASANTE NA KARIBU TENA! ***</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 p-3 border-top no-print" style="background:#f8fafc;">
                <button type="button" class="btn btn-outline-secondary flex-fill btn-sm py-2 fw-semibold close-modal" data-modal="voucherModal" style="border-radius:10px; font-size:0.85rem;">
                    <i class="bi bi-x-circle me-1"></i> Funga
                </button>
                <button type="button" class="btn btn-primary flex-fill btn-sm py-2 fw-semibold" id="btnPrintVoucher" style="border-radius:10px; font-size:0.85rem; background:#0d6efd; border-color:#0d6efd;">
                    <i class="bi bi-printer me-1"></i> Chapisha Vocha
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastNotifyMsg">Action performed</span>
    </div>

    <script>
        $(document).ready(function() {
            let isLight = true;
            $('#theme-toggle-btn').on('click', function() {
                isLight = !isLight;
                $('body').toggleClass('dark-mode');
                $('#theme-icon').toggleClass('bi-sun bi-moon-stars');
            });

            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.nav-submenu').toggleClass('open');
            });

            $('#createReturnBtn').on('click', function() { $('#createReturnModal').addClass('show'); });

            $('.view-voucher-btn').on('click', function() {
                const code = $(this).data('code') || 'VCHR-9812-44';
                const amt = $(this).data('amt') || '0';
                const cust = $(this).data('cust') || 'Mteja';
                const inv = $(this).data('inv') || '#INV-9410';
                const type = $(this).data('type') || 'Store Credit Voucher';

                $('#vchrCode').text(code);
                $('#vchrAmt').text('TSh ' + amt);
                $('#vchrCust').text(cust);
                $('#vchrInv').text(inv);
                $('#vchrType').text(type);
                $('#voucherModal').addClass('show');
            });

            // Thermal Print Voucher / Credit Note Driver
            $('#btnPrintVoucher').off('click').on('click', function() {
                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Inachapisha...');
                if (typeof printThermalReceiptDirect === 'function') {
                    printThermalReceiptDirect('voucherReceiptPrintArea');
                } else {
                    window.print();
                }
                setTimeout(function() {
                    $btn.html('<i class="bi bi-check-circle-fill me-1"></i> Imechapishwa!');
                    setTimeout(function() {
                        $btn.prop('disabled', false).html(originalHtml);
                    }, 2000);
                }, 800);
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

            $('.filter-tab').on('click', function() {
                $('.filter-tab').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                if (filter === 'all') {
                    $('#returnsTable tbody tr').show();
                } else {
                    $('#returnsTable tbody tr').each(function() {
                        $(this).toggle($(this).data('filter') === filter);
                    });
                }
            });

            $('#verifyInvBtn').on('click', function() {
                showToast('Invoice #INV-9410 verified! Customer: Fatma Salim (Purchased 2 days ago)');
            });

            $('#createReturnForm').on('submit', function(e) {
                e.preventDefault();
                $('#createReturnModal').removeClass('show');
                showToast('Return approved and stock/refund processed successfully!');
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
                toast.stop(true, true).fadeIn(180).delay(3000).fadeOut(200);
            }
        });
    </script>

    @include('partials.receipt_modal')
</body>
</html>
