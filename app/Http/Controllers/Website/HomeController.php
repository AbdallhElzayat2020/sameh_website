<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\IosImage;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $iosImages = IosImage::query()->latest()->limit(4)->get();
        $testimonials = Testimonial::query()
            ->where('status', 'active')
            ->latest()
            ->limit(6)
            ->get();

        $services = Service::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name', 'icon', 'description']);

        $homeServices = $services->map(function (Service $service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'icon' => $service->icon ? asset('uploads/' . $service->icon) : null,
                'description' => $service->description ?: 'Description will be available soon.',
            ];
        });

        $industries = Industry::query()
            ->with('media')
            ->orderBy('name')
            ->get()
            ->map(function (Industry $industry) {
                return [
                    'id' => $industry->id,
                    'name' => $industry->name,
                    'slug' => \Illuminate\Support\Str::slug($industry->name),
                    'description' => $industry->description,
                    'image' => $industry->media ? asset('uploads/' . $industry->media->path) : null,
                ];
            });

        return view('website.home', [
            'iosImages' => $iosImages,
            'testimonials' => $testimonials,
            'homeServices' => $homeServices,
            'industries' => $industries,
        ]);
    }
}
