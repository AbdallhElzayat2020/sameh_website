<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SystemPermissionSeeder::class,
            AdminSeeder::class,
        ]);

        $role = Role::factory()
            ->hasPermissions(4)
            ->create();

        User::factory()->create([
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }
}
