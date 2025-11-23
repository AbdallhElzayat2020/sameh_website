<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\FreelancerRequest;
use App\Models\Freelancer;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('View Freelancer');

        $freelancers = Freelancer::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('freelancer_code', 'like', $term)
                        ->orWhere('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('phone', 'like', $term);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.freelancers.index', compact('freelancers'));
    }

    public function create()
    {
        Gate::authorize('Create Freelancer');

        $services = Service::query()->orderBy('name')->get(['id', 'name']);
        $f_code = Freelancer::nextFreelancerCode();

        return view('dashboard.freelancers.create', compact('services', 'f_code'));
    }

    public function store(FreelancerRequest $request)
    {
        Gate::authorize('Create Freelancer');

        $freelancer = Freelancer::create($this->mappedData($request));
        $freelancer->services()->sync($request->input('service_ids', []));
        $this->storeAttachments($request, $freelancer);

        return redirect()
            ->route('dashboard.freelancers.index')
            ->with('success', 'Freelancer created successfully.');
    }

    public function show(Freelancer $freelancer)
    {
        Gate::authorize('View Freelancer');

        $freelancer->load(['services', 'media']);

        return view('dashboard.freelancers.show', compact('freelancer'));
    }

    public function edit(Freelancer $freelancer)
    {
        Gate::authorize('Update Freelancer');

        $services = Service::query()->orderBy('name')->get(['id', 'name']);
        $freelancer->load(['services', 'media']);

        return view('dashboard.freelancers.edit', compact('freelancer', 'services'));
    }

    public function update(FreelancerRequest $request, Freelancer $freelancer)
    {
        Gate::authorize('Update Freelancer');

        $freelancer->update($this->mappedData($request));
        $freelancer->services()->sync($request->input('service_ids', []));
        $this->storeAttachments($request, $freelancer);

        return redirect()
            ->route('dashboard.freelancers.index')
            ->with('success', 'Freelancer updated successfully.');
    }

    public function destroy(Freelancer $freelancer)
    {
        Gate::authorize('Delete Freelancer');

        $disk = Storage::disk('uploads');

        $freelancer->media->each(function (Media $media) use ($disk) {
            if ($media->path && $disk->exists($media->path)) {
                $disk->delete($media->path);
            }
            $media->delete();
        });

        $freelancer->delete();

        return redirect()
            ->route('dashboard.freelancers.index')
            ->with('success', 'Freelancer deleted successfully.');
    }

    public function downloadAttachment(Freelancer $freelancer, Media $media)
    {
        Gate::authorize('Download Freelancer Attachment');

        abort_if($media->mediaable_type !== Freelancer::class || $media->mediaable_id !== $freelancer->id, 404);

        $disk = Storage::disk('uploads');
        abort_unless($disk->exists($media->path), 404);

        return $disk->download($media->path, $media->original_name);
    }

    public function destroyAttachment(Freelancer $freelancer, Media $media)
    {
        Gate::authorize('Delete Freelancer Attachment');

        abort_if($media->mediaable_type !== Freelancer::class || $media->mediaable_id !== $freelancer->id, 404);

        $disk = Storage::disk('uploads');
        if ($media->path && $disk->exists($media->path)) {
            $disk->delete($media->path);
        }

        $media->delete();

        return redirect()
            ->back()
            ->with('success', 'Attachment deleted successfully.');
    }

    protected function mappedData(FreelancerRequest $request): array
    {
        $languages = collect($request->input('languages', []))
            ->filter(function ($language) {
                return ! empty($language['source']) && ! empty($language['target']);
            })
            ->values()
            ->all();

        return $request->safe()->except('languages') + [
            'language_pair' => $languages,
        ];
    }

    protected function storeAttachments(Request $request, Freelancer $freelancer): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $attachment) {
            $filename = Str::uuid() . '.' . $attachment->getClientOriginalExtension();
            $path = $attachment->storeAs('freelancers', $filename, 'uploads');

            $freelancer->media()->create([
                'type' => $attachment->getClientOriginalExtension(),
                'path' => $path,
                'original_name' => $attachment->getClientOriginalName(),
                'mime_type' => $attachment->getClientMimeType(),
                'size' => $attachment->getSize(),
            ]);
        }
    }
}
