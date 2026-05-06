<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\DeliveryToken;
use App\Services\QrTokenService;
use Illuminate\Http\Request;

class QrTokenController extends Controller
{
    public function __construct(protected QrTokenService $qrTokenService)
    {
        // Laravel auto-injects QrTokenService here
    }

    /**
     * Generate a QR token for a specific cart item.
     * Shows the neighbor their personal QR code page.
     */
    public function show(int $cartItemId)
    {
        $cartItem = CartItem::with('deliveryToken')->findOrFail($cartItemId);

        // Hardcoded user_id = 1 for now (replace with Auth::id() when auth is set up)
        $userId = 1;

        $token = $this->qrTokenService->generateToken($userId, $cartItemId);

        return view('qr_tokens.show', compact('token', 'cartItem'));
    }

    /**
     * Show the scanner page (delivery coordinator uses this).
     */
    public function scannerPage()
    {
        return view('qr_tokens.scanner');
    }

    /**
     * Handle the scanned QR token string and mark it as claimed.
     */
    public function claim(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $token = $this->qrTokenService->claimToken($request->input('token'));

        if (! $token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token or already claimed.',
            ], 422);
        }

        return response()->json([
            'success'      => true,
            'message'      => 'Claimed successfully!',
            'neighbor'     => $token->user->name,
            'vegetable'    => $token->cartItem->vegetable_name,
            'weight_kg'    => $token->cartItem->weight_kg,
            'claimed_at'   => $token->claimed_at->format('d M Y, h:i A'),
        ]);
    }
}