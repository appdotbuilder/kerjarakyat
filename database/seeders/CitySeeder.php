<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Jakarta', 'province' => 'DKI Jakarta', 'minimum_wage' => 4901798],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur', 'minimum_wage' => 4498000],
            ['name' => 'Bandung', 'province' => 'Jawa Barat', 'minimum_wage' => 4317000],
            ['name' => 'Medan', 'province' => 'Sumatera Utara', 'minimum_wage' => 3200000],
            ['name' => 'Semarang', 'province' => 'Jawa Tengah', 'minimum_wage' => 2715000],
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan', 'minimum_wage' => 3471000],
            ['name' => 'Palembang', 'province' => 'Sumatera Selatan', 'minimum_wage' => 3404000],
            ['name' => 'Tangerang', 'province' => 'Banten', 'minimum_wage' => 4641853],
            ['name' => 'Depok', 'province' => 'Jawa Barat', 'minimum_wage' => 4732000],
            ['name' => 'Bekasi', 'province' => 'Jawa Barat', 'minimum_wage' => 4783831],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}