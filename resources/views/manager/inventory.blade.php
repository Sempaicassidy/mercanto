<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report - mercanto</title>

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
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .nav-item-link:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        .nav-item-link.active {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
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

        .nav-dropdown-toggle[aria-expanded="true"] .nav-chevron {
            transform: rotate(90deg);
        }

        .nav-submenu {
            list-style: none;
            padding: 0.25rem 0 0.25rem 2rem;
            margin: 0;
            display: none;
            flex-direction: column;
            gap: 2px;
        }

        .nav-submenu.show {
            display: flex;
        }

        .nav-subitem-link {
            display: block;
            padding: 0.4rem 0.6rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.15s ease;
        }

        .nav-subitem-link:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        .nav-subitem-link.active {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
            font-weight: 600;
        }

        /* Sidebar Profile */
        .sidebar-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s ease;
            border: 1px solid var(--border-color);
            margin-top: 1rem;
        }

        .sidebar-profile:hover {
            background-color: var(--nav-active-bg);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background-color: #e4e4e7;
            color: #18181b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            margin-right: 10px;
        }

        body.dark-mode .profile-avatar {
            background-color: #27272a;
            color: #f4f4f5;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            overflow: hidden;
        }

        .profile-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .profile-email {
            font-size: 0.72rem;
            color: var(--text-muted);
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex-grow: 1;
            padding: 1.5rem 2rem 3rem 2rem;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        /* Top Nav Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            gap: 12px;
        }

        .header-search-box {
            position: relative;
            width: 240px;
        }

        .header-search-box .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .search-input {
            width: 100%;
            padding: 0.45rem 2.2rem 0.45rem 2.1rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-dark);
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .search-input:focus {
            border-color: #71717a;
        }

        .search-kbd {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.7rem;
            color: var(--text-muted);
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            padding: 1px 5px;
            border-radius: 4px;
        }

        .nav-icon-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: var(--nav-active-bg);
        }

        .header-role-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-dark);
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .header-role-pill:hover {
            background-color: var(--nav-active-bg);
        }

        .header-avatar {
            width: 36px;
            height: 36px;
            background-color: #e4e4e7;
            color: #18181b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.82rem;
            cursor: pointer;
        }

        body.dark-mode .header-avatar {
            background-color: #27272a;
            color: #f4f4f5;
        }

        /* Page Header */
        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-dark);
            margin-bottom: 0.2rem;
        }

        .page-subtext {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .btn-custom-primary {
            background-color: var(--primary-btn);
            color: #ffffff;
            border: 1px solid var(--primary-btn);
            padding: 0.48rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: opacity 0.15s ease;
            cursor: pointer;
        }

        body.dark-mode .btn-custom-primary {
            color: #09090b;
        }

        .btn-custom-primary:hover {
            opacity: 0.9;
            color: #ffffff;
        }

        body.dark-mode .btn-custom-primary:hover {
            color: #09090b;
        }

        .btn-custom-outline {
            background: transparent;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 0.48rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .btn-custom-outline:hover {
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
        }

        /* Stat Cards */
        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            padding: 1.25rem 1.4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-icon {
            font-size: 1rem;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .stat-subtext {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Content Card */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            padding: 1.25rem;
            margin-top: 1.5rem;
        }

        /* Filter Row */
        .filter-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
        }

        .filter-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-table-input {
            width: 260px;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-dark);
            font-size: 0.85rem;
            outline: none;
        }

        .select-filter {
            padding: 0.45rem 1.8rem 0.45rem 0.85rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-dark);
            font-size: 0.85rem;
            outline: none;
            cursor: pointer;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .custom-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
            vertical-align: middle;
        }

        .custom-table tr:hover td {
            background-color: var(--nav-active-bg);
        }

        /* Badges */
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .badge-healthy {
            background-color: var(--badge-success-bg);
            color: var(--badge-success-text);
        }

        .badge-low {
            background-color: var(--badge-warning-bg);
            color: var(--badge-warning-text);
        }

        .badge-out {
            background-color: var(--badge-danger-bg);
            color: var(--badge-danger-text);
        }

        .badge-cat {
            background-color: var(--badge-primary-bg);
            color: var(--badge-primary-text);
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

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: modalFadeIn 0.2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.96); }
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

        .modal-close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.1rem;
            cursor: pointer;
        }

        .modal-close-btn:hover {
            color: var(--text-dark);
        }

        .modal-body-custom {
            padding: 1.5rem;
        }

        .form-group-custom {
            margin-bottom: 1.1rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
        }

        .form-control-custom {
            width: 100%;
            padding: 0.55rem 0.85rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-dark);
            font-size: 0.85rem;
            outline: none;
        }

        .form-control-custom:focus {
            border-color: #71717a;
        }

        .modal-footer-custom {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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

        /* Toast */
        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #09090b;
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-size: 0.85rem;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            z-index: 10001;
        }

        body.dark-mode .toast-notification {
            background-color: #f4f4f5;
            color: #09090b;
        }

        .toast-notification.show {
            display: flex;
            animation: toastUp 0.2s ease-out;
        }

        @keyframes toastUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar">
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
                    <li>
                        <a href="{{ url('/manager/analytics') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>Analytics</span>
                            </span>
                        </a>
                    </li>

                    <!-- Dropdown: Manage Store -->
                    <li>
                        <a href="javascript:void(0)" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
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
                        <a href="javascript:void(0)" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
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
                        <a href="javascript:void(0)" class="nav-item-link nav-dropdown-toggle" aria-expanded="true">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up"></i>
                                <span>Reports</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu show">
                            <li><a href="{{ url('/manager/analytics') }}" class="nav-subitem-link">Sales Report</a></li>
                            <li><a href="{{ url('/manager/expenses') }}" class="nav-subitem-link">Expense Report</a></li>
                            <li><a href="{{ url('/manager/inventory') }}" class="nav-subitem-link active">Inventory Report</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>

        <!-- Sidebar Profile Section -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center;">
                <div class="profile-avatar">MN</div>
                <div class="profile-info">
                    <span class="profile-name">Store Manager</span>
                    <span class="profile-email">manager@eduka.co.tz</span>
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
                <input type="text" class="search-input" placeholder="Search inventory, products, SKU..." id="globalSearchInput">
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
                <h1 class="page-title">Inventory & Stock Valuation Report</h1>
                <p class="page-subtext">Real-time valuation of store assets, inventory turnover analysis, and reorder alerts.</p>
            </div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('manager.inventory.export-valuation') }}" class="btn-custom-outline text-decoration-none" id="exportInventoryBtn">
                    <i class="bi bi-download"></i>
                    <span>Export Valuation</span>
                </a>
                <button type="button" class="btn-custom-outline" id="btnOpenSubCategoryModal">
                    <i class="bi bi-tags"></i>
                    <span>+ Sub-Category</span>
                </button>
                <button type="button" class="btn-custom-primary" id="btnOpenBatchModal">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>+ Kundi / Batch (Expiry)</span>
                </button>
            </div>
        </div>

        <!-- KPI Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Cost Valuation</span>
                        <i class="bi bi-cash-coin stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">TSh {{ number_format($totalCostValuation ?? 142850000) }}</div>
                        <div class="stat-subtext">Gharama halisi ya manunuzi ya stoo</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Estimated Retail Value</span>
                        <i class="bi bi-graph-up-arrow stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">TSh {{ number_format($totalRetailValuation ?? 188400000) }}</div>
                        <div class="stat-subtext">Thamani inayotarajiwa ikishauzwa</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Low Stock Alerts</span>
                        <i class="bi bi-exclamation-triangle stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">{{ $lowStockCount ?? 14 }} Bidhaa</div>
                        <div class="stat-subtext">Zilizofikia kiwango cha kuagiza upya</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Expiry & FEFO Batches</span>
                        <i class="bi bi-clock-history stat-icon text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-value text-danger">{{ $nearExpiryCount ?? 0 }} Makundi</div>
                        <div class="stat-subtext">Makundi yanayokaribia kuisha muda</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3-Tab Inventory Hub -->
        <div class="content-card">
            <!-- Nav Tabs -->
            <ul class="nav nav-pills mb-3 gap-2" id="inventoryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="tab-instock-btn" data-bs-toggle="pill" data-bs-target="#tab-instock" type="button" role="tab" style="font-size: 0.85rem; border-radius: 9999px;">
                        <i class="bi bi-boxes me-1"></i> Mzigo Uliopo (In Stock: {{ isset($inStockProducts) ? $inStockProducts->count() : 8 }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-warning" id="tab-lowstock-btn" data-bs-toggle="pill" data-bs-target="#tab-lowstock" type="button" role="tab" style="font-size: 0.85rem; border-radius: 9999px;">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Tahadhari ya Kuisha (Low Stock: {{ $lowStockCount ?? 0 }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-danger" id="tab-batches-btn" data-bs-toggle="pill" data-bs-target="#tab-batches" type="button" role="tab" style="font-size: 0.85rem; border-radius: 9999px;">
                        <i class="bi bi-calendar2-x-fill me-1"></i> Muda wa Kuisha kwa Kundi (FEFO Expiry: {{ $nearExpiryCount ?? 0 }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="inventoryTabsContent">
                <!-- Tab 1: In Stock -->
                <div class="tab-pane fade show active" id="tab-instock" role="tabpanel">
                    <div class="filter-row">
                        <div class="filter-left">
                            <input type="text" class="search-table-input" id="tableSearchInput" placeholder="Tafuta bidhaa, barcode, SKU...">
                            <select class="select-filter" id="categoryFilter">
                                <option value="">Makundi Yote (Categories)</option>
                                @if(isset($categories))
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                @else
                                    <option value="Beverages & Soft Drinks">Beverages & Soft Drinks</option>
                                    <option value="Dry Food & Cooking Oil">Dry Food & Cooking Oil</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="custom-table" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th>SKU / Barcode</th>
                                    <th>Bidhaa (Product)</th>
                                    <th>Kundi & Sub-Category</th>
                                    <th>Idadi Iliyopo (Stock)</th>
                                    <th>Gharama (Cost)</th>
                                    <th>Rejareja (Retail)</th>
                                    <th>Jumla ya Thamani</th>
                                    <th>Hali</th>
                                    <th style="text-align: right;">Kitendo</th>
                                </tr>
                            </thead>
                            <tbody id="inventoryTableBody">
                                @if(isset($inStockProducts) && $inStockProducts->count() > 0)
                                    @foreach($inStockProducts as $prod)
                                        @php
                                            $stk = $prod->branchStocks->first()?->quantity ?? 0;
                                            $totalVal = $stk * (float)$prod->cost_price;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div style="font-weight: 600;">{{ $prod->sku }}</div>
                                                <div style="font-size: 0.72rem; color: var(--text-muted);">{{ $prod->barcode ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div style="font-weight: 600;">{{ $prod->name }}</div>
                                                <div style="font-size: 0.72rem; color: var(--text-muted);">Kipimo: {{ $prod->unit }}</div>
                                            </td>
                                            <td>
                                                <span class="badge-pill badge-cat">{{ $prod->category?->name ?? 'General' }}</span>
                                                @if($prod->subCategory)
                                                    <span class="badge bg-light text-dark border ms-1" style="font-size: 0.68rem;">{{ $prod->subCategory->name }}</span>
                                                @endif
                                            </td>
                                            <td style="font-weight: 600;">{{ $stk }} {{ $prod->unit }}</td>
                                            <td>TSh {{ number_format($prod->cost_price) }}</td>
                                            <td>TSh {{ number_format($prod->selling_price) }}</td>
                                            <td style="font-weight: 700;">TSh {{ number_format($totalVal) }}</td>
                                            <td><span class="badge-pill badge-healthy"><i class="bi bi-check-circle-fill"></i> Healthy</span></td>
                                            <td style="text-align: right;">
                                                <button class="btn-custom-outline quick-adjust-btn" data-id="{{ $prod->id }}" data-name="{{ $prod->name }}" data-stock="{{ $stk }}" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-pencil-square"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600;">SKU-1002</div>
                                            <div style="font-size: 0.72rem; color: var(--text-muted);">616110020101</div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600;">Azam Wheat Flour 2kg Pack</div>
                                            <div style="font-size: 0.72rem; color: var(--text-muted);">Bakhresa Group</div>
                                        </td>
                                        <td><span class="badge-pill badge-cat">Dry Food & Cooking Oil</span></td>
                                        <td style="font-weight: 600;">380 Bags</td>
                                        <td>TSh 2,800</td>
                                        <td>TSh 3,500</td>
                                        <td style="font-weight: 700;">TSh 1,064,000</td>
                                        <td><span class="badge-pill badge-healthy"><i class="bi bi-check-circle-fill"></i> Healthy</span></td>
                                        <td style="text-align: right;">
                                            <button class="btn-custom-outline quick-adjust-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600;">SKU-1008</div>
                                            <div style="font-size: 0.72rem; color: var(--text-muted);">616110020102</div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600;">Coca-Cola 500ml Pet Crate (24x)</div>
                                            <div style="font-size: 0.72rem; color: var(--text-muted);">Coca-Cola Kwanza Ltd</div>
                                        </td>
                                        <td><span class="badge-pill badge-cat">Beverages & Soft Drinks</span></td>
                                        <td style="font-weight: 600;">145 Crates</td>
                                        <td>TSh 19,500</td>
                                        <td>TSh 24,000</td>
                                        <td style="font-weight: 700;">TSh 2,827,500</td>
                                        <td><span class="badge-pill badge-healthy"><i class="bi bi-check-circle-fill"></i> Healthy</span></td>
                                        <td style="text-align: right;">
                                            <button class="btn-custom-outline quick-adjust-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 2: Low Stock -->
                <div class="tab-pane fade" id="tab-lowstock" role="tabpanel">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Bidhaa (Product)</th>
                                    <th>Kundi (Category)</th>
                                    <th>Kiwango cha Sasa (Stock)</th>
                                    <th>Kiwango cha Chini (Alert Min)</th>
                                    <th>Gharama (Cost)</th>
                                    <th>Hali ya Hatari</th>
                                    <th style="text-align: right;">Agiza Upya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                                    @foreach($lowStockProducts as $low)
                                        @php $qty = $low->branchStocks->first()?->quantity ?? 0; @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $low->name }}</div>
                                                <div class="text-muted" style="font-size: 0.72rem;">SKU: {{ $low->sku }}</div>
                                            </td>
                                            <td><span class="badge-pill badge-cat">{{ $low->category?->name ?? 'General' }}</span></td>
                                            <td class="text-danger fw-bold">{{ $qty }} {{ $low->unit }}</td>
                                            <td>{{ $low->min_alert_qty }} {{ $low->unit }}</td>
                                            <td>TSh {{ number_format($low->cost_price) }}</td>
                                            <td>
                                                @if($qty <= 0)
                                                    <span class="badge-pill badge-out"><i class="bi bi-x-circle-fill"></i> Imeisha (Out of Stock)</span>
                                                @else
                                                    <span class="badge-pill badge-low"><i class="bi bi-exclamation-triangle-fill"></i> Chini ya Kiwango</span>
                                                @endif
                                            </td>
                                            <td style="text-align: right;">
                                                <button type="button" class="btn btn-sm btn-outline-primary" style="font-size: 0.74rem; padding: 2px 8px; border-radius: 9999px;">
                                                    <i class="bi bi-cart-plus me-1"></i> Agiza Stoo
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <div class="fw-bold">Korie Cooking Oil 5L Jerrican</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">SKU: SKU-1014</div>
                                        </td>
                                        <td><span class="badge-pill badge-cat">Dry Food & Cooking Oil</span></td>
                                        <td class="text-danger fw-bold">18 Units</td>
                                        <td>50 Units</td>
                                        <td>TSh 24,000</td>
                                        <td><span class="badge-pill badge-low"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock (18/50)</span></td>
                                        <td style="text-align: right;">
                                            <button type="button" class="btn btn-sm btn-outline-primary" style="font-size: 0.74rem; padding: 2px 8px; border-radius: 9999px;"><i class="bi bi-cart-plus me-1"></i> Agiza Stoo</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 3: Batches & Expiry (FEFO) -->
                <div class="tab-pane fade" id="tab-batches" role="tabpanel">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Namba ya Kundi (Batch No)</th>
                                    <th>Bidhaa (Product)</th>
                                    <th>Mzigo Uliopo</th>
                                    <th>Bei ya Kununua</th>
                                    <th>Bei ya Kuuza</th>
                                    <th>Muda wa Kuisha (Expiry)</th>
                                    <th>Siku Zilizosalia</th>
                                    <th>Hali ya FEFO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($nearExpiryBatches) && $nearExpiryBatches->count() > 0)
                                    @foreach($nearExpiryBatches as $b)
                                        @php
                                            $days = $b->days_until_expiry;
                                            $isExpired = $b->is_expired;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-bold font-monospace">{{ $b->batch_number }}</div>
                                                <div class="text-muted" style="font-size: 0.72rem;">Mzalishaji: {{ $b->manufacture_date?->format('d/m/Y') ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $b->product?->name ?? 'Bidhaa' }}</div>
                                                <div class="text-muted" style="font-size: 0.72rem;">Kipimo: {{ $b->product?->unit ?? 'pcs' }}</div>
                                            </td>
                                            <td class="fw-bold">{{ $b->quantity }} {{ $b->product?->unit ?? 'pcs' }}</td>
                                            <td>TSh {{ number_format($b->cost_price) }}</td>
                                            <td>TSh {{ number_format($b->selling_price) }}</td>
                                            <td class="fw-bold {{ $isExpired ? 'text-danger' : ($days < 60 ? 'text-warning' : '') }}">
                                                {{ $b->expiry_date?->format('d/m/Y') ?? 'Bila Expiry' }}
                                            </td>
                                            <td>
                                                @if($isExpired)
                                                    <span class="text-danger fw-bold">Imekwisha Muda</span>
                                                @else
                                                    <span>{{ $days }} Siku</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($isExpired)
                                                    <span class="status-badge badge-danger"><i class="bi bi-x-octagon-fill"></i> Expired</span>
                                                @elseif($days <= 30)
                                                    <span class="status-badge badge-warning"><i class="bi bi-exclamation-triangle-fill"></i> Urgent FEFO (<30d)</span>
                                                @else
                                                    <span class="status-badge badge-primary"><i class="bi bi-clock-fill"></i> Near Expiry (<90d)</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <div class="fw-bold font-monospace">BCH-2026-081</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">Mzalishaji: 01/01/2026</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">Asas Fresh Milk 500ml Carton</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">Dairy</div>
                                        </td>
                                        <td class="fw-bold">8 Cartons</td>
                                        <td>TSh 1,400</td>
                                        <td>TSh 1,800</td>
                                        <td class="fw-bold text-danger">15/10/2026</td>
                                        <td><span class="text-danger fw-bold">16 Siku</span></td>
                                        <td><span class="status-badge badge-warning"><i class="bi bi-exclamation-triangle-fill"></i> Urgent FEFO (<30d)</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="fw-bold font-monospace">BCH-2026-044</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">Mzalishaji: 12/03/2026</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">Bakhresa Biscuits Pack 200g</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">Snacks</div>
                                        </td>
                                        <td class="fw-bold">45 Packs</td>
                                        <td>TSh 800</td>
                                        <td>TSh 1,200</td>
                                        <td class="fw-bold text-warning">28/11/2026</td>
                                        <td><span>60 Siku</span></td>
                                        <td><span class="status-badge badge-primary"><i class="bi bi-clock-fill"></i> Near Expiry (<90d)</span></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: Add New Batch (Packaged Goods Expiry Management) -->
    <div class="modal-overlay" id="batchModal">
        <div class="modal-card" style="max-width: 540px;">
            <div class="modal-header-custom">
                <h3><i class="bi bi-box-seam me-2 text-primary"></i>Ongeza Kundi la Mzigo (New Batch Entry)</h3>
                <button type="button" class="modal-close-btn" id="closeBatchModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="{{ route('manager.inventory.batch.store') }}" method="POST">
                @csrf
                <div class="modal-body-custom">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Chagua Bidhaa (Product) *</label>
                        <select name="product_id" class="form-control-custom" required>
                            <option value="">-- Chagua Bidhaa --</option>
                            @if(isset($inStockProducts))
                                @foreach($inStockProducts as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Namba ya Batch (Batch No) *</label>
                            <input type="text" name="batch_number" class="form-control-custom" placeholder="Mfano: BTH-2026-001" required>
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Muuzaji Mkuu (Supplier)</label>
                            <select name="supplier_id" class="form-control-custom">
                                <option value="">-- Hakuna Muuzaji --</option>
                                @if(isset($suppliers))
                                    @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Idadi ya Kuingiza (Quantity) *</label>
                            <input type="number" name="quantity" class="form-control-custom" placeholder="Mfano: 100" min="1" required>
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Bei ya Kununua (Cost TSh) *</label>
                            <input type="number" name="cost_price" class="form-control-custom" placeholder="Mfano: 2500" min="0" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Bei ya Kuuza Rejareja (Selling TSh) *</label>
                        <input type="number" name="selling_price" class="form-control-custom" placeholder="Mfano: 3500" min="0" required>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Tarehe ya Kutengenezwa (Manufacture)</label>
                            <input type="date" name="manufacture_date" class="form-control-custom">
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Tarehe ya Kuisha (Expiry Date) *</label>
                            <input type="date" name="expiry_date" class="form-control-custom" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-custom-outline" id="cancelBatchModal">Ghairi</button>
                    <button type="submit" class="btn-custom-primary"><i class="bi bi-save me-1"></i> Hifadhi Kundi (Batch)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Add New Sub-Category -->
    <div class="modal-overlay" id="subCategoryModal">
        <div class="modal-card" style="max-width: 480px;">
            <div class="modal-header-custom">
                <h3><i class="bi bi-tags me-2 text-primary"></i>Ongeza Sub-Category Mpya</h3>
                <button type="button" class="modal-close-btn" id="closeSubCatModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="{{ route('manager.inventory.sub-category.store') }}" method="POST">
                @csrf
                <div class="modal-body-custom">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Kundi Kuu (Parent Category) *</label>
                        <select name="category_id" class="form-control-custom" required>
                            <option value="">-- Chagua Kundi Kuu --</option>
                            @if(isset($categories))
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Jina la Sub-Category *</label>
                        <input type="text" name="name" class="form-control-custom" placeholder="Mfano: Mchele, Unga wa Sembe, Juisi za Boksi..." required>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Kodi / Code (Hiari)</label>
                        <input type="text" name="code" class="form-control-custom" placeholder="Mfano: SUB-01">
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Maelezo Mafupi (Description)</label>
                        <textarea name="description" class="form-control-custom" rows="2" placeholder="Ufafanuzi wa aina hii ya bidhaa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-custom-outline" id="cancelSubCatModal">Ghairi</button>
                    <button type="submit" class="btn-custom-primary"><i class="bi bi-check2-circle me-1"></i> Hifadhi Sub-Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Stock Adjustment -->
    <div class="modal-overlay" id="adjustModal">
        <div class="modal-card">
            <div class="modal-header-custom">
                <h3 id="adjustModalTitle">Adjust Stock Count</h3>
                <button type="button" class="modal-close-btn" id="closeAdjustModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="stockAdjustForm">
                <div class="modal-body-custom">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Product Selected</label>
                        <input type="text" class="form-control-custom" id="adjProdName" readonly>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Current Stock</label>
                            <input type="text" class="form-control-custom" id="adjCurrentStock" readonly>
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">New Count / Add Units</label>
                            <input type="number" class="form-control-custom" id="adjNewUnits" placeholder="e.g. 50" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Reason for Adjustment</label>
                        <select class="form-control-custom" id="adjReason">
                            <option value="Restock / Goods Intake">Restock / Goods Intake</option>
                            <option value="Physical Count Audit">Physical Count Audit</option>
                            <option value="Damaged / Spoilage">Damaged / Spoilage</option>
                            <option value="Customer Return">Customer Return</option>
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Auditor / Manager Notes</label>
                        <input type="text" class="form-control-custom" id="adjNotes" placeholder="Verification note...">
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-custom-outline" id="cancelAdjustModal">Cancel</button>
                    <button type="submit" class="btn-custom-primary">Save Adjustment</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMsg">Action completed successfully!</span>
    </div>

    <script>
        $(document).ready(function() {
            // Dark Mode Toggle
            if (localStorage.getItem('eduka_theme') === 'dark') {
                $('body').addClass('dark-mode');
                $('#themeIcon').removeClass('bi-sun').addClass('bi-moon');
            }

            $('#theme-toggle-btn').on('click', function() {
                $('body').toggleClass('dark-mode');
                const isDark = $('body').hasClass('dark-mode');
                localStorage.setItem('eduka_theme', isDark ? 'dark' : 'light');
                $('#themeIcon').toggleClass('bi-sun bi-moon');
            });

            // Sidebar dropdown toggle
            $('.nav-dropdown-toggle').on('click', function() {
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !isExpanded);
                $(this).next('.nav-submenu').toggleClass('show');
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

            // Quick Adjust Modal
            let currentRow = null;
            $(document).on('click', '.quick-adjust-btn', function() {
                currentRow = $(this).closest('tr');
                const prodName = currentRow.find('td:nth-child(2) div:first-child').text();
                const curStock = currentRow.find('td:nth-child(4)').text();

                $('#adjProdName').val(prodName);
                $('#adjCurrentStock').val(curStock);
                $('#adjNewUnits').val('');
                $('#adjustModal').addClass('show');
            });

            $('#closeAdjustModal, #cancelAdjustModal').on('click', function() {
                $('#adjustModal').removeClass('show');
            });

            // Batch Modal Opener & Closer
            $('#btnOpenBatchModal').on('click', function() {
                $('#batchModal').addClass('show');
            });
            $('#closeBatchModal, #cancelBatchModal').on('click', function() {
                $('#batchModal').removeClass('show');
            });

            // SubCategory Modal Opener & Closer
            $('#btnOpenSubCategoryModal').on('click', function() {
                $('#subCategoryModal').addClass('show');
            });
            $('#closeSubCatModal, #cancelSubCatModal').on('click', function() {
                $('#subCategoryModal').removeClass('show');
            });

            // Tabs Switcher Handler
            $('#inventoryTabs button[data-bs-toggle="pill"]').on('click', function(e) {
                e.preventDefault();
                $('#inventoryTabs button').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('bs-target');
                $('#inventoryTabsContent .tab-pane').removeClass('show active');
                $(target).addClass('show active');
            });

            // Close modals when clicking outside
            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });

            $('#stockAdjustForm').on('submit', function(e) {
                e.preventDefault();
                const added = parseInt($('#adjNewUnits').val());
                if (currentRow && !isNaN(added)) {
                    showToast('Stock quantity successfully adjusted for ' + $('#adjProdName').val());
                    $('#adjustModal').removeClass('show');
                }
            });

            // Export & Audit buttons
            $('#exportInventoryBtn').on('click', function() {
                showToast('Generating Inventory Valuation Excel / CSV report...');
            });

            $('#runAuditBtn').on('click', function() {
                showToast('Synchronizing inventory levels with POS & Storekeeper records...');
            });

            // Toast helper
            function showToast(msg) {
                $('#toastMsg').text(msg);
                $('#toastNotification').addClass('show');
                setTimeout(function() {
                    $('#toastNotification').removeClass('show');
                }, 3000);
            }

            // Table Filter Logic
            function filterTable() {
                const search = $('#tableSearchInput').val().toLowerCase();
                const category = $('#categoryFilter').val().toLowerCase();
                const status = $('#statusFilter').val().toLowerCase();

                let visibleCount = 0;
                $('#inventoryTableBody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    const matchesSearch = !search || rowText.includes(search);
                    const matchesCategory = !category || rowText.includes(category);
                    const matchesStatus = !status || rowText.includes(status);

                    if (matchesSearch && matchesCategory && matchesStatus) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                });

                $('#recordCounter').text(`Showing ${visibleCount} stock items`);
            }

            $('#tableSearchInput, #categoryFilter, #statusFilter').on('input change', filterTable);

            // Global search ⌘ K
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    $('#globalSearchInput').focus();
                }
            });
        });
    </script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
