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
        Schema::create('vendor_applications', function (Blueprint $table) {
            $table->id();
            // Link to the user who is applying
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // Store the path to the uploaded NID or Trade License
            $table->string('document_path'); 
            // Track approval status (defaults to pending so Admins can review it)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_applications');
    }
};
