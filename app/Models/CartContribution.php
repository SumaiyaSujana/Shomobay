<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_cart_id',
        'cart_item_id',
        'user_id',
        'weight_requested',
        'calculated_cost',
    ];

    public function groupCart()
    {
        return $this->belongsTo(GroupCart::class);
    }

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}