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
    Schema::create('neighbors', function (Blueprint $table) {
        $table->id(); 
        // Unique ID for each neighbor

        $table->unsignedBigInteger('user_id'); 
        // Links to users table

        $table->string('building_name'); 
        // Apartment/building name

        $table->string('flat_number'); 
        // Flat or unit number

        $table->timestamps(); 
        // created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neighbors');
    }
};
