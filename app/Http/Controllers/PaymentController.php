<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display all payments
     */
    public function index()
    {
        $payments = Payment::with('order')->latest()->get();

        return view('payments.index', compact('payments'));
    }

    /**
     * Show payment form
     */
    public function create()
    {
        $orders = Order::all();

        return view('payments.create', compact('orders'));
    }

    /**
     * Store payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'amount_paid' => 'required|numeric|min:1',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Remaining Balance Formula
        $remainingBalance = $order->total_cost - $request->amount_paid;

        contentReference[oaicite:3]{index=3};

        // Payment Status
        if ($remainingBalance <= 0) {
            $paymentStatus = 'Paid';
        } elseif ($request->amount_paid > 0) {
            $paymentStatus = 'Partial';
        } else {
            $paymentStatus = 'Unpaid';
        }

        Payment::create([
            'order_id' => $order->id,
            'amount_paid' => $request->amount_paid,
            'remaining_balance' => $remainingBalance,
            'payment_status' => $paymentStatus,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment processed successfully.');
    }

    /**
     * Show payment details
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Delete payment
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}