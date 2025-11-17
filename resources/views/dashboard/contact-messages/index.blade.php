@extends('dashboard.layouts.master')
@section('title', 'Contact Messages')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1">Contact Messages</h4>
                    <p class="mb-0 text-muted">View and manage contact submissions from the website.</p>
                </div>
                <form method="GET" class="d-flex align-items-center gap-1">
                    <div class="input-group input-group-merge" style="min-width: 260px;">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" placeholder="Search contacts"
                            value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-outline-primary px-4">Search</button>
                    @if (request()->has('search'))
                        <a href="{{ route('dashboard.contact-messages.index') }}" class="btn btn-link">Reset</a>
                    @endif
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td class="fw-semibold">
                                <a class="text-decoration-none"
                                    href="{{ route('dashboard.contact-messages.show', $message) }}">{{ $message->name }}</a>
                            </td>
                            <td>{{ $message->email }}</td>
                            <td>{{ Str::limit($message->subject, 40) }}</td>
                            <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('dashboard.contact-messages.show', $message) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.contact-messages.destroy', $message) }}"
                                        onsubmit="return confirm('Delete this message?');">
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
                            <td colspan="5" class="text-center text-muted py-4">No contact messages yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $messages->links() }}
        </div>
    </div>
@endsection
