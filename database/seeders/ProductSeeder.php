<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    \App\Models\Product::create([
        'name' => 'Premium Potatoes',
        'price_per_kg' => 45.00,
        'target_weight_kg' => 50.00,
        'current_weight_kg' => 30.00,
        'emoji_icon' => '🥔'
    ]);

    \App\Models\Product::create([
        'name' => 'Local Onions',
        'price_per_kg' => 80.00,
        'target_weight_kg' => 100.00,
        'current_weight_kg' => 85.00,
        'emoji_icon' => '🧅'
    ]);
}