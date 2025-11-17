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
            ->get(['id', 'name', 'description']);

        $homeServices = $services->map(function (Service $service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description ?: 'Description will be available soon.',
            ];
        });

        if ($homeServices->isEmpty()) {
            $homeServices = collect($this->fallbackServices());
        }

        $industries = Industry::query()
            ->with(['industryOptions', 'media'])
            ->orderBy('name')
            ->get()
            ->map(function (Industry $industry) {
                return [
                    'id' => $industry->id,
                    'name' => $industry->name,
                    'slug' => \Illuminate\Support\Str::slug($industry->name),
                    'description' => $industry->description,
                    'options' => $industry->industryOptions->pluck('name')->toArray(),
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

    private function fallbackServices(): array
    {
        return [
            [
                'name' => 'Translation',
                'description' => 'AI Artificial Intelligence is a branch of computer science that focuses on the development of intelligent machines that can perform tasks that typically require human intelligence.',
            ],
            [
                'name' => 'Transcription',
                'description' => 'Professional transcription services that convert audio and video content into accurate written text, ensuring high quality and precision for all your documentation needs.',
            ],
            [
                'name' => 'Transcreation',
                'description' => 'Creative translation services that adapt your content culturally and linguistically, maintaining the original message while resonating with your target audience.',
            ],
            [
                'name' => 'Video & Audio Translation',
                'description' => 'Comprehensive translation services for multimedia content, including subtitles, dubbing, and voice-over solutions for video and audio materials.',
            ],
            [
                'name' => 'Machine Translation',
                'description' => 'Advanced machine translation solutions powered by AI technology, providing fast and efficient translation services for large volumes of content.',
            ],
            [
                'name' => 'Create Design From Scratch',
                'description' => 'Complete design services from concept to execution, creating visually stunning and functional designs tailored to your brand and business needs.',
            ],
            [
                'name' => 'Elearning Localization',
                'description' => 'Specialized localization services for e-learning platforms, ensuring educational content is culturally appropriate and linguistically accurate for global learners.',
            ],
            [
                'name' => 'Game Localization',
                'description' => 'Expert game localization services that adapt gaming content, including storylines, dialogues, and UI elements, for international markets.',
            ],
            [
                'name' => 'Website Localization',
                'description' => 'Complete website localization services that translate and adapt your web content, ensuring seamless user experience across different languages and cultures.',
            ],
            [
                'name' => 'Website & App Localization',
                'description' => 'Comprehensive localization solutions for both websites and mobile applications, providing multilingual support and cultural adaptation for global audiences.',
            ],
            [
                'name' => 'Software Localization',
                'description' => 'Professional software localization services that translate and adapt software interfaces, documentation, and user guides for international markets.',
            ],
            [
                'name' => 'AI Powered Translation',
                'description' => 'Cutting-edge AI-powered translation services that combine machine learning with human expertise to deliver accurate, context-aware translations at scale.',
            ],
        ];
    }
}
