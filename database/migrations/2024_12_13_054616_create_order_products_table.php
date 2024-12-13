<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->uuid('order_id');
            $table->uuid('product_id');
            $table->integer('quantity');

            $table->foreign('order_id')->references('uuid')->on('orders');
            $table->foreign('product_id')->references('uuid')->on('products');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
