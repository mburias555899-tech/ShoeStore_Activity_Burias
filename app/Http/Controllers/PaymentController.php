<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.shoeProduct')->get();
        $orders = Order::with('shoeProduct')->get();

        return view('payments', compact('payments', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount_paid' => 'required|numeric|min:0.01',
        ]);

        $order = Order::findOrFail($request->order_id);
        $totalPaid = Payment::where('order_id', $order->id)
            ->sum('amount_paid');

        $newTotal = $totalPaid + $request->amount_paid;

        $remaining = max($order->total_cost - $newTotal, 0);

        $status = $remaining == 0 ? 'Paid' : 'Partial';

        Payment::create([
            'order_id' => $order->id,
            'amount_paid' => $request->amount_paid,
            'remaining_balance' => $remaining,
            'payment_status' => $status,
            'payment_date' => now(),
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment added successfully.');
    }
    public function update(Request $request, $id)
    {
        $oldPayment = Payment::findOrFail($id);
        $order = Order::findOrFail($oldPayment->order_id);
        $newTotalPaid = $oldPayment->amount_paid + $request->amount_paid;

        $remaining = $order->total_cost - $newTotalPaid;

        if ($remaining <= 0) {
            $status = 'Paid';
            $remaining = 0;
        } else {
            $status = 'Partial';
        }

        Payment::create([
            'order_id' => $order->id,
            'amount_paid' => $request->amount_paid,
            'remaining_balance' => $remaining,
            'payment_status' => $status,
            'payment_date' => now(),
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'New payment added successfully.');
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}