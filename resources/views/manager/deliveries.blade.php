<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usimamizi wa Usafirishaji (Deliveries & Dispatch) - mercanto</title>

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
            --badge-info-bg: #eff6ff;
            --badge-info-text: #2563eb;
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
            --badge-info-bg: #172554;
            --badge-info-text: #60a5fa;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body { background-color: var(--bg-page); color: var(--text-dark); min-height: 100vh; display: flex; transition: background-color 0.2s ease, color 0.2s ease; }

        .sidebar {
            width: 260px; background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color);
            display: flex; flex-direction: column; justify-content: space-between; min-height: 100vh;
            padding: 1.25rem 1rem; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .workspace-header {
            display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.6rem;
            border-radius: 8px; cursor: pointer; margin-bottom: 1.25rem;
        }
        .workspace-header:hover { background-color: var(--nav-active-bg); }
        .workspace-brand { display: flex; align-items: center; gap: 12px; }
        .workspace-icon {
            width: 36px; height: 36px; background-color: var(--primary-btn); color: #ffffff;
            border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
        }
        body.dark-mode .workspace-icon { color: #09090b; }
        .workspace-info h4 { font-size: 0.92rem; font-weight: 700; color: var(--text-dark); margin: 0; line-height: 1.2; }
        .workspace-info span { font-size: 0.75rem; color: var(--text-muted); }

        .nav-section-title { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); margin: 1rem 0 0.4rem 0.6rem; letter-spacing: 0.3px; }
        .nav-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }

        .nav-item-link {
            display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.75rem;
            border-radius: 8px; text-decoration: none; color: var(--text-muted); font-size: 0.86rem;
            font-weight: 500; transition: all 0.15s ease;
        }
        .nav-item-link:hover { background-color: var(--nav-active-bg); color: var(--text-dark); }
        .nav-item-link.active { background-color: var(--nav-active-bg); color: var(--text-dark); font-weight: 600; }
        .nav-item-left { display: flex; align-items: center; gap: 10px; }

        .main-wrapper { margin-left: 260px; flex-grow: 1; padding: 1.5rem 2rem 3rem 2rem; width: calc(100% - 260px); min-height: 100vh; }

        .top-nav-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; gap: 12px; }
        .stat-card {
            background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px;
            padding: 1.25rem 1.4rem; display: flex; flex-direction: column; justify-content: space-between; height: 100%;
        }
        .stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
        .stat-label { font-size: 0.82rem; font-weight: 500; color: var(--text-muted); }
        .stat-value { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; color: var(--text-dark); margin-bottom: 0.25rem; }
        .stat-footer { font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }

        .content-card { background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; padding: 1.25rem; margin-top: 1.5rem; }
        .custom-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .custom-table th { text-align: left; padding: 0.75rem 1rem; font-size: 0.74rem; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border-color); text-transform: uppercase; letter-spacing: 0.5px; }
        .custom-table td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--border-color); color: var(--text-dark); vertical-align: middle; }
        .custom-table tbody tr:hover td { background-color: var(--nav-active-bg); }

        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 1050; padding: 1rem;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px;
            width: 100%; max-width: 520px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15); overflow: hidden;
        }
        .modal-header-custom { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; }
        .modal-header-custom h3 { font-size: 1.05rem; font-weight: 700; color: var(--text-dark); margin: 0; }
        .modal-body-custom { padding: 1.5rem; }
        .modal-footer-custom { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 10px; }

        .form-label-custom { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-dark); margin-bottom: 0.4rem; }
        .form-control-custom { width: 100%; padding: 0.55rem 0.85rem; border-radius: 6px; border: 1px solid var(--border-color); background-color: var(--input-bg); color: var(--text-dark); font-size: 0.85rem; outline: none; }
        .form-control-custom:focus { border-color: #71717a; }
        .btn-outline-custom { background: transparent; color: var(--text-dark); border: 1px solid var(--border-color); padding: 0.48rem 1rem; font-size: 0.85rem; font-weight: 500; border-radius: 6px; cursor: pointer; text-decoration: none; }
        .btn-dark-custom { background-color: var(--primary-btn); color: #ffffff; border: 1px solid var(--primary-btn); padding: 0.48rem 1rem; font-size: 0.85rem; font-weight: 600; border-radius: 6px; cursor: pointer; text-decoration: none; }
        body.dark-mode .btn-dark-custom { color: #09090b; }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="workspace-header">
                <div class="workspace-brand">
                    <div class="workspace-icon"><i class="bi bi-shop"></i></div>
                    <div class="workspace-info">
                        <h4>mercanto</h4>
                        <span>Duka la Bidhaa</span>
                    </div>
                </div>
            </div>

            <div class="nav-section-title">MENYU KUU</div>
            <ul class="nav-list">
                <li><a href="{{ url('/manager/dashboard') }}" class="nav-item-link"><div class="nav-item-left"><i class="bi bi-grid-1x2"></i><span>Dashibodi</span></div></a></li>
                <li><a href="{{ url('/pos') }}" class="nav-item-link"><div class="nav-item-left"><i class="bi bi-cash-stack"></i><span>POS & Mauzo</span></div></a></li>
                <li><a href="{{ url('/manager/inventory') }}" class="nav-item-link"><div class="nav-item-left"><i class="bi bi-boxes"></i><span>Bidhaa & Stoo</span></div></a></li>
                <li><a href="{{ url('/manager/customers') }}" class="nav-item-link"><div class="nav-item-left"><i class="bi bi-people"></i><span>Wateja & Pochi</span></div></a></li>
                <li><a href="{{ url('/manager/deliveries') }}" class="nav-item-link active"><div class="nav-item-left"><i class="bi bi-truck"></i><span>Usafirishaji (Dispatch)</span></div></a></li>
                <li><a href="{{ url('/manager/transfers') }}" class="nav-item-link"><div class="nav-item-left"><i class="bi bi-arrow-left-right"></i><span>Matawi (Branches)</span></div></a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <main class="main-wrapper">
        @include('partials.role_switcher')

        <div class="top-nav-bar">
            <div>
                <h1 class="h3 fw-bold mb-1"><i class="bi bi-truck me-2"></i>Usimamizi wa Usafirishaji (Deliveries)</h1>
                <p class="text-muted small mb-0">Uratibu wa usafirishaji wa mizigo ya wateja wa jumla na rejareja kupitia Bodaboda, Bajaj na Magari.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn-dark-custom" id="btnOpenRiderModal">
                    <i class="bi bi-person-plus-fill me-1"></i> Sajili Dereva / Rider Mpya
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Row -->
        @php
            $pendingCount = $deliveries->where('status', 'pending')->count();
            $assignedCount = $deliveries->where('status', 'assigned')->count();
            $deliveredCount = $deliveries->where('status', 'delivered')->count();
            $activeRiders = $riders->where('status', 'available')->count();
        @endphp
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Zinazosubiri Dereva</span>
                        <i class="bi bi-hourglass-split stat-icon text-warning fs-5"></i>
                    </div>
                    <div class="stat-value text-warning">{{ $pendingCount }}</div>
                    <div class="stat-footer">Mizigo iliyotengwa dukani</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Iliyokabidhiwa / Njiani</span>
                        <i class="bi bi-send-check stat-icon text-primary fs-5"></i>
                    </div>
                    <div class="stat-value text-primary">{{ $assignedCount }}</div>
                    <div class="stat-footer">Dereva amepewa mzigo</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Zilizofikishwa</span>
                        <i class="bi bi-check-circle stat-icon text-success fs-5"></i>
                    </div>
                    <div class="stat-value text-success">{{ $deliveredCount }}</div>
                    <div class="stat-footer">Mteja amepokea kikamilifu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Madereva Huru</span>
                        <i class="bi bi-person-badge stat-icon text-info fs-5"></i>
                    </div>
                    <div class="stat-value text-info">{{ $activeRiders }}</div>
                    <div class="stat-footer">Bodaboda, Bajaj na Pick-up</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Deliveries Board -->
            <div class="col-lg-8">
                <div class="content-card mt-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-clipboard-check me-2"></i>Bodi ya Usafirishaji (Dispatch Board)</h5>
                        <span class="text-muted small">Jumla: {{ $deliveries->total() }}</span>
                    </div>

                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Oda / Tracking</th>
                                    <th>Mteja & Simu</th>
                                    <th>Eneo la Kupeleka</th>
                                    <th>Dereva / Rider</th>
                                    <th>Hali</th>
                                    <th class="text-end">Badili Hali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deliveries as $del)
                                    <tr>
                                        <td>
                                            <strong>#{{ $del->tracking_number }}</strong><br>
                                            <small class="text-muted">{{ $del->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $del->recipient_name ?? $del->customer?->name ?? 'Mteja wa Kawaida' }}</strong><br>
                                            <small class="text-muted">{{ $del->recipient_phone ?? $del->customer?->phone ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span>{{ $del->delivery_address }}</span>
                                            @if($del->delivery_fee > 0)
                                                <br><small class="text-muted">Nauli: TSh {{ number_format($del->delivery_fee) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($del->rider)
                                                <span class="badge bg-info-subtle text-info border border-info px-2 py-1">
                                                    <i class="bi bi-person me-1"></i>{{ $del->rider->name }} ({{ ucfirst($del->rider->vehicle_type) }})
                                                </span>
                                            @else
                                                <form action="{{ route('manager.deliveries.assign', $del->id) }}" method="POST" class="d-flex gap-1">
                                                    @csrf
                                                    <select name="rider_id" class="form-select form-select-sm" style="font-size: 0.78rem;" required>
                                                        <option value="">-- Mkabidhi Rider --</option>
                                                        @foreach($riders as $r)
                                                            <option value="{{ $r->id }}">{{ $r->name }} ({{ ucfirst($r->vehicle_type) }})</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary py-0" title="Mkabidhi Dereva"><i class="bi bi-check"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            @if($del->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1">Inasubiri Dereva</span>
                                            @elseif($del->status === 'assigned')
                                                <span class="badge bg-info-subtle text-info border border-info px-2 py-1">Amekabidhiwa Dereva</span>
                                            @elseif($del->status === 'in_transit')
                                                <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">Ipo Njiani</span>
                                            @elseif($del->status === 'delivered')
                                                <span class="badge bg-success-subtle text-success border border-success px-2 py-1">Imefikishwa</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">{{ ucfirst($del->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($del->status !== 'delivered')
                                                <form action="{{ route('manager.deliveries.status', $del->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @if($del->status === 'pending' || $del->status === 'assigned')
                                                        <input type="hidden" name="status" value="in_transit">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Tuma Mzigo"><i class="bi bi-send me-1"></i> Njiani</button>
                                                    @elseif($del->status === 'in_transit')
                                                        <input type="hidden" name="status" value="delivered">
                                                        <button type="submit" class="btn btn-sm btn-success text-white" title="Thibitisha Umefika"><i class="bi bi-check2-all me-1"></i> Imefika</button>
                                                    @endif
                                                </form>
                                            @else
                                                <span class="text-success small fw-bold"><i class="bi bi-check2-circle"></i> Imekamilika</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="bi bi-box-seam display-6 d-block mb-2"></i>
                                            Hakuna oda za usafirishaji kwa sasa. Wakati wa mauzo kwenye POS, weka anwani ya mteja kuanzisha delivery.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($deliveries->hasPages())
                        <div class="mt-3">
                            {{ $deliveries->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Registered Riders & Bodaboda -->
            <div class="col-lg-4">
                <div class="content-card mt-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-people me-2"></i>Madereva (Riders)</h5>
                        <span class="badge bg-secondary">{{ count($riders) }}</span>
                    </div>

                    <div class="list-group list-group-flush">
                        @forelse($riders as $rider)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                                <div>
                                    <div class="fw-bold">{{ $rider->name }}</div>
                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $rider->phone }}</small>
                                    @if($rider->vehicle_no)
                                        <span class="badge bg-light text-dark border ms-1">{{ $rider->vehicle_no }}</span>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $rider->vehicle_type === 'motorcycle' ? 'bg-danger' : ($rider->vehicle_type === 'bajaj' ? 'bg-warning text-dark' : 'bg-primary') }}" style="font-size: 0.7rem;">
                                        {{ ucfirst($rider->vehicle_type) }}
                                    </span>
                                    <br>
                                    <span class="badge bg-success-subtle text-success small mt-1">Huru (Available)</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3 text-muted">
                                <small>Hakuna madereva waliosajiliwa bado.</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: Register Rider -->
    <div class="modal-overlay" id="riderModal">
        <div class="modal-box">
            <div class="modal-header-custom">
                <h3><i class="bi bi-person-plus text-primary me-2"></i>Sajili Dereva / Rider Mpya</h3>
                <button type="button" class="btn-close" id="closeRiderModal"></button>
            </div>
            <form action="{{ route('manager.deliveries.rider.store') }}" method="POST">
                @csrf
                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label class="form-label-custom">Jina Kamili la Dereva *</label>
                        <input type="text" name="name" class="form-control-custom" placeholder="Mfano: Kassim Mussa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Namba ya Simu *</label>
                        <input type="text" name="phone" class="form-control-custom" placeholder="Mfano: +255 712 345 678" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-custom">Aina ya Chombo *</label>
                            <select name="vehicle_type" class="form-control-custom" required>
                                <option value="motorcycle">Bodaboda (Pikipiki)</option>
                                <option value="bajaj">Bajaj (Tuk-tuk)</option>
                                <option value="van">Gari ya Mzigo / Pick-up</option>
                                <option value="bicycle">Baiskeli</option>
                                <option value="foot">Miguu (Foot)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Namba ya Usajili (Plate No)</label>
                            <input type="text" name="vehicle_no" class="form-control-custom" placeholder="Mfano: MC 123 ABC">
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-outline-custom" id="cancelRiderModal">Ghairi</button>
                    <button type="submit" class="btn-dark-custom"><i class="bi bi-check2-circle"></i> Hifadhi Dereva</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#btnOpenRiderModal').on('click', function() {
                $('#riderModal').addClass('show');
            });
            $('#closeRiderModal, #cancelRiderModal').on('click', function() {
                $('#riderModal').removeClass('show');
            });
            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    $('.modal-overlay').removeClass('show');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
