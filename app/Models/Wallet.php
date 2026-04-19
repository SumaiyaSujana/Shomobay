<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance_poisha',
        'held_poisha',
    ];

    // A wallet belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A wallet has many transactions
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // Helper: get available balance (total minus held)
    public function availableBalance(): int
    {
        return $this->balance_poisha - $this->held_poisha;
    }

    // Helper: convert poisha to taka for display
    public function balanceInTaka(): string
    {
        return number_format($this->balance_poisha / 100, 2);
    }

    public function heldInTaka(): string
    {
        return number_format($this->held_poisha / 100, 2);
    }

    public function availableInTaka(): string
    {
        return number_format($this->availableBalance() / 100, 2);
    }
}