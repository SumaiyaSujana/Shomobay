<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCart extends Model
{
    // Whitelist the columns we want to save to the group_carts table
    protected $fillable = [
        'neighborhood_name', 
        'target_weight_kg', 
        'current_weight_kg', 
        'status'
    ];
}