<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;

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

Route::get('/transaction/refunds', [TransactionController::class, 'triggerAutomatedRefund']);

Route::get('/cart', [CartController::class, 'viewCart']);
Route::post('/cart/add', [CartController::class, 'addToCart']);

// Sprint 3: Vendor Portal Routes
Route::get('/vendor/verify', [VendorController::class, 'showVerificationPortal']);
Route::post('/vendor/verify', [VendorController::class, 'uploadLicense']);

// Sprint 3: Wholesaler Bidding Dashboard
Route::get('/vendor/dashboard', [VendorController::class, 'dashboard']);
Route::post('/vendor/bid', [VendorController::class, 'submitBid']);

// Sprint 3: Admin Approval Panel
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::post('/admin/accept-bid/{id}', [AdminController::class, 'acceptBid']);