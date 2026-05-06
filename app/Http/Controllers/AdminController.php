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
        // Fetch carts waiting for bids (Leaving your cart logic exactly as is!)
        $lockedCarts = GroupCart::where('status', 'Locked (Ready for Bidding)')->get();
        
        // Fetch new vendor applications waiting for approval (using lowercase 'pending' and loading user data)
        $applications = VendorApplication::with('user')->where('status', 'pending')->get();

        return view('admin.dashboard', compact('lockedCarts', 'applications'));
    }

    // Approve a vendor
    public function approveVendor($id) {
        $application = VendorApplication::findOrFail($id);
        
        // 1. Mark the application as approved
        $application->update(['status' => 'approved']);

        // 2. MAGIC: Upgrade the regular user's role to 'vendor' so they can access the bidding portal!
        $application->user->update(['role' => 'vendor']);

        // 3. Return success using the linked user's name (since business_name was removed)
        return back()->with('success', $application->user->name . ' has been approved as a Vendor!');
    }

    // Reject a vendor
    public function rejectVendor($id) {
        $application = VendorApplication::findOrFail($id);
        
        // Mark as rejected
        $application->update(['status' => 'rejected']);
        
        return back()->with('success', $application->user->name . '\'s application has been rejected.');
    }

    // 2. Accept a Bid and Close the Cart
    // (I am leaving this exactly as you wrote it so your future Bidding task is safe!)
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