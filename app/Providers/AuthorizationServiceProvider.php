<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        Gate::before(function (User $user) {
            return $user->isAdministrator()
                ? Response::allow()
                : Response::denyAsNotFound();
        });

        // Check if permissions table exists before trying to access it
        if (Schema::hasTable('permissions')) {
            try {
                $permissions = Permission::toBase()->get(['name']);

                foreach ($permissions as $permission) {
                    Gate::define($permission->name, function (User $user) use ($permission) {
                        return $user->hasPermission($permission->name)
                            ? Response::allow()
                            : Response::denyAsNotFound();
                    });
                }
            } catch (\Exception $e) {
                // Silently fail if table doesn't exist or is not ready yet
            }
        }
    }
}
