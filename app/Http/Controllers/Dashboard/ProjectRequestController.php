<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProjectRequestController extends Controller
{
    public function index(Request $request)
    {
        $projectRequests = ProjectRequest::query()
            ->with('services')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('first_name', 'like', $term)
                        ->orWhere('last_name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('project_name', 'like', $term);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.project-requests.index', compact('projectRequests'));
    }

    public function show(ProjectRequest $projectRequest)
    {
        $projectRequest->load(['services', 'media']);

        return view('dashboard.project-requests.show', compact('projectRequest'));
    }

    public function downloadAttachment(ProjectRequest $projectRequest, Media $media)
    {
        abort_if(
            $media->mediaable_type !== ProjectRequest::class || $media->mediaable_id !== $projectRequest->id,
            404
        );

        $disk = Storage::disk('uploads');
        abort_unless($disk->exists($media->path), 404);

        return response()->download($disk->path($media->path), $media->original_name);
    }

    public function destroyAttachment(ProjectRequest $projectRequest, Media $media)
    {
        abort_if(
            $media->mediaable_type !== ProjectRequest::class || $media->mediaable_id !== $projectRequest->id,
            404
        );

        $disk = Storage::disk('uploads');

        if ($media->path && $disk->exists($media->path)) {
            $disk->delete($media->path);
        }

        $media->delete();

        return redirect()
            ->back()
            ->with('success', 'Attachment deleted successfully.');
    }

    public function updateStatus(Request $request, ProjectRequest $projectRequest)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $projectRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Project request status updated successfully.');
    }

    public function storeAttachment(Request $request, ProjectRequest $projectRequest)
    {
        $validated = $request->validate([
            'file_name' => ['required', 'string', 'max:255'],
            'file_status' => ['required', 'in:DTP,Update'],
            'note' => ['nullable', 'string'],
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => [
                'file',
                'max:20480',
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip-compressed,text/plain',
            ],
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->file('attachments') as $attachment) {
                $filename = \Illuminate\Support\Str::uuid() . '.' . $attachment->getClientOriginalExtension();
                $path = $attachment->storeAs('project-requests', $filename, 'uploads');

                $projectRequest->media()->create([
                    'type' => $attachment->getClientOriginalExtension(),
                    'path' => $path,
                    'original_name' => $validated['file_name'],
                    'mime_type' => $attachment->getClientMimeType(),
                    'size' => $attachment->getSize(),
                    'note' => $validated['note'] ?? null,
                    'file_status' => $validated['file_status'],
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Files uploaded successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to upload files. Please try again.');
        }
    }

    public function destroy(ProjectRequest $projectRequest)
    {
        DB::transaction(function () use ($projectRequest) {
            $disk = Storage::disk('uploads');

            $projectRequest->media->each(function (Media $media) use ($disk) {
                if ($media->path && $disk->exists($media->path)) {
                    $disk->delete($media->path);
                }
            });

            $projectRequest->media()->delete();
            $projectRequest->services()->detach();
            $projectRequest->delete();
        });

        return redirect()
            ->route('dashboard.project-requests.index')
            ->with('success', 'Project request deleted successfully.');
    }
}
