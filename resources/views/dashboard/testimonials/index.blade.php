@extends('dashboard.layouts.master')
@section('title', 'Testimonials')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">Testimonials</h4>
                    <p class="mb-0 text-muted">Manage client quotes shown on the website.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search by name"
                                value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->has('search'))
                            <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    <a href="{{ route('dashboard.testimonials.create') }}" class="btn btn-primary px-3">
                        <i class="ti ti-plus me-1"></i>
                        New Testimonial
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $testimonial)
                        <tr>
                            <td class="fw-semibold">{{ $testimonial->name }}</td>
                            <td>
                                <span class="badge bg-label-warning">{{ $testimonial->rate }} / 5</span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $testimonial->status === 'active' ? 'bg-label-success' : 'bg-label-secondary' }}">
                                    {{ ucfirst($testimonial->status) }}
                                </span>
                            </td>
                            <td>{{ Str::limit($testimonial->description, 80) }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('dashboard.testimonials.edit', $testimonial) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.testimonials.destroy', $testimonial) }}"
                                        onsubmit="return confirm('Delete this testimonial?');">
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
                            <td colspan="5" class="text-center text-muted py-4">No testimonials yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $testimonials->links() }}
        </div>
    </div>
@endsection
