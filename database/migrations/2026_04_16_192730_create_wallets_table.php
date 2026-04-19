<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->unique();
            // Each user has exactly one wallet

            $table->unsignedBigInteger('balance_poisha')->default(0);
            // Balance stored in poisha (1 taka = 100 poisha)
            // NEVER store money as float — integer only

            $table->unsignedBigInteger('held_poisha')->default(0);
            // Amount currently locked in escrow for active carts

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};