<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorPoRequest;
use App\Models\FreelancerPo;
use App\Models\Service;
use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VendorPoController extends Controller
{
    public function index(Task $task)
    {
        $vendorPos = FreelancerPo::query()
            ->with(['media', 'services', 'freelancer'])
            ->where('task_code', $task->task_number)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.tasks.vendor-pos.index', compact('task', 'vendorPos'));
    }

    public function create(Task $task)
    {
        $services = Service::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('dashboard.tasks.vendor-pos.create', compact('task', 'services'));
    }

    public function store(VendorPoRequest $request, Task $task)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $task, $request) {
            $vendorPo = FreelancerPo::create([
                'freelancer_code' => $validated['freelancer_code'],
                'task_code' => $task->task_number,
                'project_name' => $validated['project_name'],
                'page_number' => $validated['page_number'],
                'price' => $validated['price'],
                'start_date' => $validated['start_date'],
                'payment_date' => $validated['payment_date'],
                'note' => $validated['note'] ?? null,
                'status' => 'pending',
                'created_by' => Auth::id(),
            ]);

            $vendorPo->services()->sync($validated['service_ids'] ?? []);

            $this->storePoMedia($vendorPo, $request->file('po_file'), $validated['note'] ?? null, 'vendor-pos');
        });

        return redirect()
            ->route('dashboard.tasks.vendor-pos.index', $task)
            ->with('success', 'Vendor PO created successfully.');
    }

    public function download(Task $task, FreelancerPo $vendorPo)
    {
        abort_unless($vendorPo->task_code === $task->task_number, 404);

        $media = $vendorPo->media;
        abort_if(! $media || ! Storage::disk('uploads')->exists($media->path), 404);

        return response()->download(Storage::disk('uploads')->path($media->path), $media->original_name);
    }

    protected function storePoMedia(FreelancerPo $po, UploadedFile $file, ?string $note, string $directory): void
    {
        if ($po->media) {
            $this->deleteExistingMedia($po);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'uploads');

        $po->media()->create([
            'type' => $file->getClientOriginalExtension(),
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'note' => $note,
            'file_status' => null,
        ]);
    }

    protected function deleteExistingMedia(FreelancerPo $po): void
    {
        $media = $po->media;

        if (! $media) {
            return;
        }

        $disk = Storage::disk('uploads');
        if ($media->path && $disk->exists($media->path)) {
            $disk->delete($media->path);
        }

        $media->delete();
    }
}
