<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    use ApiResponse;
    // get all items of the restaurant
    public function itemsOfRestaurant($restaurant_id)
    {
        $restaurant = Restaurant::find($restaurant_id);
        if (!$restaurant) {
            return $this->api_error_massage('Restaurant Not Found');
        }
        $items = $restaurant->items;
        return $this->api_success_massage('Restaurant Items Retrieved Successfully', $items);
    }

    public function setReviewsOfRestaurant(Request $request, $restaurant_id)
    {
        $restaurant = Restaurant::find($restaurant_id);
        if (!$restaurant) {
            return $this->api_error_massage('Restaurant Not Found');
        }
        // make review and save in reviews table
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $user = auth()->user();
        $review = $restaurant->reviews()->create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return $this->api_success_massage('Your Review Submitted Successfully');
    }
    // get all reviews of the restaurant
    public function getReviewsOfRestaurant($restaurant_id)
    {
        $restaurant = Restaurant::find($restaurant_id);
        if (!$restaurant) {
            return $this->api_error_massage('Restaurant Not Found');
        }
        if ($restaurant->reviews()->count() == 0) {
            return $this->api_success_massage('No Reviews Found For This Restaurant');
        }
        $reviews = [
            'average_rating' => round($restaurant->reviews()->avg('rating')),
            'reviews' => $restaurant->reviews()
                ->select('user_name', 'comment', 'rating')
                ->get(),
        ];
        return $this->api_success_massage('Restaurant Reviews Retrieved Successfully', $reviews);
    }
}
