<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalityAlert extends Model
{
    protected $fillable = [
        'product_name',
        'area_name',
        'wholesale_price',
        'message',
        'status',
        'published_at',
    ];
}