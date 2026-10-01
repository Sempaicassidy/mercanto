<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Orders (LPO & GRN) - mercanto</title>

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

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body { background-color: var(--bg-page); color: var(--text-dark); min-height: 100vh; display: flex; transition: background-color 0.2s ease, color 0.2s ease; }

        .sidebar {
            width: 260px; background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color);
            display: flex; flex-direction: column; justify-content: space-between; min-height: 100vh;
            padding: 1.25rem 1rem; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }

        .workspace-header {
            display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.6rem;
            border-radius: 8px; cursor: pointer; margin-bottom: 1.25rem;
        }
        .workspace-header:hover { background-color: var(--nav-active-bg); }
        .workspace-brand { display: flex; align-items: center; gap: 12px; }
        .workspace-icon {
            width: 36px; height: 36px; background-color: var(--primary-btn); color: #ffffff;
            border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
        }
        body.dark-mode .workspace-icon { color: #09090b; }
        .workspace-info h4 { font-size: 0.92rem; font-weight: 700; color: var(--text-dark); margin: 0; line-height: 1.2; }
        .workspace-info span { font-size: 0.75rem; color: var(--text-muted); }

        .nav-section-title { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); margin: 1rem 0 0.4rem 0.6rem; letter-spacing: 0.3px; }
        .nav-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }

        .nav-item-link {
            display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.75rem;
            border-radius: 8px; text-decoration: none; color: var(--text-muted); font-size: 0.86rem;
            font-weight: 500; transition: all 0.15s ease;
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
            list-style: none; padding: 0.2rem 0 0.2rem 0.85rem; margin: 2px 0 4px 0.85rem;
            display: none; flex-direction: column; gap: 2px; border-left: 1px solid var(--border-color);
        }
        .nav-submenu.open { display: flex; }
        .nav-subitem-link {
            display: block; padding: 0.35rem 0.75rem; border-radius: 6px; text-decoration: none;
            color: var(--text-muted); font-size: 0.82rem; font-weight: 500;
        }
        .nav-subitem-link:hover, .nav-subitem-link.active { color: var(--text-dark); background-color: var(--nav-active-bg); font-weight: 600; }

        .sidebar-profile {
            display: flex; align-items: center; justify-content: space-between; padding: 0.6rem;
            border-radius: 8px; border-top: 1px solid var(--border-color); padding-top: 0.85rem; cursor: pointer;
        }
        .profile-avatar {
            width: 34px; height: 34px; border-radius: 50%; background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color); color: var(--text-dark); display: flex;
            align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; margin-right: 10px;
        }
        .profile-info { display: flex; flex-direction: column; line-height: 1.2; }
        .profile-name { font-size: 0.84rem; font-weight: 600; color: var(--text-dark); }
        .profile-email { font-size: 0.72rem; color: var(--text-muted); }

        .main-wrapper { margin-left: 260px; flex: 1; padding: 1.75rem 2.25rem; width: calc(100% - 260px); min-height: 100vh; }

        .top-nav-bar { display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-bottom: 1.5rem; }
        .header-search-box { position: relative; width: 280px; }
        .search-input {
            width: 100%; background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 0.45rem 2.2rem 0.45rem 2rem; font-size: 0.85rem; color: var(--text-dark); outline: none;
        }
        .search-icon { position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem; }
        .search-kbd {
            position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); font-size: 0.68rem;
            font-weight: 600; background-color: var(--nav-active-bg); color: var(--text-muted); padding: 2px 5px;
            border-radius: 4px; border: 1px solid var(--border-color);
        }
        .nav-icon-btn {
            background-color: var(--card-bg); border: 1px solid var(--border-color); width: 36px; height: 36px;
            border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-dark); cursor: pointer;
        }

        .branch-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.75rem;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-dark);
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

        .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .page-title { font-size: 1.55rem; font-weight: 700; color: var(--text-dark); letter-spacing: -0.5px; margin: 0; }
        .page-subtext { font-size: 0.84rem; color: var(--text-muted); margin-top: 2px; }

        .btn-outline-custom {
            display: inline-flex; align-items: center; gap: 6px; padding: 0.45rem 0.85rem;
            background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 8px;
            color: var(--text-dark); font-size: 0.84rem; font-weight: 500; text-decoration: none; cursor: pointer;
        }
        .btn-dark-custom {
            display: inline-flex; align-items: center; gap: 6px; padding: 0.45rem 1rem;
            background-color: var(--primary-btn); color: #ffffff; border: 1px solid var(--primary-btn);
            border-radius: 8px; font-size: 0.84rem; font-weight: 600; text-decoration: none; cursor: pointer;
        }
        body.dark-mode .btn-dark-custom { color: #09090b; }

        .stat-card {
            background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px;
            padding: 1.2rem 1.3rem; display: flex; flex-direction: column; justify-content: space-between; min-height: 120px;
        }
        .stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
        .stat-label { font-size: 0.82rem; font-weight: 500; color: var(--text-muted); }
        .stat-icon { font-size: 1.1rem; color: var(--text-muted); }
        .stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-dark); letter-spacing: -0.5px; }
        .stat-footer { font-size: 0.74rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }

        .content-card { background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; overflow: hidden; margin-top: 1.5rem; }
        .card-toolbar {
            padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;
        }

        .filter-tabs { display: flex; align-items: center; gap: 6px; background-color: var(--nav-active-bg); padding: 4px; border-radius: 8px; }
        .filter-tab {
            padding: 0.35rem 0.8rem; font-size: 0.8rem; font-weight: 500; color: var(--text-muted);
            border-radius: 6px; border: none; background: transparent; cursor: pointer;
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

        .status-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 0.74rem; font-weight: 600; padding: 3px 8px; border-radius: 9999px; }
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

        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(4px);
            z-index: 1050; display: none; align-items: center; justify-content: center; padding: 1rem;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background-color: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 14px; width: 100%; max-width: 620px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .modal-header-custom { padding: 1.2rem 1.4rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; }
        .modal-header-custom h3 { font-size: 1.05rem; font-weight: 700; margin: 0; }
        .modal-body-custom { padding: 1.25rem 1.4rem; max-height: 70vh; overflow-y: auto; }
        .modal-footer-custom { padding: 1rem 1.4rem; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: flex-end; gap: 10px; }
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
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left"><i class="bi bi-box-seam"></i><span>Manage Store</span></span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu open">
                            <li><a href="{{ url('/manager/stock') }}" class="nav-subitem-link">Products & Stock</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">POS / Cashier</a></li>
                            <li><a href="{{ url('/manager/category') }}" class="nav-subitem-link">Categories</a></li>
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link">Suppliers</a></li>
                            <li><a href="{{ url('/manager/customers') }}" class="nav-subitem-link">Customers & Credit</a></li>
                            <li><a href="{{ url('/manager/purchases') }}" class="nav-subitem-link active">Purchase Orders (LPO)</a></li>
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
            <div style="display: flex; align-items: center;">
                <div class="profile-avatar">MN</div>
                <div class="profile-info">
                    <span class="profile-name">Store Manager</span>
                    <span class="profile-email">manager@eduka.co.tz</span>
                </div>
            </div>
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); font-size: 1.1rem; text-decoration: none; padding: 4px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.color='var(--text-dark)'; this.style.backgroundColor='var(--nav-hover-bg)';" onmouseout="this.style.color='var(--text-muted)'; this.style.backgroundColor='transparent';">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-wrapper">
        <header class="top-nav-bar">
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search purchase orders or LPO..." id="global-search-input">
                <span class="search-kbd">⌘ K</span>
            </div>

            <!-- Branch Indicator Pill -->
            <div class="branch-pill">
                <span style="width: 7px; height: 7px; background-color: #10b981; border-radius: 50%; display: inline-block;"></span>
                <span>Main Branch (HQ)</span>
            </div>

            <!-- Universal Role Switcher Component -->
            @include('partials.role_switcher')

            <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme">
                <i class="bi bi-moon-stars" id="theme-icon"></i>
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
        </header>

        <div class="page-header-row">
            <div>
                <h1 class="page-title">Purchase Orders (LPO & GRN)</h1>
                <p class="page-subtext">Draft official Local Purchase Orders (LPO) to vendors, receive shipments with Goods Received Notes (GRN), and manage payables.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-dark-custom" id="createPoBtn">
                    <i class="bi bi-file-earmark-plus-fill"></i> Create Purchase Order (LPO)
                </button>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Active Orders Awaiting Delivery</span>
                        <i class="bi bi-hourglass-split stat-icon text-warning"></i>
                    </div>
                    <div class="stat-value text-warning">4 Orders</div>
                    <div class="stat-footer">
                        <span>Expected within 3-5 days</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Monthly Purchases (Tsh)</span>
                        <i class="bi bi-cart-check stat-icon text-primary"></i>
                    </div>
                    <div class="stat-value text-primary">Tsh 18,450,000</div>
                    <div class="stat-footer">
                        <span>12 Completed shipments</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Supplier Payables (Madeni Yetu)</span>
                        <i class="bi bi-credit-card stat-icon text-danger"></i>
                    </div>
                    <div class="stat-value text-danger">Tsh 4,800,000</div>
                    <div class="stat-footer">
                        <span>To be paid under Net 30 terms</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Approved Suppliers</span>
                        <i class="bi bi-truck stat-icon text-success"></i>
                    </div>
                    <div class="stat-value text-success">18 Vendors</div>
                    <div class="stat-footer">
                        <span>Bakhresa, TBL, Bonite, etc.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Orders Table -->
        <div class="content-card">
            <div class="card-toolbar">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">All LPOs (16)</button>
                    <button class="filter-tab" data-filter="pending">Pending GRN (4)</button>
                    <button class="filter-tab" data-filter="received">Fully Received (12)</button>
                </div>
                <span class="text-muted" style="font-size: 0.8rem;">Official Procurement Orders</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="poTable">
                    <thead>
                        <tr>
                            <th>PO Reference / Date</th>
                            <th>Supplier / Vendor</th>
                            <th>Items & Categories</th>
                            <th>Total Order Value</th>
                            <th>Delivery Due</th>
                            <th>Payment Terms</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-filter="pending">
                            <td>
                                <strong>#LPO-2026-049</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">22 Sep 2026</span>
                            </td>
                            <td>
                                <strong>Bakhresa Food Products Ltd</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">TIN: 100-291-882</span>
                            </td>
                            <td>Azam Flour 2kg (100 Bales), Sembe 5kg (50 Bags)</td>
                            <td class="font-monospace font-bold">Tsh 4,200,000</td>
                            <td>25 Sep 2026</td>
                            <td>Net 14 Days</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-clock"></i> Sent / Awaiting GRN</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn grn-btn" title="Receive Shipment & Generate GRN" data-lpo="LPO-2026-049" data-vendor="Bakhresa Food Products Ltd"><i class="bi bi-box-seam"></i></button>
                                <button class="action-icon-btn view-lpo-btn" title="Print Official LPO" data-lpo="LPO-2026-049"><i class="bi bi-printer"></i></button>
                            </td>
                        </tr>
                        <tr data-filter="pending">
                            <td>
                                <strong>#LPO-2026-048</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">21 Sep 2026</span>
                            </td>
                            <td>
                                <strong>Bonite Bottlers Ltd</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">TIN: 104-551-900</span>
                            </td>
                            <td>Coca-Cola 350ml (50 Crates), Fanta Orange (30 Crates)</td>
                            <td class="font-monospace font-bold">Tsh 1,440,000</td>
                            <td>24 Sep 2026</td>
                            <td>Cash on Delivery (COD)</td>
                            <td><span class="status-badge badge-info"><i class="bi bi-truck"></i> Out for Delivery</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn grn-btn" title="Receive Shipment & Generate GRN" data-lpo="LPO-2026-048" data-vendor="Bonite Bottlers Ltd"><i class="bi bi-box-seam"></i></button>
                                <button class="action-icon-btn view-lpo-btn" title="Print Official LPO" data-lpo="LPO-2026-048"><i class="bi bi-printer"></i></button>
                            </td>
                        </tr>
                        <tr data-filter="received">
                            <td>
                                <strong>#LPO-2026-047</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">18 Sep 2026</span>
                            </td>
                            <td>
                                <strong>Serengeti Breweries Ltd</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">TIN: 101-778-994</span>
                            </td>
                            <td>Malt Beverages & Soft Drinks (80 Crates)</td>
                            <td class="font-monospace font-bold">Tsh 3,120,000</td>
                            <td>20 Sep 2026</td>
                            <td>Net 30 Days</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check2-all"></i> GRN Completed</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn view-lpo-btn" title="View Completed Order" data-lpo="LPO-2026-047"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: Create New Purchase Order -->
    <div class="modal-overlay" id="createPoModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Create Local Purchase Order (LPO)</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="createPoModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="createPoForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Select Supplier / Vendor *</label>
                        <select class="form-control-custom" required>
                            <option>Bakhresa Food Products Ltd</option>
                            <option>Bonite Bottlers Ltd</option>
                            <option>Serengeti Breweries Ltd</option>
                            <option>Kilombero Sugar Company</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Expected Delivery Date *</label>
                            <input type="date" class="form-control-custom" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Payment Terms</label>
                            <select class="form-control-custom">
                                <option>Net 14 Days</option>
                                <option>Net 30 Days</option>
                                <option>Cash on Delivery (COD)</option>
                                <option>Advance Payment 50%</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Deliver to Branch / Warehouse</label>
                        <select class="form-control-custom">
                            <option>Kariakoo Central Hub</option>
                            <option>Posta Express Branch</option>
                            <option>Mbezi Luis Branch</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Items Description & Quantities *</label>
                        <textarea class="form-control-custom" rows="3" placeholder="Mfano: 50 Bales za Unga wa Ngano Azam @ Tsh 32,000, 20 katoni za mafuta Kangaroo @ Tsh 64,000..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Estimated Total Order Value (Tsh) *</label>
                        <input type="number" class="form-control-custom font-monospace" placeholder="e.g. 2800000" required>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="createPoModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-send-check"></i> Generate & Send LPO</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Receive Goods Note (GRN) -->
    <div class="modal-overlay" id="grnModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Receive Goods Note (GRN)</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="grnModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="grnForm">
                <div class="modal-body-custom">
                    <div class="p-3 mb-3 rounded" style="background-color: var(--nav-active-bg);">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted" style="font-size: 0.8rem;">PO Reference:</span>
                            <strong id="grnPoRef">LPO-2026-049</strong>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="text-muted" style="font-size: 0.8rem;">Vendor:</span>
                            <strong id="grnVendor">Bakhresa Food Products Ltd</strong>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Supplier Delivery Note / Invoice # *</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. BAK-99214" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Delivery Truck / Reg No</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. T 902 CYA">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Received Items Condition</label>
                        <select class="form-control-custom">
                            <option>100% Complete & Good Quality</option>
                            <option>Partially Received (Some items delayed)</option>
                            <option>Some Goods Damaged in Transit (Reported)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Storekeeper Inspection Signature Notes</label>
                        <textarea class="form-control-custom" rows="2" placeholder="Mfano: Mzigo umekaguliwa stoo na kuhesabiwa, hauna uharibifu wowote..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="grnModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-all"></i> Confirm GRN & Add to Stock</button>
                </div>
            </form>
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

            $('#createPoBtn').on('click', function() { $('#createPoModal').addClass('show'); });

            $('.grn-btn').on('click', function() {
                $('#grnPoRef').text($(this).data('lpo'));
                $('#grnVendor').text($(this).data('vendor'));
                $('#grnModal').addClass('show');
            });

            $('.view-lpo-btn').on('click', function() {
                showToast('Printing official Purchase Order (LPO) document...');
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
                    $('#poTable tbody tr').show();
                } else {
                    $('#poTable tbody tr').each(function() {
                        $(this).toggle($(this).data('filter') === filter);
                    });
                }
            });

            $('#createPoForm').on('submit', function(e) {
                e.preventDefault();
                $('#createPoModal').removeClass('show');
                showToast('Official Purchase Order (LPO) created and transmitted!');
            });

            $('#grnForm').on('submit', function(e) {
                e.preventDefault();
                $('#grnModal').removeClass('show');
                showToast('Goods Received Note (GRN) approved and warehouse inventory stocked!');
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
</body>
</html>
