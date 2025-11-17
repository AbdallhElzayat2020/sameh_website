@extends('dashboard.layouts.master')
@section('title', 'Task Details')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <a href="{{ route('dashboard.tasks.index') }}" class="btn btn-link p-0">
            <i class="ti ti-arrow-left"></i> Back to list
        </a>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard.tasks.edit', $task) }}" class="btn btn-primary">
                <i class="ti ti-edit me-1"></i>
                Edit
            </a>
            <form method="POST" action="{{ route('dashboard.tasks.destroy', $task) }}"
                onsubmit="return confirm('Are you sure you want to delete this task?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="ti ti-trash me-1"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="taskTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">
                        Task Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button"
                        role="tab" aria-controls="files" aria-selected="false">
                        Files History
                        <span class="badge bg-label-secondary ms-2">{{ $task->media->count() }}</span>
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="taskTabsContent">
                <!-- Task Details Tab -->
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">Task Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Task Number</small>
                                    <span class="fw-semibold">{{ $task->task_number }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Client Code</small>
                                    @php
                                        $client = \App\Models\Client::where('client_code', $task->client_code)->first();
                                        $freelancer = \App\Models\Freelancer::where('freelancer_code', $task->client_code)->first();
                                    @endphp
                                    @if ($client)
                                        <a href="{{ route('dashboard.clients.show', $client) }}"
                                            class="fw-semibold text-decoration-none">
                                            {{ $task->client_code }}
                                        </a>
                                    @elseif ($freelancer)
                                        <a href="{{ route('dashboard.freelancers.show', $freelancer) }}"
                                            class="fw-semibold text-decoration-none">
                                            {{ $task->client_code }}
                                        </a>
                                    @else
                                        <span class="fw-semibold">{{ $task->client_code }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Reference Number</small>
                                    <span class="fw-semibold">{{ $task->reference_number ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Status</small>
                                    @php
                                        $statusLabels = [
                                            'pending' => ['label' => 'Pending', 'class' => 'bg-label-warning'],
                                            'in_progress' => ['label' => 'In Progress', 'class' => 'bg-label-info'],
                                            'completed' => ['label' => 'Completed', 'class' => 'bg-label-success'],
                                        ];
                                        $status = $statusLabels[$task->status] ?? ['label' => $task->status, 'class' => 'bg-label-secondary'];
                                    @endphp
                                    <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Page Numbers</small>
                                    <span class="fw-semibold">{{ $task->page_numbers ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Words Count</small>
                                    <span class="fw-semibold">{{ $task->words_count ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Start Date & Time</small>
                                    <span class="fw-semibold">
                                        {{ $task->start_date->format('Y-m-d') }} {{ $task->start_time }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">End Date & Time</small>
                                    <span class="fw-semibold">
                                        {{ $task->end_date->format('Y-m-d') }} {{ $task->end_time }}
                                    </span>
                                </div>
                                @if ($task->language_pair && count($task->language_pair) > 0)
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-2">Language Pairs</small>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($task->language_pair as $pair)
                                                <span class="badge bg-label-primary">
                                                    {{ strtoupper($pair['source'] ?? '') }} →
                                                    {{ strtoupper($pair['target'] ?? '') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if ($task->services->isNotEmpty())
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-2">Services</small>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($task->services as $service)
                                                <span class="badge bg-label-primary">
                                                    {{ $service->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if ($task->notes)
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-2">Notes</small>
                                        <p class="mb-0">{{ $task->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($task->freelancers->isNotEmpty())
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Freelancers Working on This Task</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    @foreach ($task->freelancers as $freelancer)
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h5 class="mb-1">
                                                                <a href="{{ route('dashboard.freelancers.show', $freelancer) }}"
                                                                    class="text-decoration-none">
                                                                    {{ $freelancer->name }}
                                                                </a>
                                                            </h5>
                                                            <small class="text-muted">Code:
                                                                {{ $freelancer->freelancer_code }}</small>
                                                        </div>
                                                        <a href="{{ route('dashboard.freelancers.show', $freelancer) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Email</small>
                                                            <span class="fw-semibold">{{ $freelancer->email }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Phone</small>
                                                            <span class="fw-semibold">{{ $freelancer->phone }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Quota</small>
                                                            <span class="fw-semibold">{{ $freelancer->quota }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Rate / Hour</small>
                                                            <span class="fw-semibold">{{ $freelancer->price_hr }}
                                                                {{ $freelancer->currency }}</span>
                                                        </div>
                                                        @if ($freelancer->language_pair && count($freelancer->language_pair) > 0)
                                                            <div class="col-12 mt-2">
                                                                <small class="text-muted d-block mb-1">Language Pairs</small>
                                                                <div class="d-flex flex-wrap gap-1">
                                                                    @foreach ($freelancer->language_pair as $pair)
                                                                        <span class="badge bg-label-secondary small">
                                                                            {{ strtoupper($pair['source'] ?? '') }} →
                                                                            {{ strtoupper($pair['target'] ?? '') }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Files History Tab -->
                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Files History</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFileModal">
                                <i class="ti ti-plus me-1"></i>
                                Add File
                            </button>
                        </div>
                        <div class="card-body">
                            @if ($task->media->isEmpty())
                                <p class="text-muted mb-0">No files attached.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Date</th>
                                                <th>Updated</th>
                                                <th>Note</th>
                                                <th>Status</th>
                                                <th class="text-end">Files</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($task->media->sortByDesc('created_at') as $media)
                                                <tr>
                                                    <td class="fw-semibold">{{ $media->original_name }}</td>
                                                    <td>
                                                        <small class="text-muted">
                                                            {{ $media->created_at->format('d/m/Y h:i A') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        @if ($media->updated_at->ne($media->created_at))
                                                            <small class="text-muted">
                                                                {{ $media->updated_at->format('d/m/Y h:i A') }}
                                                            </small>
                                                        @else
                                                            <small class="text-muted">-</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            {{ $media->note ? Str::limit($media->note, 80) : '-' }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        @if ($media->file_status)
                                                            <span
                                                                class="badge {{ $media->file_status === 'DTP' ? 'bg-label-success' : 'bg-label-warning' }}">
                                                                {{ $media->file_status }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-label-secondary">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-inline-flex gap-2">
                                                            <a href="{{ route('dashboard.tasks.attachments.download', [$task, $media]) }}"
                                                                class="btn btn-sm btn-outline-primary" title="Download">
                                                                <i class="ti ti-download"></i>
                                                            </a>
                                                            <form method="POST" class="m-0 d-inline"
                                                                action="{{ route('dashboard.tasks.attachments.destroy', [$task, $media]) }}"
                                                                onsubmit="return confirm('Delete this file?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    title="Delete">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Task Summary</h4>
                </div>
                <div class="card-body">
                    <small class="text-muted d-block">Created By</small>
                    <p class="fw-semibold mb-3">{{ $task->creator->name ?? '-' }}</p>

                    @if ($task->closer)
                        <small class="text-muted d-block">Closed By</small>
                        <p class="fw-semibold mb-3">{{ $task->closer->name }}</p>
                    @endif

                    <small class="text-muted d-block">Created At</small>
                    <p class="fw-semibold mb-3">{{ $task->created_at->format('d/m/Y h:i A') }}</p>

                    <small class="text-muted d-block">Updated At</small>
                    <p class="fw-semibold mb-3">{{ $task->updated_at->format('d/m/Y h:i A') }}</p>

                    <small class="text-muted d-block">Total Files</small>
                    <p class="fw-semibold mb-3">{{ $task->media->count() }}</p>

                    <small class="text-muted d-block">Total Freelancers</small>
                    <p class="fw-semibold mb-3">{{ $task->freelancers->count() }}</p>

                    <small class="text-muted d-block">Total Services</small>
                    <p class="fw-semibold">{{ $task->services->count() }}</p>
                </div>
            </div>

            @if ($task->services->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Services Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($task->services as $service)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $service->name }}</h6>
                                            @if ($service->description)
                                                <p class="mb-0 text-muted small">{{ Str::limit($service->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <span class="badge {{ $service->status === 'active' ? 'bg-label-success' : 'bg-label-secondary' }}">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

<!-- Add File Modal -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel">Add a new Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('dashboard.tasks.attachments.store', $task) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="file_name" class="form-label">File Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="file_name" name="file_name"
                            value="{{ old('file_name') }}" placeholder="Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="file_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="file_status" name="file_status" required>
                            <option value="">Status</option>
                            <option value="DTP" {{ old('file_status') === 'DTP' ? 'selected' : '' }}>DTP</option>
                            <option value="Update" {{ old('file_status') === 'Update' ? 'selected' : '' }}>Update</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3"
                            placeholder="Enter text here">{{ old('note') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">Upload the Files <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple
                                required>
                            <button class="btn btn-primary" type="button"
                                onclick="document.getElementById('attachments').click()">
                                <i class="ti ti-upload"></i>
                            </button>
                        </div>
                        <small class="text-muted">Select one or more files to upload (max 20MB each).</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
