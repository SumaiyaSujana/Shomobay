<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupCart;
use App\Models\CartItem;

class CartController extends Controller
{
    // 1. Show the Cart Page & Run Price Calculator
// 1. Show the Cart Page & Run Price Calculator
    public function viewCart() {
        // Find the latest cart regardless of if it is Open or Locked
        $cart = GroupCart::latest()->first();

        // If no cart exists at all, create the very first one
        if (!$cart) {
            $cart = GroupCart::create([
                'neighborhood_name' => 'Bashundhara R/A', 
                'target_weight_kg' => 50.00, 
                'current_weight_kg' => 0,
                'status' => 'Open'
            ]);
        }

        $items = CartItem::where('group_cart_id', $cart->id)->get();

        // --- SPRINT 1: DYNAMIC PRICE-DROP CALCULATOR LOGIC ---
        $basePricePerKg = 100; 
        $discountLevels = floor($cart->current_weight_kg / 5); 
        $discountAmount = $discountLevels * 2; 
        $currentPricePerKg = max(60, $basePricePerKg - $discountAmount);

        return view('cart.index', compact('cart', 'items', 'basePricePerKg', 'currentPricePerKg'));
    }

    // 2. The Group Cart Engine & Threshold Validator
    public function addToCart(Request $request) {
        $request->validate([
            'vegetable_name' => 'required|string',
            'weight_kg' => 'required|numeric|min:1'
        ]);

        $cart = GroupCart::where('status', 'Open')->first();

        CartItem::create([
            'group_cart_id' => $cart->id,
            'neighbor_name' => 'Apartment ' . rand(1, 10) . 'A', 
            'vegetable_name' => $request->vegetable_name,
            'weight_kg' => $request->weight_kg
        ]);

        $cart->current_weight_kg += $request->weight_kg;

        if ($cart->current_weight_kg >= $cart->target_weight_kg) {
            $cart->status = 'Locked (Ready for Bidding)';
        }

        $cart->save();

        return redirect()->back();
    }
}