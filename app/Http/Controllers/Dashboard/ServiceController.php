<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';
                $query->where('name', 'like', $term);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.services.index', compact('services'));
    }

    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->safe()->only(['name', 'description', 'status']);

        if ($request->hasFile('icon')) {
            $filename = Str::uuid() . '.' . $request->file('icon')->getClientOriginalExtension();
            $path = $request->file('icon')->storeAs('services', $filename, 'uploads');
            $data['icon'] = $path;
        }

        Service::create($data);

        return redirect()
            ->route('dashboard.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('dashboard.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('dashboard.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->safe()->only(['name', 'description', 'status']);

        if ($request->hasFile('icon')) {
            $this->deleteIcon($service);
            $filename = Str::uuid() . '.' . $request->file('icon')->getClientOriginalExtension();
            $path = $request->file('icon')->storeAs('services', $filename, 'uploads');
            $data['icon'] = $path;
        }

        $service->update($data);

        return redirect()
            ->route('dashboard.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->deleteIcon($service);
        $service->delete();

        return redirect()
            ->route('dashboard.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    protected function deleteIcon(Service $service): void
    {
        if ($service->icon && Storage::disk('uploads')->exists($service->icon)) {
            Storage::disk('uploads')->delete($service->icon);
        }
    }
}
