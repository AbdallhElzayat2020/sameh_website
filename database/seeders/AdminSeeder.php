<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['id' => 1],
            ['name' => 'Admin']
        );


        $allPermissions = Permission::all();
        if ($allPermissions->count() > 0) {
            $adminRole->permissions()->sync($allPermissions->pluck('id'));
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('created admin user successfully');
        $this->command->info('email: admin@gmail.com');
        $this->command->info('password: password');
        $this->command->info('note: you can add permissions from the interface and it will be available automatically for Admin');
    }
}
