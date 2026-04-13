<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\VendorController;

Route::get('/vendor/verify', [VendorController::class, 'showVerificationForm']);
Route::post('/vendor/verify', [VendorController::class, 'submitVerification']);