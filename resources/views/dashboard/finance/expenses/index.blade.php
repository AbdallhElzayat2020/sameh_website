@extends('dashboard.layouts.master')
@section('title', 'Finance - Expenses')

@section('content')
    @include('dashboard.finance.partials.tabs')

    <div class="card shadow-sm border-0 w-100">
        <div class="card-header border-0 bg-transparent pb-3 d-flex flex-column flex-md-row justify-content-between gap-2">
            <div>
                <h4 class="mb-1">Expenses</h4>
                <p class="text-muted mb-0">Monitor monthly expenses and manage their supporting sheets.</p>
            </div>
            <a href="{{ route('dashboard.finance.expenses.create') }}" class="btn btn-primary align-self-start">
                <i class="ti ti-plus me-1"></i>
                Add Expenses
            </a>
        </div>
        <div class="table-responsive w-100">
            <table class="table table-hover mb-0 align-middle w-100">
                <thead>
                    <tr>
                        <th>Total Expenses</th>
                        <th>Month</th>
                        <th>Add Sheet</th>
                        <th>Sheet</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr>
                            <td class="fw-semibold">{{ number_format($expense->total, 2) }}</td>
                            <td>{{ $expense->month?->format('F Y') }}</td>
                            <td>
                                <button class="btn btn-icon btn-round btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#expenseSheetModal-{{ $expense->id }}" title="Upload sheet">
                                    <i class="ti ti-upload"></i>
                                </button>
                            </td>
                            <td>
                                @if ($expense->sheet)
                                    <a href="{{ route('dashboard.finance.expenses.sheet.download', $expense) }}"
                                        class="btn btn-icon btn-round btn-primary" title="Download sheet">
                                        <i class="ti ti-download"></i>
                                    </a>
                                @else
                                    <button class="btn btn-icon btn-round btn-secondary" disabled>
                                        <i class="ti ti-download"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No expenses recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($expenses->hasPages())
            <div class="card-footer">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>

    @foreach ($expenses as $expense)
        <div class="modal fade" id="expenseSheetModal-{{ $expense->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Expense Sheet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('dashboard.finance.expenses.sheet.store', $expense) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="expense-sheet-{{ $expense->id }}" class="form-label">Upload file</label>
                                <input type="file" class="form-control" id="expense-sheet-{{ $expense->id }}"
                                    name="sheet" required>
                                <small class="text-muted">Uploading a new file will replace the previous sheet.</small>
                            </div>
                            @if ($expense->sheet)
                                <p class="text-muted small mb-0">Current file: {{ $expense->sheet->original_name }}</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-upload me-1"></i>
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('css')
    @once('finance-sheet-buttons')
        <style>
            .btn-icon.btn-round {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0;
            }

            .btn-icon.btn-round i {
                font-size: 1.2rem;
            }

            .btn-icon.btn-secondary {
                background: rgba(80, 125, 255, 0.2);
                border: none;
                color: #fff;
            }

            .btn-icon.btn-primary {
                background: #3c8dff;
                border: none;
            }

            .btn-icon:disabled {
                opacity: 0.4;
            }
        </style>
    @endonce
@endpush

