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
    Schema::create('vendors', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');

        $table->string('business_name');

        $table->string('trade_license')->nullable(); 
        // optional field

        $table->boolean('is_verified')->default(false); 
        // true/false

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
