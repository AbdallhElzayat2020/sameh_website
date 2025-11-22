@extends('dashboard.layouts.master')
@section('title', 'Industry Details')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">{{ $industry->name }}</h4>
                    <p class="mb-0 text-muted">Industry details and options.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.industries.edit', $industry) }}" class="btn btn-primary">
                        <i class="ti ti-edit me-1"></i>
                        Edit
                    </a>
                    <a href="{{ route('dashboard.industries.index') }}" class="btn btn-outline-secondary">
                        Back
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @if ($industry->media)
                    <div class="col-12">
                        <h5 class="mb-3">Image</h5>
                        <img src="{{ asset('uploads/' . $industry->media->path) }}" alt="{{ $industry->name }}"
                            class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                @endif
                <div class="col-12">
                    <h5 class="mb-3">Description</h5>
                    <div class="text-muted">{!! $industry->description !!}</div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <small class="text-muted">
                Created: {{ $industry->created_at->format('M d, Y H:i') }} |
                Updated: {{ $industry->updated_at->format('M d, Y H:i') }}
            </small>
        </div>
    </div>
@endsection
