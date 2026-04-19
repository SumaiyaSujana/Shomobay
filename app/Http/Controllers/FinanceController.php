<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\WalletService;

class FinanceController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    // ─────────────────────────────────────────────
    // Show wallet dashboard for a user
    // ─────────────────────────────────────────────
    public function showWallet(int $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->firstOrFail();
        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('finance.wallet', compact('wallet', 'transactions'));
    }

    // ─────────────────────────────────────────────
    // Handle wallet top-up (simulated deposit)
    // ─────────────────────────────────────────────
    public function deposit(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|integer|exists:users,id',
            'amount_taka'  => 'required|numeric|min:1|max:100000',
        ]);

        $result = $this->walletService->deposit(
            $request->user_id,
            $request->amount_taka,
            'Manual wallet top-up'
        );

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    // ─────────────────────────────────────────────
    // Hold funds in escrow when joining a cart
    // Includes Minimum Contribution Limiter
    // ─────────────────────────────────────────────
    public function holdForCart(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|integer|exists:users,id',
            'cart_id'      => 'required|integer',
            'amount_taka'  => [
                'required',
                'numeric',
                'min:50',   // Minimum Contribution Limiter — 50 taka minimum
            ],
        ]);

        $result = $this->walletService->holdForCart(
            $request->user_id,
            $request->amount_taka,
            $request->cart_id
        );

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    // ─────────────────────────────────────────────
    // Refund held funds if cart threshold fails
    // ─────────────────────────────────────────────
    public function refundHeld(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|integer|exists:users,id',
            'cart_id'     => 'required|integer',
            'amount_taka' => 'required|numeric|min:1',
        ]);

        $result = $this->walletService->refundHeld(
            $request->user_id,
            $request->amount_taka,
            $request->cart_id
        );

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    // ─────────────────────────────────────────────
    // Split-Bill Calculator
    // ─────────────────────────────────────────────
    public function calculateSplitBill(Request $request)
    {
        $request->validate([
            'total_bill_taka'          => 'required|numeric|min:1',
            'contributions'            => 'required|array|min:1',
            'contributions.*.user_id'  => 'required|integer|exists:users,id',
            'contributions.*.weight_kg'=> 'required|numeric|min:0.1',
        ]);

        $splits = $this->walletService->calculateSplitBill(
            $request->total_bill_taka,
            $request->contributions
        );

        return view('finance.split_bill', compact('splits'));
    }

    // ─────────────────────────────────────────────
    // Create wallet for a new user (called on register)
    // ─────────────────────────────────────────────
    public function createWallet(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $wallet = $this->walletService->createWallet($request->user_id);

        return back()->with('success', 'Wallet created for user #' . $request->user_id);
    }
}