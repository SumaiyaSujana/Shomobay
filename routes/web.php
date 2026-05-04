<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FinanceController;

Route::get('/', function () {
    return view('welcome');
});

// Vendor routes
Route::get('/vendor/verify', [VendorController::class, 'showVerificationForm']);
Route::post('/vendor/verify', [VendorController::class, 'submitVerification']);
Route::get('/vendor/dashboard', [VendorController::class, 'dashboard']);
Route::post('/vendor/bid', [VendorController::class, 'submitBid']);

// Cart routes
Route::get('/cart/checkout', [CartController::class, 'showCart']);
Route::post('/cart/checkout', [CartController::class, 'processCheckout']);

// Finance / Wallet routes
Route::get('/finance/wallet/{userId}', [FinanceController::class, 'showWallet']);
Route::post('/finance/deposit', [FinanceController::class, 'deposit']);
Route::post('/finance/hold', [FinanceController::class, 'holdForCart']);
Route::post('/finance/refund', [FinanceController::class, 'refundHeld']);
Route::post('/finance/split-bill', [FinanceController::class, 'calculateSplitBill']);
Route::post('/finance/create-wallet', [FinanceController::class, 'createWallet']);

Route::get('/vendor/revenue-analytics', [VendorController::class, 'viewRevenueAnalytics']);

Route::get('/vendor/route-optimization', [VendorController::class, 'viewRouteOptimization']);