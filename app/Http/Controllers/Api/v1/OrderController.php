<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{

    public function place_order(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',

            'items' => 'required|array|min:1',

            'items.*.id' => 'required|exists:items,id',

            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $item_ids = collect($request->items)
            ->pluck('id')
            ->toArray();

        if ($item_ids->duplicates()->isNotEmpty()) {

            return response()->json([
                'message' => 'Duplicate items are not allowed'
            ], 400);
        }

        // Get all items in one query
        $items = Item::whereIn('id', $item_ids)
            ->get()
            ->keyBy('id');

        $requested_price = 0;
        $delivery_fee = 10;

        // Validate restaurant items + calculate price
        foreach ($request->items as $item) {

            $item_model = $items[$item['id']];

            // Check item belongs to restaurant
            if ($item_model->restaurant_id != $request->restaurant_id) {

                return response()->json([
                    'message' => "Item with id {$item['id']} is not available in this restaurant"
                ], 400);
            }

            $requested_price += $item_model->price * $item['quantity'];
        }

        $total_price = $requested_price + $delivery_fee;

        $user = Auth::user();

        DB::beginTransaction();

        try {

            // Create order
            $order = Order::create([

                'user_id' => $user?->id,

                'restaurant_id' => $request->restaurant_id,

                'customer_name' => $user?->name ?? 'Guest',

                'customer_phone' => $user?->phone ?? 'Guest',

                'customer_email' => $user?->email ?? 'Guest',

                'city_id' => $user?->city_id,

                'customer_address' => $user?->address ?? 'Guest',

                'requested_price' => $requested_price,

                'delivery_fee' => $delivery_fee,

                'total_price' => $total_price,
            ]);

            // Prepare pivot data
            $attach_data = [];

            foreach ($request->items as $item) {

                $attach_data[$item['id']] = [
                    'quantity' => $item['quantity']
                ];
            }

            // Attach items once
            $order->items()->attach($attach_data);

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get_orders(Request $request)
    {
        // if (!$request->user()) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }
        //return reeoe massage if user has no orders
        $orders = Order::where('user_id', $request->user()->id)->with('items')->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found for this user'], 404);
        }
        return response()->json(['message' => 'Orders retrieved successfully', 'orders' => $orders], 200);
    }

    public function get_order_details(Request $request, $order_id)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $order = Order::where('id', $order_id)->with('items')->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json(['message' => 'Order details retrieved successfully', 'order' => $order], 200);
    }
}
