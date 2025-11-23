<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInvoiceStatusRequest;
use App\Models\FreelancerInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class VendorInvoiceController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('View Vendor Invoice');

        $query = FreelancerInvoice::query()
            ->with(['freelancerPo.freelancer', 'freelancerPo.task', 'freelancerPo.services', 'freelancerPo.media']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        // Filter by task number
        if ($request->filled('task_number')) {
            $query->whereHas('freelancerPo', function ($q) use ($request) {
                $q->where('task_code', 'like', '%' . $request->string('task_number') . '%');
            });
        }

        // Filter by vendor code
        if ($request->filled('vendor_code')) {
            $query->whereHas('freelancerPo', function ($q) use ($request) {
                $q->where('freelancer_code', 'like', '%' . $request->string('vendor_code') . '%');
            });
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();

        return view('dashboard.finance.invoices.vendor-invoices', compact('invoices'));
    }

    public function update(UpdateInvoiceStatusRequest $request, FreelancerInvoice $vendorInvoice)
    {
        Gate::authorize('Update Vendor Invoice');

        if ($vendorInvoice->status === 'completed' && ! Auth::user()->isAdministrator()) {
            abort(403, 'Only administrators can edit completed invoices.');
        }

        // Create a new invoice with the new status
        FreelancerInvoice::create([
            'freelancer_po_id' => $vendorInvoice->freelancer_po_id,
            'status' => $request->validated()['status'],
        ]);

        return redirect()
            ->route('dashboard.finance.invoices.vendor-invoices')
            ->with('success', 'New invoice created with updated status successfully.');
    }

    public function downloadPo(FreelancerInvoice $vendorInvoice)
    {
        Gate::authorize('Download Vendor Invoice PO');

        $po = $vendorInvoice->freelancerPo;
        $media = $po->media;

        abort_if(! $media || ! Storage::disk('uploads')->exists($media->path), 404);

        return response()->download(Storage::disk('uploads')->path($media->path), $media->original_name);
    }
}
