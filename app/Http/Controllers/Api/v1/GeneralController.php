<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\City;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Item;


class GeneralController extends Controller
{
    use ApiResponse;
    //
    public function cities()
    {
        $cities = City::all();
        return $this->api_data_response($cities);
    }

    public function restaurants()
    {
        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            $avg = $restaurant->reviews()->avg('rating');
            $restaurant->avg_rating = round($avg);
        }
        return $this->api_data_response($restaurants);
    }

    public function items()
    {
        $items = Item::all();
        return $this->api_data_response($items);
    }

    public function orders()
    {
        $orders = Order::all();
        return $this->api_data_response($orders);
    }  

    public function get_resturant_by_search(Request $request)
    {
        $restaurants = Restaurant::where('name','like','%'.$request->search.'%')->get();
        return $this->api_data_response($restaurants);
    }
}
