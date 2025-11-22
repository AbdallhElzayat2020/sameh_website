@extends('dashboard.layouts.master')
@section('title', 'Edit Service')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Service</h4>
            <a href="{{ route('dashboard.services.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.services.update', $service) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('dashboard.services.partials.form', ['service' => $service])
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
