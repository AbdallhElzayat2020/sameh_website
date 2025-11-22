<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('View Testimonial');

        $testimonials = Testimonial::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';
                $query->where('name', 'like', $term);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        Gate::authorize('Create Testimonial');

        return view('dashboard.testimonials.create');
    }

    public function store(TestimonialRequest $request)
    {
        Gate::authorize('Create Testimonial');

        Testimonial::create($request->validated());

        return redirect()
            ->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        Gate::authorize('Update Testimonial');

        return view('dashboard.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        Gate::authorize('Update Testimonial');

        $testimonial->update($request->validated());

        return redirect()
            ->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        Gate::authorize('Delete Testimonial');

        $testimonial->delete();

        return redirect()
            ->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}
