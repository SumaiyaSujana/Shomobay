<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wallet_id');
            // Which wallet this transaction belongs to

            $table->enum('type', ['deposit', 'hold', 'release', 'deduct', 'refund']);
            // deposit  → user adds money to wallet
            // hold     → money locked into escrow when joining a cart
            // release  → escrow released to vendor after delivery
            // deduct   → final deduction from balance
            // refund   → money returned if cart threshold not met

            $table->unsignedBigInteger('amount_poisha');
            // Transaction amount in poisha

            $table->string('description')->nullable();
            // Human-readable note e.g. "Joined cart #3 for Potatoes"

            $table->unsignedBigInteger('cart_id')->nullable();
            // Which cart triggered this transaction (if applicable)

            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};