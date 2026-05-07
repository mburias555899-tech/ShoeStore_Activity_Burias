<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ShoeProduct;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = ShoeProduct::count();
        $totalOrders = Order::count();
        $totalPayments = Payment::count();

        return view('dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalPayments'
        ));
    }
}