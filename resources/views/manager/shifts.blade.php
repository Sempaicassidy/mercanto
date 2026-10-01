<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift & Cash Register (Z-Report) - mercanto</title>

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

        body.dark-mode .btn-dark-custom {
            color: #09090b;
        }

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

        .modal-overlay.show { display: flex; }

        .modal-box {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
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
        }

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
            z-index: 2000;
        }

        body.dark-mode .toast-notify {
            color: #09090b;
        }

        /* Thermal receipt style for Z-report */
        .thermal-receipt {
            font-family: 'Courier New', Courier, monospace;
            background: #fff;
            color: #000;
            padding: 1.2rem;
            border: 1px dashed #ccc;
            border-radius: 4px;
            font-size: 0.82rem;
            line-height: 1.4;
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
                            <li><a href="{{ url('/manager/shifts') }}" class="nav-subitem-link active">Shift & Cash Register</a></li>
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
                <input type="text" class="search-input" placeholder="Search shift history..." id="global-search-input">
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
                <h1 class="page-title">Shift & Cash Register (Z-Report)</h1>
                <p class="page-subtext">Manage cashier shifts, drawer opening float, petty cash payouts, and daily closing balance.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-outline-custom" id="cashPayoutBtn">
                    <i class="bi bi-box-arrow-up-right"></i> Cash Out (Petty Cash)
                </button>
                <button class="btn-outline-custom" id="openShiftBtn">
                    <i class="bi bi-play-circle"></i> Open New Shift
                </button>
                <button class="btn-dark-custom" id="closeShiftBtn">
                    <i class="bi bi-lock-fill"></i> Close Shift & Z-Report
                </button>
            </div>
        </div>

        <!-- Live Shift Active Alert Card -->
        <div class="p-3 mb-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background-color: var(--nav-active-bg); border: 1px solid var(--border-color);">
            <div class="d-flex align-items-center gap-3">
                <div class="spinner-grow text-success" role="status" style="width: 14px; height: 14px;"></div>
                <div>
                    <strong style="font-size: 0.9rem;">Active Register: Register #01 (Main POS)</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">Cashier: <strong>Baraka Msuya</strong> • Opened today at 07:30 AM • Float: <strong>Tsh 50,000</strong></div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <span class="text-muted" style="font-size: 0.74rem;">Current Cash in Drawer</span>
                    <h5 class="m-0 font-monospace text-success">Tsh 894,000</h5>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Cash In Drawer (Today)</span>
                        <i class="bi bi-cash stat-icon text-success"></i>
                    </div>
                    <div class="stat-value text-success">Tsh 894,000</div>
                    <div class="stat-footer">
                        <span>Expected at register</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Mobile Money (Till / Paybill)</span>
                        <i class="bi bi-phone stat-icon text-primary"></i>
                    </div>
                    <div class="stat-value text-primary">Tsh 640,000</div>
                    <div class="stat-footer">
                        <span>18 M-Pesa / Tigo Pesa sales</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Cash Payouts (Expenses)</span>
                        <i class="bi bi-arrow-up-right-circle stat-icon text-warning"></i>
                    </div>
                    <div class="stat-value text-warning">Tsh 45,000</div>
                    <div class="stat-footer">
                        <span>Petty cash for store supplies</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Cash Variance (Net Short/Over)</span>
                        <i class="bi bi-scales stat-icon"></i>
                    </div>
                    <div class="stat-value text-muted font-monospace">Tsh 0</div>
                    <div class="stat-footer">
                        <span class="text-success"><i class="bi bi-check-circle"></i> Perfectly Balanced</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shifts History Table -->
        <div class="content-card">
            <div class="card-toolbar">
                <h5 style="font-size: 0.95rem; font-weight: 700; margin: 0;">Register Shifts & Closing History</h5>
                <span class="text-muted" style="font-size: 0.8rem;">Real-time shift log & reconciliation</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="shiftsTable">
                    <thead>
                        <tr>
                            <th>Shift Ref / Register</th>
                            <th>Cashier</th>
                            <th>Start / End Time</th>
                            <th>Opening Float</th>
                            <th>Cash Sales</th>
                            <th>Cash Out</th>
                            <th>Counted Cash</th>
                            <th>Variance</th>
                            <th>Status</th>
                            <th class="text-end">Z-Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>#SHF-2026-092</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">Register 01 (Morning)</span>
                            </td>
                            <td>Baraka Msuya</td>
                            <td>07:30 AM - Active</td>
                            <td class="font-monospace">Tsh 50,000</td>
                            <td class="font-monospace text-success">Tsh 889,000</td>
                            <td class="font-monospace text-warning">Tsh 45,000</td>
                            <td class="font-monospace">-</td>
                            <td class="font-monospace">-</td>
                            <td><span class="status-badge badge-warning"><i class="bi bi-record-circle"></i> In Progress</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn preview-z-btn" title="View Current X-Report"><i class="bi bi-receipt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>#SHF-2026-091</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">Register 01 (Evening)</span>
                            </td>
                            <td>Asha Ally</td>
                            <td>22 Sep, 02:00 PM - 09:30 PM</td>
                            <td class="font-monospace">Tsh 50,000</td>
                            <td class="font-monospace text-success">Tsh 1,420,000</td>
                            <td class="font-monospace text-warning">Tsh 20,000</td>
                            <td class="font-monospace font-bold">Tsh 1,450,000</td>
                            <td><span class="text-success font-monospace">+Tsh 0</span></td>
                            <td><span class="status-badge badge-success"><i class="bi bi-check-circle-fill"></i> Closed (Exact)</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn preview-z-btn" title="Print Z-Report"><i class="bi bi-printer"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>#SHF-2026-090</strong><br>
                                <span class="text-muted" style="font-size: 0.74rem;">Register 01 (Morning)</span>
                            </td>
                            <td>Baraka Msuya</td>
                            <td>22 Sep, 07:30 AM - 02:00 PM</td>
                            <td class="font-monospace">Tsh 50,000</td>
                            <td class="font-monospace text-success">Tsh 980,000</td>
                            <td class="font-monospace text-warning">Tsh 0</td>
                            <td class="font-monospace font-bold">Tsh 1,028,000</td>
                            <td><span class="text-danger font-monospace">-Tsh 2,000</span></td>
                            <td><span class="status-badge badge-danger"><i class="bi bi-exclamation-triangle-fill"></i> Shortage</span></td>
                            <td class="text-end">
                                <button class="action-icon-btn preview-z-btn" title="Print Z-Report"><i class="bi bi-printer"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: Open New Shift -->
    <div class="modal-overlay" id="openShiftModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Open New Cashier Shift</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="openShiftModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="openShiftForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Select Cashier</label>
                        <select class="form-control-custom">
                            <option>Baraka Msuya</option>
                            <option>Asha Ally</option>
                            <option>Khadija Omary</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Register POS Terminal</label>
                        <select class="form-control-custom">
                            <option>POS Register #01 (Front Desk)</option>
                            <option>POS Register #02 (Express Counter)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Opening Cash Float (Pesa ya Chenji - Tsh) *</label>
                        <input type="number" class="form-control-custom" value="50000" required>
                        <small class="text-muted" style="font-size: 0.72rem;">Kiasi cha chenji kilichokabidhiwa kuanzia asubuhi.</small>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="openShiftModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-play-fill"></i> Start Register Shift</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Cash Out / Petty Cash -->
    <div class="modal-overlay" id="cashPayoutModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Cash Out / Petty Cash Payout</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="cashPayoutModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="cashPayoutForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Amount to Remove from Drawer (Tsh) *</label>
                        <input type="number" class="form-control-custom" placeholder="e.g. 15000" required min="500">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Category / Expense Reason</label>
                        <select class="form-control-custom">
                            <option>Chai / Maji ya Wafanyakazi</option>
                            <option>Usafiri / Dispatch Delivery</option>
                            <option>Kununua Vifungashio (Mifuko)</option>
                            <option>Umeme / Maji (LUKU)</option>
                            <option>Other Emergency</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Authorized By (Manager Name)</label>
                        <input type="text" class="form-control-custom" value="Store Manager" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Receipt / Voucher Notes</label>
                        <textarea class="form-control-custom" rows="2" placeholder="Maelezo mafupi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="cashPayoutModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check-lg"></i> Deduct from Cash Drawer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Close Shift & Z-Report -->
    <div class="modal-overlay" id="closeShiftModal">
        <div class="modal-box" style="max-width: 580px;">
            <div class="modal-header-custom">
                <h3>Close Register & End Day (Z-Report)</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="closeShiftModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="closeShiftForm">
                <div class="modal-body-custom">
                    <div class="p-3 mb-3 rounded" style="background-color: var(--nav-active-bg);">
                        <div class="d-flex justify-content-between mb-1" style="font-size: 0.84rem;">
                            <span>Opening Float:</span>
                            <strong class="font-monospace">Tsh 50,000</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1" style="font-size: 0.84rem;">
                            <span>Total Cash Sales:</span>
                            <strong class="font-monospace text-success">+Tsh 889,000</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 0.84rem;">
                            <span>Cash Payouts:</span>
                            <strong class="font-monospace text-warning">-Tsh 45,000</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between" style="font-size: 0.9rem;">
                            <strong>Expected Cash in Drawer:</strong>
                            <strong class="font-monospace text-primary" id="expectedCashVal">Tsh 894,000</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Actual Cash Counted by Cashier (Tsh) *</label>
                        <input type="number" class="form-control-custom font-monospace" id="countedCashInput" placeholder="Enter counted physical cash..." required style="font-size: 1.1rem; font-weight: 700;">
                    </div>

                    <div class="p-3 rounded mb-3 d-flex justify-content-between align-items-center" id="varianceBox" style="background: #f4f4f5;">
                        <span style="font-size: 0.84rem;">Difference / Variance:</span>
                        <strong class="font-monospace" id="varianceResult">Enter counted amount</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Closing Handover Notes</label>
                        <textarea class="form-control-custom" rows="2" placeholder="Sababu ya ziada au upungufu ikiwa ipo..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="closeShiftModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-printer-fill"></i> Close Register & Print Z-Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Z-Report Thermal Preview -->
    <div class="modal-overlay" id="zReportModal">
        <div class="modal-box" style="max-width: 440px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);">
            <div class="modal-header-custom d-flex justify-content-between align-items-center p-3 border-bottom" style="background:#ffffff;">
                <h3 style="font-size:0.95rem; font-weight:700; margin:0; display:flex; align-items:center; gap:6px;">
                    <i class="bi bi-receipt-cutoff text-primary"></i> Daily Closing Z-Report (EFD)
                </h3>
                <button type="button" class="btn-close close-modal" data-modal="zReportModal" aria-label="Funga"></button>
            </div>
            <div class="modal-body-custom" style="padding:0; background:#ffffff;">
                <div id="zReportReceiptArea" class="thermal-receipt-paper" style="background:#ffffff; color:#000000; padding:20px 18px; font-family:'Courier New', Courier, monospace; font-size:12px; line-height:1.35; max-height:65vh; overflow-y:auto;">
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
                        <div style="font-weight:800; font-size:13px; letter-spacing:1px;">DAILY CLOSING Z-REPORT</div>
                        <div style="font-size:10px;">(MWISHO WA ZAMU YA MAUZO)</div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                    </div>
                    <div style="font-size:11px;">
                        <div class="d-flex justify-content-between">
                            <span>Tarehe:</span>
                            <span>27/09/2026 09:30 PM</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Namba ya Z-Report:</span>
                            <strong class="font-monospace">Z-20260927-01</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kituo (Terminal):</span>
                            <strong>POS-01</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Mhudumu (Cashier):</span>
                            <strong>Baraka Msuya</strong>
                        </div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div class="d-flex justify-content-between">
                            <span>Salio la Kuanzia (Float):</span>
                            <span class="font-monospace">TSh 50,000</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Mauzo ya Taslimu (Cash):</span>
                            <span class="font-monospace">TSh 889,000</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>M-Pesa / Tigo / Airtel:</span>
                            <span class="font-monospace">TSh 640,000</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Malipo ya Kadi (Card):</span>
                            <span class="font-monospace">TSh 120,000</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Matumizi / Malipo (Payouts):</span>
                            <span class="font-monospace">-TSh 45,000</span>
                        </div>
                        <div style="border-top:1px solid #000; margin:6px 0;"></div>
                        <div class="d-flex justify-content-between" style="font-weight:800; font-size:12px;">
                            <span>JUMLA YA MAUZO (GROSS):</span>
                            <span class="font-monospace">TSh 1,649,000</span>
                        </div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div class="d-flex justify-content-between">
                            <span>Pesa Inayotarajiwa:</span>
                            <span class="font-monospace">TSh 894,000</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Pesa Iliyohesabiwa:</span>
                            <span class="font-monospace">TSh 894,000</span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-weight:700;">
                            <span>Tofauti (Variance):</span>
                            <span class="font-monospace" style="color:#059669;">TSh 0 (BALANCED)</span>
                        </div>
                        <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                        <div class="d-flex justify-content-between">
                            <span>Kodi ya VAT (18% Imelipwa):</span>
                            <span class="font-monospace">TSh 251,542</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Wateja Waliohudumiwa:</span>
                            <strong>48</strong>
                        </div>
                        <div style="border-top:1px dashed #000; margin:8px 0 4px 0;"></div>
                        <div class="text-center mt-2" style="font-size:10px;">
                            <div style="font-weight:700;">TRA EFD FISCAL VERIFIED</div>
                            <div>Uthibitisho: 9A48-E71B-33C9-92F1</div>
                            <div style="letter-spacing:1px; margin:4px 0; font-weight:bold;">[ ||||||||||||||||||||||||||||||||||||||||||| ]</div>
                            <div style="font-weight:700; margin-top:4px;">*** SHIFT CLOSED & VERIFIED ***</div>
                            <div style="margin-top:6px;">Sahihi ya Meneja: ........................</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 p-3 border-top no-print" style="background:#f8fafc;">
                <button type="button" class="btn btn-outline-secondary flex-fill btn-sm py-2 fw-semibold close-modal" data-modal="zReportModal" style="border-radius:10px; font-size:0.85rem;">
                    <i class="bi bi-x-circle me-1"></i> Funga
                </button>
                <button type="button" class="btn btn-primary flex-fill btn-sm py-2 fw-semibold" id="btnPrintZReport" style="border-radius:10px; font-size:0.85rem; background:#0d6efd; border-color:#0d6efd;">
                    <i class="bi bi-printer me-1"></i> Chapisha Z-Report
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
            // Theme Toggle
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

            // Modals
            $('#openShiftBtn').on('click', function() { $('#openShiftModal').addClass('show'); });
            $('#cashPayoutBtn').on('click', function() { $('#cashPayoutModal').addClass('show'); });
            $('#closeShiftBtn').on('click', function() { $('#closeShiftModal').addClass('show'); });
            $('.preview-z-btn').on('click', function() { $('#zReportModal').addClass('show'); });

            $('.close-modal').on('click', function() {
                const modalId = $(this).data('modal');
                $('#' + modalId).removeClass('show');
            });

            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).is('.modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });

            // Variance Calculation
            $('#countedCashInput').on('keyup input', function() {
                const counted = Number($(this).val()) || 0;
                const expected = 894000;
                const diff = counted - expected;
                if (diff === 0) {
                    $('#varianceResult').html('<span class="text-success">+Tsh 0 (Balanced)</span>');
                } else if (diff > 0) {
                    $('#varianceResult').html('<span class="text-primary">+Tsh ' + diff.toLocaleString() + ' (Excess / Ziada)</span>');
                } else {
                    $('#varianceResult').html('<span class="text-danger">Tsh ' + diff.toLocaleString() + ' (Shortage / Pungufu)</span>');
                }
            });

            // Forms
            $('#openShiftForm').on('submit', function(e) {
                e.preventDefault();
                $('#openShiftModal').removeClass('show');
                showToast('New register shift started with opening float!');
            });

            $('#cashPayoutForm').on('submit', function(e) {
                e.preventDefault();
                $('#cashPayoutModal').removeClass('show');
                showToast('Petty cash payout recorded from cash drawer!');
            });

            $('#closeShiftForm').on('submit', function(e) {
                e.preventDefault();
                $('#closeShiftModal').removeClass('show');
                $('#zReportModal').addClass('show');
                showToast('Shift reconciled and closed successfully!');
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

            // Print Z-Report via Thermal Print Driver
            $('#btnPrintZReport').off('click').on('click', function() {
                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Inachapisha...');
                if (typeof printThermalReceiptDirect === 'function') {
                    printThermalReceiptDirect('zReportReceiptArea');
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
        });
    </script>

    @include('partials.receipt_modal')
</body>
</html>
