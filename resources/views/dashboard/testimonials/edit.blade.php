@extends('dashboard.layouts.master')
@section('title', 'Edit Testimonial')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Testimonial</h4>
            <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.testimonials.update', $testimonial) }}">
                @csrf
                @method('PUT')
                @include('dashboard.testimonials.partials.form', ['testimonial' => $testimonial])
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
