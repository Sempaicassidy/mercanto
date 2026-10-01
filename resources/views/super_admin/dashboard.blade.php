@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercanto - Super Admin Command Center</title>

    @include('partials.pwa_meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --bg-page: #f8fafc;
            --sidebar-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --nav-active-bg: #f1f5f9;
            --card-border: #e2e8f0;
            --card-bg: #ffffff;
            --primary-btn: #0f172a;
        }

        body.dark-mode {
            --bg-page: #0b0f17;
            --sidebar-bg: #111827;
            --border-color: #1f2937;
            --text-dark: #f8fafc;
            --text-muted: #94a3b8;
            --nav-active-bg: #1e293b;
            --card-border: #1f2937;
            --card-bg: #111827;
            --primary-btn: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
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
            margin-bottom: 1.25rem;
        }

        .workspace-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .workspace-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #dc2626, #991b1b);
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .workspace-info h4 {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .workspace-info span {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-section-title {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-muted);
            margin: 1.25rem 0 0.5rem 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
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
            padding: 0.6rem 0.8rem;
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
            color: #dc2626;
            font-weight: 700;
        }

        .nav-item-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-item-left i {
            font-size: 1.05rem;
        }

        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
        }

        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 1.35rem 1.45rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .stat-label {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .stat-icon {
            font-size: 1.25rem;
        }

        .stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
            line-height: 1.1;
        }

        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 1.4rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            background: transparent;
            padding: 0.75rem 0.85rem;
        }

        .table tbody td {
            font-size: 0.85rem;
            padding: 0.85rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-dark);
        }

        .badge-pill-status {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 4px 9px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .quick-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.55rem 1.15rem;
            border-radius: 9999px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            border: 1px solid transparent;
        }
    </style>
</head>
<body>

    <!-- Left Sidebar (Super Admin SaaS) -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Workspace Brand Header -->
            <div class="workspace-header">
                <div class="workspace-brand">
                    <div class="workspace-icon">
                        <i class="bi bi-shield-shaded"></i>
                    </div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>SaaS HQ Admin</span>
                    </div>
                </div>
            </div>

            <!-- Super Admin Nav Items -->
            <div id="sidebar-nav-container">
                <div class="nav-section-title">{{ $isSwahili ? 'Usimamizi wa Mfumo' : 'Platform Operations' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/super-admin/dashboard') }}" class="nav-item-link active">
                            <span class="nav-item-left">
                                <i class="bi bi-speedometer2"></i>
                                <span>{{ $isSwahili ? 'Dashibodi ya SaaS' : 'SaaS Dashboard' }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/tenants') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-shop-window"></i>
                                <span>{{ $isSwahili ? 'Maduka / Tenants' : 'Tenants & Stores' }}</span>
                            </span>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill" style="font-size: 0.7rem;">{{ $tenantsCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/contracts') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>{{ $isSwahili ? 'Mikataba na Leases' : 'Contracts & Leases' }}</span>
                            </span>
                            @if($expiringContractsCount > 0)
                                <span class="badge bg-warning-subtle text-warning rounded-pill" style="font-size: 0.7rem;">{{ $expiringContractsCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/support') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-headset"></i>
                                <span>{{ $isSwahili ? 'Msaada wa Wateja' : 'Customer Support' }}</span>
                            </span>
                            @if($openTicketsCount > 0)
                                <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.7rem;">{{ $openTicketsCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <div class="nav-section-title">{{ $isSwahili ? 'Tazama Maduka (Simulate)' : 'Store Views' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/switch-role/manager') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-shield-check text-primary"></i>
                                <span>{{ $isSwahili ? 'Meneja wa Duka' : 'Store Manager View' }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/switch-role/cashier') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-receipt text-success"></i>
                                <span>{{ $isSwahili ? 'Kaunta ya Mauzo (POS)' : 'Cashier / POS View' }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/switch-role/storekeeper') }}" class="nav-item-link">
                            <span class="nav-item-left">
                                <i class="bi bi-box-seam text-warning"></i>
                                <span>{{ $isSwahili ? 'Mtunza Stoo' : 'Storekeeper View' }}</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="border-top pt-3" style="border-color: var(--border-color) !important;">
            <a href="{{ url('/login') }}" class="d-flex align-items-center justify-content-between text-muted text-decoration-none px-2 py-1">
                <span class="d-flex align-items-center gap-2" style="font-size: 0.85rem; font-weight: 600;">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <span>{{ $isSwahili ? 'Toka Kwenye Mfumo' : 'Sign Out' }}</span>
                </span>
                <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Super Admin</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        <!-- Top Nav Bar -->
        <header class="top-nav-bar">
            <div class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="{{ $isSwahili ? 'Tafuta tenant, mkataba, au tiketi...' : 'Search tenant, contract, or ticket...' }}">
                <span class="search-kbd">⌘ K</span>
            </div>

            <div class="top-nav-actions">
                <div class="header-branch-pill d-none d-sm-inline-flex" style="border-color: #fca5a5 !important;">
                    <span class="branch-indicator-dot" style="background-color: #dc2626 !important;"></span>
                    <span class="branch-name" style="font-weight: 700; color: #dc2626;">SaaS Global HQ</span>
                </div>

                @include('partials.role_switcher')

                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>

                <div class="header-profile-dropdown">
                    <div class="header-avatar" style="background-color: #dc2626 !important;">SA</div>
                </div>
            </div>
        </header>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Dashboard Header & Quick Action Buttons -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark); letter-spacing: -0.5px;">
                    {{ $isSwahili ? 'Kituo Kikuu cha Usimamizi (Super Admin)' : 'Super Admin Command Center' }}
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">
                    {{ $isSwahili ? 'Usimamizi kamili wa maduka ya SaaS, mikataba ya upangaji (leases), na huduma kwa wateja.' : 'Manage multi-tenant SaaS stores, software leases, contracts, and tenant support.' }}
                </p>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="quick-action-btn btn-dark" style="background: #0f172a; color: #fff;" data-bs-toggle="modal" data-bs-target="#newTenantModal">
                    <i class="bi bi-plus-circle"></i>
                    <span>{{ $isSwahili ? 'Sajili Tenant / Duka Jipya' : 'Register New Tenant' }}</span>
                </button>

                <button type="button" class="quick-action-btn btn-primary" style="background: #2563eb; color: #fff;" data-bs-toggle="modal" data-bs-target="#newContractModal">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span>{{ $isSwahili ? 'Weka Mkataba / Lease' : 'New Contract / Lease' }}</span>
                </button>

                <button type="button" class="quick-action-btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newSupportTicketModal">
                    <i class="bi bi-headset"></i>
                    <span>{{ $isSwahili ? 'Tiketi ya Msaada' : 'New Ticket' }}</span>
                </button>
            </div>
        </div>

        <!-- 4 Primary SaaS Platform KPI Cards -->
        <div class="row g-3 mb-4">
            <!-- 1. Total Tenants -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Maduka / Tenants Yote' : 'Total SaaS Tenants' }}</span>
                        <i class="bi bi-shop stat-icon text-primary"></i>
                    </div>
                    <div class="stat-value text-primary">{{ $tenantsCount }}</div>
                    <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 0.75rem;">
                        <span class="badge bg-success-subtle text-success">{{ $activeTenantsCount }} Active</span>
                        <span class="badge bg-warning-subtle text-warning">{{ $trialTenantsCount }} Trial</span>
                        @if($suspendedTenantsCount > 0)
                            <span class="badge bg-danger-subtle text-danger">{{ $suspendedTenantsCount }} Suspended</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. Active Leases & MRR -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Mapato ya Leases (Active)' : 'Total Active Lease Value' }}</span>
                        <i class="bi bi-cash-stack stat-icon text-success"></i>
                    </div>
                    <div class="stat-value text-success" style="font-size: 1.55rem;">TSh {{ number_format($totalLeaseRevenue) }}</div>
                    <div class="text-muted mt-2" style="font-size: 0.75rem;">
                        <span class="fw-semibold text-dark">{{ $activeContractsCount }}</span> {{ $isSwahili ? 'mikataba inayotumika kikamilifu' : 'active lease agreements' }}
                    </div>
                </div>
            </div>

            <!-- 3. Expiring Contracts Alert -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Mikataba Inayoisha (< 45 Siku)' : 'Expiring Leases (< 45 Days)' }}</span>
                        <i class="bi bi-clock-history stat-icon text-warning"></i>
                    </div>
                    <div class="stat-value {{ $expiringContractsCount > 0 ? 'text-warning' : 'text-muted' }}">
                        {{ $expiringContractsCount }}
                    </div>
                    <div class="text-muted mt-2" style="font-size: 0.75rem;">
                        @if($expiringContractsCount > 0)
                            <span class="text-warning fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $isSwahili ? 'Inahitaji kuhuishwa (Renewal)' : 'Renewal required' }}</span>
                        @else
                            <span class="text-success"><i class="bi bi-check2-circle me-1"></i>{{ $isSwahili ? 'Hakuna mkataba unaoisha karibuni' : 'No upcoming expirations' }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 4. Support Desk & Open Tickets -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">{{ $isSwahili ? 'Tiketi za Msaada (Open)' : 'Open Support Tickets' }}</span>
                        <i class="bi bi-headset stat-icon text-danger"></i>
                    </div>
                    <div class="stat-value {{ $openTicketsCount > 0 ? 'text-danger' : 'text-success' }}">
                        {{ $openTicketsCount }}
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 0.75rem;">
                        @if($urgentTicketsCount > 0)
                            <span class="badge bg-danger text-white"><i class="bi bi-fire me-1"></i>{{ $urgentTicketsCount }} Urgent</span>
                        @endif
                        <span class="text-muted">{{ $resolvedTicketsCount }} {{ $isSwahili ? 'zilizotatuliwa' : 'resolved' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2 Column Section: Recent Tenants & Active Contracts -->
        <div class="row g-4 mb-4">
            <!-- Recent Tenants Table -->
            <div class="col-12 col-xl-7">
                <div class="content-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h3 class="h6 fw-bold mb-0">{{ $isSwahili ? 'Maduka / Tenants Yaliyosajiliwa' : 'Registered SaaS Tenants' }}</h3>
                            <span class="text-muted" style="font-size: 0.78rem;">{{ $isSwahili ? 'Maduka 5 ya hivi karibuni kwenye mfumo' : 'Latest 5 stores onboarded' }}</span>
                        </div>
                        <a href="{{ url('/super-admin/tenants') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 0.75rem; border-radius: 9999px;">
                            {{ $isSwahili ? 'Tazama Yote' : 'View All' }} <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>{{ $isSwahili ? 'Jina la Duka / Tenant' : 'Tenant Name' }}</th>
                                    <th>{{ $isSwahili ? 'Aina ya Biashara' : 'Type' }}</th>
                                    <th>{{ $isSwahili ? 'Matawi' : 'Branches' }}</th>
                                    <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                                    <th class="text-end">{{ $isSwahili ? 'Kitendo' : 'Action' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTenants as $tenant)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $tenant->name }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $tenant->email ?? $tenant->phone }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $tenant->business_type === 'supplier' ? 'bg-purple-subtle text-purple' : 'bg-primary-subtle text-primary' }}" style="font-size: 0.72rem;">
                                                {{ ucfirst($tenant->business_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $tenant->branches_count }}</span>
                                            <span class="text-muted" style="font-size: 0.72rem;">{{ $isSwahili ? 'matawi' : 'branches' }}</span>
                                        </td>
                                        <td>
                                            @if($tenant->status === 'active')
                                                <span class="badge-pill-status bg-success-subtle text-success">
                                                    <i class="bi bi-check-circle-fill"></i> Active
                                                </span>
                                            @elseif($tenant->status === 'trial')
                                                <span class="badge-pill-status bg-warning-subtle text-warning">
                                                    <i class="bi bi-clock-history"></i> Trial
                                                </span>
                                            @else
                                                <span class="badge-pill-status bg-danger-subtle text-danger">
                                                    <i class="bi bi-slash-circle"></i> Suspended
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ url('/super-admin/tenants/' . $tenant->id . '/status') }}" method="POST" class="d-inline">
                                                @csrf
                                                @if($tenant->status === 'active')
                                                    <input type="hidden" name="status" value="suspended">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size: 0.72rem; padding: 2px 8px;" title="Simamisha duka">
                                                        {{ $isSwahili ? 'Simamisha' : 'Suspend' }}
                                                    </button>
                                                @else
                                                    <input type="hidden" name="status" value="active">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" style="font-size: 0.72rem; padding: 2px 8px;" title="Washa duka">
                                                        {{ $isSwahili ? 'Washa' : 'Activate' }}
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">{{ $isSwahili ? 'Hakuna tenant aliyesajiliwa bado.' : 'No tenants registered yet.' }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Active Leases & Contracts List -->
            <div class="col-12 col-xl-5">
                <div class="content-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h3 class="h6 fw-bold mb-0">{{ $isSwahili ? 'Mikataba na Upangaji (Leases)' : 'SaaS Contracts & Leases' }}</h3>
                            <span class="text-muted" style="font-size: 0.78rem;">{{ $isSwahili ? 'Mikataba ya programu na leseni' : 'Active software leases & terms' }}</span>
                        </div>
                        <a href="{{ url('/super-admin/contracts') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 0.75rem; border-radius: 9999px;">
                            {{ $isSwahili ? 'Tazama Yote' : 'View All' }} <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>{{ $isSwahili ? 'Mkataba / Duka' : 'Contract / Tenant' }}</th>
                                    <th>{{ $isSwahili ? 'Kiasi' : 'Fee' }}</th>
                                    <th>{{ $isSwahili ? 'Muda Uliobaki' : 'Remaining' }}</th>
                                    <th class="text-end">{{ $isSwahili ? 'Kitendo' : 'Action' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentContracts as $contract)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-truncate" style="max-width: 170px;">{{ $contract->title }}</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">{{ $contract->tenant->name ?? 'N/A' }} • <span class="fw-semibold text-dark">{{ $contract->contract_number }}</span></div>
                                        </td>
                                        <td>
                                            <div class="fw-bold" style="font-size: 0.8rem;">TSh {{ number_format($contract->amount) }}</div>
                                            <div class="text-muted" style="font-size: 0.68rem;">{{ ucfirst($contract->billing_cycle) }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $days = $contract->daysRemaining();
                                            @endphp
                                            @if($days <= 0)
                                                <span class="badge bg-danger-subtle text-danger" style="font-size: 0.7rem;">Expired</span>
                                            @elseif($days <= 45)
                                                <span class="badge bg-warning-subtle text-warning" style="font-size: 0.7rem;">{{ $days }} {{ $isSwahili ? 'Siku' : 'Days' }}</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success" style="font-size: 0.7rem;">{{ $days }} {{ $isSwahili ? 'Siku' : 'Days' }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ url('/super-admin/contracts/' . $contract->id . '/status') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="action" value="renew">
                                                <button type="submit" class="btn btn-sm btn-outline-primary" style="font-size: 0.7rem; padding: 2px 7px;" title="Huisha mkataba">
                                                    <i class="bi bi-arrow-repeat"></i> {{ $isSwahili ? 'Huisha' : 'Renew' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">{{ $isSwahili ? 'Hakuna mikataba bado.' : 'No contracts found.' }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Support Tickets Section -->
        <div class="content-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h3 class="h6 fw-bold mb-0">{{ $isSwahili ? 'Tiketi za Msaada wa Kiufundi (Support Desk)' : 'Tenant Support & Helpdesk Tickets' }}</h3>
                    <span class="text-muted" style="font-size: 0.78rem;">{{ $isSwahili ? 'Maombi na maswali ya kiufundi kutoka kwa maduka' : 'Latest technical requests and issues reported by stores' }}</span>
                </div>
                <a href="{{ url('/super-admin/support') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 0.75rem; border-radius: 9999px;">
                    {{ $isSwahili ? 'Fungua Support Desk' : 'Open Support Desk' }} <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ $isSwahili ? 'Tiketi #' : 'Ticket #' }}</th>
                            <th>{{ $isSwahili ? 'Duka / Tenant' : 'Tenant' }}</th>
                            <th>{{ $isSwahili ? 'Mada (Subject)' : 'Subject' }}</th>
                            <th>{{ $isSwahili ? 'Kundi' : 'Category' }}</th>
                            <th>{{ $isSwahili ? 'Kipaumbele' : 'Priority' }}</th>
                            <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                            <th class="text-end">{{ $isSwahili ? 'Kitendo' : 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTickets as $ticket)
                            <tr>
                                <td class="fw-bold" style="font-size: 0.8rem;">{{ $ticket->ticket_number }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $ticket->tenant->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-truncate" style="max-width: 280px;">{{ $ticket->subject }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.72rem;">{{ ucfirst(str_replace('_', ' ', $ticket->category)) }}</span>
                                </td>
                                <td>
                                    @if($ticket->priority === 'urgent')
                                        <span class="badge bg-danger text-white" style="font-size: 0.7rem;"><i class="bi bi-fire me-1"></i>Urgent</span>
                                    @elseif($ticket->priority === 'high')
                                        <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">High</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info" style="font-size: 0.7rem;">{{ ucfirst($ticket->priority) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->status === 'resolved')
                                        <span class="badge-pill-status bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i> Resolved</span>
                                    @elseif($ticket->status === 'in_progress')
                                        <span class="badge-pill-status bg-primary-subtle text-primary"><i class="bi bi-arrow-repeat"></i> In Progress</span>
                                    @else
                                        <span class="badge-pill-status bg-danger-subtle text-danger"><i class="bi bi-exclamation-circle-fill"></i> Open</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ url('/super-admin/support/' . $ticket->id . '/status') }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($ticket->status === 'open')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="btn btn-sm btn-outline-primary" style="font-size: 0.72rem; padding: 2px 8px;">
                                                {{ $isSwahili ? 'Anza Kushughulikia' : 'Start Working' }}
                                            </button>
                                        @elseif($ticket->status === 'in_progress')
                                            <input type="hidden" name="status" value="resolved">
                                            <input type="hidden" name="resolution_notes" value="Tatizo limetatuliwa na Super Admin.">
                                            <button type="submit" class="btn btn-sm btn-outline-success" style="font-size: 0.72rem; padding: 2px 8px;">
                                                <i class="bi bi-check2"></i> {{ $isSwahili ? 'Tatua' : 'Resolve' }}
                                            </button>
                                        @else
                                            <span class="text-muted" style="font-size: 0.75rem;">-</span>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">{{ $isSwahili ? 'Hakuna tiketi za msaada zilizoripotiwa.' : 'No support tickets.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal 1: Register New SaaS Tenant & Provision Branch / Admin -->
    <div class="modal fade" id="newTenantModal" tabindex="-1" aria-labelledby="newTenantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="newTenantModalLabel">
                        <i class="bi bi-shop me-2 text-danger"></i> {{ $isSwahili ? 'Sajili Duka Jipya (Register SaaS Tenant)' : 'Register New SaaS Tenant' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/super-admin/tenants') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Jina la Biashara / Duka (Store Name)' : 'Store / Tenant Name' }} *</label>
                                <input type="text" name="name" class="form-control" placeholder="mfano: Victoria Pharmacy Ltd" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Aina ya Mfumo' : 'Business Mode' }} *</label>
                                <select name="business_type" class="form-select" required>
                                    <option value="retailer">{{ $isSwahili ? 'Rejareja (Retailer & POS Desk)' : 'Retailer (POS & Counter)' }}</option>
                                    <option value="supplier">{{ $isSwahili ? 'Jumla (Wholesale & Supplier)' : 'Wholesaler (Supplier & Bulk)' }}</option>
                                    <option value="hybrid">{{ $isSwahili ? 'Mseto (Hybrid Retail + Wholesale)' : 'Hybrid (Retail & Wholesale)' }}</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Barua Pepe ya Duka (Store Email)' : 'Store Email' }} *</label>
                                <input type="email" name="email" class="form-control" placeholder="info@store.co.tz" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Nambari ya Simu' : 'Phone Number' }}</label>
                                <input type="text" name="phone" class="form-control" placeholder="+255 712 000 111">
                            </div>

                            <div class="col-12 col-md-8">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Eneo / Anwani (Location / Address)' : 'Address' }}</label>
                                <input type="text" name="address" class="form-control" placeholder="Kariakoo, Dar es Salaam">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">TIN Number</label>
                                <input type="text" name="tin_number" class="form-control" placeholder="100-222-333">
                            </div>

                            <div class="col-12"><hr class="my-2 text-muted"></div>
                            <div class="col-12"><h6 class="fw-bold mb-0 text-primary"><i class="bi bi-file-earmark-check me-1"></i> {{ $isSwahili ? 'Mpango wa Upangaji (SaaS Lease Plan)' : 'SaaS Lease Plan' }}</h6></div>

                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Jina la Plan / Tier' : 'Plan Name' }} *</label>
                                <input type="text" name="plan_title" class="form-control" value="Retail Cloud POS Annual Lease" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Mzunguko wa Malipo (Cycle)' : 'Billing Cycle' }} *</label>
                                <select name="lease_billing_cycle" class="form-select" required>
                                    <option value="annually">{{ $isSwahili ? 'Kila Mwaka (Annually)' : 'Annually' }}</option>
                                    <option value="monthly">{{ $isSwahili ? 'Kila Mwezi (Monthly)' : 'Monthly' }}</option>
                                    <option value="quarterly">{{ $isSwahili ? 'Kila Robo Mwaka (Quarterly)' : 'Quarterly' }}</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Kiasi cha Lease (TZS)' : 'Lease Fee (TZS)' }} *</label>
                                <input type="number" name="lease_amount" class="form-control" value="1200000" min="0" required>
                            </div>

                            <div class="col-12"><hr class="my-2 text-muted"></div>
                            <div class="col-12"><h6 class="fw-bold mb-0 text-success"><i class="bi bi-person-badge me-1"></i> {{ $isSwahili ? 'Akaunti ya Meneja wa Duka' : 'Store Admin Credentials' }}</h6></div>

                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Jina Kamili la Meneja' : 'Manager Name' }} *</label>
                                <input type="text" name="manager_name" class="form-control" placeholder="Meneja Mkuu" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Barua Pepe ya Kuingilia' : 'Login Email' }} *</label>
                                <input type="email" name="manager_email" class="form-control" placeholder="meneja@store.co.tz" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Nenosiri (Password)' : 'Password' }} *</label>
                                <input type="password" name="manager_password" class="form-control" value="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                        <button type="submit" class="btn btn-dark" style="background: #0f172a;">
                            <i class="bi bi-check2-circle me-1"></i> {{ $isSwahili ? 'Kamilisha Usajili wa Duka' : 'Provision & Launch Tenant' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Create Contract / Lease -->
    <div class="modal fade" id="newContractModal" tabindex="-1" aria-labelledby="newContractModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="newContractModalLabel">
                        <i class="bi bi-file-earmark-plus text-primary me-2"></i> {{ $isSwahili ? 'Weka Mkataba / Lease Mpya' : 'Create SaaS Contract / Lease' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/super-admin/contracts') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Chagua Duka / Tenant' : 'Select Tenant' }} *</label>
                            <select name="tenant_id" class="form-select" required>
                                @foreach($recentTenants as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }} ({{ ucfirst($t->business_type) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Jina la Mkataba / Kichwa' : 'Contract Title' }} *</label>
                            <input type="text" name="title" class="form-control" placeholder="Annual POS Multi-Branch Lease Agreement" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Aina ya Mkataba' : 'Type' }}</label>
                                <select name="type" class="form-select" required>
                                    <option value="lease">Lease Agreement</option>
                                    <option value="subscription">Cloud Subscription</option>
                                    <option value="custom_license">Custom Enterprise License</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Mzunguko' : 'Cycle' }}</label>
                                <select name="billing_cycle" class="form-select" required>
                                    <option value="annually">Annually</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Kiasi (TZS)' : 'Amount (TZS)' }} *</label>
                                <input type="number" name="amount" class="form-control" value="1500000" min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Hali ya Malipo' : 'Payment Status' }}</label>
                                <select name="payment_status" class="form-select">
                                    <option value="paid">Paid (Imelipwa)</option>
                                    <option value="pending">Pending</option>
                                    <option value="partial">Partial</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Tarehe ya Kuanza' : 'Start Date' }}</label>
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Tarehe ya Kuisha' : 'End Date' }}</label>
                                <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d', strtotime('+1 year')) }}" required>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="active">
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                        <button type="submit" class="btn btn-primary">{{ $isSwahili ? 'Hifadhi Mkataba' : 'Save Contract' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 3: Create Support Ticket -->
    <div class="modal fade" id="newSupportTicketModal" tabindex="-1" aria-labelledby="newSupportTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="newSupportTicketModalLabel">
                        <i class="bi bi-headset text-danger me-2"></i> {{ $isSwahili ? 'Fungua Tiketi ya Msaada' : 'Open Support Ticket' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/super-admin/support') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Duka / Tenant' : 'Tenant' }} *</label>
                            <select name="tenant_id" class="form-select" required>
                                @foreach($recentTenants as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Mada (Subject)' : 'Subject' }} *</label>
                            <input type="text" name="subject" class="form-control" placeholder="mfano: Msaada wa kusanidi mashine ya risiti" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Kundi (Category)' : 'Category' }}</label>
                                <select name="category" class="form-select">
                                    <option value="technical">Technical</option>
                                    <option value="billing">Billing</option>
                                    <option value="pos_hardware">POS Hardware</option>
                                    <option value="feature_request">Feature Request</option>
                                    <option value="training">Training</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Kipaumbele (Priority)' : 'Priority' }}</label>
                                <select name="priority" class="form-select">
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.82rem;">{{ $isSwahili ? 'Maelezo Kamili ya Changamoto' : 'Description' }} *</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Eleza changamoto au hitaji la duka..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $isSwahili ? 'Ghairi' : 'Cancel' }}</button>
                        <button type="submit" class="btn btn-danger">{{ $isSwahili ? 'Fungua Tiketi' : 'Submit Ticket' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme toggle
        document.getElementById('theme-toggle-btn')?.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            const icon = document.getElementById('theme-icon');
            if (icon) {
                icon.className = isDark ? 'bi bi-moon-stars' : 'bi bi-sun';
            }
        });
    </script>
</body>
</html>
