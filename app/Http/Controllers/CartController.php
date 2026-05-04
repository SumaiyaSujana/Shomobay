<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupCart;
use App\Models\CartItem;

class CartController extends Controller
{
    // 1. Show the Cart Page
    public function viewCart() {
        // Find the first open cart, or create a dummy one for the neighborhood if none exist
        $cart = GroupCart::firstOrCreate(
            ['status' => 'Open'],
            ['neighborhood_name' => 'Bashundhara R/A', 'target_weight_kg' => 50.00, 'current_weight_kg' => 0]
        );

        // Fetch all real items from the database tied to this cart
        $items = CartItem::where('group_cart_id', $cart->id)->get();

        return view('cart.index', compact('cart', 'items'));
    }

    // 2. The Group Cart Engine & Threshold Validator
    public function addToCart(Request $request) {
        // Validate the form input
        $request->validate([
            'vegetable_name' => 'required|string',
            'weight_kg' => 'required|numeric|min:1'
        ]);

        $cart = GroupCart::where('status', 'Open')->first();

        // Save the real item to the database
        CartItem::create([
            'group_cart_id' => $cart->id,
            'neighbor_name' => 'Apartment ' . rand(1, 10) . 'A', // Simulating different neighbors adding items
            'vegetable_name' => $request->vegetable_name,
            'weight_kg' => $request->weight_kg
        ]);

        // Update the Cart's Current Weight
        $cart->current_weight_kg += $request->weight_kg;

        // --- SPRINT 2 THRESHOLD VALIDATOR LOGIC ---
        // If the cart hits the target weight (e.g. 50kg), lock it for bidding!
        if ($cart->current_weight_kg >= $cart->target_weight_kg) {
            $cart->status = 'Locked (Ready for Bidding)';
        }

        // Save changes to the MySQL database
        $cart->save();

        return redirect()->back();
    }
}