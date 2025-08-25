<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkillCategory>
 */
class SkillCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Tukang Kayu', 'Tukang Listrik', 'Tukang Ledeng', 'Tukang Batu', 
            'Tukang Cat', 'Tukang Besi', 'Tukang Genteng', 'Tukang Keramik',
            'Tukang AC', 'Tukang Kebun'
        ];

        return [
            'name' => fake()->randomElement($categories),
            'description' => fake()->sentence(10),
        ];
    }
}