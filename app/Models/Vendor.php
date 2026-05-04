<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    // Allowing these fields to be filled based on your UML diagram
    protected $fillable = [
        'businessName', 
        'tradeLicenseFile', 
        'isVerified'
    ];
}