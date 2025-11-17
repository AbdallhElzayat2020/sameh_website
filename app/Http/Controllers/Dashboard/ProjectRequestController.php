<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectRequestController extends Controller
{
    public function index(Request $request)
    {
        $projectRequests = ProjectRequest::query()
            ->with('services')
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->string('status')))
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

        return $disk->download($media->path, $media->original_name);
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
