<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkillLevel>
 */
class SkillLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Pemula', 'Menengah', 'Ahli', 'Master']),
            'hourly_rate_multiplier' => fake()->randomFloat(2, 1.00, 2.00),
            'daily_rate_multiplier' => fake()->randomFloat(2, 1.00, 2.00),
            'overtime_rate_multiplier' => fake()->randomFloat(2, 1.50, 2.50),
        ];
    }
}