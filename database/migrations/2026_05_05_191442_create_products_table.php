<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'Premium Potatoes'
            $table->decimal('price_per_kg', 8, 2); // e.g., 45.00
            $table->decimal('target_weight_kg', 8, 2); // e.g., 50.00
            $table->decimal('current_weight_kg', 8, 2)->default(0); // e.g., 30.00
            $table->string('emoji_icon')->nullable(); // e.g., '🥔'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
