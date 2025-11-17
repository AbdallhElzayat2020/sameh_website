@extends('dashboard.layouts.master')
@section('title', 'Edit Freelancer')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Freelancer</h4>
            <a href="{{ route('dashboard.freelancers.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('dashboard.freelancers.update', $freelancer) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('dashboard.freelancers.partials.form', ['freelancer' => $freelancer, 'services' => $services])
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    @if ($freelancer->media->isNotEmpty())
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Existing Attachments</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach ($freelancer->media as $media)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold d-block">{{ $media->original_name }}</span>
                                <small class="text-muted">{{ strtoupper($media->type) }} •
                                    {{ number_format($media->size / 1024, 1) }} KB</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('dashboard.freelancers.attachments.download', [$freelancer, $media]) }}">
                                    Download
                                </a>
                                <form method="POST"
                                    action="{{ route('dashboard.freelancers.attachments.destroy', [$freelancer, $media]) }}"
                                    onsubmit="return confirm('Delete this attachment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
