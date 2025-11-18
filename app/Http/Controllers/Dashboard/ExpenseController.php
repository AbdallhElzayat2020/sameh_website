<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\FinanceSheetRequest;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(): View
    {
        $expenses = Expense::query()
            ->latest('month')
            ->paginate(12);

        return view('dashboard.finance.expenses.index', compact('expenses'));
    }

    public function create(): View
    {
        return view('dashboard.finance.expenses.create');
    }

    public function store(ExpenseRequest $request): RedirectResponse
    {
        $expense = Expense::create($this->preparePayload($request));

        if ($request->hasFile('sheet')) {
            $this->storeSheet($expense, $request->file('sheet'));
        }

        return redirect()
            ->route('dashboard.finance.expenses.index')
            ->with('success', 'Expense record added successfully.');
    }

    public function edit(Expense $expense): View
    {
        return view('dashboard.finance.expenses.edit', compact('expense'));
    }

    public function update(ExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $expense->update($this->preparePayload($request));

        if ($request->hasFile('sheet')) {
            $this->storeSheet($expense, $request->file('sheet'));
        }

        return redirect()
            ->route('dashboard.finance.expenses.index')
            ->with('success', 'Expense record updated successfully.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->deleteSheet($expense);

        $expense->delete();

        return redirect()
            ->route('dashboard.finance.expenses.index')
            ->with('success', 'Expense record deleted successfully.');
    }

    public function uploadSheet(FinanceSheetRequest $request, Expense $expense): RedirectResponse
    {
        $this->storeSheet($expense, $request->file('sheet'));

        return redirect()
            ->route('dashboard.finance.expenses.index')
            ->with('success', 'Expense sheet updated successfully.');
    }

    public function downloadSheet(Expense $expense)
    {
        $sheet = $expense->sheet;

        abort_if(! $sheet, 404);

        $disk = Storage::disk('uploads');

        abort_unless($sheet->path && $disk->exists($sheet->path), 404);

        return $disk->download($sheet->path, $sheet->original_name);
    }

    protected function preparePayload(ExpenseRequest $request): array
    {
        $data = $request->validated();
        $data['month'] = Carbon::createFromFormat('Y-m', $data['month'])
            ->startOfMonth()
            ->toDateString();

        return $data;
    }

    private function storeSheet(Expense $expense, UploadedFile $sheet): void
    {
        $this->deleteSheet($expense);

        $filename = Str::uuid() . '.' . $sheet->getClientOriginalExtension();
        $path = $sheet->storeAs('expenses', $filename, 'uploads');

        $expense->media()->create([
            'type' => 'expense_sheet',
            'path' => $path,
            'original_name' => $sheet->getClientOriginalName(),
            'mime_type' => $sheet->getClientMimeType(),
            'size' => $sheet->getSize(),
            'note' => null,
        ]);
    }

    private function deleteSheet(Expense $expense): void
    {
        $sheet = $expense->sheet;

        if (! $sheet) {
            return;
        }

        $disk = Storage::disk('uploads');

        if ($sheet->path && $disk->exists($sheet->path)) {
            $disk->delete($sheet->path);
        }

        $sheet->delete();
    }
}
