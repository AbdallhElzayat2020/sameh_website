@extends('dashboard.layouts.master')
@section('title', 'Finance - Invoices')

@section('content')
    @include('dashboard.finance.partials.tabs')

    <!-- Invoice Tabs -->
    <ul class="nav nav-tabs mb-4" id="invoiceTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->routeIs('dashboard.finance.invoices.vendor-invoices*') ? 'active' : '' }}"
                href="{{ route('dashboard.finance.invoices.vendor-invoices') }}">
                Vendor Invoices
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->routeIs('dashboard.finance.invoices.client-invoices*') ? 'active' : '' }}"
                href="{{ route('dashboard.finance.invoices.client-invoices') }}">
                Client Invoices
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 w-100">
        <div class="card-body text-center py-5">
            <h4 class="mb-2">Invoices</h4>
            <p class="text-muted mb-4">Select a tab above to view invoices.</p>
        </div>
    </div>
@endsection
