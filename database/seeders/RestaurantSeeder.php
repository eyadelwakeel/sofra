<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       
        $Resturants = 
            [
             ['name' => 'Pizza Hut',
                'phone' => '0123456789',
                'email' => 'pizza hut@example.com',
                'city_id' => 1,
                'address' => '123 Main St, Cairo',
                'notes' => 'Best pizza in town!'] ,
                ['name' => 'KFC',
                'phone' => '0123456789',
                'email' => 'kfc@example.com',
                'city_id' => 1,
                'address' => '456 Oak Ave, Cairo',
                'minimum_order' => 20.00,
                'delivery_fee' => 5.00,
                'notes' => 'Fast and delicious!'],
                ['name' => 'McDonald\'s',
                'phone' => '0123456789',
                'email' => 'mcdonalds@example.com',
                'city_id' => 1,
                'address' => '789 Pine Rd, Cairo',
                'minimum_order' => 15.00,
                'delivery_fee' => 3.00,
                'notes' => 'Great for quick meals!']

        ];

        foreach ($Resturants as $restaurant) {
            Restaurant::create($restaurant);
        }

    }
}
