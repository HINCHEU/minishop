<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Create order
            $order = Order::create($request->only([
                'customer_name',
                'customer_email',
                'customer_phone',
                'shipping_address',
                'total_amount'
            ]));

            // Create order items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],  // matches your table
                    'subtotal'   => $item['subtotal'],    // matches your front-end
                ]);
            }

            return response()->json([
                'success' => true,
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            // Return the SQL error for debugging
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
