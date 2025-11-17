@extends('dashboard.layouts.master')
@section('title', 'Edit Client')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Client</h4>
            <a href="{{ route('dashboard.clients.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.clients.update', $client) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('dashboard.clients.partials.form', ['client' => $client])
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    @if ($client->media->isNotEmpty())
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Existing Attachments</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach ($client->media as $media)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold d-block">{{ $media->original_name }}</span>
                                <small class="text-muted">{{ strtoupper($media->type) }} •
                                    {{ number_format($media->size / 1024, 1) }} KB</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('dashboard.clients.attachments.download', [$client, $media]) }}">
                                    Download
                                </a>
                                <form method="POST" action="{{ route('dashboard.clients.attachments.destroy', [$client, $media]) }}"
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
