<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard.finance.invoices');
    }

    public function invoices(): View
    {
        return view('dashboard.finance.invoices.index');
    }
}
