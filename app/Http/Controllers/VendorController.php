<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    // 1. Show the Vendor Verification Portal View
    public function showVerificationPortal() {
        return view('vendor.verify');
    }

    // 2. Handle the Trade License File Upload
    public function uploadLicense(Request $request) {
        // Validate that they provided a name and a valid file (PDF or Image)
        $request->validate([
            'businessName' => 'required|string|max:255',
            'tradeLicenseFile' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);

        // Create a unique file name and save it to the public/uploads folder
        $fileName = time() . '_' . $request->file('tradeLicenseFile')->getClientOriginalName();
        $request->file('tradeLicenseFile')->storeAs('uploads/licenses', $fileName, 'public');

        // Save the Vendor to the database
        Vendor::create([
            'businessName' => $request->businessName,
            'tradeLicenseFile' => $fileName,
            'isVerified' => false // Set to false because Admin must approve it later!
        ]);

        return back()->with('success', 'Trade License uploaded successfully! Waiting for admin approval.');
    }
}