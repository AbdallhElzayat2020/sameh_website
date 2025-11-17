@extends('dashboard.layouts.master')
@section('title', 'Price Requests')

@section('content')
    <div class="card">
        <div class="card-header">

            <!-- العنوان فوق -->
            <h4 class="mb-3">Price Requests</h4>

            <!-- الفلاتر تحت وجنب بعض -->
            <form method="GET" class="row g-2 align-items-center">

                <!-- Search input -->
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Search client, email, project"
                            value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Status select -->
                <div class="col-auto">
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending review</option>
                        <option value="in_progress" @selected(request('status') === 'in_progress')>In progress</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                    </select>
                </div>

                <!-- Apply button -->
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>

            </form>
        </div>


        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Project</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th>Requested at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projectRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->first_name }} {{ $request->last_name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->project_name }}</td>
                            <td>
                                @if ($request->services->isNotEmpty())
                                    <span class="badge bg-label-primary">
                                        {{ $request->services->pluck('name')->take(2)->join(', ') }}
                                    </span>
                                    @if ($request->services->count() > 2)
                                        <small class="text-muted d-block">+{{ $request->services->count() - 2 }}
                                            more</small>
                                    @endif
                                @else
                                    <span class="text-muted">No services selected</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'pending' => 'Pending review',
                                        'in_progress' => 'In progress',
                                        'completed' => 'Completed',
                                    ];
                                    $statusColors = [
                                        'pending' => 'bg-label-warning',
                                        'in_progress' => 'bg-label-info',
                                        'completed' => 'bg-label-success',
                                    ];
                                @endphp
                                <span class="badge {{ $statusColors[$request->status] ?? 'bg-label-secondary' }}">
                                    {{ $statusLabels[$request->status] ?? $request->status }}
                                </span>
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.project-requests.show', $request) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No requests yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $projectRequests->links() }}
        </div>
    </div>
@endsection
