<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Report - mercanto</title>

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
            justify-content: space-between;
            margin-bottom: 1.5rem;
            gap: 12px;
            width: 100%;
        }

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
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

        /* Card Container */
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

        .badge-paid {
            background-color: var(--badge-success-bg);
            color: var(--badge-success-text);
        }

        .badge-pending {
            background-color: var(--badge-warning-bg);
            color: var(--badge-warning-text);
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
            max-width: 540px;
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

        /* Role Switcher Modal Styles */
        .role-modal-overlay {
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
            z-index: 10000;
            padding: 1rem;
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
                            <li><a href="{{ url('/manager/expenses') }}" class="nav-subitem-link active">Expense Report</a></li>
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
                <input type="text" class="search-input" placeholder="Search expenses, invoices..." id="globalSearchInput">
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
                <h1 class="page-title">Expenses & Operational Costs</h1>
                <p class="page-subtext">Record, monitor, and audit day-to-day expenditures, utility bills, and vendor disbursements.</p>
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="btn-custom-outline" id="exportBtn">
                    <i class="bi bi-download"></i>
                    <span>Export Report</span>
                </button>
                <button class="btn-custom-primary" id="openAddExpenseBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>Record Expense</span>
                </button>
            </div>
        </div>

        <!-- KPI Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">This Month Expenses</span>
                        <i class="bi bi-cash-stack stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning" id="kpiTotalMonth">TSh 7,840,000</div>
                        <div class="stat-subtext">↓ 4.2% lower than last month</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Utilities & Rent</span>
                        <i class="bi bi-lightning-charge stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">TSh 2,450,000</div>
                        <div class="stat-subtext">Electricity, Water & Shop Rent</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Procurement & Logistics</span>
                        <i class="bi bi-truck stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">TSh 3,890,000</div>
                        <div class="stat-subtext">Freight, offloading & courier fees</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Pending Approval</span>
                        <i class="bi bi-clock-history stat-icon text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-value text-danger">TSh 1,500,000</div>
                        <div class="stat-subtext">2 invoices awaiting authorization</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search Row -->
        <div class="content-card">
            <div class="filter-row">
                <div class="filter-left">
                    <input type="text" class="search-table-input" id="tableSearchInput" placeholder="Search expense description, ref...">
                    <select class="select-filter" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="Utilities & Bills">Utilities & Bills</option>
                        <option value="Logistics & Delivery">Logistics & Delivery</option>
                        <option value="Rent & Lease">Rent & Lease</option>
                        <option value="Packaging & Bags">Packaging & Bags</option>
                        <option value="Maintenance & Repair">Maintenance & Repair</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                    </select>
                    <select class="select-filter" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending Approval</option>
                    </select>
                </div>
                <div>
                    <span style="font-size: 0.8rem; color: var(--text-muted);" id="recordCounter">Showing 7 expenses</span>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="custom-table" id="expensesTable">
                    <thead>
                        <tr>
                            <th>Date / Ref</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Vendor / Recipient</th>
                            <th>Payment Method</th>
                            <th>Amount (TSh)</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="expensesTableBody">
                        <tr>
                            <td>
                                <div style="font-weight: 600;">22 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0891</div>
                            </td>
                            <td>TANESCO Electricity Tokens - Monthly Unit</td>
                            <td><span class="badge-pill badge-cat">Utilities & Bills</span></td>
                            <td>TANESCO Prepaid</td>
                            <td>M-Pesa Business Till</td>
                            <td class="font-monospace text-warning font-semibold">TSh 450,000</td>
                            <td><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;" title="View Voucher"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 600;">21 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0890</div>
                            </td>
                            <td>Carrier Delivery from Dar Port to Kariakoo Store</td>
                            <td><span class="badge-pill badge-cat">Logistics & Delivery</span></td>
                            <td>Kilimanjaro Express Cargo</td>
                            <td>Bank Transfer (CRDB)</td>
                            <td class="font-monospace text-warning font-semibold">TSh 1,200,000</td>
                            <td><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 600;">20 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0889</div>
                            </td>
                            <td>DAWASA Water Utility Monthly Bill</td>
                            <td><span class="badge-pill badge-cat">Utilities & Bills</span></td>
                            <td>DAWASA Utility Corp</td>
                            <td>Cash on Hand</td>
                            <td class="font-monospace text-warning font-semibold">TSh 180,000</td>
                            <td><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 600;">19 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0888</div>
                            </td>
                            <td>Branded Biodegradable Packaging Bags (5,000 Pcs)</td>
                            <td><span class="badge-pill badge-cat">Packaging & Bags</span></td>
                            <td>Dar Pack Ltd</td>
                            <td>NMB Cheque</td>
                            <td class="font-monospace text-warning font-semibold">TSh 850,000</td>
                            <td><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 600;">18 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0887</div>
                            </td>
                            <td>Air Conditioning Servicing & Re-gassing (Main Hall)</td>
                            <td><span class="badge-pill badge-cat">Maintenance & Repair</span></td>
                            <td>CoolAir Technical Services</td>
                            <td>Airtel Money</td>
                            <td class="font-monospace text-warning font-semibold">TSh 260,000</td>
                            <td><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 600;">16 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0886</div>
                            </td>
                            <td>Commercial Shop Rent - Quarter 4 Advance Payment</td>
                            <td><span class="badge-pill badge-cat">Rent & Lease</span></td>
                            <td>Kariakoo Commercial Properties</td>
                            <td>Bank Transfer (CRDB)</td>
                            <td class="font-monospace text-warning font-semibold">TSh 3,400,000</td>
                            <td><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 600;">15 Sep, 2026</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">EXP-2026-0885</div>
                            </td>
                            <td>Barcode Scanner Units Replacement (POS Counter 3)</td>
                            <td><span class="badge-pill badge-cat">Maintenance & Repair</span></td>
                            <td>Bongo POS Systems Ltd</td>
                            <td>Pending Cheque</td>
                            <td class="font-monospace text-warning font-semibold">TSh 1,500,000</td>
                            <td><span class="badge-pill badge-pending"><i class="bi bi-hourglass-split"></i> Pending</span></td>
                            <td style="text-align: right;">
                                <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;"><i class="bi bi-file-earmark-text"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: Record Expense -->
    <div class="modal-overlay" id="addExpenseModal">
        <div class="modal-card">
            <div class="modal-header-custom">
                <h3>Record Operating Expense</h3>
                <button type="button" class="modal-close-btn" id="closeAddExpenseModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="recordExpenseForm">
                <div class="modal-body-custom">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Expense Description / Title</label>
                        <input type="text" class="form-control-custom" id="expDesc" placeholder="e.g. Internet Fiber Bill - Kariakoo Hub" required>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Category</label>
                            <select class="form-control-custom" id="expCategory" required>
                                <option value="Utilities & Bills">Utilities & Bills</option>
                                <option value="Logistics & Delivery">Logistics & Delivery</option>
                                <option value="Rent & Lease">Rent & Lease</option>
                                <option value="Packaging & Bags">Packaging & Bags</option>
                                <option value="Maintenance & Repair">Maintenance & Repair</option>
                                <option value="Miscellaneous">Miscellaneous</option>
                            </select>
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Amount (TSh)</label>
                            <input type="number" class="form-control-custom" id="expAmount" placeholder="e.g. 150000" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Vendor / Recipient</label>
                            <input type="text" class="form-control-custom" id="expVendor" placeholder="e.g. TTCL Fiber" required>
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Payment Method</label>
                            <select class="form-control-custom" id="expMethod">
                                <option value="M-Pesa Business Till">M-Pesa Business Till</option>
                                <option value="Bank Transfer (CRDB)">Bank Transfer (CRDB)</option>
                                <option value="NMB Account">NMB Account</option>
                                <option value="Airtel Money">Airtel Money</option>
                                <option value="Cash on Hand">Cash on Hand</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Date</label>
                            <input type="date" class="form-control-custom" id="expDate" required>
                        </div>
                        <div class="col-6 form-group-custom">
                            <label class="form-label-custom">Status</label>
                            <select class="form-control-custom" id="expStatus">
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending Approval</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-custom-outline" id="cancelExpenseModal">Cancel</button>
                    <button type="submit" class="btn-custom-primary">Save Expense</button>
                </div>
            </form>
    <!-- Modal: Official Expense Payment Voucher Preview & Print -->
    <div class="modal-overlay" id="expenseVoucherModal">
        <div class="modal-box" style="max-width: 600px;">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-check text-primary" style="font-size: 1.25rem;"></i>
                    <div>
                        <h3 style="margin: 0; font-size: 1.05rem;" id="vchTitle">Expense Payment Voucher</h3>
                        <span class="text-muted" style="font-size: 0.74rem;">Hati ya Malipo ya Matumizi ya Duka</span>
                    </div>
                </div>
                <button type="button" class="btn-custom-outline" id="closeVoucherModal" style="padding: 0.25rem 0.5rem;"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body-custom" id="voucherPrintArea">
                <div style="border: 1px solid var(--border-color); border-radius: 10px; padding: 1.25rem; background: var(--card-bg);">
                    <div class="d-flex justify-content-between align-items-start pb-3 mb-3 border-bottom">
                        <div>
                            <strong style="font-size: 1.05rem; letter-spacing: -0.3px;">Mercanto Retail & Wholesale</strong>
                            <div class="text-muted" style="font-size: 0.74rem;">Main Store HQ • TIN: 100-882-901</div>
                            <div class="text-muted" style="font-size: 0.74rem;">Internal Petty Cash & Expense Voucher</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-dark text-white font-monospace" style="font-size: 0.8rem;" id="vchNumber">#EXP-2026-0814</span>
                            <div class="text-muted mt-1" style="font-size: 0.74rem;" id="vchDate">24 Sep 2026</div>
                            <div class="mt-1" id="vchStatusBadge"><span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span></div>
                        </div>
                    </div>

                    <div class="p-3 mb-3 rounded" style="background-color: var(--nav-active-bg); font-size: 0.8rem;">
                        <div class="row g-2">
                            <div class="col-6"><span class="text-muted">Paid To (Payee / Vendor):</span><br><strong id="vchVendor">Kariakoo Property Management</strong></div>
                            <div class="col-6"><span class="text-muted">Expense Category:</span><br><span class="badge-pill badge-cat" id="vchCategory">Rent & Property</span></div>
                            <div class="col-6"><span class="text-muted">Payment Source:</span><br><strong id="vchMethod">Bank Transfer</strong></div>
                            <div class="col-6"><span class="text-muted">Amount Paid:</span><br><strong class="font-monospace text-primary" style="font-size: 1.1rem;" id="vchAmount">TSh 1,500,000</strong></div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-size: 0.82rem;">
                        <span class="text-muted">Purpose / Particulars:</span>
                        <p class="m-0 mt-1 p-2 rounded border bg-light text-dark" id="vchDesc">Kodi ya Pango - Mwezi Septemba 2026 (Store Counter & Storage)</p>
                    </div>

                    <div class="row pt-3 mt-3 border-top" style="font-size: 0.75rem;">
                        <div class="col-6 text-center">
                            <div style="border-top: 1px solid var(--border-color); margin-top: 2rem; padding-top: 0.3rem;">
                                Authorized By: <strong>Store Manager</strong>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <div style="border-top: 1px solid var(--border-color); margin-top: 2rem; padding-top: 0.3rem;">
                                Received / Acknowledged By Payee
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-custom-outline" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print Voucher</button>
                <button type="button" class="btn-custom-primary" id="dismissVoucherModal">Close</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMsg">Action completed successfully!</span>
    </div>

    <script>
        $(document).ready(function() {
            // Set default date in modal
            const today = new Date().toISOString().split('T')[0];
            $('#expDate').val(today);

            // Persistent Dark Mode Toggle
            if (localStorage.getItem('theme') === 'dark' || localStorage.getItem('eduka_theme') === 'dark') {
                $('body').addClass('dark-mode');
                $('#themeIcon').removeClass('bi-sun').addClass('bi-moon');
            } else {
                $('body').removeClass('dark-mode');
                $('#themeIcon').removeClass('bi-moon').addClass('bi-sun');
            }

            $('#theme-toggle-btn').on('click', function() {
                $('body').toggleClass('dark-mode');
                const isDark = $('body').hasClass('dark-mode');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                localStorage.setItem('eduka_theme', isDark ? 'dark' : 'light');
                $('#themeIcon').toggleClass('bi-sun bi-moon');
            });

            // Sidebar dropdown toggle
            $('.nav-dropdown-toggle').on('click', function() {
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !isExpanded);
                $(this).next('.nav-submenu').toggleClass('show');
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

            // Add Expense Modal
            $('#openAddExpenseBtn').on('click', function() {
                $('#addExpenseModal').addClass('show');
            });

            $('#closeAddExpenseModal, #cancelExpenseModal').on('click', function() {
                $('#addExpenseModal').removeClass('show');
            });

            // Save Expense Submit
            $('#recordExpenseForm').on('submit', function(e) {
                e.preventDefault();
                const desc = $('#expDesc').val();
                const cat = $('#expCategory').val();
                const rawAmount = parseInt($('#expAmount').val()) || 0;
                const amountFormatted = rawAmount.toLocaleString();
                const vendor = $('#expVendor').val();
                const method = $('#expMethod').val();
                const date = $('#expDate').val();
                const status = $('#expStatus').val();

                const refId = 'EXP-2026-0' + Math.floor(100 + Math.random() * 900);
                const statusBadge = status === 'Paid'
                    ? '<span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid</span>'
                    : '<span class="badge-pill badge-pending"><i class="bi bi-hourglass-split"></i> Pending</span>';

                const newRow = `
                    <tr data-ref="${refId}" data-date="${date}" data-desc="${desc}" data-cat="${cat}" data-vendor="${vendor}" data-method="${method}" data-amount="${rawAmount}" data-status="${status}">
                        <td>
                            <div style="font-weight: 600;">${date}</div>
                            <div style="font-size: 0.72rem; color: var(--text-muted);">${refId}</div>
                        </td>
                        <td>${desc}</td>
                        <td><span class="badge-pill badge-cat">${cat}</span></td>
                        <td>${vendor}</td>
                        <td>${method}</td>
                        <td style="font-weight: 600;">TSh ${amountFormatted}</td>
                        <td>${statusBadge}</td>
                        <td style="text-align: right;">
                            <button class="btn-custom-outline view-receipt-btn" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;" title="View Payment Voucher"><i class="bi bi-file-earmark-text"></i></button>
                        </td>
                    </tr>
                `;

                $('#expensesTableBody').prepend(newRow);

                // Update Total Monthly KPI
                let curTotal = parseInt($('#kpiTotalMonth').text().replace(/[^\d]/g, '')) || 7840000;
                curTotal += rawAmount;
                $('#kpiTotalMonth').text('TSh ' + curTotal.toLocaleString());

                $('#addExpenseModal').removeClass('show');
                $('#recordExpenseForm')[0].reset();
                $('#expDate').val(today);

                filterTable();
                showToast(`Expense recorded & voucher ${refId} created successfully!`);
            });

            // View Official Receipt Voucher Modal
            $(document).on('click', '.view-receipt-btn', function() {
                const row = $(this).closest('tr');
                const ref = row.data('ref') || row.find('td:first div:nth-child(2)').text().trim() || 'EXP-2026-0814';
                const date = row.data('date') || row.find('td:first div:first').text().trim() || '24 Sep 2026';
                const desc = row.data('desc') || row.find('td:nth-child(2)').text().trim() || 'Store Operation Expense';
                const cat = row.data('cat') || row.find('td:nth-child(3)').text().trim() || 'General';
                const vendor = row.data('vendor') || row.find('td:nth-child(4)').text().trim() || 'Vendor / Payee';
                const method = row.data('method') || row.find('td:nth-child(5)').text().trim() || 'Cash';
                const amount = row.find('td:nth-child(6)').text().trim() || 'TSh 0';
                const isPaid = row.find('td:nth-child(7)').text().toLowerCase().includes('paid');

                $('#vchNumber').text('#' + ref);
                $('#vchDate').text(date);
                $('#vchVendor').text(vendor);
                $('#vchCategory').text(cat);
                $('#vchMethod').text(method);
                $('#vchAmount').text(amount);
                $('#vchDesc').text(desc);

                if (isPaid) {
                    $('#vchStatusBadge').html('<span class="badge-pill badge-paid"><i class="bi bi-check-circle-fill"></i> Paid & Reconciled</span>');
                } else {
                    $('#vchStatusBadge').html('<span class="badge-pill badge-pending"><i class="bi bi-hourglass-split"></i> Pending Approval</span>');
                }

                $('#expenseVoucherModal').addClass('show');
            });

            $('#closeVoucherModal, #dismissVoucherModal').on('click', function() {
                $('#expenseVoucherModal').removeClass('show');
            });

            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).is('.modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });

            // Export Button
            $('#exportBtn').on('click', function() {
                showToast('Generating official Expense CSV Ledger Export...');
            });

            // Toast helper
            function showToast(msg) {
                $('#toastMsg').text(msg);
                $('#toastNotification').addClass('show');
                setTimeout(function() {
                    $('#toastNotification').removeClass('show');
                }, 3200);
            }

            // Table Filter Logic
            function filterTable() {
                const search = $('#tableSearchInput').val().toLowerCase();
                const category = $('#categoryFilter').val().toLowerCase();
                const status = $('#statusFilter').val().toLowerCase();

                let visibleCount = 0;
                $('#expensesTableBody tr').each(function() {
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

                $('#recordCounter').text(`Showing ${visibleCount} expenses`);
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
</body>
</html>
