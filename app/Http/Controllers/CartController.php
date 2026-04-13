<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show the checkout test screen
    public function showCart() {
        return view('cart.checkout');
    }

    // THE THRESHOLD VALIDATOR LOGIC
    public function processCheckout(Request $request) {
        $currentWeight = $request->input('current_weight');
        $targetWeight = $request->input('target_weight');

        // Check if the group hit the minimum weight
        if ($currentWeight < $targetWeight) {
            return back()->with('error', 'Threshold Failed: The group cart must reach ' . $targetWeight . 'kg before checkout. You currently only have ' . $currentWeight . 'kg.');
        }

        // If they pass the threshold
        return back()->with('success', 'Threshold Met! The cart is now locked and open for Vendor Bidding.');
    }
}
