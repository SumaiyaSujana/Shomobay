<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\VendorController;

Route::get('/vendor/verify', [VendorController::class, 'showVerificationForm']);
Route::post('/vendor/verify', [VendorController::class, 'submitVerification']);

Route::get('/vendor/dashboard', [VendorController::class, 'dashboard']);
Route::post('/vendor/bid', [VendorController::class, 'submitBid']);

// Shomobay Sprint 3: Cart Threshold Validator Routes
use App\Http\Controllers\CartController;

Route::get('/cart/checkout', [CartController::class, 'showCart']);
Route::post('/cart/checkout', [CartController::class, 'processCheckout']);