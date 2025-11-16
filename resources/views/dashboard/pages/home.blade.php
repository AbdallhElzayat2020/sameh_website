@extends('dashboard.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-file-invoice text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Quote Requests</span>
                    <h3 class="card-title mb-2">345345</h3>
                    <small class="text-warning fw-semibold">
                        <i class="ti ti-file"></i> Requests
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="ti ti-briefcase text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Job Applications</span>
                    <h3 class="card-title mb-2">23434</h3>
                    <small class="text-success fw-semibold">
                        <i class="ti ti-user-check"></i> Applications
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{--    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
@endpush
