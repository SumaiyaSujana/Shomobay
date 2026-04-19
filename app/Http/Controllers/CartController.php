<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupCart;
use App\Models\CartItem;
use App\Models\CartContribution;

class CartController extends Controller
{
    public function showCart()
    {
        return view('cart.checkout');
    }

    public function processCheckout(Request $request)
    {
        $currentWeight = $request->input('current_weight');
        $targetWeight = $request->input('target_weight');

        if ($currentWeight < $targetWeight) {
            return back()->with(
                'error',
                'Threshold Failed: The group cart must reach ' . $targetWeight . 'kg before checkout. You currently only have ' . $currentWeight . 'kg.'
            );
        }

        return back()->with('success', 'Threshold Met! The cart is now locked and open for Vendor Bidding.');
    }

    public function createCart(Request $request)
    {
        $request->validate([
            'building_name' => 'required|string|max:255',
            'target_weight' => 'required|numeric|min:1',
            'expires_at' => 'required|date|after:now',
        ]);

        $cart = GroupCart::create([
            'creator_id' => 1,
            'building_name' => $request->building_name,
            'target_weight' => $request->target_weight,
            'current_weight' => 0,
            'expires_at' => $request->expires_at,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Cart created successfully',
            'cart' => $cart,
        ]);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'group_cart_id' => 'required|exists:group_carts,id',
            'product_name' => 'required|string|max:255',
            'base_price_per_kg' => 'required|numeric|min:1',
        ]);

        $groupCart = GroupCart::findOrFail($request->group_cart_id);

        if ($groupCart->status !== 'active') {
            return response()->json([
                'message' => 'Items cannot be added because this cart is not active.',
            ], 400);
        }

        $item = CartItem::create([
            'group_cart_id' => $request->group_cart_id,
            'product_name' => $request->product_name,
            'base_price_per_kg' => $request->base_price_per_kg,
            'current_price_per_kg' => $request->base_price_per_kg,
        ]);

        return response()->json([
            'message' => 'Item added to cart',
            'item' => $item,
        ]);
    }

    public function addContribution(Request $request)
    {
        $request->validate([
            'group_cart_id' => 'required|exists:group_carts,id',
            'cart_item_id' => 'required|exists:cart_items,id',
            'weight_requested' => 'required|numeric|min:0.5',
        ]);

        $groupCart = GroupCart::findOrFail($request->group_cart_id);

        // Expiry check
        if (now()->greaterThan($groupCart->expires_at)) {
            $groupCart->status = 'expired';
            $groupCart->save();

            return response()->json([
                'message' => 'This cart has already expired.',
                'cart_status' => $groupCart->status,
            ], 400);
        }

        // Already locked check
        if ($groupCart->current_weight >= $groupCart->target_weight) {
            $groupCart->status = 'locked';
            $groupCart->save();

            return response()->json([
                'message' => 'This cart is already locked because the target weight has been reached.',
                'cart_status' => $groupCart->status,
            ], 400);
        }

        // 🔴 IMPORTANT: Overshoot protection (THIS is where your code goes)
        if ($groupCart->current_weight + $request->weight_requested > $groupCart->target_weight) {
            return response()->json([
                'message' => 'This contribution exceeds the target weight limit.',
                'remaining_allowed' => $groupCart->target_weight - $groupCart->current_weight
            ], 400);
        }

        $item = CartItem::findOrFail($request->cart_item_id);

        $calculatedCost = $request->weight_requested * $item->current_price_per_kg;

        $contribution = CartContribution::create([
            'group_cart_id' => $request->group_cart_id,
            'cart_item_id' => $request->cart_item_id,
            'user_id' => 1,
            'weight_requested' => $request->weight_requested,
            'calculated_cost' => $calculatedCost,
        ]);

        $groupCart->current_weight += $request->weight_requested;

        // Lock if target reached exactly
        if ($groupCart->current_weight >= $groupCart->target_weight) {
            $groupCart->status = 'locked';
        }

        $groupCart->save();

        $this->recalculateCartPrices($groupCart);

        return response()->json([
            'message' => 'Contribution added successfully',
            'contribution' => $contribution,
            'updated_cart_weight' => $groupCart->current_weight,
            'cart_status' => $groupCart->status,
            'updated_items' => $groupCart->items()->get(),
        ]);
    }

    private function recalculateCartPrices(GroupCart $groupCart)
    {
        $discountSteps = floor($groupCart->current_weight / 10);
        $discountPerStep = 2;
        $minimumPrice = 40;

        foreach ($groupCart->items as $item) {
            $newPrice = $item->base_price_per_kg - ($discountSteps * $discountPerStep);

            if ($newPrice < $minimumPrice) {
                $newPrice = $minimumPrice;
            }

            $item->current_price_per_kg = $newPrice;
            $item->save();
        }
    }
}