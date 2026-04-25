<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Neighborhood;

class NeighborhoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    $data = [
        'Cairo' => ['Nasr City', 'Heliopolis'],
        'Giza' => ['Dokki', 'Mohandessin'],
        'Alexandria' => ['Smouha', 'Stanley'],
    ];

    foreach ($data as $cityName => $neighborhoods) {
        $city = City::where('name', $cityName)->first();

        if ($city) {
            foreach ($neighborhoods as $neighborhood) {
                Neighborhood::create([
                    'name' => $neighborhood,
                    'city_id' => $city->id
                ]);
            }
        }
    }
}
}
