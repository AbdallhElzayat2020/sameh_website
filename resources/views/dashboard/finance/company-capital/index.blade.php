@extends('dashboard.layouts.master')
@section('title', 'Finance - Company Capital')

@section('content')
    @include('dashboard.finance.partials.tabs')

    @php
        $capital = $capital ?? null;
        $cards = [
            [
                'label' => 'Total Capital',
                'currency' => 'EGP',
                'value' => $capital?->total_capital_egp ?? '0',
            ],
            [
                'label' => 'Temporary Capital',
                'currency' => 'EGP',
                'value' => $capital?->temporary_capital_egp ?? '0',
            ],
            [
                'label' => 'Emergency Capital',
                'currency' => 'EGP',
                'value' => $capital?->emergency_capital_egp ?? '0',
            ],
            [
                'label' => 'Total Capital',
                'currency' => 'USD',
                'value' => $capital?->total_capital_usd ?? '0',
            ],
            [
                'label' => 'Temporary Capital',
                'currency' => 'USD',
                'value' => $capital?->temporary_capital_usd ?? '0',
            ],
            [
                'label' => 'Emergency Capital',
                'currency' => 'USD',
                'value' => $capital?->emergency_capital_usd ?? '0',
            ],
        ];
    @endphp

    <div class="card shadow-sm border-0 w-100">
        <div class="card-header border-0 bg-transparent pb-0">
            <h4 class="mb-2">Company Capital Overview</h4>
            <p class="text-muted mb-0">All values are displayed with their respective currencies.</p>
        </div>
        <div class="card-body">
            <div class="row g-4 capital-cards">
                @foreach ($cards as $card)
                    <div class="col-md-4">
                        <div class="border rounded-3 p-4 h-100 capital-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold fs-5">{{ $card['label'] }}</span>
                                <span class="text-muted">{{ $card['currency'] }}</span>
                            </div>
                            <div class="mt-3">
                                <span class="display-6 fw-bold">{{ $card['value'] }}</span>
                                <span class="text-muted">{{ $card['currency'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('dashboard.finance.company-capital.edit') }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit Values
                </a>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .capital-card {
            transition: all 0.2s ease-in-out;
            background: rgba(255, 255, 255, 0.02);
        }

        .capital-card:hover {
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 12px 25px rgba(17, 25, 40, 0.25);
            transform: translateY(-4px);
        }
    </style>
@endpush

