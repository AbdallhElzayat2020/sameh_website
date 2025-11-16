<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'status' => fake()->word(),
            'phone' => fake()->phoneNumber(),
            'agency' => fake()->word(),
            'currency' => fake()->word(),
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(fake()->password()),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'role_id' => Role::factory(),
        ];
    }
}
