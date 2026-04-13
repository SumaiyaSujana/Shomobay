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
// Show the Vendor Dashboard with active carts
    public function dashboard() {
        // In a real app, we would fetch carts from the database here.
        // For now, we will pass some dummy data to build the UI.
        $activeCarts = [
            ['id' => 1, 'item' => 'Potatoes', 'targetWeight' => 50, 'currentWeight' => 50, 'status' => 'ready_for_bids'],
            ['id' => 2, 'item' => 'Onions', 'targetWeight' => 100, 'currentWeight' => 100, 'status' => 'ready_for_bids'],
        ];

        return view('vendor.dashboard', compact('activeCarts'));
    }

    // Process the submitted bid
    public function submitBid(Request $request) {
        $request->validate([
            'cart_id' => 'required|integer',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        // Logic to save the bid to the database will go here.
        return back()->with('success', 'Your bid of ৳' . $request->bid_amount . ' has been successfully placed!');
    }



}

