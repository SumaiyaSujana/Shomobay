<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_cart_id')->constrained('group_carts')->onDelete('cascade');
            $table->foreignId('cart_item_id')->constrained('cart_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('weight_requested', 8, 2);
            $table->decimal('calculated_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_contributions');
    }
};