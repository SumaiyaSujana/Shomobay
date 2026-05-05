<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorApplication extends Model
{
    use HasFactory;

    // Tell Laravel it is safe to auto-fill these columns
    protected $fillable = [
        'business_name',
        'document_path',
        'status'
    ];
}