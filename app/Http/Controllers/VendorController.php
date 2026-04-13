<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VendorController extends Controller
{
    
    public function showVerificationForm() {
        return view('vendor.verify');
    }

    
    public function submitVerification(Request $request) {
        
        $request->validate([
            'trade_license' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->file('trade_license')->store('licenses', 'public');


        return back()->with('success', 'Your trade license has been uploaded for Admin review!');
    }
}