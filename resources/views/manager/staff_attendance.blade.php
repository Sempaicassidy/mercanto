<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Shifts & Attendance - mercanto</title>

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
            --badge-present-bg: #f0fdf4;
            --badge-present-text: #16a34a;
            --badge-late-bg: #fffbeb;
            --badge-late-text: #d97706;
            --badge-leave-bg: #eff6ff;
            --badge-leave-text: #2563eb;
            --badge-absent-bg: #fef2f2;
            --badge-absent-text: #dc2626;
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
            --badge-present-bg: #052e16;
            --badge-present-text: #4ade80;
            --badge-late-bg: #451a03;
            --badge-late-text: #fbbf24;
            --badge-leave-bg: #172554;
            --badge-leave-text: #60a5fa;
            --badge-absent-bg: #450a0a;
            --badge-absent-text: #f87171;
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

        /* Sidebar Styling (Matching Manager Panel) */
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

        /* Card Container */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
        }

        /* Filter Toolbar */
        .filter-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 1.25rem;
        }

        .filter-group-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.45rem 2rem 0.45rem 0.85rem;
            font-size: 0.82rem;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2371717a' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
        }

        .filter-pill-tabs {
            display: flex;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 3px;
            gap: 2px;
        }

        .filter-tab-btn {
            background: transparent;
            border: none;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .filter-tab-btn.active {
            background-color: var(--card-bg);
            color: var(--text-dark);
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Clean Table */
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

        .staff-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .staff-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .staff-name {
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .staff-meta {
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 0.73rem;
            font-weight: 600;
        }

        .status-badge.present, .badge-success {
            background-color: var(--badge-present-bg);
            color: var(--badge-present-text);
        }

        .status-badge.late, .badge-warning {
            background-color: var(--badge-late-bg);
            color: var(--badge-late-text);
        }

        .status-badge.leave, .badge-primary {
            background-color: var(--badge-leave-bg);
            color: var(--badge-leave-text);
        }

        .status-badge.absent, .badge-danger {
            background-color: var(--badge-absent-bg);
            color: var(--badge-absent-text);
        }

        .pulse-indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--text-dark);
            display: inline-block;
            box-shadow: 0 0 0 2px rgba(9, 9, 11, 0.2);
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(9, 9, 11, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 5px rgba(9, 9, 11, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(9, 9, 11, 0); }
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

        /* Modal Overlays (Shadcn Style) */
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
                            <li><a href="{{ url('/manager/staff_attendance') }}" class="nav-subitem-link active">Staff Shifts & Attendance</a></li>
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
                            <li><a href="{{ url('/manager/permission') }}" class="nav-subitem-link">Auditing Settings & Roles</a></li>
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
                <input type="text" class="search-input" placeholder="Search staff, shifts..." id="global-search-input">
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

        <!-- Page Header Title -->
        <div class="page-header-row">
            <div>
                <h1 class="page-title">Staff Shifts & Attendance</h1>
                <p class="page-subtext">Monitor real-time employee clock-ins, shift rosters, punctuality, and hours logged.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-outline-custom" id="exportAttendanceBtn">
                    <i class="bi bi-download"></i>
                    <span>Export CSV</span>
                </button>
                <button class="btn-outline-custom" id="assignShiftBtn">
                    <i class="bi bi-calendar-check"></i>
                    <span>Assign Shift</span>
                </button>
                <button class="btn-dark-custom" id="manualClockInBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>Log Clock-In</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Present Today</span>
                        <i class="bi bi-person-check stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">14 / 16</div>
                        <div class="stat-subtext">
                            <span class="pulse-indicator me-1"></span>
                            87.5% punctuality on duty
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Late Arrivals</span>
                        <i class="bi bi-clock-history stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">2 Staff</div>
                        <div class="stat-subtext">Avg delay: 18 mins today</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">On Leave / Off</span>
                        <i class="bi bi-calendar2-minus stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">2 Staff</div>
                        <div class="stat-subtext">1 Sick Leave, 1 Annual</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Hours Logged Today</span>
                        <i class="bi bi-hourglass-split stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">112.5 hrs</div>
                        <div class="stat-subtext">Expected shift target: 128 hrs</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table Card -->
        <div class="content-card">
            <!-- Filter Toolbar -->
            <div class="filter-toolbar">
                <div class="filter-group-left">
                    <div class="filter-pill-tabs">
                        <button class="filter-tab-btn active" data-date-filter="today">Today</button>
                        <button class="filter-tab-btn" data-date-filter="yesterday">Yesterday</button>
                        <button class="filter-tab-btn" data-date-filter="week">This Week</button>
                        <button class="filter-tab-btn" data-date-filter="month">This Month</button>
                    </div>

                    <select class="filter-select" id="departmentFilter">
                        <option value="all">All Departments</option>
                        <option value="cashier">POS Cashiers</option>
                        <option value="storekeeper">Warehouse / Store</option>
                        <option value="supervisor">Supervisors</option>
                        <option value="security">Floor & Security</option>
                    </select>

                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Statuses</option>
                        <option value="present">Present (On-Time)</option>
                        <option value="late">Late Arrival</option>
                        <option value="leave">On Leave</option>
                        <option value="absent">Absent</option>
                    </select>
                </div>

                <div style="font-size: 0.8rem; color: var(--text-muted);">
                    Showing <strong id="visibleStaffCount" class="text-dark">8</strong> attendance logs for today
                </div>
            </div>

            <!-- Table of Attendance Records -->
            <div class="table-responsive">
                <table class="custom-table" id="attendanceTable">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Role & Department</th>
                            <th>Assigned Shift</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Total Logged</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Staff 1 -->
                        <tr data-dept="cashier" data-status="present">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">JA</div>
                                    <div>
                                        <div class="staff-name">Juma Ally</div>
                                        <div class="staff-meta">ID: #ED-014 • M-Pesa ID: 255714...</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">POS Cashier</span></td>
                            <td>Morning (07:30 - 16:00)</td>
                            <td><strong>07:25 AM</strong> <span class="status-badge badge-success ms-1">Early</span></td>
                            <td><span style="color: var(--text-dark); font-weight: 500;"><span class="pulse-indicator me-1"></span>On Duty</span></td>
                            <td>7h 45m</td>
                            <td><span class="status-badge present"><i class="bi bi-check-circle-fill"></i> Present</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 2 -->
                        <tr data-dept="cashier" data-status="present">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">NB</div>
                                    <div>
                                        <div class="staff-name">Neema Bakari</div>
                                        <div class="staff-meta">ID: #ED-019 • Counter 2</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Senior Cashier</span></td>
                            <td>Morning (07:30 - 16:00)</td>
                            <td><strong>07:30 AM</strong> <span class="status-badge badge-primary ms-1">On-Time</span></td>
                            <td><span style="color: var(--text-dark); font-weight: 500;"><span class="pulse-indicator me-1"></span>On Duty</span></td>
                            <td>7h 40m</td>
                            <td><span class="status-badge present"><i class="bi bi-check-circle-fill"></i> Present</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 3 -->
                        <tr data-dept="storekeeper" data-status="present">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">BJ</div>
                                    <div>
                                        <div class="staff-name">Baraka Joseph</div>
                                        <div class="staff-meta">ID: #ED-008 • Warehouse Bay 1</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Store Keeper</span></td>
                            <td>Full Shift (07:00 - 16:30)</td>
                            <td><strong>06:55 AM</strong> <span class="status-badge badge-success ms-1">Early</span></td>
                            <td><span style="color: var(--text-dark); font-weight: 500;"><span class="pulse-indicator me-1"></span>Active</span></td>
                            <td>8h 15m</td>
                            <td><span class="status-badge present"><i class="bi bi-check-circle-fill"></i> Present</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 4 -->
                        <tr data-dept="cashier" data-status="late">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">SS</div>
                                    <div>
                                        <div class="staff-name">Salma Salim</div>
                                        <div class="staff-meta">ID: #ED-027 • Counter 4</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">POS Cashier</span></td>
                            <td>Morning (08:00 - 17:00)</td>
                            <td><strong>08:24 AM</strong> <span class="status-badge badge-warning ms-1">+24m Late</span></td>
                            <td><span style="color: var(--text-dark); font-weight: 500;"><span class="pulse-indicator me-1"></span>On Duty</span></td>
                            <td>6h 46m</td>
                            <td><span class="status-badge late"><i class="bi bi-exclamation-circle-fill"></i> Late</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 5 -->
                        <tr data-dept="storekeeper" data-status="late">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">FM</div>
                                    <div>
                                        <div class="staff-name">Farida Mussa</div>
                                        <div class="staff-meta">ID: #ED-031 • Inbound Receiving</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Inventory Assistant</span></td>
                            <td>Morning (07:30 - 16:00)</td>
                            <td><strong>07:42 AM</strong> <span class="status-badge badge-warning ms-1">+12m Late</span></td>
                            <td><span style="color: var(--text-dark); font-weight: 500;"><span class="pulse-indicator me-1"></span>On Duty</span></td>
                            <td>7h 28m</td>
                            <td><span class="status-badge late"><i class="bi bi-exclamation-circle-fill"></i> Late</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 6 -->
                        <tr data-dept="supervisor" data-status="present">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">RO</div>
                                    <div>
                                        <div class="staff-name">Rashidi Omari</div>
                                        <div class="staff-meta">ID: #ED-005 • Floor Management</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Floor Supervisor</span></td>
                            <td>Day Shift (08:00 - 17:30)</td>
                            <td><strong>07:50 AM</strong> <span class="status-badge badge-success ms-1">Early</span></td>
                            <td><span style="color: var(--text-dark); font-weight: 500;"><span class="pulse-indicator me-1"></span>Active</span></td>
                            <td>7h 20m</td>
                            <td><span class="status-badge present"><i class="bi bi-check-circle-fill"></i> Present</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 7 -->
                        <tr data-dept="security" data-status="leave">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">KM</div>
                                    <div>
                                        <div class="staff-name">Kelvin Massawe</div>
                                        <div class="staff-meta">ID: #ED-044 • Security Guard</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Floor & Security</span></td>
                            <td>Night Shift (20:00 - 06:00)</td>
                            <td><span class="text-muted">--:--</span></td>
                            <td><span class="text-muted">--:--</span></td>
                            <td>0h 00m</td>
                            <td><span class="status-badge leave"><i class="bi bi-info-circle-fill"></i> Sick Leave</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Staff 8 -->
                        <tr data-dept="cashier" data-status="absent">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">ZA</div>
                                    <div>
                                        <div class="staff-name">Zawadi Athumani</div>
                                        <div class="staff-meta">ID: #ED-036 • Counter 5</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">POS Cashier</span></td>
                            <td>Evening (14:00 - 22:30)</td>
                            <td><span class="text-muted">No Punch</span></td>
                            <td><span class="text-muted">--:--</span></td>
                            <td>0h 00m</td>
                            <td><span class="status-badge absent"><i class="bi bi-x-circle-fill"></i> Unexcused</span></td>
                            <td style="text-align: right;">
                                <button class="action-icon-btn view-log-btn" title="View Timesheet"><i class="bi bi-eye"></i></button>
                                <button class="action-icon-btn edit-log-btn" title="Edit Punch Record"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weekly Shift Roster Preview Card -->
        <div class="content-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--text-dark);">Weekly Shift Schedule Overview</h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 2px 0 0 0;">Current active week roster (Sep 21 - Sep 27, 2026)</p>
                </div>
                <span class="status-badge badge-primary px-3 py-2">Full Branch Roster</span>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div style="background-color: var(--nav-active-bg); border-radius: 8px; padding: 1rem; border: 1px solid var(--border-color);">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-dark);"><i class="bi bi-brightness-high me-1"></i> Morning Shift</span>
                            <span class="badge bg-secondary-subtle text-dark">07:30 - 16:00</span>
                        </div>
                        <p style="font-size: 0.76rem; color: var(--text-muted); margin-bottom: 0.5rem;">Allocated: 6 Staff Members</p>
                        <div style="font-size: 0.8rem; color: var(--text-dark);">
                            <div>• Juma Ally (Cashier 1)</div>
                            <div>• Neema Bakari (Cashier 2)</div>
                            <div>• Baraka Joseph (Warehouse)</div>
                            <div>• Farida Mussa (Intake)</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div style="background-color: var(--nav-active-bg); border-radius: 8px; padding: 1rem; border: 1px solid var(--border-color);">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-dark);"><i class="bi bi-sunset me-1"></i> Afternoon / Peak Shift</span>
                            <span class="badge bg-secondary-subtle text-dark">13:30 - 22:00</span>
                        </div>
                        <p style="font-size: 0.76rem; color: var(--text-muted); margin-bottom: 0.5rem;">Allocated: 5 Staff Members</p>
                        <div style="font-size: 0.8rem; color: var(--text-dark);">
                            <div>• Salma Salim (Cashier 3)</div>
                            <div>• Rashidi Omari (Floor Supervisor)</div>
                            <div>• Amani Kondo (Restock Runner)</div>
                            <div>• Rehema Saidi (Checkout Assistant)</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div style="background-color: var(--nav-active-bg); border-radius: 8px; padding: 1rem; border: 1px solid var(--border-color);">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-dark);"><i class="bi bi-moon-stars me-1"></i> Night / Security Shift</span>
                            <span class="badge bg-secondary-subtle text-dark">20:00 - 07:00</span>
                        </div>
                        <p style="font-size: 0.76rem; color: var(--text-muted); margin-bottom: 0.5rem;">Allocated: 3 Staff Members</p>
                        <div style="font-size: 0.8rem; color: var(--text-dark);">
                            <div>• Kelvin Massawe (Lead Guard)</div>
                            <div>• Godfrey Peter (CCTV Watch)</div>
                            <div>• Daudi Mrope (Intake Security)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: Manual Clock-In Entry -->
    <div class="modal-overlay" id="manualClockInModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Manual Attendance Clock-In</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="manualClockInModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="manualClockInForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Select Staff Member</label>
                        <select class="form-control-custom" required>
                            <option value="">Choose employee...</option>
                            <option value="1">Juma Ally (Cashier)</option>
                            <option value="2">Neema Bakari (Senior Cashier)</option>
                            <option value="3">Baraka Joseph (Store Keeper)</option>
                            <option value="4">Salma Salim (Cashier)</option>
                            <option value="5">Farida Mussa (Store Keeper)</option>
                            <option value="6">Rashidi Omari (Floor Supervisor)</option>
                            <option value="7">Zawadi Athumani (Cashier)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Date</label>
                            <input type="date" class="form-control-custom" value="2026-09-22" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Shift Template</label>
                            <select class="form-control-custom">
                                <option>Morning (07:30 - 16:00)</option>
                                <option>Afternoon (13:30 - 22:00)</option>
                                <option>Night (20:00 - 06:00)</option>
                                <option>Custom Hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Clock In Time</label>
                            <input type="time" class="form-control-custom" value="07:30" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Clock Out Time (Optional)</label>
                            <input type="time" class="form-control-custom">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Reason / Verification Note</label>
                        <textarea class="form-control-custom" rows="2" placeholder="e.g. Biometric device offline, manager override..."></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="manualClockInModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom">Confirm & Save Punch</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Assign Shift -->
    <div class="modal-overlay" id="assignShiftModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Assign Shift Roster</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="assignShiftModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="assignShiftForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Staff Member</label>
                        <select class="form-control-custom" required>
                            <option value="">Select staff...</option>
                            <option value="1">Juma Ally (#ED-014)</option>
                            <option value="2">Neema Bakari (#ED-019)</option>
                            <option value="3">Baraka Joseph (#ED-008)</option>
                            <option value="4">Salma Salim (#ED-027)</option>
                            <option value="5">Farida Mussa (#ED-031)</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Effective Date</label>
                            <input type="date" class="form-control-custom" value="2026-09-23" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Target Shift</label>
                            <select class="form-control-custom" required>
                                <option>Morning (07:30 - 16:00)</option>
                                <option>Afternoon (13:30 - 22:00)</option>
                                <option>Night (20:00 - 06:00)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Assigned Station / Counter</label>
                        <input type="text" class="form-control-custom" placeholder="e.g. POS Counter 2, Receiving Bay B">
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="assignShiftModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom">Save Shift Assignment</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Toast Notification -->
    <div class="toast-notify" id="toastNotify">
        <i class="bi bi-check-circle-fill" style="color: var(--text-dark);"></i>
        <span id="toastNotifyMsg">Action performed successfully</span>
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

            // Filter Table Rows
            function applyFilters() {
                const dept = $('#departmentFilter').val();
                const status = $('#statusFilter').val();
                const searchTerm = $('#global-search-input').val().toLowerCase();

                let visibleCount = 0;
                $('#attendanceTable tbody tr').each(function() {
                    const row = $(this);
                    const rowDept = row.data('dept');
                    const rowStatus = row.data('status');
                    const rowText = row.text().toLowerCase();

                    const matchDept = (dept === 'all' || rowDept === dept);
                    const matchStatus = (status === 'all' || rowStatus === status);
                    const matchSearch = (!searchTerm || rowText.includes(searchTerm));

                    if (matchDept && matchStatus && matchSearch) {
                        row.show();
                        visibleCount++;
                    } else {
                        row.hide();
                    }
                });
                $('#visibleStaffCount').text(visibleCount);
            }

            $('#departmentFilter, #statusFilter').on('change', applyFilters);
            $('#global-search-input').on('keyup', applyFilters);

            // Filter date tabs
            $('.filter-tab-btn').on('click', function() {
                $('.filter-tab-btn').removeClass('active');
                $(this).addClass('active');
                showToast('Filtered records for: ' + $(this).text());
            });

            // Modals trigger
            $('#manualClockInBtn').on('click', function() {
                $('#manualClockInModal').addClass('show');
            });

            $('#assignShiftBtn').on('click', function() {
                $('#assignShiftModal').addClass('show');
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

            // Forms Submit
            $('#manualClockInForm').on('submit', function(e) {
                e.preventDefault();
                $('#manualClockInModal').removeClass('show');
                showToast('Attendance punch logged successfully!');
                this.reset();
            });

            $('#assignShiftForm').on('submit', function(e) {
                e.preventDefault();
                $('#assignShiftModal').removeClass('show');
                showToast('New shift roster assigned successfully!');
                this.reset();
            });

            $('#exportAttendanceBtn').on('click', function() {
                showToast('Exporting attendance report as CSV...');
            });

            // Toast Display
            function showToast(msg) {
                const toast = $('#toastNotify');
                $('#toastNotifyMsg').html(msg);
                toast.stop(true, true).fadeIn(180).delay(3000).fadeOut(200);
            }

            // Role Switcher Modal Logic
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
