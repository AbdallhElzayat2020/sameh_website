<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(): RedirectResponse
    {
        Gate::authorize('View Finance');

        return redirect()->route('dashboard.finance.invoices');
    }

    public function invoices(): View
    {
        Gate::authorize('View Invoices');

        return view('dashboard.finance.invoices.index');
    }
}
