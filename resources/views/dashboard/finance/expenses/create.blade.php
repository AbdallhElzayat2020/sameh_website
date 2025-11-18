@extends('dashboard.layouts.master')
@section('title', 'Add Expenses')

@section('content')
    @include('dashboard.finance.partials.tabs')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 bg-transparent pb-0">
                    <h4 class="mb-0">Add Expenses</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.finance.expenses.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="total" class="form-label">Total Expenses</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('total') is-invalid @enderror" id="total" name="total"
                                    value="{{ old('total') }}" required>
                                @error('total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="month" class="form-label">Month</label>
                                <input type="month" class="form-control @error('month') is-invalid @enderror" id="month"
                                    name="month" value="{{ old('month') }}" required>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="sheet" class="form-label">Expenses Sheet</label>
                                <input type="file" class="form-control @error('sheet') is-invalid @enderror" id="sheet"
                                    name="sheet" accept=".xls,.xlsx">
                                @error('sheet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div id="sheet-preview" class="d-none w-100">
                                    <div class="border rounded-3 p-3 d-flex align-items-center gap-3">
                                        <div class="bg-label-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="ti ti-file-spreadsheet fs-4 text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-semibold" id="sheet-name"></p>
                                            <small class="text-muted" id="sheet-size"></small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-text-danger ms-auto" id="sheet-clear">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('dashboard.finance.expenses.index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('sheet');
            const preview = document.getElementById('sheet-preview');
            const nameEl = document.getElementById('sheet-name');
            const sizeEl = document.getElementById('sheet-size');
            const clearBtn = document.getElementById('sheet-clear');

            const togglePreview = file => {
                if (!file) {
                    preview.classList.add('d-none');
                    fileInput.value = '';
                    return;
                }

                nameEl.textContent = file.name;
                sizeEl.textContent = `${(file.size / 1024).toFixed(1)} KB`;
                preview.classList.remove('d-none');
            };

            fileInput.addEventListener('change', event => {
                togglePreview(event.target.files[0]);
            });

            clearBtn.addEventListener('click', () => {
                togglePreview(null);
            });
        });
    </script>
@endpush

