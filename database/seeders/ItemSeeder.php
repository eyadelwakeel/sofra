<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Items = 
            [
             ['restaurant_id' => 1,
                'name' => 'Pepperoni Pizza',
                'description' => 'A classic pizza topped with pepperoni slices and melted cheese.',
                'price' => 12.99,
                'preparation_time' => 20,
                'notes' => 'Best served hot!'] ,
                ['restaurant_id' => 2,
                'name' => 'Fried Chicken Bucket',
                'description' => 'A bucket of crispy fried chicken pieces, perfect for sharing.',
                'price' => 19.99,
                'preparation_time' => 30,
                'notes' => 'Comes with a side of fries!'],
                ['restaurant_id' => 3,
                'name' => 'Big Mac',
                'description' => 'Two beef patties, special sauce, lettuce, cheese, pickles, onions on a sesame seed bun.',
                'price' => 5.99,
                'preparation_time' => 10,
                'notes' => 'A McDonald\'s classic!']

        ];

        foreach ($Items as $item) {
            Item::create($item);
        }
            
    }
}
