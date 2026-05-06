<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model

class UserController extends Controller
{
    /**
     * Display the homepage with product cards.
     */
    public function index() 
    { 
        // 1. Ask the Database for all products (The 'M' in MVC)
        $products = Product::all(); 
        
        // 2. Pass the products to the welcome view (The 'V' in MVC)
        return view('welcome', compact('products')); 
    }

    // Note: Manual login(), register(), and logout() methods were removed 
    // because Laravel Breeze handles authentication automatically via auth.php!
}