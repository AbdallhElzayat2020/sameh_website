@extends('dashboard.layouts.master')
@section('title', 'Freelancers')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">Freelancers</h4>
                    <p class="mb-0 text-muted">Manage your talent pool, rates, and language pairs.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search freelancers"
                                value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->has('search'))
                            <a href="{{ route('dashboard.freelancers.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    @can('Create Freelancer')
                        <a href="{{ route('dashboard.freelancers.create') }}" class="btn btn-primary px-3">
                            <i class="ti ti-plus me-1"></i>
                            New Freelancer
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Primary language pair</th>
                        <th>Rate /hr</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $canUpdateFreelancer = Gate::allows('Update Freelancer');
                        $canDeleteFreelancer = Gate::allows('Delete Freelancer');
                    @endphp
                    @forelse ($freelancers as $freelancer)
                        <tr>
                            <td class="fw-semibold">
                                <a href="{{ route('dashboard.freelancers.show', $freelancer) }}" class="text-decoration-none">
                                    {{ $freelancer->freelancer_code }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.freelancers.show', $freelancer) }}"
                                    class="fw-semibold text-decoration-none">
                                    {{ $freelancer->name }}
                                </a>
                            </td>
                            <td>{{ $freelancer->email }}</td>
                            <td>{{ $freelancer->phone }}</td>
                            <td>
                                @if (!empty($freelancer->language_pair))
                                    {{ $freelancer->language_pair[0]['source'] ?? '' }} →
                                    {{ $freelancer->language_pair[0]['target'] ?? '' }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $freelancer->price_hr }} {{ $freelancer->currency }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    @if($canUpdateFreelancer)
                                        <a href="{{ route('dashboard.freelancers.edit', $freelancer) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                    @endif
                                    @if($canDeleteFreelancer)
                                        <form method="POST" action="{{ route('dashboard.freelancers.destroy', $freelancer) }}"
                                            onsubmit="return confirm('Delete this freelancer?');">
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
                            <td colspan="7" class="text-center text-muted py-4">No freelancers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $freelancers->links() }}
        </div>
    </div>
@endsection
