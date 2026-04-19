<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount_poisha',
        'description',
        'cart_id',
    ];

    // A transaction belongs to one wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // Helper: convert poisha to taka for display
    public function amountInTaka(): string
    {
        return number_format($this->amount_poisha / 100, 2);
    }
}