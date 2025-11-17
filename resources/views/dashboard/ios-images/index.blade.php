@extends('dashboard.layouts.master')
@section('title', 'iOS Images')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">iOS Images</h4>
                    <p class="mb-0 text-muted">Manage the gallery shown inside the iOS section.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search by title"
                                value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->has('search'))
                            <a href="{{ route('dashboard.ios-images.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    <a href="{{ route('dashboard.ios-images.create') }}" class="btn btn-primary px-3">
                        <i class="ti ti-plus me-1"></i>
                        New Image
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Uploaded</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($images as $image)
                        <tr>
                            <td>
                                <img src="{{ asset('uploads/' . $image->img_path) }}" alt="{{ $image->title }}" class="rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td class="fw-semibold">{{ $image->title }}</td>
                            <td>{{ $image->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('dashboard.ios-images.edit', $image) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.ios-images.destroy', $image) }}"
                                        onsubmit="return confirm('Delete this image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No images yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $images->links() }}
        </div>
    </div>
@endsection
