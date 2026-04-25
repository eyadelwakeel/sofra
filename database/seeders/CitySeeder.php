<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{

    public function run()
    {
        $cities = [
            'Cairo',
            'Giza',
            'Alexandria',
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => $city
            ]);
        }
    }
}
