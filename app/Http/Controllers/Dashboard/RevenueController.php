<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceSheetRequest;
use App\Http\Requests\RevenueRequest;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RevenueController extends Controller
{
    public function index(): View
    {
        $revenues = Revenue::query()
            ->latest('month')
            ->paginate(12);

        return view('dashboard.finance.revenues.index', compact('revenues'));
    }

    public function create(): View
    {
        return view('dashboard.finance.revenues.create');
    }

    public function store(RevenueRequest $request): RedirectResponse
    {
        $revenue = Revenue::create($this->preparePayload($request));

        if ($request->hasFile('sheet')) {
            $this->storeSheet($revenue, $request->file('sheet'));
        }

        return redirect()
            ->route('dashboard.finance.revenues.index')
            ->with('success', 'Revenue record added successfully.');
    }

    public function edit(Revenue $revenue): View
    {
        return view('dashboard.finance.revenues.edit', compact('revenue'));
    }

    public function update(RevenueRequest $request, Revenue $revenue): RedirectResponse
    {
        $revenue->update($this->preparePayload($request));

        if ($request->hasFile('sheet')) {
            $this->storeSheet($revenue, $request->file('sheet'));
        }

        return redirect()
            ->route('dashboard.finance.revenues.index')
            ->with('success', 'Revenue record updated successfully.');
    }

    public function destroy(Revenue $revenue): RedirectResponse
    {
        $this->deleteSheet($revenue);

        $revenue->delete();

        return redirect()
            ->route('dashboard.finance.revenues.index')
            ->with('success', 'Revenue record deleted successfully.');
    }

    public function uploadSheet(FinanceSheetRequest $request, Revenue $revenue): RedirectResponse
    {
        $this->storeSheet($revenue, $request->file('sheet'));

        return redirect()
            ->route('dashboard.finance.revenues.index')
            ->with('success', 'Revenue sheet updated successfully.');
    }

    public function downloadSheet(Revenue $revenue)
    {
        $sheet = $revenue->sheet;

        abort_if(! $sheet, 404);

        $disk = Storage::disk('uploads');

        abort_unless($sheet->path && $disk->exists($sheet->path), 404);

        return $disk->download($sheet->path, $sheet->original_name);
    }

    protected function preparePayload(RevenueRequest $request): array
    {
        $data = $request->validated();
        $data['month'] = Carbon::createFromFormat('Y-m', $data['month'])
            ->startOfMonth()
            ->toDateString();

        return $data;
    }

    private function storeSheet(Revenue $revenue, UploadedFile $sheet): void
    {
        $this->deleteSheet($revenue);

        $filename = Str::uuid() . '.' . $sheet->getClientOriginalExtension();
        $path = $sheet->storeAs('revenues', $filename, 'uploads');

        $revenue->media()->create([
            'type' => 'revenue_sheet',
            'path' => $path,
            'original_name' => $sheet->getClientOriginalName(),
            'mime_type' => $sheet->getClientMimeType(),
            'size' => $sheet->getSize(),
            'note' => null,
        ]);
    }

    private function deleteSheet(Revenue $revenue): void
    {
        $sheet = $revenue->sheet;

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
