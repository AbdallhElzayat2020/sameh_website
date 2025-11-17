@extends('dashboard.layouts.master')
@section('title', 'Clients')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-1">
                <div>
                    <h4 class="mb-1">Clients</h4>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <form method="GET" class="d-flex align-items-center gap-1">
                        <div class="input-group input-group-merge" style="min-width: 260px;">
                            <span class="input-group-text">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="Search clients"
                                value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                        @if (request()->has('search'))
                            <a href="{{ route('dashboard.clients.index') }}" class="btn btn-link">Reset</a>
                        @endif
                    </form>
                    <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary px-3">
                        <i class="ti ti-plus me-1"></i>
                        New Client
                    </a>
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
                        <th>Agency</th>
                        <th>Currency</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td class="fw-semibold">
                                <a href="{{ route('dashboard.clients.show', $client) }}" class="text-decoration-none">
                                    {{ $client->client_code }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.clients.show', $client) }}"
                                    class="fw-semibold text-decoration-none">
                                    {{ $client->name }}
                                </a>
                            </td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->agency ?? '-' }}</td>
                            <td>{{ $client->currency ?? '-' }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('dashboard.clients.edit', $client) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.clients.destroy', $client) }}"
                                        onsubmit="return confirm('Delete this client?');">
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
                            <td colspan="7" class="text-center text-muted py-4">No clients yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $clients->links() }}
        </div>
    </div>
@endsection
