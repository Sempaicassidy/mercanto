@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercanto - {{ $isSwahili ? 'Maduka na Tenants (SaaS)' : 'Tenants & Stores (SaaS)' }}</title>

    @include('partials.pwa_meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        }

        .workspace-info span {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
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

        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 1.75rem 2.25rem;
            width: calc(100% - 260px);
        }

        .content-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 1.4rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .filter-tab-pill {
            padding: 0.4rem 0.95rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-tab-pill.active {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
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
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div>
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

            <div id="sidebar-nav-container">
                <div class="nav-section-title">{{ $isSwahili ? 'Usimamizi wa Mfumo' : 'Platform Operations' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/super-admin/dashboard') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-speedometer2"></i><span>{{ $isSwahili ? 'Dashibodi ya SaaS' : 'SaaS Dashboard' }}</span></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/tenants') }}" class="nav-item-link active">
                            <span class="nav-item-left"><i class="bi bi-shop-window"></i><span>{{ $isSwahili ? 'Maduka / Tenants' : 'Tenants & Stores' }}</span></span>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill" style="font-size: 0.7rem;">{{ $counts['total'] }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/contracts') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-file-earmark-text"></i><span>{{ $isSwahili ? 'Mikataba na Leases' : 'Contracts & Leases' }}</span></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/support') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-headset"></i><span>{{ $isSwahili ? 'Msaada wa Wateja' : 'Customer Support' }}</span></span>
                        </a>
                    </li>
                </ul>

                <div class="nav-section-title">{{ $isSwahili ? 'Tazama Maduka (Simulate)' : 'Store Views' }}</div>
                <ul class="nav-list">
                    <li>
                        <a href="{{ url('/switch-role/manager') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-shield-check text-primary"></i><span>{{ $isSwahili ? 'Meneja wa Duka' : 'Store Manager View' }}</span></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/switch-role/cashier') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-receipt text-success"></i><span>{{ $isSwahili ? 'Kaunta ya Mauzo (POS)' : 'Cashier / POS View' }}</span></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

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
        <header class="top-nav-bar">
            <form action="{{ url('/super-admin/tenants') }}" method="GET" class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="search-input" value="{{ $search }}" placeholder="{{ $isSwahili ? 'Tafuta kwa jina, barua pepe, simu...' : 'Search store name, email, phone...' }}">
                <span class="search-kbd">Enter</span>
            </form>

            <div class="top-nav-actions">
                @include('partials.role_switcher')
                <button class="nav-icon-btn" id="theme-toggle-btn" title="Toggle theme">
                    <i class="bi bi-sun" id="theme-icon"></i>
                </button>
            </div>
        </header>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark); letter-spacing: -0.5px;">
                    {{ $isSwahili ? 'Usimamizi wa Maduka (Tenants)' : 'SaaS Tenants & Stores' }}
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">
                    {{ $isSwahili ? 'Orodha ya maduka yote ya rejareja, jumla na mseto yaliyosajiliwa kwenye jukwaa.' : 'Manage all multi-tenant stores registered on the Mercanto SaaS platform.' }}
                </p>
            </div>

            <button type="button" class="btn btn-dark" style="background: #0f172a; border-radius: 9999px; padding: 0.55rem 1.25rem; font-weight: 600; font-size: 0.85rem;" data-bs-toggle="modal" data-bs-target="#newTenantModal">
                <i class="bi bi-plus-circle me-1"></i> {{ $isSwahili ? 'Sajili Tenant Mpya' : 'Register New Tenant' }}
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="d-flex align-items-center gap-2 flex-wrap mb-4">
            <a href="{{ url('/super-admin/tenants') }}" class="filter-tab-pill {{ empty($statusFilter) ? 'active' : '' }}">
                <span>{{ $isSwahili ? 'Yote' : 'All Stores' }}</span>
                <span class="badge bg-secondary rounded-pill" style="font-size: 0.68rem;">{{ $counts['total'] }}</span>
            </a>
            <a href="{{ url('/super-admin/tenants?status=active') }}" class="filter-tab-pill {{ $statusFilter === 'active' ? 'active' : '' }}">
                <span class="text-success"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i></span>
                <span>Active</span>
                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.68rem;">{{ $counts['active'] }}</span>
            </a>
            <a href="{{ url('/super-admin/tenants?status=trial') }}" class="filter-tab-pill {{ $statusFilter === 'trial' ? 'active' : '' }}">
                <span class="text-warning"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i></span>
                <span>Trial</span>
                <span class="badge bg-warning-subtle text-warning rounded-pill" style="font-size: 0.68rem;">{{ $counts['trial'] }}</span>
            </a>
            <a href="{{ url('/super-admin/tenants?status=suspended') }}" class="filter-tab-pill {{ $statusFilter === 'suspended' ? 'active' : '' }}">
                <span class="text-danger"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i></span>
                <span>Suspended</span>
                <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.68rem;">{{ $counts['suspended'] }}</span>
            </a>
        </div>

        <!-- Tenants Table Card -->
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ $isSwahili ? 'Duka / Tenant' : 'Store / Tenant' }}</th>
                            <th>{{ $isSwahili ? 'Aina' : 'Type' }}</th>
                            <th>{{ $isSwahili ? 'Matawi' : 'Branches' }}</th>
                            <th>{{ $isSwahili ? 'Watumiaji' : 'Users' }}</th>
                            <th>{{ $isSwahili ? 'Mkataba wa Sasa' : 'Current Lease' }}</th>
                            <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                            <th class="text-end">{{ $isSwahili ? 'Vitendo' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                            <tr>
                                <td>
                                    <div class="fw-bold" style="font-size: 0.9rem;">{{ $tenant->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-envelope me-1"></i> {{ $tenant->email ?? '-' }} • <i class="bi bi-telephone ms-1 me-1"></i> {{ $tenant->phone ?? '-' }}
                                    </div>
                                    @if($tenant->address)
                                        <div class="text-muted" style="font-size: 0.72rem;"><i class="bi bi-geo-alt me-1"></i>{{ $tenant->address }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $tenant->business_type === 'supplier' ? 'bg-purple-subtle text-purple' : ($tenant->business_type === 'hybrid' ? 'bg-info-subtle text-info' : 'bg-primary-subtle text-primary') }}" style="font-size: 0.72rem;">
                                        {{ ucfirst($tenant->business_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $tenant->branches_count }}</span>
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ $isSwahili ? 'matawi hai' : 'active branches' }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $tenant->users_count }}</span>
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ $isSwahili ? 'wafanyakazi' : 'staff members' }}</div>
                                </td>
                                <td>
                                    @if($tenant->activeContract)
                                        <div class="fw-semibold text-truncate" style="max-width: 180px; font-size: 0.8rem;">{{ $tenant->activeContract->title }}</div>
                                        <div class="text-success fw-bold" style="font-size: 0.74rem;">TSh {{ number_format($tenant->activeContract->amount) }}</div>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.7rem;">{{ $isSwahili ? 'Hakuna Mkataba' : 'No Active Lease' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($tenant->status === 'active')
                                        <span class="badge-pill-status bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i> Active</span>
                                    @elseif($tenant->status === 'trial')
                                        <span class="badge-pill-status bg-warning-subtle text-warning"><i class="bi bi-clock-history"></i> Trial</span>
                                    @else
                                        <span class="badge-pill-status bg-danger-subtle text-danger"><i class="bi bi-slash-circle"></i> Suspended</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('super_admin.tenants.masquerade', $tenant->id) }}" class="btn btn-sm btn-outline-warning text-dark me-1" style="font-size: 0.72rem; padding: 3px 10px; font-weight: 600;" title="Ingia kwenye duka kutoa msaada wa kiufundi (Support Masquerade)">
                                        <i class="bi bi-shield-lock me-1"></i> {{ $isSwahili ? 'Usaidizi' : 'Support' }}
                                    </a>
                                    <form action="{{ url('/super-admin/tenants/' . $tenant->id . '/status') }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($tenant->status === 'active')
                                            <input type="hidden" name="status" value="suspended">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size: 0.72rem; padding: 3px 10px;" title="Simamisha duka">
                                                <i class="bi bi-pause-circle me-1"></i> {{ $isSwahili ? 'Simamisha' : 'Suspend' }}
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit" class="btn btn-sm btn-outline-success" style="font-size: 0.72rem; padding: 3px 10px;" title="Washa duka">
                                                <i class="bi bi-play-circle me-1"></i> {{ $isSwahili ? 'Washa' : 'Activate' }}
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">{{ $isSwahili ? 'Hakuna duka lililopatikana kulingana na vigezo.' : 'No tenants found.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tenants->links() }}
            </div>
        </div>
    </main>

    <!-- Register New SaaS Tenant Modal -->
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

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
