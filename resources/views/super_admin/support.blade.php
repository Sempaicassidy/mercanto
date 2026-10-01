@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercanto - {{ $isSwahili ? 'Msaada wa Wateja (Support Desk)' : 'Customer Support Desk (SaaS)' }}</title>

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
                        <a href="{{ url('/super-admin/tenants') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-shop-window"></i><span>{{ $isSwahili ? 'Maduka / Tenants' : 'Tenants & Stores' }}</span></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/contracts') }}" class="nav-item-link">
                            <span class="nav-item-left"><i class="bi bi-file-earmark-text"></i><span>{{ $isSwahili ? 'Mikataba na Leases' : 'Contracts & Leases' }}</span></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/super-admin/support') }}" class="nav-item-link active">
                            <span class="nav-item-left"><i class="bi bi-headset"></i><span>{{ $isSwahili ? 'Msaada wa Wateja' : 'Customer Support' }}</span></span>
                            <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.7rem;">{{ $counts['open'] }}</span>
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
            <form action="{{ url('/super-admin/support') }}" method="GET" class="header-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="search-input" value="{{ $search }}" placeholder="{{ $isSwahili ? 'Tafuta tiketi, mada, duka...' : 'Search ticket #, subject, tenant...' }}">
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
                    {{ $isSwahili ? 'Msaada wa Wateja na Tiketi (Support Desk)' : 'SaaS Customer Support & Tickets' }}
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">
                    {{ $isSwahili ? 'Kupokea na kutatua changamoto za kiufundi, maunzi ya POS, na maswali ya malipo kutoka madukani.' : 'Resolve tenant technical inquiries, POS hardware issues, and billing support requests.' }}
                </p>
            </div>

            <button type="button" class="btn btn-danger" style="background: #dc2626; border-radius: 9999px; padding: 0.55rem 1.25rem; font-weight: 600; font-size: 0.85rem;" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                <i class="bi bi-plus-circle me-1"></i> {{ $isSwahili ? 'Fungua Tiketi Mpya' : 'Open Support Ticket' }}
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="d-flex align-items-center gap-2 flex-wrap mb-4">
            <a href="{{ url('/super-admin/support') }}" class="filter-tab-pill {{ empty($statusFilter) && empty($priorityFilter) ? 'active' : '' }}">
                <span>{{ $isSwahili ? 'Tiketi Zote' : 'All Tickets' }}</span>
                <span class="badge bg-secondary rounded-pill" style="font-size: 0.68rem;">{{ $counts['total'] }}</span>
            </a>
            <a href="{{ url('/super-admin/support?status=open') }}" class="filter-tab-pill {{ $statusFilter === 'open' ? 'active' : '' }}">
                <span class="text-danger"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i></span>
                <span>Open</span>
                <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.68rem;">{{ $counts['open'] }}</span>
            </a>
            <a href="{{ url('/super-admin/support?status=in_progress') }}" class="filter-tab-pill {{ $statusFilter === 'in_progress' ? 'active' : '' }}">
                <span class="text-primary"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i></span>
                <span>In Progress</span>
                <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 0.68rem;">{{ $counts['in_progress'] }}</span>
            </a>
            <a href="{{ url('/super-admin/support?priority=urgent') }}" class="filter-tab-pill {{ $priorityFilter === 'urgent' ? 'active' : '' }}">
                <span class="text-danger"><i class="bi bi-fire"></i></span>
                <span>Urgent</span>
                <span class="badge bg-danger text-white rounded-pill" style="font-size: 0.68rem;">{{ $counts['urgent'] }}</span>
            </a>
            <a href="{{ url('/super-admin/support?status=resolved') }}" class="filter-tab-pill {{ $statusFilter === 'resolved' ? 'active' : '' }}">
                <span class="text-success"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i></span>
                <span>Resolved</span>
                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.68rem;">{{ $counts['resolved'] }}</span>
            </a>
        </div>

        <!-- Support Tickets Table -->
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ $isSwahili ? 'Nambari' : 'Ticket #' }}</th>
                            <th>{{ $isSwahili ? 'Duka / Tenant' : 'Tenant' }}</th>
                            <th>{{ $isSwahili ? 'Mada na Maelezo' : 'Subject & Description' }}</th>
                            <th>{{ $isSwahili ? 'Kundi' : 'Category' }}</th>
                            <th>{{ $isSwahili ? 'Kipaumbele' : 'Priority' }}</th>
                            <th>{{ $isSwahili ? 'Tarehe' : 'Created' }}</th>
                            <th>{{ $isSwahili ? 'Hali' : 'Status' }}</th>
                            <th class="text-end">{{ $isSwahili ? 'Kitendo' : 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="fw-bold" style="font-size: 0.8rem;">{{ $ticket->ticket_number }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $ticket->tenant->name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ $ticket->tenant->phone ?? '' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-truncate" style="max-width: 320px; font-size: 0.85rem;">{{ $ticket->subject }}</div>
                                    <div class="text-muted text-truncate" style="max-width: 320px; font-size: 0.75rem;">{{ $ticket->description }}</div>
                                    @if($ticket->resolution_notes)
                                        <div class="text-success" style="font-size: 0.72rem;"><i class="bi bi-check-all me-1"></i><strong>Ufumbuzi:</strong> {{ $ticket->resolution_notes }}</div>
                                    @endif
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
                                    <div style="font-size: 0.78rem;">{{ $ticket->created_at->format('d M Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $ticket->created_at->format('H:i') }}</div>
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
                                                <i class="bi bi-play me-1"></i> {{ $isSwahili ? 'Shughulikia' : 'Handle' }}
                                            </button>
                                        @elseif($ticket->status === 'in_progress')
                                            <input type="hidden" name="status" value="resolved">
                                            <input type="hidden" name="resolution_notes" value="Tatizo limetatuliwa kikamilifu na timu ya msaada.">
                                            <button type="submit" class="btn btn-sm btn-outline-success" style="font-size: 0.72rem; padding: 2px 8px;">
                                                <i class="bi bi-check2"></i> {{ $isSwahili ? 'Kamilisha' : 'Resolve' }}
                                            </button>
                                        @else
                                            <span class="text-muted" style="font-size: 0.75rem;">-</span>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">{{ $isSwahili ? 'Hakuna tiketi zilizopatikana.' : 'No support tickets found.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tickets->links() }}
            </div>
        </div>
    </main>

    <!-- Modal: Open Support Ticket -->
    <div class="modal fade" id="newTicketModal" tabindex="-1" aria-labelledby="newTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="newTicketModalLabel">
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
                                @foreach($allTenants as $t)
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
