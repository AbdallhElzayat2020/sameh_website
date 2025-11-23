<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCapitalRequest;
use App\Models\CompanyCapital;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CompanyCapitalController extends Controller
{
    public function index(): View
    {
        Gate::authorize('View Finance');

        $capital = CompanyCapital::first();

        return view('dashboard.finance.company-capital.index', compact('capital'));
    }

    public function edit(): View
    {
        Gate::authorize('Update Company Capital');

        $capital = CompanyCapital::first();

        return view('dashboard.finance.company-capital.edit', compact('capital'));
    }

    public function update(CompanyCapitalRequest $request): RedirectResponse
    {
        Gate::authorize('Update Company Capital');

        $capital = CompanyCapital::first();

        if ($capital) {
            $capital->update($request->validated());
        } else {
            $capital = CompanyCapital::create($request->validated());
        }

        return redirect()
            ->route('dashboard.finance.company-capital.index')
            ->with('success', 'Company capital updated successfully.');
    }
}
