<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Neighbor;
use App\Models\Vendor;
use App\Models\Admin;
use App\Models\GroupCart;
use App\Models\CartContribution;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
    public function neighbor()
    {
        return $this->hasOne(Neighbor::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function createdGroupCarts()
    {
        return $this->hasMany(GroupCart::class, 'creator_id');
    }

    public function cartContributions()
    {
        return $this->hasMany(CartContribution::class);
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}