@extends('dashboard.layouts.master')
@section('title', 'Create Vendor PO')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Create Vendor PO</h4>
            <small class="text-muted">Task #{{ $task->task_number }}</small>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard.tasks.vendor-pos.index', $task) }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back to List
            </a>
        </div>
    </div>

    <div class="card">
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

            <form method="POST" action="{{ route('dashboard.tasks.vendor-pos.store', $task) }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="freelancer_code" class="form-label">Vendor Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="freelancer_code" name="freelancer_code"
                            value="{{ old('freelancer_code') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="project_name" class="form-label">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="project_name" name="project_name"
                            value="{{ old('project_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="page_number" class="form-label">Page Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="page_number" name="page_number"
                            value="{{ old('page_number') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="price" name="price"
                            value="{{ old('price') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ old('start_date', $task->start_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date"
                            value="{{ old('payment_date', $task->end_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-12">
                        <label for="service_ids" class="form-label">Services</label>
                        <select id="service_ids" name="service_ids[]" class="form-select select2" multiple>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ collect(old('service_ids', []))->contains($service->id) ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="4" placeholder="Add any remarks">{{ old('note') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label for="po_file" class="form-label">Upload P.O (PDF) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="po_file" name="po_file" accept="application/pdf"
                            required>
                        <small class="text-muted">Maximum file size 20MB.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard.tasks.vendor-pos.index', $task) }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save PO</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/select2/select2.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/dashboard/assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = $('#service_ids');
            if (select.length) {
                select.select2({
                    placeholder: 'Select services',
                    width: '100%'
                });
            }
        });
    </script>
@endpush

