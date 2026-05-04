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
            // Links this item to a specific group cart
            $table->foreignId('group_cart_id')->constrained()->onDelete('cascade');
            $table->string('neighbor_name'); // e.g., 'Apartment 4A'
            $table->string('vegetable_name'); // e.g., 'Potatoes'
            $table->decimal('weight_kg', 8, 2); // How many KGs this neighbor ordered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
