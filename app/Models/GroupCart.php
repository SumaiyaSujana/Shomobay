<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'building_name',
        'target_weight',
        'current_weight',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function contributions()
    {
        return $this->hasMany(CartContribution::class);
    }
}