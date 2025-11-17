<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IosImageRequest;
use App\Models\IosImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IosImageController extends Controller
{
    public function index(Request $request)
    {
        $images = IosImage::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';
                $query->where('title', 'like', $term);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.ios-images.index', compact('images'));
    }

    public function create()
    {
        return view('dashboard.ios-images.create');
    }

    public function store(IosImageRequest $request)
    {
        IosImage::create($this->mappedData($request));

        return redirect()
            ->route('dashboard.ios-images.index')
            ->with('success', 'Image added successfully.');
    }

    public function edit(IosImage $iosImage)
    {
        return view('dashboard.ios-images.edit', compact('iosImage'));
    }

    public function update(IosImageRequest $request, IosImage $iosImage)
    {
        if ($request->hasFile('image')) {
            $this->deleteImage($iosImage);
        }

        $iosImage->update($this->mappedData($request));

        return redirect()
            ->route('dashboard.ios-images.index')
            ->with('success', 'Image updated successfully.');
    }

    public function destroy(IosImage $iosImage)
    {
        $this->deleteImage($iosImage);
        $iosImage->delete();

        return redirect()
            ->route('dashboard.ios-images.index')
            ->with('success', 'Image deleted successfully.');
    }

    protected function mappedData(IosImageRequest $request): array
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('ios-images', $filename, 'uploads');
            $data['img_path'] = $path;
        }

        return $data;
    }

    protected function deleteImage(IosImage $iosImage): void
    {
        if ($iosImage->img_path && Storage::disk('uploads')->exists($iosImage->img_path)) {
            Storage::disk('uploads')->delete($iosImage->img_path);
        }
    }
}
