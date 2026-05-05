<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorApplicationController; 
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
// --- NEW IMPORT FOR SPRINT 2 ---
use App\Models\Product; 

// Public Route: Updated to fetch real products from the database
Route::get('/', function () {
    $products = Product::all(); // This pulls everything from your new 'products' table
    return view('welcome', compact('products'));
});

// Default Breeze Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// SECURE ROUTES (Only logged-in users)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- YOUR SHOMOBAY ROUTES ---
    
    // Vendor Routes
    Route::get('/vendor/register', [VendorApplicationController::class, 'showForm']);
    Route::post('/vendor/register', [VendorApplicationController::class, 'submitApplication']);

    // ==========================================
    // ADMIN ONLY ROUTES (Protected by Bouncer)
    // ==========================================
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::post('/admin/vendor/{id}/approve', [AdminController::class, 'approveVendor']);
        Route::post('/admin/vendor/{id}/reject', [AdminController::class, 'rejectVendor']);
    });
});

require __DIR__.'/auth.php';