<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('system_permissions', []);

        $now = now();

        $permissionsData = [];

        foreach ($permissions as $permissionName) {
            $permissionsData[] = [
                'name' => $permissionName,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($permissionsData)) {
            DB::table('permissions')->upsert(
                $permissionsData,
                ['name'],
                ['updated_at']
            );
        }
    }
}
