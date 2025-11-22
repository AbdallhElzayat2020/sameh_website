@extends('dashboard.layouts.master')
@section('title', 'Service Details')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            @if ($service->icon)
                                <img src="{{ asset('uploads/' . $service->icon) }}" alt="{{ $service->name }}"
                                    style="width: 48px; height: 48px; object-fit: contain;">
                            @endif
                            <h4 class="mb-0">{{ $service->name }}</h4>
                        </div>
                        <span class="badge {{ $service->status === 'active' ? 'bg-label-success' : 'bg-label-secondary' }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.services.edit', $service) }}" class="btn btn-outline-primary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('dashboard.services.index') }}" class="btn btn-light">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($service->icon)
                        <div class="mb-4">
                            <p class="text-muted mb-2">Icon</p>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('uploads/' . $service->icon) }}" alt="{{ $service->name }}"
                                    class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                <div>
                                    <small class="text-muted d-block">File: {{ basename($service->icon) }}</small>
                                    <small class="text-muted">Path: {{ $service->icon }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div>
                        <p class="text-muted mb-1">Description</p>
                        <p>{{ $service->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0">
                    <h5 class="mb-0">Metadata</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Created at</span>
                        <span class="fw-semibold">{{ $service->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last update</span>
                        <span class="fw-semibold">{{ $service->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
