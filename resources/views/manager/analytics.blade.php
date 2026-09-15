<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - e-duka</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js for smooth curved line/area chart -->
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
            margin-bottom: 1.5rem;
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

        .badge-subtle {
            background-color: #18181b;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 9999px;
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

        /* Sidebar Profile Bottom */
        .sidebar-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s ease;
            margin-top: 1rem;
        }

        .sidebar-profile:hover {
            background-color: var(--nav-active-bg);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background-color: #e4e4e7;
            color: #18181b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            margin-left: 10px;
            overflow: hidden;
        }

        .profile-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .profile-email {
            font-size: 0.74rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.25rem 2.5rem 2.5rem 2.5rem;
            min-height: 100vh;
        }

        /* Top Navigation Header Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--border-color);
        }

        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-search-box {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            width: 250px;
            height: 38px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .header-search-box:focus-within {
            border-color: #09090b;
            box-shadow: 0 0 0 1px #09090b;
        }

        .search-icon {
            color: #64748b;
            font-size: 0.95rem;
            margin-right: 8px;
        }

        .search-input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.88rem;
            color: #1e293b;
            width: 100%;
        }

        .search-input::placeholder {
            color: #64748b;
        }

        .search-kbd {
            font-size: 0.68rem;
            font-weight: 600;
            color: #64748b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 2px 6px;
            line-height: 1;
            white-space: nowrap;
        }

        .nav-icon-btn {
            background: transparent;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            font-size: 1.15rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-icon-btn:hover {
            background-color: #f4f4f5;
            color: #09090b;
        }

        .header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #f1f5f9;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
        }

        .header-avatar:hover {
            background-color: #e2e8f0;
        }

        /* Top Header */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .dashboard-title {
            font-size: 1.95rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-dark);
        }

        .btn-download {
            background-color: var(--primary-btn);
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-download:hover {
            background-color: #27272a;
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Nav Tabs Switcher */
        .dashboard-tabs {
            display: inline-flex;
            background-color: #f4f4f5;
            padding: 4px;
            border-radius: 8px;
            margin-bottom: 2rem;
            gap: 2px;
        }

        .tab-btn {
            border: none;
            background: transparent;
            padding: 0.4rem 1.1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-block;
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

        /* Statistics UI Components matching image */
        .stat-card-custom {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            transition: box-shadow 0.2s ease;
        }

        .stat-card-custom:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .stat-card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #09090b;
        }

        .stat-card-icon {
            font-size: 1.1rem;
            color: #64748b;
        }

        .stat-card-value {
            font-size: 1.95rem;
            font-weight: 800;
            color: #09090b;
            letter-spacing: -0.5px;
            line-height: 1.1;
            margin-bottom: 0.45rem;
        }

        .stat-card-trend {
            font-size: 0.82rem;
            color: #71717a;
            font-weight: 500;
        }

        /* Large Card Container */
        .chart-card-large {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 1.75rem 2rem 2rem 2rem;
            margin-bottom: 1.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .chart-header-block {
            margin-bottom: 1.75rem;
        }

        .chart-main-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #09090b;
            margin-bottom: 4px;
        }

        .chart-subtitle {
            font-size: 0.85rem;
            color: #71717a;
        }

        /* Breakdown Cards (Referrers & Devices) */
        .breakdown-card {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 1.75rem 2rem;
            height: 100%;
        }

        .breakdown-header {
            margin-bottom: 1.75rem;
        }

        .breakdown-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #09090b;
            margin-bottom: 4px;
        }

        .breakdown-subtitle {
            font-size: 0.85rem;
            color: #71717a;
        }

        .breakdown-list {
            display: flex;
            flex-direction: column;
            gap: 1.4rem;
        }

        .breakdown-item-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .breakdown-item-name {
            font-size: 0.88rem;
            font-weight: 500;
            color: #3f3f46;
        }

        .breakdown-item-val {
            font-size: 0.88rem;
            font-weight: 700;
            color: #09090b;
        }

        /* Progress Bars */
        .custom-progress-track {
            width: 100%;
            height: 8px;
            background-color: #f1f5f9;
            border-radius: 9999px;
            overflow: hidden;
        }

        .custom-progress-bar-dark {
            height: 100%;
            background-color: #111827;
            border-radius: 9999px;
            transition: width 0.6s ease;
        }

        .custom-progress-bar-slate {
            height: 100%;
            background-color: #475569;
            border-radius: 9999px;
            transition: width 0.6s ease;
        }
    </style>
</head>
<body>

    <!-- Left Sidebar (Shadcn Style) -->
    <aside class="sidebar">
        <div>
            <!-- Workspace Switcher Header -->
            <div class="workspace-header">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>e-duka</h4>
                        <span>Manager Panel</span>
                    </div>
                </div>
                <i class="bi bi-chevron-expand text-muted" style="font-size: 0.9rem;"></i>
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
                        <!-- Analytics Nav Item (Active) -->
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
                            <li><a href="#" class="nav-subitem-link">Products & Stock</a></li>
                            <li><a href="#" class="nav-subitem-link">POS / Cashier</a></li>
                            <li><a href="#" class="nav-subitem-link">Categories</a></li>
                            <li><a href="#" class="nav-subitem-link">Suppliers</a></li>
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
                            <li><a href="#" class="nav-subitem-link">Cashiers List</a></li>
                            <li><a href="#" class="nav-subitem-link">Staff Shifts</a></li>
                            <li><a href="#" class="nav-subitem-link">Permissions</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-graph-up"></i>
                                <span>Reports</span>
                            </span>
                            <span class="badge-subtle">3</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-section-title">Pages</div>
                <ul class="nav-list">
                    <!-- Dropdown: Auth -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-shield-lock"></i>
                                <span>Auth</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="#" class="nav-subitem-link">Sign In</a></li>
                            <li><a href="#" class="nav-subitem-link">Register Staff</a></li>
                            <li><a href="#" class="nav-subitem-link">Reset Password</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown: Errors -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-exclamation-octagon"></i>
                                <span>Errors</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="#" class="nav-subitem-link">404 Not Found</a></li>
                            <li><a href="#" class="nav-subitem-link">500 Server Error</a></li>
                            <li><a href="#" class="nav-subitem-link">Maintenance Mode</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="nav-section-title">Other</div>
                <ul class="nav-list">
                    <!-- Dropdown: Settings -->
                    <li>
                        <a href="#" class="nav-item-link nav-dropdown-toggle" aria-expanded="false">
                            <span class="nav-item-left">
                                <i class="bi bi-gear"></i>
                                <span>Settings</span>
                            </span>
                            <i class="bi bi-chevron-right nav-chevron"></i>
                        </a>
                        <ul class="nav-submenu">
                            <li><a href="#" class="nav-subitem-link">General Settings</a></li>
                            <li><a href="#" class="nav-subitem-link">Store Profile</a></li>
                            <li><a href="#" class="nav-subitem-link">VAT & Tax Rules</a></li>
                            <li><a href="#" class="nav-subitem-link">Receipt Branding</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-question-circle"></i>
                                <span>Help Center</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Bottom Profile Section -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center;">
                <div class="profile-avatar">MN</div>
                <div class="profile-info">
                    <span class="profile-name">Manager</span>
                    <span class="profile-email">manager@eduka.co.tz</span>
                </div>
            </div>
            <i class="bi bi-chevron-expand text-muted" style="font-size: 0.9rem;"></i>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Utility Header (Search, Theme, Settings, Avatar) -->
        <header class="top-nav-bar">
            <div class="top-nav-actions">
                <div class="header-search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search" id="global-search-input">
                    <span class="search-kbd">⌘ K</span>
                </div>

                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme" aria-label="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>

                <button class="nav-icon-btn" id="settings-btn" title="Settings" aria-label="Settings">
                    <i class="bi bi-gear"></i>
                </button>

                <div class="header-avatar" id="user-avatar-btn" title="User Profile (SN)">
                    SN
                </div>
            </div>
        </header>

        <!-- Top Header Title & Actions -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Analytics</h1>
            <button class="btn-download">
                <i class="bi bi-download"></i>
                Download
            </button>
        </div>

        <!-- Tab Controls -->
        <div class="dashboard-tabs">
            <a href="{{ url('/manager/dashboard') }}" class="tab-btn">Overview</a>
            <a href="{{ url('/manager/analytics') }}" class="tab-btn active">Analytics</a>
            <button class="tab-btn">Reports</button>
            <button class="tab-btn">Notifications</button>
        </div>

        <!-- TOP SECTION: Traffic Overview (Weekly clicks & unique visitors) Area Chart -->
        <div class="chart-card-large">
            <div class="chart-header-block">
                <h2 class="chart-main-title">Traffic Overview</h2>
                <span class="chart-subtitle">Weekly clicks and unique visitors</span>
            </div>
            <div style="height: 380px; position: relative;">
                <canvas id="trafficOverviewChart"></canvas>
            </div>
        </div>

        <!-- MIDDLE SECTION: 4 Stat Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Total Clicks -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card-custom">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Clicks</span>
                        <i class="bi bi-graph-up stat-card-icon"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">1,248</div>
                        <div class="stat-card-trend">+12.4% vs last week</div>
                    </div>
                </div>
            </div>

            <!-- Unique Visitors -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card-custom">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Unique Visitors</span>
                        <i class="bi bi-person stat-card-icon"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">832</div>
                        <div class="stat-card-trend">+5.8% vs last week</div>
                    </div>
                </div>
            </div>

            <!-- Bounce Rate -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card-custom">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Bounce Rate</span>
                        <i class="bi bi-chevron-down stat-card-icon"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">42%</div>
                        <div class="stat-card-trend">-3.2% vs last week</div>
                    </div>
                </div>
            </div>

            <!-- Avg. Session -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card-custom">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Avg. Session</span>
                        <i class="bi bi-clock stat-card-icon"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">3m 24s</div>
                        <div class="stat-card-trend">+18s vs last week</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM SECTION: Referrers & Devices Row -->
        <div class="row g-4">
            <!-- Referrers Card -->
            <div class="col-12 col-lg-6">
                <div class="breakdown-card">
                    <div class="breakdown-header">
                        <h3 class="breakdown-title">Referrers</h3>
                        <span class="breakdown-subtitle">Top sources driving traffic</span>
                    </div>

                    <div class="breakdown-list">
                        <!-- Direct -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Direct</span>
                                <span class="breakdown-item-val">512</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-bar-dark" style="width: 100%;"></div>
                            </div>
                        </div>

                        <!-- Product Hunt -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Product Hunt</span>
                                <span class="breakdown-item-val">238</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-bar-dark" style="width: 46%;"></div>
                            </div>
                        </div>

                        <!-- Twitter -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Twitter</span>
                                <span class="breakdown-item-val">174</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-bar-dark" style="width: 34%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Devices Card -->
            <div class="col-12 col-lg-6">
                <div class="breakdown-card">
                    <div class="breakdown-header">
                        <h3 class="breakdown-title">Devices</h3>
                        <span class="breakdown-subtitle">How users access your app</span>
                    </div>

                    <div class="breakdown-list">
                        <!-- Desktop -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Desktop</span>
                                <span class="breakdown-item-val">74%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-bar-slate" style="width: 74%;"></div>
                            </div>
                        </div>

                        <!-- Mobile -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Mobile</span>
                                <span class="breakdown-item-val">22%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-bar-slate" style="width: 22%;"></div>
                            </div>
                        </div>

                        <!-- Tablet -->
                        <div>
                            <div class="breakdown-item-header">
                                <span class="breakdown-item-name">Tablet</span>
                                <span class="breakdown-item-val">4%</span>
                            </div>
                            <div class="custom-progress-track">
                                <div class="custom-progress-bar-slate" style="width: 4%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Interactive Scripts & Chart.js Implementation -->
    <script>
        // Render Traffic Overview Chart matching screenshot exactly
        const ctx = document.getElementById('trafficOverviewChart').getContext('2d');
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        // Line 1 (Dark line with filled shadow): High on Mon, Tue, drops on Wed, rises on Fri, drops on Sun
        const dataClicks = [870, 990, 240, 480, 700, 480, 160];
        
        // Line 2 (Lighter thin curve): Starts ~730, slopes down to Thu ~160, rises to Sun ~760
        const dataVisitors = [730, 600, 280, 160, 650, 410, 760];

        // Gradient for filled area
        const fillGradient = ctx.createLinearGradient(0, 0, 0, 380);
        fillGradient.addColorStop(0, 'rgba(203, 213, 225, 0.6)');
        fillGradient.addColorStop(1, 'rgba(241, 245, 249, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'Weekly Clicks',
                        data: dataClicks,
                        borderColor: '#1e293b',
                        borderWidth: 2,
                        backgroundColor: fillGradient,
                        fill: true,
                        tension: 0.45, // smooth spline curve
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#1e293b',
                    },
                    {
                        label: 'Unique Visitors',
                        data: dataVisitors,
                        borderColor: '#64748b',
                        borderWidth: 1.5,
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.45, // smooth spline curve
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#64748b',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#09090b',
                        padding: 10,
                        titleFont: { size: 12 },
                        bodyFont: { size: 12 },
                        cornerRadius: 6,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { size: 12.5, family: 'Inter' }
                        }
                    },
                    y: {
                        border: { display: false },
                        grid: { 
                            color: '#f1f5f9',
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#64748b',
                            font: { size: 12, family: 'Inter' },
                            stepSize: 250,
                            callback: function(value) {
                                return value;
                            }
                        },
                        min: 0,
                        max: 1000
                    }
                }
            }
        });

        // Cmd+K or Ctrl+K shortcut to focus search bar
        $(document).on('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                $('#global-search-input').focus();
            }
        });

        // Theme toggle button interaction
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

        // Interactive Dropdowns for all nav items with chevron-right
        $('.nav-dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            const btn = $(this);
            const subMenu = btn.next('.nav-submenu');

            // Slide toggle the target submenu
            subMenu.stop(true, true).slideToggle(200);
            btn.toggleClass('open');

            const isOpen = btn.hasClass('open');
            btn.attr('aria-expanded', isOpen);
        });
    </script>
</body>
</html>
