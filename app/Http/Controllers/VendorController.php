<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\GroupCart; // Add this
use App\Models\Bid;       // Add this

class VendorController extends Controller
{
    // --- SPRINT 3, FEATURE 1: VENDOR VERIFICATION ---
    public function showVerificationPortal() {
        return view('vendor.verify');
    }

    public function uploadLicense(Request $request) {
        $request->validate([
            'businessName' => 'required|string|max:255',
            'tradeLicenseFile' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $fileName = time() . '_' . $request->file('tradeLicenseFile')->getClientOriginalName();
        $request->file('tradeLicenseFile')->storeAs('uploads/licenses', $fileName, 'public');

        Vendor::create([
            'businessName' => $request->businessName,
            'tradeLicenseFile' => $fileName,
            'isVerified' => false 
        ]);

        return back()->with('success', 'Trade License uploaded successfully! Waiting for admin approval.');
    }

    // --- SPRINT 3, FEATURE 2: WHOLESALER BIDDING DASHBOARD ---
    
    // 1. Show the Dashboard with "Locked" Carts
    public function dashboard() {
        // Only fetch carts that reached their target weight and are locked
        $lockedCarts = GroupCart::where('status', 'Locked (Ready for Bidding)')->get();
        return view('vendor.dashboard', compact('lockedCarts'));
    }

    // 2. Submit a Bid to the Database
    public function submitBid(Request $request) {
        $request->validate([
            'group_cart_id' => 'required|exists:group_carts,id',
            'vendor_name' => 'required|string',
            'price_per_kg' => 'required|numeric|min:1'
        ]);

        Bid::create([
            'group_cart_id' => $request->group_cart_id,
            'vendor_name' => $request->vendor_name,
            'price_per_kg' => $request->price_per_kg,
            'status' => 'Pending' // Bid waits for neighborhood approval
        ]);

        return back()->with('success', 'Your bid has been submitted successfully!');
    }
}