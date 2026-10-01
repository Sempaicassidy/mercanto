<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permissions & Role Access - mercanto</title>

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
            --toggle-active: #09090b;
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
            --toggle-active: #ffffff;
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

        /* Page Header Title */
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

        /* Role Selector Tabs */
        .role-nav-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .role-tab-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.65rem 1.15rem;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .role-tab-item:hover {
            border-color: #a1a1aa;
        }

        .role-tab-item.active {
            background-color: var(--nav-active-bg);
            border-color: var(--text-dark);
        }

        .role-tab-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 9999px;
            background-color: var(--border-color);
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Content Card */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
        }

        /* Module Section */
        .permission-module {
            margin-bottom: 2rem;
        }

        .permission-module:last-child {
            margin-bottom: 0;
        }

        .module-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .module-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        /* Permission Row */
        .permission-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0.5rem;
            border-radius: 8px;
            transition: background-color 0.12s ease;
        }

        .permission-item-row:hover {
            background-color: var(--nav-active-bg);
        }

        .perm-info h5 {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .perm-info p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 2px 0 0 0;
        }

        .risk-badge {
            font-size: 0.68rem;
            padding: 2px 7px;
            border-radius: 9999px;
            font-weight: 600;
        }

        .risk-badge.sensitive {
            background-color: var(--badge-warning-bg);
            color: var(--badge-warning-text);
        }

        .risk-badge.standard {
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

        /* Modern Toggle Switch */
        .form-check-input-custom {
            width: 2.75rem;
            height: 1.45rem;
            background-color: #e4e4e7;
            border: none;
            border-radius: 2rem;
            position: relative;
            cursor: pointer;
            outline: none;
            appearance: none;
            transition: background-color 0.2s ease;
        }

        body.dark-mode .form-check-input-custom {
            background-color: #3f3f46;
        }

        .form-check-input-custom:checked {
            background-color: var(--toggle-active);
        }

        .form-check-input-custom::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 50%;
            background-color: #ffffff;
            transition: transform 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }

        body.dark-mode .form-check-input-custom:checked::before {
            background-color: #09090b;
        }

        .form-check-input-custom:checked::before {
            transform: translateX(1.3rem);
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
            <!-- Workspace Brand Header -->
            <div class="workspace-header">
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

                    <!-- Dropdown: Manage Staff (Active Section) -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle open" aria-expanded="true">
                            <span class="nav-item-left">
                                <i class="bi bi-people"></i>
                                <span>Manage Staff</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu open">
                            <li><a href="{{ url('/manager/staff_attendance') }}" class="nav-subitem-link">Staff Shifts & Attendance</a></li>
                            <li><a href="{{ url('/manager/staff_salary') }}" class="nav-subitem-link">Staff Salary & Allowances</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link active">Permissions</a></li>
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

                    <!-- Dropdown: Auditing -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-shield-check"></i>
                                <span>Auditing</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="{{ url('/manager/auditing') }}" class="nav-subitem-link">Activity Logs</a></li>
                            <li><a href="{{ url('/manager/damages') }}" class="nav-subitem-link">Stock Audit & Wastage</a></li>
                            <li><a href="{{ url('/manager/auditing?tab=alerts') }}" class="nav-subitem-link">Audit Trail & Alerts</a></li>
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link active">Auditing Settings & Roles</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Bottom Profile Section -->
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
                <input type="text" class="search-input" placeholder="Search permissions..." id="global-search-input">
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
        <div class="page-header-row">
            <div>
                <h1 class="page-title">Role Permissions & Access Control</h1>
                <p class="page-subtext">Configure operational authorities, POS transaction limits, inventory privileges, and manager gates.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-outline-custom" id="resetDefaultsBtn">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <span>Reset Defaults</span>
                </button>
                <button class="btn-outline-custom" id="newRoleBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>New Role</span>
                </button>
                <button class="btn-dark-custom" id="savePermissionsBtn">
                    <i class="bi bi-check2-circle"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Active Role Configured</span>
                        <i class="bi bi-person-badge stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary" id="activeRoleDisplay">Store Manager</div>
                        <div class="stat-subtext"><span class="status-badge badge-primary">2 Staff Assigned</span></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Enabled Privileges</span>
                        <i class="bi bi-shield-lock stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success" id="enabledPermCount">18 / 20</div>
                        <div class="stat-subtext">90% Operational Authority</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Sensitive Actions</span>
                        <i class="bi bi-exclamation-triangle stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">3 Restricted</div>
                        <div class="stat-subtext">Requires 2FA / Manager PIN</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Audit Log Status</span>
                        <i class="bi bi-activity stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">Live Active</div>
                        <div class="stat-subtext">All permission changes recorded</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Navigation Tabs -->
        <div class="role-nav-tabs">
            <div class="role-tab-item active" data-role="manager">
                <i class="bi bi-person-gear"></i>
                <span style="font-size: 0.85rem; font-weight: 600;">Store Manager</span>
                <span class="role-tab-badge">2 Users</span>
            </div>
            <div class="role-tab-item" data-role="cashier">
                <i class="bi bi-cart3"></i>
                <span style="font-size: 0.85rem; font-weight: 600;">Cashier (POS)</span>
                <span class="role-tab-badge">6 Users</span>
            </div>
            <div class="role-tab-item" data-role="storekeeper">
                <i class="bi bi-box-seam"></i>
                <span style="font-size: 0.85rem; font-weight: 600;">Store Keeper</span>
                <span class="role-tab-badge">3 Users</span>
            </div>
            <div class="role-tab-item" data-role="admin">
                <i class="bi bi-shield-check"></i>
                <span style="font-size: 0.85rem; font-weight: 600;">Store Owner</span>
                <span class="role-tab-badge">Super Admin</span>
            </div>
        </div>

        <!-- Permission Matrix Card -->
        <div class="content-card">
            <!-- Module 1: POS & Sales -->
            <div class="permission-module">
                <div class="module-header">
                    <h4 class="module-title"><i class="bi bi-cart-check"></i> Point of Sale & Checkout</h4>
                    <span style="font-size: 0.78rem; color: var(--text-muted);">Checkout desk, cash drawer, and receipt policies</span>
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Process Sales & Print Receipts <span class="risk-badge standard">Standard</span></h5>
                        <p>Allow cashier to scan barcodes, checkout orders, and print customer thermal receipts.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="pos_sales">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Apply Custom Line Discount <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Allow manual percentage or amount discount per item without supervisor PIN approval.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="pos_discount">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Void / Cancel Active Order <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Authorize cancelling orders in cart or voiding receipt after printing.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="pos_void">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Issue Cash Customer Refund <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Return funds to customer from physical cash drawer for damaged or returned stock.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="pos_refund">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Open Cash Drawer Manually <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Allow triggering cash drawer pop-out without completing a sale transaction.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="pos_drawer">
                </div>
            </div>

            <!-- Module 2: Warehouse & Stock -->
            <div class="permission-module">
                <div class="module-header">
                    <h4 class="module-title"><i class="bi bi-boxes"></i> Inventory & Warehouse Control</h4>
                    <span style="font-size: 0.78rem; color: var(--text-muted);">Stock intake, catalog updates, and adjustment authority</span>
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>View Stock Quantities & Locations <span class="risk-badge standard">Standard</span></h5>
                        <p>Allow checking SKU stock levels, bin locations, and inventory counts.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="inv_view">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Add / Edit Product Details <span class="risk-badge standard">Standard</span></h5>
                        <p>Create new SKUs, update retail prices, categories, and barcode numbers.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="inv_edit">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Stock Count Adjustment & Damage Write-off <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Adjust physical inventory levels due to spoilage, shrinkage, or audit variance.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="inv_adjust">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Approve Goods Received Notes (GRN) <span class="risk-badge standard">Standard</span></h5>
                        <p>Receive inbound shipments, record supplier invoice numbers, and increment stock.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="inv_grn">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>View Wholesale Buying / Cost Prices <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Expose supplier purchase costs and margin calculations to this role.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="inv_cost">
                </div>
            </div>

            <!-- Module 3: Staff & Payroll -->
            <div class="permission-module">
                <div class="module-header">
                    <h4 class="module-title"><i class="bi bi-people"></i> Staff & Payroll Management</h4>
                    <span style="font-size: 0.78rem; color: var(--text-muted);">Attendance timesheets, salary records, and duty rosters</span>
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>View Staff Attendance & Shifts <span class="risk-badge standard">Standard</span></h5>
                        <p>See shift rosters, clock-in records, and punctuality reports.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="staff_view">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Manual Punch & Timesheet Edit <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Modify check-in/out timestamps and approve overtime hours.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="staff_timesheet">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>View Salary & Compensation Records <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Access monthly payroll totals, employee pay slips, and bonus disbursements.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="staff_salary">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Modify Staff Roles & Permissions <span class="risk-badge sensitive">Admin Only</span></h5>
                        <p>Grant or revoke permissions and assign system roles to employees.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="staff_perm">
                </div>
            </div>

            <!-- Module 4: Reports & Auditing -->
            <div class="permission-module">
                <div class="module-header">
                    <h4 class="module-title"><i class="bi bi-graph-up"></i> Reports & Financial Auditing</h4>
                    <span style="font-size: 0.78rem; color: var(--text-muted);">Sales trends, gross margin visibility, and activity logs</span>
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>View Sales Revenue Reports <span class="risk-badge standard">Standard</span></h5>
                        <p>Access daily and monthly gross sales analytics and charts.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="rep_sales">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>View Net Profit & Margin Metrics <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>Display net store profits, markup margins, and expense balance.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="rep_profit">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Export Financial Reports (Excel/PDF) <span class="risk-badge standard">Standard</span></h5>
                        <p>Download structured financial spreadsheets and tax summary sheets.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="rep_export">
                </div>

                <div class="permission-item-row">
                    <div class="perm-info">
                        <h5>Inspect System Audit Trail & Activity Logs <span class="risk-badge sensitive">Sensitive</span></h5>
                        <p>View timestamped records of logins, price changes, and cancellations.</p>
                    </div>
                    <input type="checkbox" class="form-check-input-custom" checked data-perm="rep_audit">
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: New Custom Role -->
    <div class="modal-overlay" id="newRoleModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Create Custom Operational Role</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="newRoleModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="newRoleForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Role Title</label>
                        <input type="text" class="form-control-custom" placeholder="e.g. Lead Shift Supervisor" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Clone Permissions From</label>
                        <select class="form-control-custom">
                            <option>Cashier (POS)</option>
                            <option>Store Keeper</option>
                            <option>Store Manager</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Role Description</label>
                        <textarea class="form-control-custom" rows="2" placeholder="Brief scope of duties and permissions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="newRoleModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom">Create & Configure</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill" style="color: var(--text-dark);"></i>
        <span id="toastNotifyMsg">Permissions saved successfully</span>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Dropdown Collapsible Submenu
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                const btn = $(this);
                const subMenu = btn.next('.nav-submenu');
                subMenu.stop(true, true).slideToggle(180);
                btn.toggleClass('open');
                btn.attr('aria-expanded', btn.hasClass('open'));
            });

            // Theme Toggle
            let isLight = true;
            $('#theme-toggle-btn').on('click', function() {
                isLight = !isLight;
                $('body').toggleClass('dark-mode');
                $('#theme-icon').toggleClass('bi-sun bi-moon-stars');
            });

            // Cmd+K Shortcut
            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    $('#global-search-input').focus();
                }
            });

            // Filter permissions on search
            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase();
                $('.permission-item-row').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(term));
                });
            });

            // Role matrix definitions
            const roleDefaults = {
                manager: {
                    pos_sales: true, pos_discount: true, pos_void: true, pos_refund: true, pos_drawer: true,
                    inv_view: true, inv_edit: true, inv_adjust: true, inv_grn: true, inv_cost: true,
                    staff_view: true, staff_timesheet: true, staff_salary: true, staff_perm: true,
                    rep_sales: true, rep_profit: true, rep_export: true, rep_audit: true
                },
                cashier: {
                    pos_sales: true, pos_discount: false, pos_void: false, pos_refund: false, pos_drawer: true,
                    inv_view: true, inv_edit: false, inv_adjust: false, inv_grn: false, inv_cost: false,
                    staff_view: false, staff_timesheet: false, staff_salary: false, staff_perm: false,
                    rep_sales: true, rep_profit: false, rep_export: false, rep_audit: false
                },
                storekeeper: {
                    pos_sales: false, pos_discount: false, pos_void: false, pos_refund: false, pos_drawer: false,
                    inv_view: true, inv_edit: true, inv_adjust: true, inv_grn: true, inv_cost: true,
                    staff_view: true, staff_timesheet: false, staff_salary: false, staff_perm: false,
                    rep_sales: false, rep_profit: false, rep_export: true, rep_audit: false
                },
                admin: {
                    pos_sales: true, pos_discount: true, pos_void: true, pos_refund: true, pos_drawer: true,
                    inv_view: true, inv_edit: true, inv_adjust: true, inv_grn: true, inv_cost: true,
                    staff_view: true, staff_timesheet: true, staff_salary: true, staff_perm: true,
                    rep_sales: true, rep_profit: true, rep_export: true, rep_audit: true
                }
            };

            function updateTogglesForRole(roleKey) {
                const conf = roleDefaults[roleKey] || roleDefaults.manager;
                let activeCount = 0;
                $('.form-check-input-custom').each(function() {
                    const perm = $(this).data('perm');
                    const isAllowed = conf[perm] !== undefined ? conf[perm] : true;
                    $(this).prop('checked', isAllowed);
                    if (isAllowed) activeCount++;
                });
                $('#enabledPermCount').text(activeCount + ' / 18');
            }

            $('.role-tab-item').on('click', function() {
                $('.role-tab-item').removeClass('active');
                $(this).addClass('active');
                const role = $(this).data('role');
                const roleName = $(this).find('span:first').text();
                $('#activeRoleDisplay').text(roleName);
                updateTogglesForRole(role);
                showToast('Viewing permissions for role: ' + roleName);
            });

            // Count changes on toggle
            $('.form-check-input-custom').on('change', function() {
                const total = $('.form-check-input-custom').length;
                const checked = $('.form-check-input-custom:checked').length;
                $('#enabledPermCount').text(checked + ' / ' + total);
            });

            // Save Permissions
            $('#savePermissionsBtn').on('click', function() {
                showToast('Permissions matrix saved & propagated to all active sessions!');
            });

            $('#resetDefaultsBtn').on('click', function() {
                const activeRole = $('.role-tab-item.active').data('role');
                updateTogglesForRole(activeRole);
                showToast('Permissions reset to system defaults for ' + activeRole);
            });

            // Modals
            $('#newRoleBtn').on('click', function() {
                $('#newRoleModal').addClass('show');
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

            $('#newRoleForm').on('submit', function(e) {
                e.preventDefault();
                $('#newRoleModal').removeClass('show');
                showToast('New role created and added to workspace!');
                this.reset();
            });

            function showToast(msg) {
                const toast = $('#toastNotify');
                $('#toastNotifyMsg').html(msg);
                toast.stop(true, true).fadeIn(180).delay(3000).fadeOut(200);
            }

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
        });
    </script>
</body>
</html>
