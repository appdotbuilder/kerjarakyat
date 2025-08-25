<?php

namespace Database\Seeders;

use App\Models\SkillLevel;
use Illuminate\Database\Seeder;

class SkillLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillLevels = [
            [
                'name' => 'Pemula',
                'hourly_rate_multiplier' => 1.00,
                'daily_rate_multiplier' => 1.00,
                'overtime_rate_multiplier' => 1.50,
            ],
            [
                'name' => 'Menengah',
                'hourly_rate_multiplier' => 1.25,
                'daily_rate_multiplier' => 1.25,
                'overtime_rate_multiplier' => 1.75,
            ],
            [
                'name' => 'Ahli',
                'hourly_rate_multiplier' => 1.50,
                'daily_rate_multiplier' => 1.50,
                'overtime_rate_multiplier' => 2.00,
            ],
            [
                'name' => 'Master',
                'hourly_rate_multiplier' => 2.00,
                'daily_rate_multiplier' => 2.00,
                'overtime_rate_multiplier' => 2.50,
            ],
        ];

        foreach ($skillLevels as $skillLevel) {
            SkillLevel::create($skillLevel);
        }
    }
}