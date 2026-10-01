<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - mercanto</title>

    @include('partials.pwa_meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js -->
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

        .nav-subitem-link.active {
            color: var(--text-dark);
            background-color: #f4f4f5;
            font-weight: 600;
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

        /* Branch Tag & Profile Dropdown */
        .header-branch-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--card-bg, #ffffff);
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
            background-color: var(--card-bg, #ffffff);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .header-profile-btn:hover {
            background-color: var(--nav-active-bg, #f4f4f5);
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
            background-color: var(--card-bg, #ffffff);
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
            background-color: var(--nav-active-bg, #f4f4f5);
            color: var(--text-dark);
        }

        .profile-dropdown-item.text-danger {
            color: #ef4444 !important;
        }

        .profile-dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626 !important;
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

        .btn-download-clean {
            background-color: var(--primary-btn);
            color: #ffffff;
            border: 1px solid var(--primary-btn);
            padding: 0.45rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.15s ease;
        }

        .btn-download-clean:hover {
            opacity: 0.9;
            color: #ffffff;
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

        /* Large Card Container */
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

        /* Breakdown Progress List */
        .breakdown-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .breakdown-item-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .breakdown-item-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .breakdown-item-val {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .custom-progress-track {
            width: 100%;
            height: 8px;
            background-color: #f4f4f5;
            border-radius: 9999px;
            overflow: hidden;
        }

        .custom-progress-fill {
            height: 100%;
            background-color: #0f172a;
            border-radius: 9999px;
            transition: width 0.6s ease;
        }

        .custom-progress-fill.subtle {
            background-color: #71717a;
        }



        /* Toast Notify */
        .toast-notify {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: #09090b;
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 2000;
        }
    </style>
</head>
<body>

    <!-- Left Sidebar (Clean Shadcn Style) -->
    <aside class="sidebar">
        <div>
            <!-- Workspace Brand Header -->
            <div class="workspace-header">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>Manager Panel</span>
                    </div>
                </div>
            </div>

            <!-- DYNAMIC NAV ITEMS -->
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
                    <li>
                        <a href="{{ url('/manager/analytics') }}" class="nav-item-link active">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>Analytics</span>
                            </span>
                        </a>
                    </li>

                    <!-- Dropdown: Manage Store -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-box-seam"></i>
                                <span>Manage Store</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/stock') }}" class="nav-subitem-link">Products & Stock</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">POS / Cashier</a></li>
                            <li><a href="{{ url('/manager/category') }}" class="nav-subitem-link">Categories</a></li>
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link">Suppliers</a></li>
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
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up"></i>
                                <span>Reports</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu" style="display: flex;">
                            <li><a href="{{ url('/manager/analytics') }}" class="nav-subitem-link active">Sales Report</a></li>
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

        <!-- Sidebar Profile Section -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div class="profile-avatar" id="sidebarAvatarInitial">MN</div>
                <div class="profile-info">
                    <span class="profile-name" id="sidebarProfileName">Store Manager</span>
                    <span class="profile-email" id="sidebarProfileEmail">manager@eduka.co.tz</span>
                </div>
            </div>
            <a href="{{ url('/login') }}" title="Sign Out" style="color: var(--text-muted); font-size: 1.1rem; text-decoration: none; padding: 4px; border-radius: 6px; display: flex; align-items: center;">
                <i class="bi bi-box-arrow-right"></i>
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
                <input type="text" class="search-input" placeholder="Search..." id="global-search-input">
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

        <!-- Top Header Title & Actions -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Analytics</h1>
            <button class="btn-download-clean" id="downloadReportBtn">
                <i class="bi bi-download"></i>
                <span>Download Report</span>
            </button>
        </div>

        <!-- Tab Controls -->
        <div class="dashboard-tabs">
            <a href="{{ url('/manager/dashboard') }}" class="tab-btn">Overview</a>
            <a href="{{ url('/manager/analytics') }}" class="tab-btn active">Analytics</a>
            <a href="{{ url('/manager/expenses') }}" class="tab-btn">Reports</a>
            <button class="tab-btn">Notifications</button>
        </div>

        <!-- TOP SECTION: Traffic Overview (Weekly clicks & unique visitors) Line Chart -->
        <div class="content-card mb-4" style="height: auto;">
            <div class="card-header-clean">
                <h3>Traffic & Store Analytics Overview</h3>
                <p>Weekly customer visits, POS counter engagements, and unique foot traffic trends.</p>
            </div>
            <div style="height: 350px; width: 100%; position: relative;">
                <canvas id="trafficOverviewChart"></canvas>
            </div>
        </div>

        <!-- MIDDLE SECTION: 4 Stat Cards Row -->
        <div class="row g-4 mb-4">
            <!-- 1. Total Clicks -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Visits</span>
                        <i class="bi bi-cursor stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">14,248</div>
                        <div class="stat-subtext"><span class="text-success"><i class="bi bi-arrow-up-right"></i> +12.4%</span> vs last week • Peak: Friday</div>
                    </div>
                </div>
            </div>

            <!-- 2. Unique Customers -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Unique Shoppers</span>
                        <i class="bi bi-people stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">8,632</div>
                        <div class="stat-subtext"><span class="text-success"><i class="bi bi-arrow-up-right"></i> +5.8%</span> vs last week • Repeat: 64%</div>
                    </div>
                </div>
            </div>

            <!-- 3. Conversion Rate -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Basket Conversion</span>
                        <i class="bi bi-cart-check stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">78.4%</div>
                        <div class="stat-subtext">+2.1% improvement from POS speed</div>
                    </div>
                </div>
            </div>

            <!-- 4. Avg. Checkout Time -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Avg. Checkout</span>
                        <i class="bi bi-stopwatch stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">1m 18s</div>
                        <div class="stat-subtext">-14s faster per basket ticket</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM SECTION: Referrers & Devices Row -->
        <div class="row g-4">
            <!-- Traffic Channels Card (6 Cols) -->
            <div class="col-12 col-xl-6">
                <div class="content-card">
                    <div class="card-header-clean">
                        <h3>Customer Channels</h3>
                        <p>Main channels driving customer purchases and orders.</p>
                    </div>

                    <div class="breakdown-list">
                        <!-- Walk-in Retail Desk -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Walk-in POS Desk (Kariakoo Counter)</span>
                                <span class="breakdown-item-val">72%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-fill" style="width: 72%;"></div>
                            </div>
                        </div>

                        <!-- Phone & WhatsApp Orders -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">WhatsApp Direct Orders</span>
                                <span class="breakdown-item-val">18%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-fill subtle" style="width: 18%;"></div>
                            </div>
                        </div>

                        <!-- Wholesale B2B Distribution -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">B2B Wholesale Invoices</span>
                                <span class="breakdown-item-val">10%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-fill subtle" style="width: 10%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods Split (6 Cols) -->
            <div class="col-12 col-xl-6">
                <div class="content-card">
                    <div class="card-header-clean">
                        <h3>Payment Methods Distribution</h3>
                        <p>Breakdown of settlement channels across all transactions.</p>
                    </div>

                    <div class="breakdown-list">
                        <!-- M-Pesa Till / Mobile Money -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Mobile Money (M-Pesa, Airtel Money)</span>
                                <span class="breakdown-item-val">58%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-fill" style="width: 58%;"></div>
                            </div>
                        </div>

                        <!-- Physical Cash -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Cash on Delivery / Register Cash</span>
                                <span class="breakdown-item-val">34%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-fill subtle" style="width: 34%;"></div>
                            </div>
                        </div>

                        <!-- Bank & Card -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Bank Transfer / Card POS</span>
                                <span class="breakdown-item-val">8%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-fill subtle" style="width: 8%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill" style="color: #ffffff;"></i>
        <span id="toastNotifyMsg">Report generated successfully</span>
    </div>

    <!-- Chart & Interactive Script -->
    <script>
        const ctx = document.getElementById('trafficOverviewChart').getContext('2d');
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const valuesVisits = [420, 680, 590, 810, 940, 890, 720];
        const valuesOrders = [310, 520, 470, 640, 760, 710, 580];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'Store Visits',
                        data: valuesVisits,
                        borderColor: '#10b981',
                        borderWidth: 2.5,
                        backgroundColor: 'rgba(16, 185, 129, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#10b981',
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Completed Orders',
                        data: valuesOrders,
                        borderColor: '#2563eb',
                        borderWidth: 2,
                        borderDash: [4, 4],
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        fill: false,
                        tension: 0.35,
                        pointRadius: 3,
                        pointBackgroundColor: '#2563eb',
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            color: '#71717a',
                            font: { size: 12, family: 'Inter' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#09090b',
                        padding: 10,
                        titleFont: { size: 12, family: 'Inter' },
                        bodyFont: { size: 12, family: 'Inter' },
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { color: '#71717a', font: { size: 12, family: 'Inter' } }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#f4f4f5' },
                        ticks: {
                            color: '#71717a',
                            font: { size: 12, family: 'Inter' },
                            stepSize: 200,
                        },
                        min: 0,
                        max: 1000
                    }
                }
            }
        });

        // Dropdown Collapsible Submenu Toggle
        $('.nav-dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            const btn = $(this);
            const subMenu = btn.next('.nav-submenu');

            subMenu.stop(true, true).slideToggle(180);
            btn.toggleClass('open');
            const isOpen = btn.hasClass('open');
            btn.attr('aria-expanded', isOpen);
        });

        // Theme toggle button
        let isLight = true;
        $('#theme-toggle-btn').on('click', function() {
            isLight = !isLight;
            const icon = $('#theme-icon');
            if (isLight) {
                icon.removeClass('bi-moon-stars').addClass('bi-sun');
            } else {
                icon.removeClass('bi-sun').addClass('bi-moon-stars');
            }
        });

        // Cmd+K shortcut
        $(document).on('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                $('#global-search-input').focus();
            }
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

        // Download Report button
        $('#downloadReportBtn').on('click', function() {
            $('#toastNotifyMsg').text('Generating Analytics Report (CSV)...');
            $('#toastNotify').fadeIn(200).delay(2500).fadeOut(200);
        });
    </script>
</body>
</html>
