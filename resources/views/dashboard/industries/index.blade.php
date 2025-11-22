@extends('dashboard.layouts.master')
@section('title', 'Industries')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">Industries</h4>
                    <p class="mb-0 text-muted">Manage industries and their options.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search industries"
                                value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->has('search'))
                            <a href="{{ route('dashboard.industries.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    <a href="{{ route('dashboard.industries.create') }}" class="btn btn-primary px-3">
                        <i class="ti ti-plus me-1"></i>
                        New Industry
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($industries as $industry)
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.industries.show', $industry) }}"
                                    class="fw-semibold text-decoration-none">
                                    {{ $industry->name }}
                                </a>
                            </td>
                            <td>
                                description when you view the industry
                                <a href="{{ route('dashboard.industries.show', $industry) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('dashboard.industries.edit', $industry) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.industries.destroy', $industry) }}"
                                        onsubmit="return confirm('Delete this industry?');">
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
                            <td colspan="3" class="text-center text-muted py-4">No industries yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $industries->links() }}
        </div>
    </div>
@endsection
