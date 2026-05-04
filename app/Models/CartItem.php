<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // Whitelist the columns we want to save to the cart_items table
    protected $fillable = [
        'group_cart_id', 
        'neighbor_name', 
        'vegetable_name', 
        'weight_kg'
    ];
}