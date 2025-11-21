@extends('dashboard.layouts.master')
@section('title', 'Client Invoices')

@section('content')
    @include('dashboard.finance.partials.tabs')

    <!-- Invoice Tabs -->
    <ul class="nav nav-tabs mb-4" id="invoiceTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('dashboard.finance.invoices.vendor-invoices') }}">
                Vendor Invoices
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ route('dashboard.finance.invoices.client-invoices') }}">
                Client Invoices
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <h4 class="mb-1">Client Invoices</h4>
            <p class="mb-0 text-muted">Manage client purchase order invoices.</p>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" action="{{ route('dashboard.finance.invoices.client-invoices') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="task_number" class="form-label">Task Number</label>
                        <input type="text" class="form-control" id="task_number" name="task_number"
                            value="{{ request('task_number') }}" placeholder="Search task number">
                    </div>
                    <div class="col-md-3">
                        <label for="client_code" class="form-label">Client Code</label>
                        <input type="text" class="form-control" id="client_code" name="client_code"
                            value="{{ request('client_code') }}" placeholder="Search client code">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('dashboard.finance.invoices.client-invoices') }}"
                            class="btn btn-outline-secondary">Clear</a>
                    </div>
                </div>
            </form>

            @if ($invoices->isEmpty())
                <p class="text-muted mb-0">No client invoices found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Task No.</th>
                                <th>Vendor Code</th>
                                <th>20% Date</th>
                                <th>80% Date</th>
                                <th>Services</th>
                                <th>20%</th>
                                <th>80%</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Proposal</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                @php
                                    $po = $invoice->clientPo;
                                @endphp
                                <tr>
                                    <td>{{ $po->task_code }}</td>
                                    <td>{{ $po->client_code }}</td>
                                    <td>{{ optional($po->date_20)->format('d/m/Y') }}</td>
                                    <td>{{ optional($po->date_80)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($po->services->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($po->services as $service)
                                                    <span class="badge bg-label-primary">{{ $service->name }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format((float) $po->payment_20, 2) }}</td>
                                    <td>{{ number_format((float) $po->payment_80, 2) }}</td>
                                    <td>{{ number_format((float) $po->total_price, 2) }}</td>
                                    <td>
                                        @php
                                            $statusLabels = [
                                                'pending' => ['label' => 'Pending', 'class' => 'bg-label-warning'],
                                                'in_progress' => [
                                                    'label' => 'In Progress',
                                                    'class' => 'bg-label-info',
                                                ],
                                                'completed' => [
                                                    'label' => 'Completed',
                                                    'class' => 'bg-label-success',
                                                ],
                                            ];
                                            $status = $statusLabels[$invoice->status] ?? [
                                                'label' => $invoice->status,
                                                'class' => 'bg-label-secondary',
                                            ];
                                        @endphp
                                        <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                                    </td>
                                    <td>
                                        @if ($po->media)
                                            <a href="{{ route('dashboard.finance.invoices.client-invoices.download-po', $invoice) }}"
                                                class="btn btn-icon btn-sm btn-outline-primary" title="Download Proposal">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-icon btn-sm btn-outline-secondary" disabled
                                                title="No file uploaded">
                                                <i class="ti ti-file-off"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($invoice->status === 'completed' && auth()->user()->isAdministrator())
                                            <button type="button" class="btn btn-icon btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal{{ $invoice->id }}" title="Edit Status">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        @elseif ($invoice->status !== 'completed')
                                            <button type="button" class="btn btn-icon btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal{{ $invoice->id }}" title="Edit Status">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-icon btn-sm btn-outline-secondary" disabled
                                                title="Cannot edit completed invoice">
                                                <i class="ti ti-lock"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit Status Modal -->
                                <div class="modal fade" id="editStatusModal{{ $invoice->id }}" tabindex="-1"
                                    aria-labelledby="editStatusModalLabel{{ $invoice->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStatusModalLabel{{ $invoice->id }}">Update
                                                    Invoice Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="POST"
                                                action="{{ route('dashboard.finance.invoices.client-invoices.update', $invoice) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="status{{ $invoice->id }}" class="form-label">Status
                                                            <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="status{{ $invoice->id }}"
                                                            name="status" required>
                                                            <option value="pending"
                                                                {{ $invoice->status === 'pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="in_progress"
                                                                {{ $invoice->status === 'in_progress' ? 'selected' : '' }}>
                                                                In Progress</option>
                                                            <option value="completed"
                                                                {{ $invoice->status === 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

