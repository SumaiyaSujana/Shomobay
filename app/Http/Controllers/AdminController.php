<?php

namespace App\Http\Controllers;
use App\Models\VendorApplication;
use Illuminate\Http\Request;
use App\Models\GroupCart;
use App\Models\Bid;

class AdminController extends Controller
{
    // 1. Show the Admin Dashboard with locked carts and their bids
public function dashboard() {
        // Fetch carts waiting for bids
        $lockedCarts = \App\Models\GroupCart::where('status', 'Locked (Ready for Bidding)')->get();
        
        // Fetch new vendor applications waiting for approval
        $applications = VendorApplication::where('status', 'Pending')->get();

        return view('admin.dashboard', compact('lockedCarts', 'applications'));
    }

    // Approve a vendor
    public function approveVendor($id) {
        $vendor = VendorApplication::findOrFail($id);
        $vendor->update(['status' => 'Approved']);
        return back()->with('success', $vendor->business_name . ' has been approved!');
    }

    // Reject a vendor
    public function rejectVendor($id) {
        $vendor = VendorApplication::findOrFail($id);
        $vendor->update(['status' => 'Rejected']);
        return back()->with('success', $vendor->business_name . ' has been rejected.');
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