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

    public function dashboard() {

        $activeCarts = [
            ['id' => 1, 'item' => 'Potatoes', 'targetWeight' => 50, 'currentWeight' => 50, 'status' => 'ready_for_bids'],
            ['id' => 2, 'item' => 'Onions', 'targetWeight' => 100, 'currentWeight' => 100, 'status' => 'ready_for_bids'],
        ];

        return view('vendor.dashboard', compact('activeCarts'));
    }


    public function submitBid(Request $request) {
        $request->validate([
            'cart_id' => 'required|integer',
            'bid_amount' => 'required|numeric|min:1',
        ]);

 
        return back()->with('success', 'Your bid of ৳' . $request->bid_amount . ' has been successfully placed!');
    }


    public function viewRevenueAnalytics() {
  
        $monthlyEarnings = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'data' => [5000, 7500, 6200, 9800, 12400]
        ];

        $popularItems = [
            'labels' => ['Potatoes', 'Onions', 'Tomatoes', 'Green Chilies'],
            'data' => [300, 250, 150, 80]
        ];

        return view('vendor.revenue-analytics', compact('monthlyEarnings', 'popularItems'));
    }

    public function viewRouteOptimization() {
   
        $deliveryStops = [
            ['name' => 'Farm/Warehouse (Start)', 'lat' => 23.8103, 'lng' => 90.4125],
            ['name' => 'Apartment A (Drop 1)', 'lat' => 23.7925, 'lng' => 90.4078],
            ['name' => 'Apartment B (Drop 2)', 'lat' => 23.7461, 'lng' => 90.3742]
        ];

        return view('vendor.route-optimization', compact('deliveryStops'));
    }
}

