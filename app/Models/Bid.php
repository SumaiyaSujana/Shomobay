<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    // Allow these fields to be saved to the database
    protected $fillable = [
        'group_cart_id', 
        'vendor_name', 
        'price_per_kg', 
        'status'
    ];
}