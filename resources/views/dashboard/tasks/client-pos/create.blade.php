@extends('dashboard.layouts.master')
@section('title', 'Create Client PO')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Create Client PO</h4>
            <small class="text-muted">Task #{{ $task->task_number }}</small>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard.tasks.client-pos.index', $task) }}" class="btn btn-outline-secondary">
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

            <form method="POST" action="{{ route('dashboard.tasks.client-pos.store', $task) }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Task Code</label>
                        <input type="text" class="form-control" value="{{ $task->task_number }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="client_code" class="form-label">Client Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="client_code" name="client_code"
                            value="{{ old('client_code', $task->client_code) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_20" class="form-label">Date 20% <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date_20" name="date_20"
                            value="{{ old('date_20', $task->start_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_80" class="form-label">Date 80% <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date_80" name="date_80"
                            value="{{ old('date_80', $task->end_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="payment_20" class="form-label">Payment 20% <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="payment_20" name="payment_20"
                            value="{{ old('payment_20') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="payment_80" class="form-label">Payment 80% <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="payment_80" name="payment_80"
                            value="{{ old('payment_80') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="total_price" class="form-label">Total Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="total_price" name="total_price"
                            value="{{ old('total_price') }}" required>
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
                    <a href="{{ route('dashboard.tasks.client-pos.index', $task) }}" class="btn btn-outline-secondary">Cancel</a>
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

