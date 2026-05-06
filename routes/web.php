<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorApplicationController;
use App\Models\VendorApplication;
use Illuminate\Support\Facades\Route;

// 1. Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. Dashboard
Route::get('/dashboard', function () {
    $applications = VendorApplication::all(); 
    $lockedCarts = collect(); 
    return view('admin.dashboard', compact('applications', 'lockedCarts'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Authenticated Routes
Route::middleware('auth')->group(function () {
    // Vendor Application
    Route::get('/vendor/register', [VendorApplicationController::class, 'showForm']);
    Route::post('/vendor/register', [VendorApplicationController::class, 'submitApplication']);

    // Approve/Reject Actions
    Route::post('/admin/vendor/{id}/approve', [VendorApplicationController::class, 'approve'])->name('admin.vendor.approve');
    Route::post('/admin/vendor/{id}/reject', [VendorApplicationController::class, 'reject'])->name('admin.vendor.reject');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';