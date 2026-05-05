<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupCart;
use App\Models\Bid;

class AdminController extends Controller
{
    // 1. Show the Admin Dashboard with locked carts and their bids
    public function dashboard() {
        // Fetch locked carts and pull in their bids at the same time
        $lockedCarts = GroupCart::where('status', 'Locked (Ready for Bidding)')->with('bids')->get();
        return view('admin.dashboard', compact('lockedCarts'));
    }

    // 2. Accept a Bid and Close the Cart
    public function acceptBid($bidId) {
        $acceptedBid = Bid::findOrFail($bidId);
        $cart = GroupCart::findOrFail($acceptedBid->group_cart_id);

        // A. Mark this specific bid as Accepted
        $acceptedBid->status = 'Accepted';
        $acceptedBid->save();

        // B. Mark all OTHER bids for this cart as Rejected
        Bid::where('group_cart_id', $cart->id)
           ->where('id', '!=', $bidId)
           ->update(['status' => 'Rejected']);

        // C. Change the Cart status to Closed
        $cart->status = 'Closed (Order Placed)';
        $cart->save();

        return back()->with('success', "Bid from {$acceptedBid->vendor_name} accepted! The cart is now closed.");
    }
}