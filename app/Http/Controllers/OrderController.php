<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index()
    {
        $orders = Order::with('user', 'shoeProduct')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show create order form
     */
    public function create()
    {
        $shoeProducts = ShoeProduct::all();

        return view('orders.create', compact('shoeProducts'));
    }

    /**
     * Store order
     */
    public function store(Request $request)
    {
        $request->validate([
            'shoe_product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $shoe = ShoeProduct::findOrFail($request->shoe_product_id);

        // Total Cost Formula
        $totalCost = $request->quantity * $shoe->price;

        contentReference[oaicite:2]{index=2}

        Order::create([
            'user_id' => Auth::id(),
            'shoe_product_id' => $shoe->id,
            'quantity' => $request->quantity,
            'total_cost' => $totalCost,
            'status' => 'Pending',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Show single order
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Edit order
     */
    public function edit(Order $order)
    {
        $shoeProducts = ShoeProduct::all();

        return view('orders.edit', compact('order', 'shoeProducts'));
    }

    /**
     * Update order
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'shoe_product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'status' => 'required',
        ]);

        $shoe = ShoeProduct::findOrFail($request->shoe_product_id);

        $totalCost = $request->quantity * $shoe->price;

        $order->update([
            'shoe_product_id' => $shoe->id,
            'quantity' => $request->quantity,
            'total_cost' => $totalCost,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}