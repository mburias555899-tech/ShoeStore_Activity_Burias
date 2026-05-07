<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShoeProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    Route::resource('shoe-products', ShoeProductController::class);


    Route::resource('orders', OrderController::class);

    
    Route::resource('payments', PaymentController::class);

});

require __DIR__.'/auth.php';