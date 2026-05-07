<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoeProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('shoeProduct')->get();
        $shoeProducts = ShoeProduct::all();

        return view('orders', compact('orders', 'shoeProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shoe_product_id' => 'required|exists:shoe_products,id',
            'quantity' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        $product = ShoeProduct::findOrFail($request->shoe_product_id);

        Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'shoe_product_id' => $request->shoe_product_id,
            'quantity' => $request->quantity,
            'total_cost' => $request->quantity * $product->price,
            'status' => $request->status,
            'order_date' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shoe_product_id' => 'required|exists:shoe_products,id',
            'quantity' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        $product = ShoeProduct::findOrFail($request->shoe_product_id);

        $order->update([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'shoe_product_id' => $request->shoe_product_id,
            'quantity' => $request->quantity,
            'total_cost' => $request->quantity * $product->price,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}