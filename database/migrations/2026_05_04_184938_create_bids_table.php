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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            // Connects the bid to the specific cart
            $table->foreignId('group_cart_id')->constrained()->onDelete('cascade'); 
            $table->string('vendor_name'); // The name of the vendor bidding
            $table->decimal('price_per_kg', 8, 2); // The price they are offering
            $table->string('status')->default('Pending'); // Pending, Accepted, or Rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
