<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Activity Monitor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛡️</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Inter', sans-serif;
            color: #4b5563;
        }
        
        /* Sidebar Filter Styling */
        .filter-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        /* Stats Cards Styling */
        .stat-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 1.25rem;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Table Styling */
        .main-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1.5rem;
        }
        .table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .badge-soft-success { background-color: #dcfce7; color: #166534; }
        .badge-soft-primary { background-color: #dbeafe; color: #1e40af; }
        .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            background-color: #6366f1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom py-3 sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="#">
                <div class="bg-primary text-white rounded p-1 me-2 d-flex align-items-center justify-content-center" style="width:30px; height:30px;">
                    <i class="fas fa-wave-square" style="font-size: 14px;"></i>
                </div>
                Activity<span class="text-primary">Log</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <div class="row">
            
            <div class="col-lg-3 mb-4">
                <div class="filter-card p-4 sticky-top" style="top: 100px; z-index: 1;">
                    <h5 class="fw-bold mb-4">Filters</h5>
                    
                    <form action="{{ route('activity.logs') }}" method="GET">
                        
                        <div class="mb-4">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="User, description..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Date Range</label>
                            <div class="d-flex flex-wrap gap-2">
                                <input type="radio" class="btn-check" name="date_range" id="all" value="" {{ request('date_range') == '' ? 'checked' : '' }}>
                                <label class="btn btn-sm btn-outline-light text-dark border" for="all">All Time</label>

                                <input type="radio" class="btn-check" name="date_range" id="today" value="today" {{ request('date_range') == 'today' ? 'checked' : '' }}>
                                <label class="btn btn-sm btn-outline-light text-dark border" for="today">Today</label>

                                <input type="radio" class="btn-check" name="date_range" id="7days" value="7days" {{ request('date_range') == '7days' ? 'checked' : '' }}>
                                <label class="btn btn-sm btn-outline-light text-dark border" for="7days">7 Days</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-xs fw-bold text-uppercase text-muted">Event Types</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="actions[]" value="CREATE" id="chkCreate" 
                                    {{ in_array('CREATE', request('actions', [])) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex align-items-center" for="chkCreate">
                                    <span class="badge badge-soft-success rounded-circle p-1 me-2" style="width:10px; height:10px;"> </span>
                                    Created
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="actions[]" value="UPDATE" id="chkUpdate"
                                    {{ in_array('UPDATE', request('actions', [])) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex align-items-center" for="chkUpdate">
                                    <span class="badge badge-soft-primary rounded-circle p-1 me-2" style="width:10px; height:10px;"> </span>
                                    Updated
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="actions[]" value="DELETE" id="chkDelete"
                                    {{ in_array('DELETE', request('actions', [])) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex align-items-center" for="chkDelete">
                                    <span class="badge badge-soft-danger rounded-circle p-1 me-2" style="width:10px; height:10px;"> </span>
                                    Deleted
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            @if(request()->has('search') || request()->has('actions') || request()->has('date_range'))
                                <a href="{{ route('activity.logs') }}" class="btn btn-light text-muted">Clear All</a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card d-flex align-items-center">
                            <div class="icon-box bg-light text-primary me-3">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs text-uppercase fw-bold mb-0">Total Activities</h6>
                                <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card d-flex align-items-center">
                            <div class="icon-box bg-light text-success me-3">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs text-uppercase fw-bold mb-0">Today</h6>
                                <h4 class="fw-bold mb-0">{{ $stats['today'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card d-flex align-items-center">
                            <div class="icon-box bg-light text-info me-3">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs text-uppercase fw-bold mb-0">Created</h6>
                                <h4 class="fw-bold mb-0">{{ $stats['create'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card d-flex align-items-center">
                            <div class="icon-box bg-light text-warning me-3">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs text-uppercase fw-bold mb-0">Updated</h6>
                                <h4 class="fw-bold mb-0">{{ $stats['update'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Activity Log <span class="text-muted fw-normal text-sm ms-2">{{ $logs->total() }} activities found</span></h5>
                    
                    <div class="text-muted text-sm">
                        Page {{ $logs->currentPage() }} of {{ $logs->lastPage() }}
                    </div>
                </div>

                <div class="main-card shadow-sm">
                    @if($logs->isEmpty())
                        <div class="text-center p-5">
                            <div class="mb-3 text-muted opacity-50">
                                <i class="fas fa-search fa-3x"></i>
                            </div>
                            <h5>No activities found</h5>
                            <p class="text-muted">Try adjusting your filters or search query.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Event</th>
                                        <th>Description</th>
                                        <th>Subject/Target</th>
                                        <th>User</th>
                                        <th class="text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            @if($log->action == 'CREATE')
                                                <span class="badge badge-soft-success rounded-pill px-3 py-2 border border-success border-opacity-25">
                                                    <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i> Created
                                                </span>
                                            @elseif($log->action == 'UPDATE')
                                                <span class="badge badge-soft-primary rounded-pill px-3 py-2 border border-primary border-opacity-25">
                                                    <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i> Updated
                                                </span>
                                            @elseif($log->action == 'DELETE')
                                                <span class="badge badge-soft-danger rounded-pill px-3 py-2 border border-danger border-opacity-25">
                                                    <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i> Deleted
                                                </span>
                                            @endif
                                        </td>

                                        <td class="fw-bold text-dark">
                                            {{ $log->description }}
                                        </td>

                                        <td class="text-muted text-sm">
                                            @if(str_contains($log->description, 'Pet'))
                                                <i class="fas fa-paw me-1"></i> Pet Data
                                            @elseif(str_contains($log->description, 'Appointment'))
                                                <i class="fas fa-calendar-check me-1"></i> Appointment
                                            @else
                                                <i class="fas fa-database me-1"></i> System Data
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $initial = strtoupper(substr($log->user->name ?? '?', 0, 1));
                                                    // Array warna avatar
                                                    $colors = ['#6366f1', '#ec4899', '#10b981', '#f59e0b'];
                                                    $bg = $colors[rand(0, 3)];
                                                @endphp
                                                <div class="user-avatar me-2" style="background-color: {{ $bg }}">
                                                    {{ $initial }}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-xs text-dark">{{ $log->user->name ?? 'System' }}</span>
                                                    <span class="text-muted text-xs" style="font-size: 10px;">{{ $log->user->role ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex flex-column align-items-end">
                                                <span class="fw-bold text-dark text-sm">{{ $log->created_at->format('d/m/Y') }}</span>
                                                <span class="text-muted text-xs">{{ $log->created_at->format('H:i') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light">
                            <span class="text-muted text-sm">Showing data {{ $logs->firstItem() }} to {{ $logs->lastItem() }}</span>
                            {{ $logs->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>