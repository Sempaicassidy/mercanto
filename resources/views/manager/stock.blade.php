@php
    $businessMode = session('business_mode', 'retailer');
    $isWholesale = $businessMode === 'wholesaler';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products & Stock - Mercanto Manager</title>

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
            --badge-in-bg: #f0fdf4;
            --badge-in-text: #16a34a;
            --badge-low-bg: #fffbeb;
            --badge-low-text: #d97706;
            --badge-out-bg: #fef2f2;
            --badge-out-text: #dc2626;
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
            --badge-in-bg: #052e16;
            --badge-in-text: #4ade80;
            --badge-low-bg: #451a03;
            --badge-low-text: #fbbf24;
            --badge-out-bg: #450a0a;
            --badge-out-text: #f87171;
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
            cursor: pointer;
            transition: background 0.15s ease;
            border-top: 1px solid var(--border-color);
            padding-top: 0.85rem;
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

        /* Main Content Layout */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
            min-height: 100vh;
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
            transition: border-color 0.15s ease;
        }

        .search-input:focus {
            border-color: #a1a1aa;
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
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: var(--nav-active-bg);
        }

        .header-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.42rem 0.9rem;
            cursor: pointer;
            transition: all 0.15s ease;
            color: var(--text-dark);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
        }

        .header-role-pill:hover {
            background-color: var(--nav-active-bg);
        }

        .header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary-btn);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
        }

        body.dark-mode .header-avatar {
            color: #09090b;
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

        /* Stat Cards */
        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.2rem 1.3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
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

        .stat-subtext {
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        /* Content Card & Filters */
        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .filter-toolbar {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 12px;
        }

        .filter-group-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-select {
            padding: 0.4rem 1.8rem 0.4rem 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-dark);
            font-size: 0.82rem;
            outline: none;
            cursor: pointer;
        }

        /* Table */
        .table-responsive {
            margin: 0;
            overflow-x: auto;
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
            transition: background-color 0.1s ease;
        }

        .custom-table tbody tr:hover td {
            background-color: var(--nav-active-bg);
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background-color: var(--nav-active-bg);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--text-dark);
        }

        .product-name {
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .product-meta {
            font-size: 0.74rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .stock-progress-wrap {
            width: 110px;
        }

        .stock-progress-bar {
            height: 5px;
            width: 100%;
            background-color: var(--nav-active-bg);
            border-radius: 9999px;
            overflow: hidden;
            margin-top: 4px;
        }

        .stock-progress-fill {
            height: 100%;
            border-radius: 9999px;
            background-color: var(--primary-btn);
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

        .status-badge.in-stock {
            background-color: var(--badge-in-bg);
            color: var(--badge-in-text);
        }

        .status-badge.low-stock {
            background-color: var(--badge-low-bg);
            color: var(--badge-low-text);
        }

        .status-badge.out-stock {
            background-color: var(--badge-out-bg);
            color: var(--badge-out-text);
        }

        .badge-danger { background-color: var(--badge-danger-bg); color: var(--badge-danger-text); }
        .badge-warning { background-color: var(--badge-warning-bg); color: var(--badge-warning-text); }
        .badge-success { background-color: var(--badge-success-bg); color: var(--badge-success-text); }
        .badge-primary { background-color: var(--badge-primary-bg); color: var(--badge-primary-text); }

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
            transition: all 0.15s ease;
        }

        .action-icon-btn:hover {
            color: var(--text-dark);
            background-color: var(--nav-active-bg);
        }

        /* Modal Overlay */
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

        .modal-overlay.show {
            display: flex;
        }

        .modal-box {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: modalFadeIn 0.18s ease-out;
        }

        .modal-box.modal-box-lg {
            max-width: 860px;
        }

        .preset-chip-btn {
            border: 1px dashed var(--border-color);
            background-color: var(--nav-active-bg);
            color: var(--text-dark);
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .preset-chip-btn:hover {
            border-color: #2563eb;
            background-color: rgba(37, 99, 235, 0.08);
            color: #2563eb;
        }

        .sub-unit-pills .badge {
            cursor: pointer;
            transition: transform 0.12s ease;
        }

        .sub-unit-pills .badge:hover {
            transform: translateY(-1px);
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
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
            color: var(--text-dark);
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
            transition: border-color 0.15s ease;
        }

        .form-control-custom:focus {
            border-color: #a1a1aa;
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

        /* Toast Notification */
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
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            z-index: 2000;
        }

        body.dark-mode .toast-notify {
            color: #09090b;
        }
    </style>
</head>
<body>

    <!-- Left Sidebar (Manager Panel) -->
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
                <i class="bi bi-chevron-expand text-muted" style="font-size: 0.9rem;"></i>
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
                            <li><a href="{{ url('/manager/stock') }}" class="nav-subitem-link active">Products & Stock</a></li>
                            <li><a href="{{ url('/pos') }}" class="nav-subitem-link">POS / Cashier</a></li>
                            <li><a href="{{ url('/manager/category') }}" class="nav-subitem-link">Categories</a></li>
                            <li><a href="{{ url('/manager/suppliers') }}" class="nav-subitem-link">Suppliers</a></li>
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

        <!-- Sidebar Bottom Profile Section -->
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
                <input type="text" class="search-input" placeholder="Search product, barcode, SKU..." id="global-search-input">
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
        <div class="page-header-row d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h1 class="page-title mb-0">{{ $isWholesale ? 'Wholesale Inventory & Stock' : 'Products & Stock Inventory' }}</h1>
                    @if($isWholesale)
                        <span class="badge" style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; padding: 4px 12px; border: 1px solid rgba(124, 58, 237, 0.25);">
                            <i class="bi bi-boxes me-1"></i> Bei za Jumla (Wholesale Pricing)
                        </span>
                    @else
                        <span class="badge" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; padding: 4px 12px; border: 1px solid rgba(37, 99, 235, 0.25);">
                            <i class="bi bi-cart3 me-1"></i> Bei za Rejareja (Retail Pricing)
                        </span>
                    @endif
                </div>
                <p class="page-subtext">{{ $isWholesale ? 'Manage bulk distributor packs, cartons, bales, wholesale pricing tiers, and warehouse reserves.' : 'Manage store product catalog, pricing margins, stock levels, warehouse bins, and barcode labels.' }}</p>
            </div>
            <div class="page-header-actions d-flex align-items-center flex-wrap gap-2">
                <form action="{{ url('/tenant/toggle-business-mode') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="border-radius: 9999px; font-size: 0.76rem; font-weight: 600;" title="Badili muundo wa bei na bidhaa kuwa Rejareja au Jumla">
                        <i class="bi bi-arrow-repeat me-1"></i> Badili: {{ $isWholesale ? 'Kuwa Rejareja (Retail)' : 'Kuwa Jumla (Wholesale)' }}
                    </button>
                </form>
                @if(!$isWholesale)
                    <button class="btn btn-sm btn-primary-custom" id="openRetailUnitsBtn" style="background: #2563eb; color: #ffffff; border-radius: 8px; font-weight: 600; padding: 0.45rem 0.9rem; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 6px; border: none; box-shadow: 0 2px 6px rgba(37,99,235,0.25);" title="Panga vipimo vidogo vya rejareja kama Kilo 1, Nusu, Robo, Kibaba, Glasi">
                        <i class="bi bi-diagram-3-fill"></i>
                        <span>Vipimo vya Rejareja</span>
                    </button>
                @endif
                <button class="btn-outline-custom" id="exportStockBtn">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    <span>Export {{ $isWholesale ? 'Wholesale List' : 'Stock' }}</span>
                </button>
                <button class="btn-outline-custom" id="quickIntakeBtn">
                    <i class="bi bi-box-arrow-in-down"></i>
                    <span>Stock Intake (GRN)</span>
                </button>
                <button class="btn-dark-custom" id="addProductBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add Product</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Active Catalog Products</span>
                        <i class="bi bi-boxes stat-icon text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary">1,420 SKUs</div>
                        <div class="stat-subtext">Across 8 Active Categories</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Stock In Hand</span>
                        <i class="bi bi-layers stat-icon text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success">38,450 Units</div>
                        <div class="stat-subtext">Valuation: TSh 128,450,000</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Low Stock Alerts</span>
                        <i class="bi bi-exclamation-triangle stat-icon text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-value text-danger">18 Products</div>
                        <div class="stat-subtext">Under reorder threshold</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Expiring in 30 Days</span>
                        <i class="bi bi-calendar-event stat-icon text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning">6 Batches</div>
                        <div class="stat-subtext">Dairy & drinks batch watch</div>
                    </div>
                </div>
            </div>
        </div>

        @if(!$isWholesale)
            <!-- Retail Breakdown Sub-Units Helper Banner -->
            <div class="card border-0 mb-4" style="background: linear-gradient(135deg, rgba(37,99,235,0.06), rgba(59,130,246,0.03)); border: 1px solid rgba(37,99,235,0.2) !important; border-radius: 12px; padding: 1rem 1.25rem;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 44px; height: 44px; border-radius: 10px; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(37,99,235,0.25);">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <strong style="color: var(--text-dark); font-size: 0.95rem;">Mfumo wa Kupanga Vipimo Vidogo vya Rejareja (Sub-units & Breakdown)</strong>
                                <span class="badge" style="background: rgba(37,99,235,0.12); color: #2563eb; font-size: 0.72rem; font-weight: 700;">Duka la Rejareja</span>
                            </div>
                            <p style="margin: 3px 0 0 0; font-size: 0.82rem; color: var(--text-muted); line-height: 1.4;">
                                Unauza bidhaa kwa kupima au kugawa kutoka magunia, mifuko au madumu? Panga vipimo vya <strong>Kilo 1, Nusu Kilo (500g), Robo Kilo (250g), Kibaba, Fungu, Glasi</strong> na weka bei zake. Mfumo utapunguza stoo ya gunia kiotomatiki wakati cashier anapouza!
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="bannerManageUnitsBtn" style="font-weight: 600; font-size: 0.82rem; padding: 0.5rem 1.1rem; border-radius: 8px; background-color: #2563eb; border: none; white-space: nowrap; box-shadow: 0 2px 6px rgba(37,99,235,0.2);">
                        <i class="bi bi-sliders me-1"></i> Panga Vipimo vya Rejareja
                    </button>
                </div>
            </div>
        @endif

        <!-- Stock Management Table Card -->
        <div class="content-card">
            <!-- Filter Toolbar -->
            <div class="filter-toolbar">
                <div class="filter-group-left">
                    <select class="filter-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="beverages">Beverages & Drinks</option>
                        <option value="staples">Grains & Flour</option>
                        <option value="oils">Cooking Oils & Fats</option>
                        <option value="spices">Spices & Pastes</option>
                        <option value="cleaning">Toiletries & Soap</option>
                    </select>

                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Stock Statuses</option>
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="out_stock">Out of Stock</option>
                    </select>

                    <select class="filter-select" id="locationFilter">
                        <option value="all">All Locations</option>
                        <option value="main">Main Store Floor</option>
                        <option value="cold">Cold Room</option>
                        <option value="bay_b">Bay B (Racks)</option>
                    </select>
                </div>

                <div style="font-size: 0.8rem; color: var(--text-muted);">
                    Showing <strong id="visibleStockCount" style="color: var(--text-dark);">6</strong> products in catalog
                </div>
            </div>

            <!-- Table of Products -->
            <div class="table-responsive">
                <table class="custom-table" id="stockTable">
                    <thead>
                        <tr>
                            <th>Product Details</th>
                            <th>Category</th>
                            <th>Location / Shelf</th>
                            <th>Buying Cost</th>
                            @if($isWholesale)
                                <th>Wholesale Price (Jumla)</th>
                                <th>Min Wholesale Qty</th>
                            @else
                                <th>Retail Price (Rejareja)</th>
                            @endif
                            <th>Margin</th>
                            <th>{{ $isWholesale ? 'Stock in Hand (Packs/Units)' : 'Stock in Hand' }}</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Product 1 -->
                        <tr data-cat="beverages" data-status="in_stock" data-loc="cold" data-name="Azam Energy Drink 300ml" data-sku="AZM-ENG-300" data-stock="480" data-cost="750" data-price="{{ $isWholesale ? '18000' : '1000' }}">
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon-box"><i class="bi bi-cup-straw"></i></div>
                                    <div>
                                        <div class="product-name">Azam Energy Drink 300ml</div>
                                        <div class="product-meta">SKU: AZM-ENG-300 • Barcode: 6161100234190</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Beverages</span></td>
                            <td>Cold Room - Bay 2</td>
                            <td>TSh 750</td>
                            @if($isWholesale)
                                <td><strong style="color: #7c3aed;">TSh 18,000 / Ctn</strong></td>
                                <td><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight: 600;">1 Ctn (24 pcs)</span></td>
                                <td><span class="badge bg-light text-success border">+20.0%</span></td>
                            @else
                                <td><strong>TSh 1,000</strong></td>
                                <td><span class="badge bg-light text-success border">+33.3%</span></td>
                            @endif
                            <td>
                                <div class="stock-progress-wrap">
                                    <div class="d-flex justify-content-between" style="font-size: 0.78rem; font-weight: 600;">
                                        <span>{{ $isWholesale ? '20 Ctns (480 pcs)' : '480' }}</span>
                                        <span class="text-muted">/ 600</span>
                                    </div>
                                    <div class="stock-progress-bar">
                                        <div class="stock-progress-fill" style="width: 80%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span></td>
                            <td style="text-align: right;">
                                @if(!$isWholesale)
                                    <button class="action-icon-btn manage-units-btn" data-product="Azam Energy Drink 300ml" data-sku="AZM-ENG-300" data-cost="750" data-price="1000" data-stock="480" data-base="Chupa 300ml" title="Panga Vipimo Vidogo vya Rejareja"><i class="bi bi-diagram-3"></i></button>
                                @endif
                                <button class="action-icon-btn restock-btn" title="Quick Restock"><i class="bi bi-box-arrow-in-down"></i></button>
                                <button class="action-icon-btn edit-product-btn" title="Edit Product"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Product 2 -->
                        <tr data-cat="staples" data-status="in_stock" data-loc="main" data-name="Kilombero Super Rice 25kg" data-sku="RCE-KLM-025" data-stock="120" data-cost="58,000" data-price="{{ $isWholesale ? '62000' : '68000' }}">
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon-box"><i class="bi bi-box2-heart"></i></div>
                                    <div>
                                        <div class="product-name">Kilombero Super Rice 25kg</div>
                                        <div class="product-meta">SKU: RCE-KLM-025 • Barcode: 6161900142851</div>
                                        @if(!$isWholesale)
                                            <div class="sub-unit-pills mt-1 d-flex flex-wrap gap-1">
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;" title="Kipimo cha Rejareja: Kilo 1">1kg: 3,200/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;" title="Kipimo cha Rejareja: Nusu Kilo">Nusu: 1,650/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;" title="Kipimo cha Rejareja: Robo Kilo">Robo: 850/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;" title="Kipimo cha Rejareja: Kibaba cha Mchele">Kibaba: 2,300/=</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Grains & Flour</span></td>
                            <td>Aisle A - Pallet 04</td>
                            <td>TSh 58,000</td>
                            @if($isWholesale)
                                <td><strong style="color: #7c3aed;">TSh 62,000 / Gunia</strong></td>
                                <td><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight: 600;">1 Bag (25kg)</span></td>
                                <td><span class="badge bg-light text-success border">+6.9%</span></td>
                            @else
                                <td><strong>TSh 68,000</strong></td>
                                <td><span class="badge bg-light text-success border">+17.2%</span></td>
                            @endif
                            <td>
                                <div class="stock-progress-wrap">
                                    <div class="d-flex justify-content-between" style="font-size: 0.78rem; font-weight: 600;">
                                        <span>120 Bags</span>
                                        <span class="text-muted">/ 150</span>
                                    </div>
                                    <div class="stock-progress-bar">
                                        <div class="stock-progress-fill" style="width: 80%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span></td>
                            <td style="text-align: right;">
                                @if(!$isWholesale)
                                    <button class="action-icon-btn manage-units-btn" data-product="Kilombero Super Rice 25kg" data-sku="RCE-KLM-025" data-cost="58000" data-price="68000" data-stock="120" data-base="Gunia 25kg" title="Panga Vipimo Vidogo vya Rejareja (Kilo, Nusu, Robo, Kibaba)"><i class="bi bi-diagram-3-fill" style="color: #2563eb;"></i></button>
                                @endif
                                <button class="action-icon-btn restock-btn" title="Quick Restock"><i class="bi bi-box-arrow-in-down"></i></button>
                                <button class="action-icon-btn edit-product-btn" title="Edit Product"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Product 3 -->
                        <tr data-cat="staples" data-status="low_stock" data-loc="main" data-name="Bakhresa Wheat Flour 2kg" data-sku="BKH-WHT-002" data-stock="14" data-cost="3,100" data-price="{{ $isWholesale ? '34000' : '3700' }}">
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon-box"><i class="bi bi-bag"></i></div>
                                    <div>
                                        <div class="product-name">Bakhresa Wheat Flour 2kg</div>
                                        <div class="product-meta">SKU: BKH-WHT-002 • Barcode: 6161100881920</div>
                                        @if(!$isWholesale)
                                            <div class="sub-unit-pills mt-1 d-flex flex-wrap gap-1">
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;">1kg: 1,900/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;">Nusu (500g): 1,000/=</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Grains & Flour</span></td>
                            <td>Aisle B - Shelf 01</td>
                            <td>TSh 3,100</td>
                            @if($isWholesale)
                                <td><strong style="color: #7c3aed;">TSh 34,000 / Bale</strong></td>
                                <td><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight: 600;">1 Bale (12 pcs)</span></td>
                                <td><span class="badge bg-light text-success border">+9.7%</span></td>
                            @else
                                <td><strong>TSh 3,700</strong></td>
                                <td><span class="badge bg-light text-success border">+19.3%</span></td>
                            @endif
                            <td>
                                <div class="stock-progress-wrap">
                                    <div class="d-flex justify-content-between" style="font-size: 0.78rem; font-weight: 600;">
                                        <span>{{ $isWholesale ? '14 Bales' : '14' }}</span>
                                        <span class="text-muted">/ 50 min</span>
                                    </div>
                                    <div class="stock-progress-bar">
                                        <div class="stock-progress-fill" style="width: 28%; background-color: #dc2626;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge low-stock"><i class="bi bi-exclamation-circle-fill"></i> Low Stock</span></td>
                            <td style="text-align: right;">
                                @if(!$isWholesale)
                                    <button class="action-icon-btn manage-units-btn" data-product="Bakhresa Wheat Flour 2kg" data-sku="BKH-WHT-002" data-cost="3100" data-price="3700" data-stock="14" data-base="Pakiti 2kg" title="Panga Vipimo Vidogo vya Rejareja"><i class="bi bi-diagram-3-fill" style="color: #2563eb;"></i></button>
                                @endif
                                <button class="action-icon-btn restock-btn" title="Quick Restock"><i class="bi bi-box-arrow-in-down"></i></button>
                                <button class="action-icon-btn edit-product-btn" title="Edit Product"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Product 4 -->
                        <tr data-cat="oils" data-status="low_stock" data-loc="bay_b" data-name="Korie Cooking Oil 5L" data-sku="MET-OIL-005" data-stock="6" data-cost="24,500" data-price="{{ $isWholesale ? '94000' : '28500' }}">
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon-box"><i class="bi bi-droplet-half"></i></div>
                                    <div>
                                        <div class="product-name">Korie Cooking Oil 5L</div>
                                        <div class="product-meta">SKU: MET-OIL-005 • Barcode: 6162200331048</div>
                                        @if(!$isWholesale)
                                            <div class="sub-unit-pills mt-1 d-flex flex-wrap gap-1">
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;">1 Lita: 6,500/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;">500ml: 3,300/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;">250ml: 1,700/=</span>
                                                <span class="badge" style="background: rgba(37,99,235,0.08); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); font-size: 0.68rem; font-weight: 600;">Glasi: 1,000/=</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Cooking Oils</span></td>
                            <td>Bay B - Rack 03</td>
                            <td>TSh 24,500</td>
                            @if($isWholesale)
                                <td><strong style="color: #7c3aed;">TSh 94,000 / Ctn</strong></td>
                                <td><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight: 600;">1 Ctn (4 jerycans)</span></td>
                                <td><span class="badge bg-light text-success border">+8.0%</span></td>
                            @else
                                <td><strong>TSh 28,500</strong></td>
                                <td><span class="badge bg-light text-success border">+16.3%</span></td>
                            @endif
                            <td>
                                <div class="stock-progress-wrap">
                                    <div class="d-flex justify-content-between" style="font-size: 0.78rem; font-weight: 600;">
                                        <span>{{ $isWholesale ? '6 Ctns' : '6' }}</span>
                                        <span class="text-muted">/ 30 min</span>
                                    </div>
                                    <div class="stock-progress-bar">
                                        <div class="stock-progress-fill" style="width: 20%; background-color: #dc2626;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge low-stock"><i class="bi bi-exclamation-circle-fill"></i> Low Stock</span></td>
                            <td style="text-align: right;">
                                @if(!$isWholesale)
                                    <button class="action-icon-btn manage-units-btn" data-product="Korie Cooking Oil 5L" data-sku="MET-OIL-005" data-cost="24500" data-price="28500" data-stock="6" data-base="Dumu 5L" title="Panga Vipimo Vidogo vya Rejareja (Lita, Nusu, Robo, Glasi)"><i class="bi bi-diagram-3-fill" style="color: #2563eb;"></i></button>
                                @endif
                                <button class="action-icon-btn restock-btn" title="Quick Restock"><i class="bi bi-box-arrow-in-down"></i></button>
                                <button class="action-icon-btn edit-product-btn" title="Edit Product"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Product 5 -->
                        <tr data-cat="spices" data-status="in_stock" data-loc="main" data-name="Red Gold Tomato Paste 400g" data-sku="RDG-TMP-400" data-stock="180" data-cost="1,400" data-price="{{ $isWholesale ? '31000' : '1800' }}">
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon-box"><i class="bi bi-archive"></i></div>
                                    <div>
                                        <div class="product-name">Red Gold Tomato Paste 400g</div>
                                        <div class="product-meta">SKU: RDG-TMP-400 • Barcode: 6161400229871</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Spices & Pastes</span></td>
                            <td>Aisle C - Shelf 02</td>
                            <td>TSh 1,400</td>
                            @if($isWholesale)
                                <td><strong style="color: #7c3aed;">TSh 31,000 / Ctn</strong></td>
                                <td><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight: 600;">1 Ctn (24 tins)</span></td>
                                <td><span class="badge bg-light text-success border">+15.3%</span></td>
                            @else
                                <td><strong>TSh 1,800</strong></td>
                                <td><span class="badge bg-light text-success border">+28.5%</span></td>
                            @endif
                            <td>
                                <div class="stock-progress-wrap">
                                    <div class="d-flex justify-content-between" style="font-size: 0.78rem; font-weight: 600;">
                                        <span>{{ $isWholesale ? '180 Ctns' : '180' }}</span>
                                        <span class="text-muted">/ 200</span>
                                    </div>
                                    <div class="stock-progress-bar">
                                        <div class="stock-progress-fill" style="width: 90%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span></td>
                            <td style="text-align: right;">
                                @if(!$isWholesale)
                                    <button class="action-icon-btn manage-units-btn" data-product="Red Gold Tomato Paste 400g" data-sku="RDG-TMP-400" data-cost="1400" data-price="1800" data-stock="180" data-base="Kopo 400g" title="Panga Vipimo Vidogo vya Rejareja"><i class="bi bi-diagram-3"></i></button>
                                @endif
                                <button class="action-icon-btn restock-btn" title="Quick Restock"><i class="bi bi-box-arrow-in-down"></i></button>
                                <button class="action-icon-btn edit-product-btn" title="Edit Product"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>

                        <!-- Product 6 -->
                        <tr data-cat="cleaning" data-status="out_stock" data-loc="main" data-name="Mo Detergent Powder 1kg" data-sku="MET-DET-001" data-stock="0" data-cost="2,400" data-price="{{ $isWholesale ? '38000' : '3000' }}">
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon-box"><i class="bi bi-stars"></i></div>
                                    <div>
                                        <div class="product-name">Mo Detergent Powder 1kg</div>
                                        <div class="product-meta">SKU: MET-DET-001 • Barcode: 6161100445672</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Toiletries & Soap</span></td>
                            <td>Aisle D - Shelf 04</td>
                            <td>TSh 2,400</td>
                            @if($isWholesale)
                                <td><strong style="color: #7c3aed;">TSh 38,000 / Box</strong></td>
                                <td><span class="badge" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-weight: 600;">1 Box (16 pkts)</span></td>
                                <td><span class="badge bg-light text-success border">+11.8%</span></td>
                            @else
                                <td><strong>TSh 3,000</strong></td>
                                <td><span class="badge bg-light text-success border">+25.0%</span></td>
                            @endif
                            <td>
                                <div class="stock-progress-wrap">
                                    <div class="d-flex justify-content-between" style="font-size: 0.78rem; font-weight: 600;">
                                        <span>0</span>
                                        <span class="text-muted">/ 100 min</span>
                                    </div>
                                    <div class="stock-progress-bar">
                                        <div class="stock-progress-fill" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge out-stock"><i class="bi bi-x-circle-fill"></i> Out of Stock</span></td>
                            <td style="text-align: right;">
                                @if(!$isWholesale)
                                    <button class="action-icon-btn manage-units-btn" data-product="Mo Detergent Powder 1kg" data-sku="MET-DET-001" data-cost="2400" data-price="3000" data-stock="0" data-base="Mfuko 1kg" title="Panga Vipimo Vidogo vya Rejareja"><i class="bi bi-diagram-3"></i></button>
                                @endif
                                <button class="action-icon-btn restock-btn" title="Quick Restock"><i class="bi bi-box-arrow-in-down"></i></button>
                                <button class="action-icon-btn edit-product-btn" title="Edit Product"><i class="bi bi-pencil"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal: Add New Product -->
    <div class="modal-overlay" id="addProductModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3>Add New Product to Catalog</h3>
                <button type="button" class="action-icon-btn close-modal" data-modal="addProductModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="addProductForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Product Title & Brand *</label>
                        <input type="text" class="form-control-custom" placeholder="e.g. Azam Pure Apple Juice 1L" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Category</label>
                            <select class="form-control-custom" required>
                                <option>Beverages & Drinks</option>
                                <option>Grains & Flour</option>
                                <option>Cooking Oils & Fats</option>
                                <option>Spices & Pastes</option>
                                <option>Toiletries & Cleaning</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">SKU Code</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. AZM-APL-001" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Barcode (EAN-13)</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. 6161100992812">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Warehouse / Shelf Location</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. Bay 2 - Shelf B">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Buying Cost (TSh) *</label>
                            <input type="number" class="form-control-custom" placeholder="1800" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Retail Selling Price (TSh) *</label>
                            <input type="number" class="form-control-custom" placeholder="2500" min="1" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Initial Stock Quantity</label>
                            <input type="number" class="form-control-custom" placeholder="50" min="0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Reorder Safety Level</label>
                            <input type="number" class="form-control-custom" placeholder="15" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="addProductModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom">Create & Save SKU</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Quick Restock -->
    <div class="modal-overlay" id="quickRestockModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <div>
                    <h3>Quick Restock Product</h3>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 2px 0 0 0;" id="restockProductMeta">SKU: AZM-ENG-300</p>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="quickRestockModal"><i class="bi bi-x-lg"></i></button>
            </div>
            <form id="quickRestockForm">
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Product Selected</label>
                        <input type="text" class="form-control-custom" id="restockProductName" readonly style="background-color: var(--nav-active-bg);">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Units to Add *</label>
                            <input type="number" class="form-control-custom" placeholder="e.g. 50" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Batch / Lot #</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. BATCH-2026-SEP">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Supplier / Source</label>
                        <select class="form-control-custom">
                            <option>Said Salim Bakhresa & Co.</option>
                            <option>MeTL Group (Mohammed Ent.)</option>
                            <option>Bonite Bottlers Ltd</option>
                            <option>Direct Local Farm Intake</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="quickRestockModal">Cancel</button>
                    <button type="submit" class="btn-dark-custom">Confirm Intake</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Retail Sub-Units Breakdown (Vipimo Vidogo vya Rejareja) -->
    <div class="modal-overlay" id="retailUnitsModal">
        <div class="modal-box modal-box-lg">
            <div class="modal-header-custom d-flex align-items-center justify-content-between">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-size: 0.74rem; font-weight: 700; border-radius: 9999px; padding: 3px 8px;">
                            <i class="bi bi-diagram-3-fill me-1"></i> Rejareja POS Breakdown
                        </span>
                        <h3 class="mb-0">Vipimo Vidogo vya Rejareja (Retail Sub-units)</h3>
                    </div>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin: 3px 0 0 0;">
                        Gawa mzigo mkuu (gunia, dumu, katoni) kuwa vipimo vya rejareja kama Kilo 1, Nusu, Robo, Kibaba, Fungu na panga bei zake.
                    </p>
                </div>
                <button type="button" class="action-icon-btn close-modal" data-modal="retailUnitsModal"><i class="bi bi-x-lg"></i></button>
            </div>

            <div class="modal-body-custom">
                <!-- Product Selector & Snapshot -->
                <div class="p-3 mb-3" style="background: var(--nav-active-bg); border: 1px solid var(--border-color); border-radius: 10px;">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom mb-1"><i class="bi bi-box2 me-1 text-primary"></i> Chagua Bidhaa ya Kupanga Vipimo</label>
                            <select class="form-control-custom" id="subUnitProductSelect" style="font-weight: 600;">
                                <option value="Kilombero Super Rice 25kg" data-sku="RCE-KLM-025" data-cost="58000" data-price="68000" data-stock="120" data-base="Gunia 25kg">Kilombero Super Rice 25kg (Gunia 25kg)</option>
                                <option value="Korie Cooking Oil 5L" data-sku="MET-OIL-005" data-cost="24500" data-price="28500" data-stock="6" data-base="Dumu 5L">Korie Cooking Oil 5L (Dumu 5L)</option>
                                <option value="Bakhresa Wheat Flour 2kg" data-sku="BKH-WHT-002" data-cost="3100" data-price="3700" data-stock="14" data-base="Pakiti 2kg">Bakhresa Wheat Flour 2kg (Pakiti 2kg)</option>
                                <option value="Sukari ya Kilombero 50kg" data-sku="SUK-50K-001" data-cost="135000" data-price="155000" data-stock="45" data-base="Gunia 50kg">Sukari ya Kilombero 50kg (Gunia 50kg)</option>
                                <option value="Mo Detergent Powder 1kg" data-sku="MET-DET-001" data-cost="2400" data-price="3000" data-stock="0" data-base="Mfuko 1kg">Mo Detergent Powder 1kg</option>
                                <option value="Azam Energy Drink 300ml" data-sku="AZM-ENG-300" data-cost="750" data-price="1000" data-stock="480" data-base="Chupa 300ml">Azam Energy Drink 300ml</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                                <div>
                                    <div style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Mzigo Mkuu (Base Packaging)</div>
                                    <div class="fw-bold" id="currentBaseUnitText" style="font-size: 0.88rem; color: var(--text-dark);">Gunia 25kg</div>
                                </div>
                                <div class="text-end">
                                    <div style="font-size: 0.72rem; color: var(--text-muted);">Gharama / Bei ya Gunia:</div>
                                    <div style="font-size: 0.84rem; font-weight: 700; color: #2563eb;" id="currentBasePriceText">TSh 58,000 / 68,000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 1-Click Quick Presets for Retailers -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label-custom mb-0"><i class="bi bi-magic me-1 text-primary"></i> Violezo vya Haraka (1-Click Retail Presets):</label>
                        <span style="font-size: 0.72rem; color: var(--text-muted);">Bonyeza kuweka mfumo wa vipimo papo hapo</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="preset-chip-btn" data-preset="grains">
                            <i class="bi bi-box-seam text-warning"></i>
                            <span>Nafaka & Mchele (1kg, Nusu, Robo, Kibaba)</span>
                        </button>
                        <button type="button" class="preset-chip-btn" data-preset="oils">
                            <i class="bi bi-droplet-half text-info"></i>
                            <span>Mafuta (1L, 500ml, 250ml, Glasi)</span>
                        </button>
                        <button type="button" class="preset-chip-btn" data-preset="soap">
                            <i class="bi bi-stars text-primary"></i>
                            <span>Sabuni (Mche, Nusu, Kipande)</span>
                        </button>
                        <button type="button" class="preset-chip-btn" data-preset="bunches">
                            <i class="bi bi-basket text-success"></i>
                            <span>Mafungu (Fungu Kubwa, Fungu Dogo)</span>
                        </button>
                    </div>
                </div>

                <!-- Existing Sub-Units Table -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label-custom mb-0"><i class="bi bi-list-check me-1 text-success"></i> Vipimo Vilivyopangwa kwa ajili ya Kuuza (Configured Sub-Units):</label>
                        <span class="badge bg-light text-dark border" style="font-size: 0.72rem;" id="subUnitsCountBadge">4 Vipimo Hai</span>
                    </div>
                    <div class="table-responsive" style="border: 1px solid var(--border-color); border-radius: 8px;">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
                            <thead style="background: var(--nav-active-bg); font-weight: 600; font-size: 0.75rem; color: var(--text-muted);">
                                <tr>
                                    <th>Kipimo cha Rejareja</th>
                                    <th>Kifupi</th>
                                    <th>Uwiano (Ratio)</th>
                                    <th>Bei ya Kununua</th>
                                    <th>Bei ya Kuuzia (Retail)</th>
                                    <th>Faida %</th>
                                    <th>Barcode</th>
                                    <th style="text-align: right;">Ondoa</th>
                                </tr>
                            </thead>
                            <tbody id="subUnitsTableBody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add New Sub-Unit Form -->
                <div class="p-3" style="background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: 10px;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <strong style="font-size: 0.84rem; color: var(--text-dark);">
                            <i class="bi bi-plus-circle-fill text-primary me-1"></i> Ongeza Kipimo Kipya cha Rejareja
                        </strong>
                        <span style="font-size: 0.74rem; color: var(--text-muted);">Mfano: Kibaba, Robo Kilo, Nusu Mche</span>
                    </div>
                    <form id="addNewSubUnitForm">
                        <div class="row g-2 mb-2">
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label-custom">Jina la Kipimo *</label>
                                <input type="text" class="form-control-custom form-control-sm" id="newUnitName" placeholder="mf. Kibaba" required>
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label-custom">Kifupi (Code) *</label>
                                <input type="text" class="form-control-custom form-control-sm" id="newUnitCode" placeholder="kibaba" required>
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label-custom" title="Uwiano wa ujazo kutoka mzigo mkuu">Uwiano (Ratio) *</label>
                                <input type="number" step="0.0001" min="0.0001" max="1" class="form-control-custom form-control-sm" id="newUnitRatio" placeholder="0.04" required>
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label-custom">Bei ya Kununua</label>
                                <input type="number" class="form-control-custom form-control-sm" id="newUnitCost" placeholder="2,320">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">Bei ya Kuuza (TSh) *</label>
                                <input type="number" class="form-control-custom form-control-sm" id="newUnitPrice" placeholder="3,200" required>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div style="font-size: 0.74rem; color: var(--text-muted);">
                                <i class="bi bi-info-circle me-1"></i> Uwiano unasaidia stoo ya duka kujipunguza kiotomatiki wakati cashier anapouza kipimo hiki.
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary" style="font-size: 0.8rem; font-weight: 600; padding: 0.35rem 0.9rem; border-radius: 6px;">
                                <i class="bi bi-plus-lg me-1"></i> Hifadhi Kipimo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer-custom d-flex align-items-center justify-content-between">
                <div style="font-size: 0.78rem; color: var(--text-muted);">
                    <i class="bi bi-check2-all text-success me-1"></i> Vipimo hivi vinaonekana moja kwa moja kwenye <strong>Kaunta ya Mauzo (POS)</strong>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn-outline-custom close-modal" data-modal="retailUnitsModal">Funga</button>
                    <a href="{{ url('/pos') }}" class="btn-dark-custom text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.82rem;">
                        <i class="bi bi-cart3"></i>
                        <span>Nenda kwenye POS Uone Matokeo</span>
                    </a>
                </div>
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

            // Theme Toggle
            let isLight = true;
            $('#theme-toggle-btn').on('click', function() {
                isLight = !isLight;
                $('body').toggleClass('dark-mode');
                $('#theme-icon').toggleClass('bi-sun bi-moon-stars');
            });

            // Nav Dropdowns
            $('.nav-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.nav-submenu').toggleClass('open');
            });

            // Global search filter
            $('#global-search-input').on('keyup', function() {
                const term = $(this).val().toLowerCase();
                let visibleCount = 0;
                $('#stockTable tbody tr').each(function() {
                    const matches = $(this).text().toLowerCase().includes(term);
                    $(this).toggle(matches);
                    if (matches) visibleCount++;
                });
                $('#visibleStockCount').text(visibleCount);
            });

            // Category filter
            $('#categoryFilter, #statusFilter, #locationFilter').on('change', function() {
                const cat = $('#categoryFilter').val();
                const status = $('#statusFilter').val();
                const loc = $('#locationFilter').val();

                let visibleCount = 0;
                $('#stockTable tbody tr').each(function() {
                    const rowCat = $(this).data('cat');
                    const rowStatus = $(this).data('status');
                    const rowLoc = $(this).data('loc');

                    const matchCat = (cat === 'all' || rowCat === cat);
                    const matchStatus = (status === 'all' || rowStatus === status);
                    const matchLoc = (loc === 'all' || rowLoc === loc);

                    const isVisible = matchCat && matchStatus && matchLoc;
                    $(this).toggle(isVisible);
                    if (isVisible) visibleCount++;
                });
                $('#visibleStockCount').text(visibleCount);
            });

            // Modals
            $('#addProductBtn').on('click', function() { $('#addProductModal').addClass('show'); });
            $('#quickIntakeBtn').on('click', function() {
                $('#restockProductName').val('Quick Intake / General Inward Delivery');
                $('#restockProductMeta').text('Warehouse Receiving Intake');
                $('#quickRestockModal').addClass('show');
            });

            $('.restock-btn').on('click', function() {
                const row = $(this).closest('tr');
                const name = row.data('name');
                const sku = row.data('sku');
                $('#restockProductName').val(name);
                $('#restockProductMeta').text('SKU: ' + sku);
                $('#quickRestockModal').addClass('show');
            });

            $('.edit-product-btn').on('click', function() {
                const row = $(this).closest('tr');
                const name = row.data('name');
                showToast('Editing product SKU details: ' + name);
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

            // Forms
            $('#addProductForm').on('submit', function(e) {
                e.preventDefault();
                $('#addProductModal').removeClass('show');
                showToast('New SKU successfully added to manager product catalog!');
                this.reset();
            });

            $('#quickRestockForm').on('submit', function(e) {
                e.preventDefault();
                $('#quickRestockModal').removeClass('show');
                showToast('Product stock intake confirmed and levels updated!');
                this.reset();
            });

            $('#exportStockBtn').on('click', function() {
                showToast('Downloading Store Inventory CSV report...');
            });

            // ==========================================
            // Retail Sub-units Data & Interactive State
            // ==========================================
            const productUnitsData = {
                'Kilombero Super Rice 25kg': {
                    baseUnit: 'Gunia 25kg',
                    baseCost: 58000,
                    basePrice: 68000,
                    units: [
                        { name: 'Kilo 1', code: '1kg', ratio: 0.0400, cost: 2320, price: 3200, barcode: '6161900142851-1K' },
                        { name: 'Nusu Kilo (500g)', code: '500g', ratio: 0.0200, cost: 1160, price: 1650, barcode: '6161900142851-05K' },
                        { name: 'Robo Kilo (250g)', code: '250g', ratio: 0.0100, cost: 580, price: 850, barcode: '6161900142851-025K' },
                        { name: 'Kibaba cha Mchele', code: 'kibaba', ratio: 0.0280, cost: 1624, price: 2300, barcode: '6161900142851-KIB' }
                    ]
                },
                'Korie Cooking Oil 5L': {
                    baseUnit: 'Dumu 5L',
                    baseCost: 24500,
                    basePrice: 28500,
                    units: [
                        { name: 'Lita 1 (1L)', code: '1L', ratio: 0.2000, cost: 4900, price: 6500, barcode: '6162200331048-1L' },
                        { name: 'Nusu Lita (500ml)', code: '500ml', ratio: 0.1000, cost: 2450, price: 3300, barcode: '6162200331048-500ML' },
                        { name: 'Robo Lita (250ml)', code: '250ml', ratio: 0.0500, cost: 1225, price: 1700, barcode: '6162200331048-250ML' },
                        { name: 'Kibaba / Glasi', code: 'glasi', ratio: 0.0300, cost: 735, price: 1000, barcode: '6162200331048-GLS' }
                    ]
                },
                'Bakhresa Wheat Flour 2kg': {
                    baseUnit: 'Pakiti 2kg',
                    baseCost: 3100,
                    basePrice: 3700,
                    units: [
                        { name: 'Kilo 1', code: '1kg', ratio: 0.5000, cost: 1550, price: 1900, barcode: '6161100881920-1K' },
                        { name: 'Nusu Kilo (500g)', code: '500g', ratio: 0.2500, cost: 775, price: 1000, barcode: '6161100881920-05K' }
                    ]
                },
                'Sukari ya Kilombero 50kg': {
                    baseUnit: 'Gunia 50kg',
                    baseCost: 135000,
                    basePrice: 155000,
                    units: [
                        { name: 'Kilo 1 Kamili', code: '1kg', ratio: 0.0200, cost: 2700, price: 3200, barcode: 'SUK-01K' },
                        { name: 'Nusu Kilo (500g)', code: '500g', ratio: 0.0100, cost: 1350, price: 1650, barcode: 'SUK-05K' },
                        { name: 'Robo Kilo (250g)', code: '250g', ratio: 0.0050, cost: 675, price: 850, barcode: 'SUK-025K' }
                    ]
                },
                'Mo Detergent Powder 1kg': {
                    baseUnit: 'Mfuko 1kg',
                    baseCost: 2400,
                    basePrice: 3000,
                    units: [
                        { name: 'Nusu Mfuko (500g)', code: '500g', ratio: 0.5000, cost: 1200, price: 1600, barcode: 'MET-DET-05' },
                        { name: 'Robo (250g)', code: '250g', ratio: 0.2500, cost: 600, price: 850, barcode: 'MET-DET-025' }
                    ]
                },
                'Azam Energy Drink 300ml': {
                    baseUnit: 'Chupa 300ml',
                    baseCost: 750,
                    basePrice: 1000,
                    units: [
                        { name: 'Chupa 1', code: 'pcs', ratio: 1.0000, cost: 750, price: 1000, barcode: '6161100234190' }
                    ]
                }
            };

            function renderSubUnitsTable(productName) {
                const data = productUnitsData[productName] || {
                    baseUnit: 'Pakiti',
                    baseCost: 1000,
                    basePrice: 1200,
                    units: []
                };

                $('#currentBaseUnitText').text(data.baseUnit);
                $('#currentBasePriceText').text('TSh ' + data.baseCost.toLocaleString() + ' / ' + data.basePrice.toLocaleString());
                $('#subUnitsCountBadge').text(data.units.length + ' Vipimo Hai');

                const tbody = $('#subUnitsTableBody');
                tbody.empty();

                if (data.units.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                Bado hakuna vipimo vidogo vya rejareja vilivyopangwa kwa bidhaa hii.<br>
                                <span style="font-size:0.75rem;">Tumia violezo vya haraka hapo juu au jaza fomu hapa chini kuongeza.</span>
                            </td>
                        </tr>
                    `);
                    return;
                }

                data.units.forEach((u, idx) => {
                    const margin = u.cost > 0 ? (((u.price - u.cost) / u.cost) * 100).toFixed(1) : 0;
                    const row = `
                        <tr>
                            <td class="fw-semibold text-dark">
                                <i class="bi bi-check-circle-fill text-primary me-1" style="font-size: 0.75rem;"></i>
                                ${u.name}
                            </td>
                            <td><span class="badge bg-light text-dark border">${u.code}</span></td>
                            <td><span class="badge bg-primary-subtle text-primary border">${u.ratio} (${(u.ratio * 100).toFixed(1)}%)</span></td>
                            <td>TSh ${u.cost.toLocaleString()}</td>
                            <td><strong style="color: #16a34a;">TSh ${u.price.toLocaleString()}</strong></td>
                            <td><span class="badge bg-success-subtle text-success border">+${margin}%</span></td>
                            <td><code style="font-size:0.75rem;">${u.barcode || '-'}</code></td>
                            <td style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1 delete-subunit-btn" data-index="${idx}" title="Ondoa kipimo hiki" style="border-radius:4px; font-size:0.75rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }

            // Open Retail Units Modal
            $('#openRetailUnitsBtn, #bannerManageUnitsBtn').on('click', function() {
                const prod = $('#subUnitProductSelect').val();
                renderSubUnitsTable(prod);
                $('#retailUnitsModal').addClass('show');
            });

            $('.manage-units-btn').on('click', function() {
                const prod = $(this).data('product');
                if (prod && $('#subUnitProductSelect option[value="' + prod + '"]').length) {
                    $('#subUnitProductSelect').val(prod);
                }
                renderSubUnitsTable($('#subUnitProductSelect').val());
                $('#retailUnitsModal').addClass('show');
            });

            $('#subUnitProductSelect').on('change', function() {
                renderSubUnitsTable($(this).val());
            });

            // Ratio change auto calculates cost
            $('#newUnitRatio').on('input', function() {
                const prod = $('#subUnitProductSelect').val();
                const data = productUnitsData[prod];
                const ratio = parseFloat($(this).val()) || 0;
                if (data && ratio > 0) {
                    const estCost = Math.round(data.baseCost * ratio);
                    $('#newUnitCost').val(estCost);
                }
            });

            // Add new sub unit form submit
            $('#addNewSubUnitForm').on('submit', function(e) {
                e.preventDefault();
                const prod = $('#subUnitProductSelect').val();
                if (!productUnitsData[prod]) {
                    productUnitsData[prod] = { baseUnit: 'Pakiti', baseCost: 1000, basePrice: 1200, units: [] };
                }

                const name = $('#newUnitName').val().trim();
                const code = $('#newUnitCode').val().trim();
                const ratio = parseFloat($('#newUnitRatio').val()) || 0.1;
                const cost = parseInt($('#newUnitCost').val()) || 0;
                const price = parseInt($('#newUnitPrice').val()) || 0;
                const barcode = prod.substring(0, 3).toUpperCase() + '-' + code.toUpperCase();

                productUnitsData[prod].units.push({
                    name: name,
                    code: code,
                    ratio: ratio,
                    cost: cost,
                    price: price,
                    barcode: barcode
                });

                renderSubUnitsTable(prod);
                this.reset();
                showToast('Kipimo cha <strong>' + name + ' (TSh ' + price.toLocaleString() + ')</strong> kimehifadhiwa kikamilifu!');
            });

            // Delete sub unit
            $(document).on('click', '.delete-subunit-btn', function() {
                const idx = $(this).data('index');
                const prod = $('#subUnitProductSelect').val();
                if (productUnitsData[prod] && productUnitsData[prod].units[idx]) {
                    const removed = productUnitsData[prod].units.splice(idx, 1);
                    renderSubUnitsTable(prod);
                    showToast('Kipimo cha ' + (removed[0] ? removed[0].name : '') + ' kimeondolewa.');
                }
            });

            // 1-Click Quick Presets
            $('.preset-chip-btn').on('click', function() {
                const preset = $(this).data('preset');
                const prod = $('#subUnitProductSelect').val();
                if (!productUnitsData[prod]) {
                    productUnitsData[prod] = { baseUnit: 'Unit', baseCost: 10000, basePrice: 12000, units: [] };
                }

                if (preset === 'grains') {
                    productUnitsData[prod].units = [
                        { name: 'Kilo 1', code: '1kg', ratio: 0.0400, cost: Math.round(productUnitsData[prod].baseCost * 0.04), price: 3200, barcode: 'GRAIN-1K' },
                        { name: 'Nusu Kilo (500g)', code: '500g', ratio: 0.0200, cost: Math.round(productUnitsData[prod].baseCost * 0.02), price: 1650, barcode: 'GRAIN-05K' },
                        { name: 'Robo Kilo (250g)', code: '250g', ratio: 0.0100, cost: Math.round(productUnitsData[prod].baseCost * 0.01), price: 850, barcode: 'GRAIN-025K' },
                        { name: 'Kibaba cha Nafaka', code: 'kibaba', ratio: 0.0280, cost: Math.round(productUnitsData[prod].baseCost * 0.028), price: 2300, barcode: 'GRAIN-KIB' }
                    ];
                    showToast('Mfumo wa Nafaka & Mchele umewekwa kikamilifu!');
                } else if (preset === 'oils') {
                    productUnitsData[prod].units = [
                        { name: 'Lita 1 (1L)', code: '1L', ratio: 0.2000, cost: Math.round(productUnitsData[prod].baseCost * 0.2), price: 6500, barcode: 'OIL-1L' },
                        { name: 'Nusu Lita (500ml)', code: '500ml', ratio: 0.1000, cost: Math.round(productUnitsData[prod].baseCost * 0.1), price: 3300, barcode: 'OIL-500ML' },
                        { name: 'Robo Lita (250ml)', code: '250ml', ratio: 0.0500, cost: Math.round(productUnitsData[prod].baseCost * 0.05), price: 1700, barcode: 'OIL-250ML' },
                        { name: 'Glasi / Kibaba', code: 'glasi', ratio: 0.0300, cost: Math.round(productUnitsData[prod].baseCost * 0.03), price: 1000, barcode: 'OIL-GLS' }
                    ];
                    showToast('Mfumo wa Mafuta (1L, 500ml, 250ml, Glasi) umewekwa kikamilifu!');
                } else if (preset === 'soap') {
                    productUnitsData[prod].units = [
                        { name: 'Mche Mzima', code: 'mche', ratio: 1.0000, cost: Math.round(productUnitsData[prod].baseCost), price: 2500, barcode: 'SOAP-MCH' },
                        { name: 'Nusu Mche', code: 'nusu', ratio: 0.5000, cost: Math.round(productUnitsData[prod].baseCost * 0.5), price: 1300, barcode: 'SOAP-NUS' },
                        { name: 'Kipande / Robo', code: 'robo', ratio: 0.2500, cost: Math.round(productUnitsData[prod].baseCost * 0.25), price: 700, barcode: 'SOAP-ROB' }
                    ];
                    showToast('Mfumo wa Sabuni (Mche, Nusu, Kipande) umewekwa kikamilifu!');
                } else if (preset === 'bunches') {
                    productUnitsData[prod].units = [
                        { name: 'Fungu Kubwa', code: 'fg-kb', ratio: 0.2000, cost: Math.round(productUnitsData[prod].baseCost * 0.2), price: 2000, barcode: 'FNG-BIG' },
                        { name: 'Fungu Dogo', code: 'fg-dg', ratio: 0.1000, cost: Math.round(productUnitsData[prod].baseCost * 0.1), price: 1000, barcode: 'FNG-SML' },
                        { name: 'Moja Moja (Kipande)', code: 'pcs', ratio: 0.0300, cost: Math.round(productUnitsData[prod].baseCost * 0.03), price: 300, barcode: 'FNG-PCS' }
                    ];
                    showToast('Mfumo wa Mafungu (Fungu Kubwa, Dogo, Moja) umewekwa kikamilifu!');
                }

                renderSubUnitsTable(prod);
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
