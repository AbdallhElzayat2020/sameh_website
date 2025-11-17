@extends('dashboard.layouts.master')
@section('title', 'Contact Message')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $contactMessage->name }}</h4>
                        <small class="text-muted">{{ $contactMessage->email }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="mailto:{{ $contactMessage->email }}" class="btn btn-outline-primary">
                            <i class="ti ti-mail me-1"></i> Reply
                        </a>
                        <a href="{{ route('dashboard.contact-messages.index') }}" class="btn btn-light">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Phone</p>
                            <p class="fw-semibold">{{ $contactMessage->phone ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Subject</p>
                            <p class="fw-semibold">{{ $contactMessage->subject ?? '—' }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-muted mb-1">Message</p>
                        <p>{{ $contactMessage->message }}</p>
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
                        <span class="text-muted">Received at</span>
                        <span class="fw-semibold">{{ $contactMessage->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last update</span>
                        <span class="fw-semibold">{{ $contactMessage->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
