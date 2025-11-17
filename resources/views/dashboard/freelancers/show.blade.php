@extends('dashboard.layouts.master')
@section('title', 'Freelancer Details')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $freelancer->name }}</h4>
                        <small class="text-muted">Code: {{ $freelancer->freelancer_code }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.freelancers.edit', $freelancer) }}" class="btn btn-outline-primary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('dashboard.freelancers.index') }}" class="btn btn-light">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <p class="fw-semibold">{{ $freelancer->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Phone</p>
                            <p class="fw-semibold">{{ $freelancer->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Quota</p>
                            <p class="fw-semibold">{{ $freelancer->quota }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Rate / hour</p>
                            <p class="fw-semibold">{{ $freelancer->price_hr }} {{ $freelancer->currency }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5>Language pairs</h5>
                        <div class="list-group">
                            @forelse ($freelancer->language_pair ?? [] as $pair)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">{{ $pair['source'] ?? '' }} → {{ $pair['target'] ?? '' }}</span>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">No languages provided.</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5>Services</h5>
                        <div class="list-group">
                            @forelse ($freelancer->services as $service)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold">{{ $service->name }}</span>
                                        <small class="text-muted d-block">{{ Str::limit($service->description, 80) }}</small>
                                    </div>
                                    <span
                                        class="badge {{ $service->status === 'active' ? 'bg-label-success' : 'bg-label-secondary' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">No services assigned.</div>
                            @endforelse
                        </div>
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
                        <span class="fw-semibold">{{ $freelancer->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last update</span>
                        <span class="fw-semibold">{{ $freelancer->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Attachments</h5>
                </div>
                <div class="card-body">
                    @if ($freelancer->media->isEmpty())
                        <p class="text-muted mb-0">No attachments uploaded.</p>
                    @else
                        <div class="list-group">
                            @foreach ($freelancer->media as $media)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold d-block">{{ $media->original_name }}</span>
                                        <small class="text-muted">{{ strtoupper($media->type) }} •
                                            {{ number_format($media->size / 1024, 1) }} KB</small>
                                    </div>
                                    <a class="btn btn-sm btn-outline-primary"
                                        href="{{ route('dashboard.freelancers.attachments.download', [$freelancer, $media]) }}">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
