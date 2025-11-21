<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInvoiceStatusRequest;
use App\Models\ClientInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ClientInvoice::query()
            ->with(['clientPo.client', 'clientPo.task', 'clientPo.services', 'clientPo.media']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        // Filter by task number
        if ($request->filled('task_number')) {
            $query->whereHas('clientPo', function ($q) use ($request) {
                $q->where('task_code', 'like', '%' . $request->string('task_number') . '%');
            });
        }

        // Filter by client code
        if ($request->filled('client_code')) {
            $query->whereHas('clientPo', function ($q) use ($request) {
                $q->where('client_code', 'like', '%' . $request->string('client_code') . '%');
            });
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();

        return view('dashboard.finance.invoices.client-invoices', compact('invoices'));
    }

    public function update(UpdateInvoiceStatusRequest $request, ClientInvoice $clientInvoice)
    {
        if ($clientInvoice->status === 'completed' && ! Auth::user()->isAdministrator()) {
            abort(403, 'Only administrators can edit completed invoices.');
        }

        $clientInvoice->update([
            'status' => $request->validated()['status'],
        ]);

        return redirect()
            ->route('dashboard.finance.invoices.client-invoices')
            ->with('success', 'Invoice status updated successfully.');
    }

    public function downloadPo(ClientInvoice $clientInvoice)
    {
        $po = $clientInvoice->clientPo;
        $media = $po->media;

        abort_if(! $media || ! Storage::disk('uploads')->exists($media->path), 404);

        return response()->download(Storage::disk('uploads')->path($media->path), $media->original_name);
    }
}
