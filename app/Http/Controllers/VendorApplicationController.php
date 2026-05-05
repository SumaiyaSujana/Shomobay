<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorApplication;

class VendorApplicationController extends Controller
{
    // 1. Show the Application Form
    public function showForm() {
        return view('vendor.register');
    }

    // 2. Handle the File Upload
    public function submitApplication(Request $request) {
        // Validate that they actually uploaded a safe file
        $request->validate([
            'business_name' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048', // Max 2MB
        ]);

        // Save the file into the 'storage/app/public/trade_licenses' folder
        $path = $request->file('document')->store('trade_licenses', 'public');

        // Save the record in the database
        VendorApplication::create([
            'business_name' => $request->business_name,
            'document_path' => $path,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Trade License uploaded successfully! Waiting for admin approval.');
    }
}