@extends('dashboard.layouts.master')
@section('title', 'Price Request Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <a href="{{ route('dashboard.project-requests.index') }}" class="btn btn-link p-0">
            <i class="ti ti-arrow-left"></i> Back to list
        </a>

        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                <i class="ti ti-arrows-transfer-up me-1"></i>
                Update Status
            </button>

            <form method="POST" action="{{ route('dashboard.project-requests.destroy', $projectRequest) }}"
                onsubmit="return confirm('Are you sure you want to delete this request and all attachments?');">
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
            <ul class="nav nav-tabs mb-4" id="projectTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">
                        Project Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button"
                        role="tab" aria-controls="files" aria-selected="false">
                        Files History
                        <span class="badge bg-label-secondary ms-2">{{ $projectRequest->media->count() }}</span>
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="projectTabsContent">
                <!-- Project Details Tab -->
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">Client Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Client</small>
                                    <span class="fw-semibold">{{ $projectRequest->first_name }} {{ $projectRequest->last_name }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Email</small>
                                    <a href="mailto:{{ $projectRequest->email }}">{{ $projectRequest->email }}</a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Source language</small>
                                    <span class="fw-semibold text-uppercase">{{ $projectRequest->source_language }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Target language</small>
                                    <span class="fw-semibold text-uppercase">{{ $projectRequest->target_language }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Preferred payment method</small>
                                    <span class="fw-semibold">{{ $projectRequest->preferred_payment_type }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Currency</small>
                                    <span class="fw-semibold">{{ $projectRequest->currency }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Project Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block">Project name</small>
                                <span class="fw-semibold">{{ $projectRequest->project_name }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Time zone</small>
                                <span class="fw-semibold">{{ $projectRequest->time_zone }}</span>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Kick-off</small>
                                    <span class="fw-semibold">
                                        {{ $projectRequest->start_date?->format('Y-m-d') }} {{ $projectRequest->start_date_time }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Delivery</small>
                                    <span class="fw-semibold">
                                        {{ $projectRequest->end_date?->format('Y-m-d') }} {{ $projectRequest->end_date_time }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-2">Description</small>
                                <p class="mb-0">{{ $projectRequest->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Files History Tab -->
                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Files History</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFileModal">
                                <i class="ti ti-plus me-1"></i>
                                Add Files
                            </button>
                        </div>
                        <div class="card-body">
                            @if ($projectRequest->media->isEmpty())
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
                                            @foreach ($projectRequest->media->sortByDesc('created_at') as $media)
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
                                                            <a href="{{ route('dashboard.project-requests.attachments.download', [$projectRequest, $media]) }}"
                                                                class="btn btn-sm btn-outline-primary" title="Download">
                                                                <i class="ti ti-download"></i>
                                                            </a>
                                                            <form method="POST" class="m-0"
                                                                action="{{ route('dashboard.project-requests.attachments.destroy', [$projectRequest, $media]) }}"
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
            <div class="card">
                <div class="card-body">
                    <small class="text-muted d-block">Current status</small>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        @php
                            $statusLabels = [
                                'pending' => 'Pending review',
                                'in_progress' => 'In progress',
                                'completed' => 'Completed',
                            ];
                        @endphp
                        <span class="badge bg-label-info">{{ $statusLabels[$projectRequest->status] ?? $projectRequest->status }}</span>
                    </div>
                    <small class="text-muted d-block">Requested services</small>
                    <ul class="list-unstyled mt-2 mb-3">
                        @forelse ($projectRequest->services as $service)
                            <li class="d-flex align-items-center gap-2 mb-1">
                                <i class="ti ti-check text-success"></i>
                                <span>{{ $service->name }}</span>
                            </li>
                        @empty
                            <li class="text-muted">No services selected.</li>
                        @endforelse
                    </ul>

                    <small class="text-muted d-block">Created at</small>
                    <p class="fw-semibold">{{ $projectRequest->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
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
            <form method="POST" action="{{ route('dashboard.project-requests.attachments.store', $projectRequest) }}"
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
                            <button class="btn btn-primary" type="button" onclick="document.getElementById('attachments').click()">
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

@push('scripts')
  @include('dashboard.project-requests.update-status')
@endpush

