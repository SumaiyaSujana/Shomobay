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

// Cart Threshold Validator
Route::get('/cart/checkout', [CartController::class, 'showCart']);
Route::post('/cart/checkout', [CartController::class, 'processCheckout']);

// Cart Manager Routes
Route::post('/cart/create', [CartController::class, 'createCart']);
Route::post('/cart/add-item', [CartController::class, 'addItem']);
Route::post('/cart/add-contribution', [CartController::class, 'addContribution']);

// ---------- TEST PAGES ----------

// Test: Create Cart
Route::get('/cart/test-create', function () {
    return '
        <form method="POST" action="/cart/create">
            '.csrf_field().'
            <label>Building Name:</label><br>
            <input type="text" name="building_name"><br><br>

            <label>Target Weight:</label><br>
            <input type="number" name="target_weight" step="0.01"><br><br>

            <label>Expires At:</label><br>
            <input type="datetime-local" name="expires_at"><br><br>

            <button type="submit">Create Cart</button>
        </form>
    ';
});

// Test: Add Item
Route::get('/cart/test-add-item', function () {
    return '
        <form method="POST" action="/cart/add-item">
            '.csrf_field().'
            <label>Cart ID:</label><br>
            <input type="number" name="group_cart_id"><br><br>

            <label>Product Name:</label><br>
            <input type="text" name="product_name"><br><br>

            <label>Base Price per KG:</label><br>
            <input type="number" name="base_price_per_kg" step="0.01"><br><br>

            <button type="submit">Add Item</button>
        </form>
    ';
});

// Test: Add Contribution
Route::get('/cart/test-add-contribution', function () {
    return '
        <form method="POST" action="/cart/add-contribution">
            '.csrf_field().'
            <label>Cart ID:</label><br>
            <input type="number" name="group_cart_id"><br><br>

            <label>Cart Item ID:</label><br>
            <input type="number" name="cart_item_id"><br><br>

            <label>Weight Requested (kg):</label><br>
            <input type="number" name="weight_requested" step="0.01"><br><br>

            <button type="submit">Add Contribution</button>
        </form>
    ';
});

Route::get('/cart/manager', function () {
    return view('cart.manager');
});
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
