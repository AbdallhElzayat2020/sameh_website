@extends('dashboard.layouts.master')
@section('title', 'Client Purchase Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Client Purchase Orders</h4>
            <small class="text-muted">Task #{{ $task->task_number }}</small>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard.tasks.show', $task) }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back to Task
            </a>
            <a href="{{ route('dashboard.tasks.client-pos.create', $task) }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Create PO
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($clientPos->isEmpty())
                <p class="text-muted mb-0">No client purchase orders have been added for this task yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Task Code</th>
                                <th>Client Code</th>
                                <th>Date 20%</th>
                                <th>Date 80%</th>
                                <th>Start Date</th>
                                <th>Payment Date</th>
                                <th class="text-end">P.O</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientPos as $po)
                                <tr>
                                    <td>{{ $po->task_code }}</td>
                                    <td>{{ $po->client_code }}</td>
                                    <td>{{ optional($po->date_20)->format('d/m/Y') }}</td>
                                    <td>{{ optional($po->date_80)->format('d/m/Y') }}</td>
                                    <td>{{ optional($po->task?->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ optional($po->task?->end_date)->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        @if ($po->media)
                                            <a href="{{ route('dashboard.tasks.client-pos.download', [$task, $po]) }}"
                                                class="btn btn-icon btn-sm btn-outline-primary" title="Download PO">
                                                <i class="ti ti-file-download"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-icon btn-sm btn-outline-secondary" disabled
                                                title="No file uploaded">
                                                <i class="ti ti-file-off"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $clientPos->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

