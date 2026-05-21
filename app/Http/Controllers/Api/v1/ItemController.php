<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\ApiResponse;

class ItemController extends Controller
{
    use ApiResponse;
    //
    //get restaurant items
    public function restaurant_items(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        $restaurant = $request->restaurant_id;
        $items = Item::where('restaurant_id', $restaurant)->get();
        return $this->api_response([
            'status' => true,
            'message' => 'Restaurant items retrieved successfully',
            'data' => $items,
        ]);
    }
}
