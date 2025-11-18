<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(): View
    {
        $permissions = Permission::with('roles')->latest()->paginate(10);

        return view('dashboard.pages.permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('dashboard.pages.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create($validated);

        return redirect()->route('dashboard.permissions.index')
            ->with('success', 'تم إنشاء الصلاحية بنجاح');
    }

    public function edit(Permission $permission): View
    {
        return view('dashboard.pages.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($validated);

        return redirect()->route('dashboard.permissions.index')
            ->with('success', 'تم تحديث الصلاحية بنجاح');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->roles()->detach();
        $permission->delete();

        return redirect()->route('dashboard.permissions.index')
            ->with('success', 'تم حذف الصلاحية بنجاح');
    }
}
