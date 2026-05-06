<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorApplication extends Model
{
    use HasFactory;

    // Added business_name and user_id to the fillable array
    protected $fillable = [
        'user_id',
        'business_name', 
        'document_path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}