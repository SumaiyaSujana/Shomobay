<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // This allows you to safely insert data into these columns
    protected $fillable = [
        'name',
        'price_per_kg',
        'target_weight_kg',
        'current_weight_kg',
        'emoji_icon',
    ];
}