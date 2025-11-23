@extends('dashboard.layouts.master')
@section('title', 'Dashboard')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Users Statistics -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-users text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Users</span>
                    <h3 class="card-title mb-2">{{ number_format($totalUsers) }}</h3>
                    <small class="text-primary fw-semibold">
                        <i class="ti ti-user-check"></i> {{ $activeUsers }} Active
                    </small>
                </div>
            </div>
        </div>

        <!-- Tasks Statistics -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-checklist text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Tasks</span>
                    <h3 class="card-title mb-2">{{ number_format($totalTasks) }}</h3>
                    <small class="text-info fw-semibold">
                        <i class="ti ti-clock"></i> {{ $pendingTasks }} Pending, {{ $inProgressTasks }} In Progress
                    </small>
                </div>
            </div>
        </div>

        <!-- Clients Statistics -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-building text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Clients</span>
                    <h3 class="card-title mb-2">{{ number_format($totalClients) }}</h3>
                    <small class="text-success fw-semibold">
                        <i class="ti ti-building"></i> Clients
                    </small>
                </div>
            </div>
        </div>

        <!-- Freelancers Statistics -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-user-star text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Freelancers</span>
                    <h3 class="card-title mb-2">{{ number_format($totalFreelancers) }}</h3>
                    <small class="text-warning fw-semibold">
                        <i class="ti ti-user-star"></i> Freelancers
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="row mb-4">
        <!-- Project Requests -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-file-invoice text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Project Requests</span>
                    <h3 class="card-title mb-2">{{ number_format($totalProjectRequests) }}</h3>
                    <small class="text-warning fw-semibold">
                        <i class="ti ti-clock"></i> {{ $pendingProjectRequests }} Pending
                    </small>
                </div>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-mail text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Contact Messages</span>
                    <h3 class="card-title mb-2">{{ number_format($totalContactMessages) }}</h3>
                    <small class="text-danger fw-semibold">
                        <i class="ti ti-calendar"></i> {{ $recentContactMessages }} This Week
                    </small>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-arrow-down text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Revenue</span>
                    <h3 class="card-title mb-2">${{ number_format($totalRevenue, 2) }}</h3>
                    <small class="text-success fw-semibold">
                        <i class="ti ti-currency-dollar"></i> Revenue
                    </small>
                </div>
            </div>
        </div>

        <!-- Expenses -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-arrow-up text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Expenses</span>
                    <h3 class="card-title mb-2">${{ number_format($totalExpense, 2) }}</h3>
                    <small class="text-danger fw-semibold">
                        <i class="ti ti-currency-dollar"></i> Expenses
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Financial Summary</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Total Revenue:</span>
                                <span class="fw-semibold text-success">${{ number_format($totalRevenue, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Total Expenses:</span>
                                <span class="fw-semibold text-danger">${{ number_format($totalExpense, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Net Profit:</span>
                                <span class="fw-semibold {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                    ${{ number_format($netProfit, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Tasks -->
        <div class="col-lg-6 col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Tasks</h5>
                </div>
                <div class="card-body">
                    @if ($recentTasks->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Task Number</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentTasks as $task)
                                        <tr>
                                            <td>
                                                <a href="{{ route('dashboard.tasks.show', $task) }}"
                                                    class="text-decoration-none">
                                                    {{ $task->task_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $task->created_at->diffForHumans() }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No tasks yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Project Requests -->
        <div class="col-lg-6 col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Project Requests</h5>
                </div>
                <div class="card-body">
                    @if ($recentProjectRequests->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentProjectRequests as $request)
                                        <tr>
                                            <td>
                                                <a href="{{ route('dashboard.project-requests.show', $request) }}"
                                                    class="text-decoration-none">
                                                    {{ Str::limit($request->project_name ?? 'N/A', 30) }}
                                                </a>
                                            </td>
                                            <td>
                                                <small>{{ $request->email }}</small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $request->status === 'pending' ? 'warning' : 'success' }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $request->created_at->diffForHumans() }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No project requests yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{--    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
@endpush
