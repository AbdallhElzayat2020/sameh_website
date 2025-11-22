<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryRequest;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class IndustryController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('View Industry');

        $industries = Industry::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';
                $query->where('name', 'like', $term);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.industries.index', compact('industries'));
    }

    public function create()
    {
        Gate::authorize('Create Industry');

        return view('dashboard.industries.create');
    }

    public function store(IndustryRequest $request)
    {
        Gate::authorize('Create Industry');

        DB::beginTransaction();

        try {
            $industry = Industry::create($request->safe()->only(['name', 'description']));

            $this->storeImage($request, $industry);

            DB::commit();

            return redirect()
                ->route('dashboard.industries.index')
                ->with('success', 'Industry created successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create industry. Please try again.');
        }
    }

    public function show(Industry $industry)
    {
        Gate::authorize('View Industry');

        $industry->load('media');

        return view('dashboard.industries.show', compact('industry'));
    }

    public function edit(Industry $industry)
    {
        Gate::authorize('Update Industry');

        $industry->load('media');

        return view('dashboard.industries.edit', compact('industry'));
    }

    public function update(IndustryRequest $request, Industry $industry)
    {
        Gate::authorize('Update Industry');

        DB::beginTransaction();

        try {
            $industry->update($request->safe()->only(['name', 'description']));

            // Check if image file was uploaded using Request instance
            $baseRequest = request();
            if ($baseRequest->hasFile('image')) {
                $this->storeImage($baseRequest, $industry);
            }

            DB::commit();

            return redirect()
                ->route('dashboard.industries.index')
                ->with('success', 'Industry updated successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update industry. Please try again.');
        }
    }

    public function destroy(Industry $industry)
    {
        Gate::authorize('Delete Industry');

        $this->deleteImage($industry);
        $industry->delete();

        return redirect()
            ->route('dashboard.industries.index')
            ->with('success', 'Industry deleted successfully.');
    }

    protected function storeImage(Request $request, Industry $industry): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        // Delete existing image if exists (since it's morphOne, only one image allowed)
        if ($industry->media) {
            $this->deleteImage($industry);
        }

        $image = $request->file('image');
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('industries', $filename, 'uploads');

        $industry->media()->create([
            'type' => $image->getClientOriginalExtension(),
            'path' => $path,
            'original_name' => $image->getClientOriginalName(),
            'mime_type' => $image->getClientMimeType(),
            'size' => $image->getSize(),
        ]);
    }

    protected function deleteImage(Industry $industry): void
    {
        if (! $industry->media) {
            return;
        }

        $disk = Storage::disk('uploads');
        $media = $industry->media;

        if ($media->path && $disk->exists($media->path)) {
            $disk->delete($media->path);
        }

        $media->delete();
    }
}
