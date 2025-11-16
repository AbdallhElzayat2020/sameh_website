<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

trait HasPermissions
{
    public function hasPermission(string $permission): bool
    {
        return DB::table('users')
            ->join('role_permission', function (JoinClause $join) {
                $join->on('role_permission.role_id', '=', 'users.role_id')
                    ->where('users.id', $this->id);
            })
            ->join('permissions', function (JoinClause $join) use ($permission) {
                $join->on('permissions.id', '=', 'role_permission.permission_id')
                    ->where('permissions.name', $permission);
            })
            ->exists();
    }

    public function hasRole(string $role): bool
    {
        return DB::table('users')
            ->join('roles', function (JoinClause $join) use ($role) {
                $join->on('roles.id', '=', 'users.role_id')
                    ->where('roles.name', $role);
            })
            ->exists();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permission',
            'role_id',
            'permission_id',
            'role_id',
            'id',
        );
    }
}
