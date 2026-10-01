<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Branch & Stock Transfers - mercanto</title>

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

        /* Branch Mini Cards */
        .branch-card {
            background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 10px;
            padding: 1rem 1.15rem; display: flex; align-items: center; justify-content: space-between;
        }
        .branch-icon {
            width: 40px; height: 40px; border-radius: 8px; background: var(--nav-active-bg);
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--text-dark);
        }

        .content-card { background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; overflow: hidden; margin-top: 1.5rem; }
        .card-toolbar {
            padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;
        }

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
            border-radius: 14px; width: 100%; max-width: 560px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
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

        .filter-tabs { display: flex; align-items: center; gap: 4px; background-color: var(--nav-active-bg); padding: 3px; border-radius: 8px; }
        .filter-tab { border: none; background: transparent; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); padding: 0.35rem 0.8rem; border-radius: 6px; cursor: pointer; transition: all 0.15s ease; }
        .filter-tab.active { background-color: var(--card-bg); color: var(--text-dark); box-shadow: 0 1px 3px rgba(0,0,0,0.05); }

        .waybill-doc {
            border: 1px solid var(--border-color); border-radius: 10px; padding: 1.25rem; background: var(--card-bg);
        }
        .waybill-header {
            display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 1rem; border-bottom: 2px dashed var(--border-color); margin-bottom: 1rem;
        }
        .waybill-parties {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 0.85rem; background-color: var(--nav-active-bg); border-radius: 8px; margin-bottom: 1rem;
        }
        .signature-line {
            border-top: 1px solid var(--border-color); margin-top: 2rem; padding-top: 0.25rem; font-size: 0.72rem; color: var(--text-muted); text-align: center;
        }
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
                            <li><a href="{{ url('/manager/purchases') }}" class="nav-subitem-link">Purchase Orders (LPO)</a></li>
                            <li><a href="{{ url('/manager/transfers') }}" class="nav-subitem-link active">Branch Transfers</a></li>
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
                <input type="text" class="search-input" placeholder="Search transfer shipments..." id="global-search-input">
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
                <h1 class="page-title">Multi-Branch & Stock Transfers</h1>
                <p class="page-subtext">Manage warehouse dispatches, transfer stock between branch stores, and track in-transit cargo.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-outline-custom" id="addBranchBtn">
                    <i class="bi bi-building-add"></i> Add Branch
                </button>
                <button class="btn-dark-custom" id="newTransferBtn">
                    <i class="bi bi-truck"></i> Create Stock Transfer
                </button>
            </div>
        </div>

        <!-- Store Branches Overview Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="branch-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="branch-icon"><i class="bi bi-building"></i></div>
                        <div>
                            <strong style="font-size: 0.92rem;">Kariakoo Main Warehouse</strong>
                            <div class="text-muted" style="font-size: 0.74rem;">Central Hub • In-Charge: Hassan M.</div>
                        </div>
                    </div>
                    <span class="status-badge badge-success">Hub</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="branch-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="branch-icon"><i class="bi bi-shop-window"></i></div>
                        <div>
                            <strong style="font-size: 0.92rem;">Posta Express Branch</strong>
                            <div class="text-muted" style="font-size: 0.74rem;">Retail Store • In-Charge: Baraka M.</div>
                        </div>
                    </div>
                    <span class="status-badge badge-primary">Active</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="branch-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="branch-icon"><i class="bi bi-shop-window"></i></div>
                        <div>
                            <strong style="font-size: 0.92rem;">Mbezi Luis Branch</strong>
                            <div class="text-muted" style="font-size: 0.74rem;">Supermarket • In-Charge: Asha Ally</div>
                        </div>
                    </div>
                    <span class="status-badge badge-primary">Active</span>
                </div>
            </div>
        </div>

        <!-- Transfer Orders Table -->
        <div class="content-card">
            <div class="card-toolbar d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="filter-tabs">
                    <button type="button" class="filter-tab active" data-filter="all">All Transfers (<span id="allCount">2</span>)</button>
                    <button type="button" class="filter-tab" data-filter="in-transit">In Transit (<span id="inTransitCount">1</span>)</button>
                    <button type="button" class="filter-tab" data-filter="received">Received (<span id="receivedCount">1</span>)</button>
                </div>
                <span class="text-muted" style="font-size: 0.8rem;">Real-time transit tracking & Waybills</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="transfersTable">
                    <thead>
                        <tr>
                            <th>Transfer Order / Date</th>
                            <th>Source Branch (Kutoka)</th>
                            <th>Destination (Kwenda)</th>
                            <th>Total Items</th>
                            <th>Driver / Vehicle</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transfersTableBody">
                        <tr data-status="in-transit" data-order="TRF-2026-081" data-source="Kariakoo Central Hub" data-dest="Posta Express Branch" data-items="45 Cartons (Beverages & Oil)" data-driver="Juma Kassim (T 412 DFC)" data-date="23 Sep 2026, 09:30">
                            <td>
                                <strong>#TRF-2026-081</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">23 Sep 2026, 09:30</span>
                            </td>
                            <td>Kariakoo Central Hub</td>
                            <td><strong>Posta Express Branch</strong></td>
                            <td>45 Cartons (Beverages & Oil)</td>
                            <td>T 412 DFC (Juma Driver)</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-truck"></i> In Transit (Njiani)</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn receive-btn" title="Receive & Confirm at Destination" data-id="TRF-2026-081" data-items="45 Cartons (Beverages & Oil)" data-source="Kariakoo Central Hub" data-dest="Posta Express Branch"><i class="bi bi-box-seam"></i></button>
                                <button class="action-icon-btn view-waybill-btn" title="Print Delivery Waybill" data-id="TRF-2026-081"><i class="bi bi-printer"></i></button>
                            </td>
                        </tr>
                        <tr data-status="received" data-order="TRF-2026-080" data-source="Kariakoo Central Hub" data-dest="Mbezi Luis Branch" data-items="120 Bags (Sugar & Rice)" data-driver="Rashid Omari (T 882 BMN)" data-date="22 Sep 2026, 14:15">
                            <td>
                                <strong>#TRF-2026-080</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">22 Sep 2026, 14:15</span>
                            </td>
                            <td>Kariakoo Central Hub</td>
                            <td><strong>Mbezi Luis Branch</strong></td>
                            <td>120 Bags (Sugar & Rice)</td>
                            <td>T 882 BMN (Rashid)</td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check2-all"></i> Received & Stocked</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn view-waybill-btn" title="View Waybill" data-id="TRF-2026-080"><i class="bi bi-file-earmark-check"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: Create Stock Transfer -->
    <div class="modal-overlay" id="newTransferModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-truck text-primary" style="font-size: 1.25rem;"></i>
                    <h3 style="margin: 0;">Create Inter-Branch Stock Transfer</h3>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="newTransferModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="newTransferForm">
                <div class="modal-body-custom">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Source (Kutoka) *</label>
                            <select class="form-control-custom" id="trfSource" required>
                                <option value="Kariakoo Central Hub">Kariakoo Central Hub</option>
                                <option value="Posta Express Branch">Posta Express Branch</option>
                                <option value="Mbezi Luis Branch">Mbezi Luis Branch</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Destination (Kwenda) *</label>
                            <select class="form-control-custom" id="trfDest" required>
                                <option value="Posta Express Branch">Posta Express Branch</option>
                                <option value="Mbezi Luis Branch">Mbezi Luis Branch</option>
                                <option value="Kariakoo Central Hub">Kariakoo Central Hub</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Select Product to Transfer *</label>
                        <select class="form-control-custom" id="trfProduct" required>
                            <option value="Coca-Cola 350ml Crate" data-unit="Crates" data-max="120">Coca-Cola 350ml Crate (Available: 120 Crates)</option>
                            <option value="Super Basmati Rice 5kg" data-unit="Bags" data-max="85">Super Basmati Rice 5kg (Available: 85 Bags)</option>
                            <option value="Kangaroo Cooking Oil 5L" data-unit="Gallons" data-max="40">Kangaroo Cooking Oil 5L (Available: 40 Gallons)</option>
                            <option value="Azam Wheat Flour 2kg" data-unit="Bales" data-max="60">Azam Wheat Flour 2kg (Available: 60 Bales)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Transfer Quantity *</label>
                        <input type="number" class="form-control-custom" id="trfQty" placeholder="e.g. 25" required min="1" max="120">
                        <span class="text-muted" style="font-size: 0.72rem;" id="trfQtyHelp">Must not exceed current warehouse balance.</span>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Driver / Courier Name *</label>
                            <input type="text" class="form-control-custom" id="trfDriver" placeholder="e.g. Juma Kassim" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Vehicle Plate Number *</label>
                            <input type="text" class="form-control-custom" id="trfPlate" placeholder="e.g. T 412 DFC" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Dispatch Notes / Sababu ya Kuhamisha</label>
                        <textarea class="form-control-custom" id="trfNotes" rows="2" placeholder="Mfano: Kuongeza mzigo baada ya tawi kuishiwa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="newTransferModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-truck"></i> Dispatch Shipment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Receive & Verify Shipment -->
    <div class="modal-overlay" id="receiveModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-box-seam text-success" style="font-size: 1.25rem;"></i>
                    <h3 style="margin: 0;">Confirm Receipt & Stock-In</h3>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="receiveModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="receiveConfirmForm">
                <div class="modal-body-custom">
                    <div class="p-3 mb-3 rounded" style="background-color: var(--nav-active-bg);">
                        <div class="row g-2" style="font-size: 0.8rem;">
                            <div class="col-6"><span class="text-muted">Waybill Ref:</span> <strong id="recOrderRef">#TRF-2026-081</strong></div>
                            <div class="col-6"><span class="text-muted">Source:</span> <strong id="recSource">Kariakoo Hub</strong></div>
                            <div class="col-6"><span class="text-muted">Destination:</span> <strong id="recDest">Posta Express</strong></div>
                            <div class="col-6"><span class="text-muted">Manifest Items:</span> <strong id="recItems">45 Cartons</strong></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Condition of Goods Upon Arrival *</label>
                        <select class="form-control-custom" id="recCondition">
                            <option value="good">100% Intact, Sealed & In Order</option>
                            <option value="shortage">Minor Discrepancy / Transit Breakage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Verified Receiving Storekeeper *</label>
                        <input type="text" class="form-control-custom" id="recSignee" value="Store Manager (MN)" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label-custom">Receiving Verification Notes</label>
                        <textarea class="form-control-custom" id="recNotes" rows="2" placeholder="Bidhaa zimehesabiwa na kuingizwa kwenye leja ya tawi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="receiveModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-all"></i> Confirm & Stock Inventory</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Official Delivery Waybill Document -->
    <div class="modal-overlay" id="waybillModal">
        <div class="modal-box" style="max-width: 680px;">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-check text-primary" style="font-size: 1.25rem;"></i>
                    <div>
                        <h3 style="margin: 0;" id="wbTitle">Inter-Branch Delivery Waybill</h3>
                        <span class="text-muted" style="font-size: 0.74rem;">Official Cargo Dispatch Note</span>
                    </div>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="waybillModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body-custom" id="waybillPrintArea">
                <div class="waybill-doc">
                    <div class="waybill-header">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="workspace-icon" style="width: 28px; height: 28px; font-size: 0.85rem;"><i class="bi bi-shop"></i></div>
                                <strong style="font-size: 1.1rem; letter-spacing: -0.3px;">Mercanto Retail & Wholesale</strong>
                            </div>
                            <div class="text-muted" style="font-size: 0.75rem;">HQ: Kariakoo Central Depot • TIN: 100-882-901</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Tel: +255 777 410 099 • info@mercanto.co.tz</div>
                        </div>
                        <div class="text-end">
                            <span class="status-badge badge-primary font-monospace" style="font-size: 0.82rem;" id="wbNumber">#TRF-2026-081</span>
                            <div class="text-muted mt-1" style="font-size: 0.74rem;" id="wbDate">23 Sep 2026, 09:30</div>
                            <div class="badge bg-dark text-white mt-1" style="font-size: 0.65rem;" id="wbStatus">IN TRANSIT</div>
                        </div>
                    </div>

                    <div class="waybill-parties">
                        <div>
                            <span class="text-muted" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Dispatched From (Kutoka):</span>
                            <div class="fw-bold mt-1" id="wbSource">Kariakoo Central Hub</div>
                            <div class="text-muted" style="font-size: 0.74rem;">In-Charge: Store Dispatch Desk</div>
                        </div>
                        <div>
                            <span class="text-muted" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Delivering To (Kwenda):</span>
                            <div class="fw-bold mt-1" id="wbDest">Posta Express Branch</div>
                            <div class="text-muted" style="font-size: 0.74rem;">Assigned Receiving Desk</div>
                        </div>
                    </div>

                    <div class="p-2 mb-3 rounded border" style="background-color: var(--card-bg); font-size: 0.78rem;">
                        <div class="row">
                            <div class="col-6"><span class="text-muted">Assigned Transporter / Driver:</span> <strong id="wbDriver">Juma Kassim</strong></div>
                            <div class="col-6"><span class="text-muted">Vehicle Registration:</span> <strong class="font-monospace" id="wbPlate">T 412 DFC</strong></div>
                        </div>
                    </div>

                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-bordered" style="font-size: 0.8rem; margin: 0;">
                            <thead class="table-light">
                                <tr>
                                    <th>Item SKU / Description</th>
                                    <th class="text-center" style="width: 100px;">Qty Sent</th>
                                    <th class="text-center" style="width: 100px;">Qty Received</th>
                                    <th>Notes / Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="wbItemsList">
                                <tr>
                                    <td><strong id="wbItemDesc">Coca-Cola 350ml Crate</strong></td>
                                    <td class="text-center fw-bold" id="wbSentQty">45 Crates</td>
                                    <td class="text-center text-success fw-bold" id="wbRecQty">Pending</td>
                                    <td class="text-muted" style="font-size: 0.74rem;" id="wbNotes">Transit security sealed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row pt-2">
                        <div class="col-4">
                            <div class="signature-line">
                                Dispatcher Sign & Date
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="signature-line">
                                Transporter Sign & Date
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="signature-line">
                                Receiving Manager Sign
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-outline-custom" onclick="window.print()"><i class="bi bi-printer"></i> Print Delivery Waybill</button>
                <button type="button" class="btn-dark-custom close-modal" data-modal="waybillModal">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal: Add New Branch -->
    <div class="modal-overlay" id="addBranchModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-building-add text-primary" style="font-size: 1.25rem;"></i>
                    <h3 style="margin: 0;">Register New Store Branch</h3>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="addBranchModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="addBranchForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Branch Name *</label>
                        <input type="text" class="form-control-custom" id="brName" placeholder="e.g. Mercanto Mwenge Branch" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Branch Code *</label>
                            <input type="text" class="form-control-custom" id="brCode" placeholder="e.g. BR-MWN" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Branch Type</label>
                            <select class="form-control-custom" id="brType">
                                <option>Retail Store Counter</option>
                                <option>Supermarket Outlet</option>
                                <option>Wholesale Warehouse</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Physical Location / Address *</label>
                        <input type="text" class="form-control-custom" id="brLocation" placeholder="e.g. Mwenge ITV, Bagamoyo Road" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Assigned Branch Manager *</label>
                        <input type="text" class="form-control-custom" id="brManager" placeholder="e.g. David Minja" required>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="addBranchModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-circle"></i> Save Branch</button>
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

            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase();
                $('#transfersTable tbody tr').each(function() {
                    $(this).toggle($(this).text().toLowerCase().includes(term));
                });
            });

            // Filter Tabs
            $('.filter-tab').on('click', function() {
                $('.filter-tab').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                if (filter === 'all') {
                    $('#transfersTable tbody tr').show();
                } else {
                    $('#transfersTable tbody tr').each(function() {
                        $(this).toggle($(this).data('status') === filter);
                    });
                }
            });

            function updateCounts() {
                const total = $('#transfersTable tbody tr').length;
                const inTransit = $('#transfersTable tbody tr[data-status="in-transit"]').length;
                const received = $('#transfersTable tbody tr[data-status="received"]').length;
                $('#allCount').text(total);
                $('#inTransitCount').text(inTransit);
                $('#receivedCount').text(received);
            }

            // Open Modals
            $('#newTransferBtn').on('click', function() { $('#newTransferModal').addClass('show'); });
            $('#addBranchBtn').on('click', function() { $('#addBranchModal').addClass('show'); });

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

            // Receive Transfer Workflow
            let activeReceiveRow = null;
            $(document).on('click', '.receive-btn', function() {
                activeReceiveRow = $(this).closest('tr');
                const id = activeReceiveRow.data('order') || $(this).data('id');
                const source = activeReceiveRow.data('source') || $(this).data('source');
                const dest = activeReceiveRow.data('dest') || $(this).data('dest');
                const items = activeReceiveRow.data('items') || $(this).data('items');

                $('#recOrderRef').text('#' + id);
                $('#recSource').text(source);
                $('#recDest').text(dest);
                $('#recItems').text(items);
                $('#receiveModal').addClass('show');
            });

            $('#receiveConfirmForm').on('submit', function(e) {
                e.preventDefault();
                $('#receiveModal').removeClass('show');
                if (activeReceiveRow) {
                    const id = activeReceiveRow.data('order');
                    activeReceiveRow.attr('data-status', 'received');
                    activeReceiveRow.find('.badge-warning').removeClass('badge-warning').addClass('badge-success')
                        .html('<i class="bi bi-check2-all"></i> Received & Stocked');
                    activeReceiveRow.find('.receive-btn').replaceWith('<span class="text-success me-2" title="Stock Verified"><i class="bi bi-check-circle-fill"></i></span>');
                    updateCounts();
                    showToast(`Shipment #${id} confirmed and stocked into branch inventory!`);
                }
            });

            // View / Print Waybill Workflow
            $(document).on('click', '.view-waybill-btn', function() {
                const row = $(this).closest('tr');
                const id = row.data('order') || '#TRF-2026-081';
                const source = row.data('source') || 'Kariakoo Central Hub';
                const dest = row.data('dest') || 'Posta Express Branch';
                const items = row.data('items') || '45 Cartons (Beverages & Oil)';
                const driver = row.data('driver') || 'Juma Kassim (T 412 DFC)';
                const date = row.data('date') || '23 Sep 2026, 09:30';
                const status = row.data('status') === 'received' ? 'RECEIVED & STOCKED' : 'IN TRANSIT (NJIANI)';

                $('#wbNumber').text('#' + id);
                $('#wbDate').text(date);
                $('#wbSource').text(source);
                $('#wbDest').text(dest);
                $('#wbDriver').text(driver.split('(')[0].trim());
                $('#wbPlate').text(driver.includes('(') ? driver.split('(')[1].replace(')', '') : 'T 412 DFC');
                $('#wbItemDesc').text(items);
                $('#wbSentQty').text(items);
                $('#wbRecQty').text(row.data('status') === 'received' ? 'Fully Received' : 'In Transit');
                $('#wbStatus').text(status).removeClass('bg-warning bg-success bg-dark')
                    .addClass(row.data('status') === 'received' ? 'bg-success' : 'bg-warning');

                $('#waybillModal').addClass('show');
            });

            // Update Qty Max on Product Select
            $('#trfProduct').on('change', function() {
                const max = $(this).find(':selected').data('max');
                const unit = $(this).find(':selected').data('unit');
                $('#trfQty').attr('max', max);
                $('#trfQtyHelp').text(`Available stock: ${max} ${unit}.`);
            });

            // Dispatch Stock Transfer Submit
            $('#newTransferForm').on('submit', function(e) {
                e.preventDefault();
                const source = $('#trfSource').val();
                const dest = $('#trfDest').val();

                if (source === dest) {
                    alert('Source branch and Destination branch cannot be the same! Tafadhali chagua tawi tofauti.');
                    return;
                }

                const product = $('#trfProduct').val();
                const qty = $('#trfQty').val();
                const unit = $('#trfProduct').find(':selected').data('unit') || 'Units';
                const driver = $('#trfDriver').val();
                const plate = $('#trfPlate').val();
                const orderId = 'TRF-2026-0' + Math.floor(82 + Math.random() * 20);
                const itemsStr = `${qty} ${unit} (${product})`;
                const dateStr = 'Just Now';

                const newRow = `
                    <tr data-status="in-transit" data-order="${orderId}" data-source="${source}" data-dest="${dest}" data-items="${itemsStr}" data-driver="${driver} (${plate})" data-date="${dateStr}">
                        <td>
                            <strong>#${orderId}</strong><br>
                            <span class="text-muted" style="font-size: 0.74rem;">${dateStr}</span>
                        </td>
                        <td>${source}</td>
                        <td><strong>${dest}</strong></td>
                        <td>${itemsStr}</td>
                        <td>${plate} (${driver})</td>
                        <td><span class="status-badge badge-warning"><i class="bi bi-truck"></i> In Transit (Njiani)</span></td>
                        <td class="text-end">
                            <button class="action-icon-btn receive-btn" title="Receive & Confirm at Destination" data-id="${orderId}" data-items="${itemsStr}" data-source="${source}" data-dest="${dest}"><i class="bi bi-box-seam"></i></button>
                            <button class="action-icon-btn view-waybill-btn" title="Print Delivery Waybill" data-id="${orderId}"><i class="bi bi-printer"></i></button>
                        </td>
                    </tr>
                `;

                $('#transfersTableBody').prepend(newRow);
                updateCounts();
                $('#newTransferModal').removeClass('show');
                this.reset();
                showToast(`Waybill #${orderId} generated and cargo dispatched successfully!`);
            });

            // Add Store Branch Submit
            $('#addBranchForm').on('submit', function(e) {
                e.preventDefault();
                const name = $('#brName').val();
                const type = $('#brType').val();
                const loc = $('#brLocation').val();
                const mgr = $('#brManager').val();

                // Append card to overview row
                const newBranchCard = `
                    <div class="col-md-4">
                        <div class="branch-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="branch-icon"><i class="bi bi-shop-window"></i></div>
                                <div>
                                    <strong style="font-size: 0.92rem;">${name}</strong>
                                    <div class="text-muted" style="font-size: 0.74rem;">${type} • In-Charge: ${mgr}</div>
                                </div>
                            </div>
                            <span class="status-badge badge-primary">Active</span>
                        </div>
                    </div>
                `;
                $('.row.g-3.mb-4').append(newBranchCard);

                // Add to select options
                $('#trfSource, #trfDest').append(`<option value="${name}">${name}</option>`);

                $('#addBranchModal').removeClass('show');
                this.reset();
                showToast(`Branch "${name}" successfully registered into network!`);
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
</body>
</html>
