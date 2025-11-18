<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyCapital>
 */
class CompanyCapitalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = fn () => number_format(fake()->numberBetween(100_000, 5_000_000));

        return [
            'total_capital_egp' => $number(),
            'total_capital_usd' => $number(),
            'temporary_capital_egp' => $number(),
            'temporary_capital_usd' => $number(),
            'emergency_capital_egp' => $number(),
            'emergency_capital_usd' => $number(),
        ];
    }
}
