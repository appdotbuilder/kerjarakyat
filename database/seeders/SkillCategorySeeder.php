<?php

namespace Database\Seeders;

use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillCategories = [
            [
                'name' => 'Tukang Kayu',
                'description' => 'Ahli dalam pembuatan furniture, konstruksi kayu, dan perbaikan',
            ],
            [
                'name' => 'Tukang Listrik',
                'description' => 'Spesialis instalasi dan perbaikan sistem kelistrikan',
            ],
            [
                'name' => 'Tukang Ledeng',
                'description' => 'Ahli dalam instalasi dan perbaikan sistem perpipaan',
            ],
            [
                'name' => 'Tukang Batu',
                'description' => 'Spesialis pembangunan struktur beton dan batu',
            ],
            [
                'name' => 'Tukang Cat',
                'description' => 'Ahli dalam pengecatan dinding, furniture, dan dekorasi',
            ],
            [
                'name' => 'Tukang Besi',
                'description' => 'Spesialis pembuatan dan perbaikan konstruksi besi',
            ],
            [
                'name' => 'Tukang Genteng',
                'description' => 'Ahli dalam pemasangan dan perbaikan atap',
            ],
            [
                'name' => 'Tukang Keramik',
                'description' => 'Spesialis pemasangan keramik dan ubin',
            ],
            [
                'name' => 'Tukang AC',
                'description' => 'Ahli dalam instalasi dan service AC',
            ],
            [
                'name' => 'Tukang Kebun',
                'description' => 'Spesialis perawatan taman dan landscape',
            ],
        ];

        foreach ($skillCategories as $category) {
            SkillCategory::create($category);
        }
    }
}