<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_cart_id',
        'product_name',
        'base_price_per_kg',
        'current_price_per_kg',
    ];

    public function groupCart()
    {
        return $this->belongsTo(GroupCart::class);
    }

    public function contributions()
    {
        return $this->hasMany(CartContribution::class);
    }
}