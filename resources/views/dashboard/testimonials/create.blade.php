@extends('dashboard.layouts.master')
@section('title', 'New Testimonial')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add Testimonial</h4>
            <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-link">Back to list</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.testimonials.store') }}">
                @csrf
                @include('dashboard.testimonials.partials.form')
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
