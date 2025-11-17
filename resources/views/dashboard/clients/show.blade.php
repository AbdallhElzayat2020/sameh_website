@extends('dashboard.layouts.master')
@section('title', 'Client Details')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $client->name }}</h4>
                        <small class="text-muted">Client Code: {{ $client->client_code }}</small>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('dashboard.clients.edit', $client) }}" class="btn btn-outline-primary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('dashboard.clients.index') }}" class="btn btn-light">Back to list</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <p class="fw-semibold">{{ $client->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Phone</p>
                            <p class="fw-semibold">{{ $client->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Agency</p>
                            <p class="fw-semibold">{{ $client->agency ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Preferred Currency</p>
                            <p class="fw-semibold">{{ $client->currency ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-header border-0">
                    <h5 class="mb-0">History</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Created by</span>
                        <span class="fw-semibold">
                            {{ $client->creator?->name ?? '—' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Created at</span>
                        <span class="fw-semibold">{{ $client->created_at->format('Y-m-d H:i') }}</span>
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
                        <span class="text-muted">Last update</span>
                        <span class="fw-semibold">{{ $client->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
