<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();

            $table->foreignId('shoe_product_id')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('total_cost', 10, 2);

            $table->enum('status', ['Pending', 'Shipped', 'Delivered'])
                ->default('Pending');

            $table->date('order_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};