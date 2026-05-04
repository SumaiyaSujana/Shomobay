<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
    {
        // This table follows your strict snake_case plural naming rule
        Schema::create('group_carts', function (Blueprint $table) {
            $table->id();
            $table->string('neighborhood_name'); // e.g., 'Bashundhara R/A Block C'
            $table->decimal('target_weight_kg', 8, 2); // e.g., 50.00
            $table->decimal('current_weight_kg', 8, 2)->default(0); 
            $table->string('status')->default('Open'); // 'Open', 'Locked (Ready for Bidding)', 'Failed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_carts');
    }
};
