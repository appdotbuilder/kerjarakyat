<?php

namespace Database\Factories;

use App\Models\SkillCategory;
use App\Models\SkillLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'skill_category_id' => SkillCategory::factory(),
            'skill_level_id' => SkillLevel::factory(),
            'certification_number' => fake()->optional()->regexify('[A-Z]{2}[0-9]{6}'),
            'certification_date' => fake()->optional()->dateTimeBetween('-2 years', 'now'),
            'certification_expiry' => fake()->optional()->dateTimeBetween('now', '+3 years'),
            'certification_status' => fake()->randomElement(['pending', 'scheduled', 'certified', 'expired']),
            'bio' => fake()->paragraph(3),
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'total_jobs' => fake()->numberBetween(0, 100),
            'total_reviews' => fake()->numberBetween(0, 50),
            'is_available' => fake()->boolean(80),
        ];
    }
}