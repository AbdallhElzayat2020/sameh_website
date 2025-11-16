<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
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

        $permissions = Permission::toBase()->get(['name']);

        foreach ($permissions as $permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission->name)
                    ? Response::allow()
                    : Response::denyAsNotFound();
            });
        }
    }
}
