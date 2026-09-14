<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\GeneralController;
use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\RestaurantController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ItemController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});



// general
Route::get('/cities', [GeneralController::class, 'cities']);
Route::get('/restaurants', [GeneralController::class, 'restaurants']);
Route::get('/items', [GeneralController::class, 'items']);
// Route::get('/orders', [GeneralController::class, 'orders']);
Route::post('/search/restaurants', [GeneralController::class, 'get_resturant_by_search']);
Route::post('/search/items', [GeneralController::class, 'get_item_by_search']);
Route::post('/contact-us', [GeneralController::class, 'contact_us'])->middleware('auth:sanctum');


//  restaurant
Route::get('/restaurants/{restaurant_id}/items', [RestaurantController::class, 'itemsOfRestaurant']);
Route::post('/restaurants/{restaurant_id}/reviews', [RestaurantController::class, 'setReviewsOfRestaurant'])->middleware('auth:sanctum');
Route::get('/restaurants/{restaurant_id}/reviews', [RestaurantController::class, 'getReviewsOfRestaurant']);

// order
Route::post('/orders', [OrderController::class, 'place_order'])->middleware('auth:sanctum');
Route::get('/orders', [OrderController::class, 'get_orders'])->middleware('auth:sanctum');
Route::get('/orders/{order_id}', [OrderController::class, 'get_order_details'])->middleware('auth:sanctum');   

// items of restaurant
Route::post('/restaurant-items', [ItemController::class, 'restaurant_items']);