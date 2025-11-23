@extends('dashboard.layouts.master')
@section('title', 'Services')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">Services</h4>
                    <p class="mb-0 text-muted">Manage the offerings available to clients and freelancers.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search services"
                                value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->has('search'))
                            <a href="{{ route('dashboard.services.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    @can('Create Service')
                        <a href="{{ route('dashboard.services.create') }}" class="btn btn-primary px-3">
                            <i class="ti ti-plus me-1"></i>
                            New Service
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $canUpdateService = Gate::allows('Update Service');
                        $canDeleteService = Gate::allows('Delete Service');
                    @endphp
                    @forelse ($services as $service)
                        <tr>
                            <td>
                                @if ($service->icon)
                                    <img src="{{ asset('uploads/' . $service->icon) }}" alt="{{ $service->name }}"
                                        style="width: 50px; height: 50px; object-fit: contain; border-radius: 4px;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dashboard.services.show', $service) }}"
                                    class="fw-semibold text-decoration-none">
                                    {{ $service->name }}
                                </a>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $service->status === 'active' ? 'bg-label-success' : 'bg-label-secondary' }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td>{{ Str::limit($service->description, 80) }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    @if($canUpdateService)
                                        <a href="{{ route('dashboard.services.edit', $service) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                    @endif
                                    @if($canDeleteService)
                                        <form method="POST" action="{{ route('dashboard.services.destroy', $service) }}"
                                            onsubmit="return confirm('Delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No services yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $services->links() }}
        </div>
    </div>
@endsection
