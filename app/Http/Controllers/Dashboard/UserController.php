<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {

        $users = User::with('role')->latest()->paginate(10);

        return view('dashboard.pages.users.index', compact('users'));
    }

    public function create(): View
    {

        $roles = Role::all();

        return view('dashboard.pages.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:255',
            'agency' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'] ?? null,
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? null,
            'agency' => $validated['agency'] ?? null,
            'currency' => $validated['currency'] ?? null,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function edit(User $user): View
    {

        $roles = Role::all();

        return view('dashboard.pages.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:255',
            'agency' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'] ?? null,
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? null,
            'agency' => $validated['agency'] ?? null,
            'currency' => $validated['currency'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (! Auth::user()->isAdministrator()) {
            abort(403, 'فقط Admin الأساسي يمكنه حذف المستخدمين.');
        }

        if ($user->isAdministrator()) {
            return redirect()->route('dashboard.users.index')
                ->with('error', 'لا يمكن حذف حساب Admin');
        }

        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
