@extends('dashboard.layouts.master')
@section('title', 'Tasks')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">Tasks</h4>
                    <p class="mb-0 text-muted">Manage tasks and their files.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search tasks"
                                value="{{ request('search') }}">
                        </div>
                        <select name="status" class="form-select" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->hasAny(['search', 'status']))
                            <a href="{{ route('dashboard.tasks.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    <a href="{{ route('dashboard.tasks.create') }}" class="btn btn-primary px-3">
                        <i class="ti ti-plus me-1"></i>
                        New Task
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Task Number</th>
                        <th>Client Code</th>
                        <th>Freelancers</th>
                        <th>Reference Number</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Created By</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td class="fw-semibold">{{ $task->task_number }}</td>
                            <td>
                                @php
                                    $client = \App\Models\Client::where('client_code', $task->client_code)->first();
                                    $freelancer = \App\Models\Freelancer::where(
                                        'freelancer_code',
                                        $task->client_code,
                                    )->first();
                                @endphp
                                @if ($client)
                                    <a href="{{ route('dashboard.clients.show', $client) }}" class="text-decoration-none">
                                        {{ $task->client_code }}
                                    </a>
                                @elseif ($freelancer)
                                    <a href="{{ route('dashboard.freelancers.show', $freelancer) }}"
                                        class="text-decoration-none">
                                        {{ $task->client_code }}
                                    </a>
                                @else
                                    {{ $task->client_code }}
                                @endif
                            </td>
                            <td>
                                @if ($task->freelancers->isNotEmpty())
                                    @foreach ($task->freelancers as $freelancer)
                                        <a href="{{ route('dashboard.freelancers.show', $freelancer) }}"
                                            class="text-decoration-none d-block">
                                            {{ $freelancer->freelancer_code }}
                                        </a>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($task->referencedTask)
                                    <a href="{{ route('dashboard.tasks.show', $task->referencedTask) }}"
                                        class="text-decoration-none">
                                        {{ $task->referencedTask->task_number }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'pending' => ['label' => 'Pending', 'class' => 'bg-label-warning'],
                                        'in_progress' => ['label' => 'In Progress', 'class' => 'bg-label-info'],
                                        'completed' => ['label' => 'Completed', 'class' => 'bg-label-success'],
                                    ];
                                    $status = $statusLabels[$task->status] ?? [
                                        'label' => $task->status,
                                        'class' => 'bg-label-secondary',
                                    ];
                                @endphp
                                <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                            </td>
                            <td>{{ $task->start_date->format('Y-m-d') }}</td>
                            <td>{{ $task->end_date->format('Y-m-d') }}</td>
                            <td>{{ $task->creator->name ?? '-' }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('dashboard.tasks.show', $task) }}"
                                        class="btn btn-sm btn-outline-info" title="View Details">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.tasks.edit', $task) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.tasks.destroy', $task) }}"
                                        onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No tasks yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
