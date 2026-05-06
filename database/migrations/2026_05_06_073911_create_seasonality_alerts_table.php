<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasonality_alerts', function (Blueprint $table) {
           $table->id();
           $table->string('product_name');
           $table->string('area_name')->nullable();
           $table->decimal('wholesale_price', 8, 2);
           $table->text('message');
           $table->enum('status', ['draft', 'published'])->default('draft');
           $table->timestamp('published_at')->nullable();
           $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('seasonality_alerts');
    }
};
