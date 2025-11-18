@extends('dashboard.layouts.master')
@section('title', 'Edit Company Capital')

@section('content')
    @include('dashboard.finance.partials.tabs')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 bg-transparent pb-0">
                    <h4 class="mb-0">Edit Company Capital</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.finance.company-capital.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="total_capital_egp" class="form-label">Total Capital (EGP)</label>
                                <input type="text"
                                    class="form-control @error('total_capital_egp') is-invalid @enderror"
                                    id="total_capital_egp" name="total_capital_egp"
                                    value="{{ old('total_capital_egp', $capital?->total_capital_egp) }}" required>
                                @error('total_capital_egp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="total_capital_usd" class="form-label">Total Capital (USD)</label>
                                <input type="text"
                                    class="form-control @error('total_capital_usd') is-invalid @enderror"
                                    id="total_capital_usd" name="total_capital_usd"
                                    value="{{ old('total_capital_usd', $capital?->total_capital_usd) }}" required>
                                @error('total_capital_usd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="temporary_capital_egp" class="form-label">Temporary Capital (EGP)</label>
                                <input type="text"
                                    class="form-control @error('temporary_capital_egp') is-invalid @enderror"
                                    id="temporary_capital_egp" name="temporary_capital_egp"
                                    value="{{ old('temporary_capital_egp', $capital?->temporary_capital_egp) }}" required>
                                @error('temporary_capital_egp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="temporary_capital_usd" class="form-label">Temporary Capital (USD)</label>
                                <input type="text"
                                    class="form-control @error('temporary_capital_usd') is-invalid @enderror"
                                    id="temporary_capital_usd" name="temporary_capital_usd"
                                    value="{{ old('temporary_capital_usd', $capital?->temporary_capital_usd) }}" required>
                                @error('temporary_capital_usd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="emergency_capital_egp" class="form-label">Emergency Capital (EGP)</label>
                                <input type="text"
                                    class="form-control @error('emergency_capital_egp') is-invalid @enderror"
                                    id="emergency_capital_egp" name="emergency_capital_egp"
                                    value="{{ old('emergency_capital_egp', $capital?->emergency_capital_egp) }}" required>
                                @error('emergency_capital_egp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="emergency_capital_usd" class="form-label">Emergency Capital (USD)</label>
                                <input type="text"
                                    class="form-control @error('emergency_capital_usd') is-invalid @enderror"
                                    id="emergency_capital_usd" name="emergency_capital_usd"
                                    value="{{ old('emergency_capital_usd', $capital?->emergency_capital_usd) }}" required>
                                @error('emergency_capital_usd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('dashboard.finance.company-capital.index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

