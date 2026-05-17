<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;


class OrderController extends Controller
{
    //
    public function place_order(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate total price
        $total_price = 0;
        foreach ($request->items as $item) {
            $item_model = Item::find($item['id']);
            $total_price += $item_model->price * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => $request->user()->id ?? 1,
            'restaurant_id' => $request->restaurant_id,
            'total_price' => $total_price,
        ]);

        // Attach items to order
        foreach ($request->items as $item) {
            $order->items()->attach($item['id'], ['quantity' => $item['quantity']]);
        }

        return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id], 201);
    }

    public function get_orders(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
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
