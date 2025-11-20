<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientPoRequest;
use App\Models\ClientPo;
use App\Models\Service;
use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientPoController extends Controller
{
    public function index(Task $task)
    {
        $clientPos = ClientPo::query()
            ->with(['media', 'services', 'client', 'task'])
            ->where('task_code', $task->task_number)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.tasks.client-pos.index', compact('task', 'clientPos'));
    }

    public function create(Task $task)
    {
        $services = Service::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('dashboard.tasks.client-pos.create', compact('task', 'services'));
    }

    public function store(ClientPoRequest $request, Task $task)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $task, $request) {
            $clientPo = ClientPo::create([
                'task_code' => $task->task_number,
                'client_code' => $validated['client_code'],
                'date_20' => $validated['date_20'],
                'date_80' => $validated['date_80'],
                'payment_20' => $validated['payment_20'],
                'payment_80' => $validated['payment_80'],
                'total_price' => $validated['total_price'],
                'status' => 'pending',
            ]);

            $clientPo->services()->sync($validated['service_ids'] ?? []);

            $this->storePoMedia($clientPo, $request->file('po_file'), $validated['note'] ?? null, 'client-pos');
        });

        return redirect()
            ->route('dashboard.tasks.client-pos.index', $task)
            ->with('success', 'Client PO created successfully.');
    }

    public function download(Task $task, ClientPo $clientPo)
    {
        abort_unless($clientPo->task_code === $task->task_number, 404);

        $media = $clientPo->media;
        abort_if(! $media || ! Storage::disk('uploads')->exists($media->path), 404);

        return response()->download(Storage::disk('uploads')->path($media->path), $media->original_name);
    }

    protected function storePoMedia(ClientPo $po, UploadedFile $file, ?string $note, string $directory): void
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

    protected function deleteExistingMedia(ClientPo $po): void
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
