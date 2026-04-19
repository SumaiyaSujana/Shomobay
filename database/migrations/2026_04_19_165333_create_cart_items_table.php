<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_cart_id')->constrained('group_carts')->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('base_price_per_kg', 10, 2);
            $table->decimal('current_price_per_kg', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};