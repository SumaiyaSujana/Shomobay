<?php

namespace App\Http\Controllers;

use App\Models\GroupCart;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Vendor;
use App\Models\Neighbor;
use App\Models\Bid;

class AdminSystemHealthController extends Controller
{
    public function index()
    {
        $totalCarts = GroupCart::count();

        $activeCarts = GroupCart::where('status', 'active')->count();

        $completedCarts = GroupCart::where('status', 'completed')->count();

        $totalWalletBalance = Wallet::sum('balance');

        $totalTransactions = WalletTransaction::count();

        $totalVendors = Vendor::count();

        $totalNeighbors = Neighbor::count();

        $totalBids = Bid::count();

        return view('admin.system-health', compact(
            'totalCarts',
            'activeCarts',
            'completedCarts',
            'totalWalletBalance',
            'totalTransactions',
            'totalVendors',
            'totalNeighbors',
            'totalBids'
        ));
    }
}