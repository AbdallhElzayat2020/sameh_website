@extends('dashboard.layouts.master')
@section('title', 'Create Task')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <h4 class="mb-1">Create Task</h4>
            <p class="mb-0 text-muted">Add a new task with files.</p>
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

            <form method="POST" action="{{ route('dashboard.tasks.store') }}" enctype="multipart/form-data">
                @csrf
                @include('dashboard.tasks.partials.form')
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('dashboard.tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
@endsection
