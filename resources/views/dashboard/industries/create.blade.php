@extends('dashboard.layouts.master')
@section('title', 'Create Industry')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <h4 class="mb-1">Create Industry</h4>
            <p class="mb-0 text-muted">Add a new industry with its options.</p>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dashboard.industries.store') }}" enctype="multipart/form-data">
                @csrf
                @include('dashboard.industries.partials.form')
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('dashboard.industries.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Industry</button>
                </div>
            </form>
        </div>
    </div>
@endsection
