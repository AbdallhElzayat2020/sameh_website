@extends('dashboard.layouts.master')
@section('title', 'Edit Client')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Client</h4>
            <a href="{{ route('dashboard.clients.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.clients.update', $client) }}">
                @csrf
                @method('PUT')
                @include('dashboard.clients.partials.form', ['client' => $client])
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
