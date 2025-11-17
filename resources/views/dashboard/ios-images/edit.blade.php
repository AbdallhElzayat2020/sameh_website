@extends('dashboard.layouts.master')
@section('title', 'Edit iOS Image')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Image</h4>
            <a href="{{ route('dashboard.ios-images.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.ios-images.update', $iosImage) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('dashboard.ios-images.partials.form', ['iosImage' => $iosImage])
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
