@extends('dashboard.layouts.master')
@section('title', 'New Freelancer')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add Freelancer</h4>
            <a href="{{ route('dashboard.freelancers.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('dashboard.freelancers.store') }}" enctype="multipart/form-data">
                @csrf
                @include('dashboard.freelancers.partials.form', ['services' => $services])
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
