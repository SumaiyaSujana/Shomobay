<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryToken extends Model
{
    protected $fillable = [
        'user_id',
        'cart_item_id',
        'token',
        'is_claimed',
        'claimed_at',
    ];

    protected $casts = [
        'is_claimed'  => 'boolean',
        'claimed_at'  => 'datetime',
    ];

    // A token belongs to one user (the neighbor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A token belongs to one cart item (vegetable + weight)
    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }
}