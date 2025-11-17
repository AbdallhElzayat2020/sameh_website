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

            <div class="card mb-4">
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

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Attachments</h4>
                    <span class="badge bg-label-secondary">{{ $projectRequest->media->count() }}</span>
                </div>
                <div class="card-body">
                    @if ($projectRequest->media->isEmpty())
                        <p class="text-muted mb-0">No files attached.</p>
                    @else
                        <div class="list-group">
                            @foreach ($projectRequest->media as $media)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold d-block">{{ $media->original_name }}</span>
                                        <small class="text-muted">{{ strtoupper($media->type) }} • {{ number_format($media->size / 1024, 1) }} KB</small>
                                    </div>
                                    <a class="btn btn-sm btn-outline-primary"
                                        href="{{ route('dashboard.project-requests.attachments.download', [$projectRequest, $media]) }}">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
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

@push('scripts')
  @include('dashboard.project-requests.update-status')
@endpush

