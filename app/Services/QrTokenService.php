<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\DeliveryToken;
use Illuminate\Support\Str;

class QrTokenService
{
    /**
     * Generate a unique QR token for a given user and cart item.
     * Safe to call multiple times — won't create duplicates.
     */
    public function generateToken(int $userId, int $cartItemId): DeliveryToken
    {
        // If a token already exists for this user+item, return it
        $existing = DeliveryToken::where('user_id', $userId)
            ->where('cart_item_id', $cartItemId)
            ->first();

        if ($existing) {
            return $existing;
        }

        return DeliveryToken::create([
            'user_id'      => $userId,
            'cart_item_id' => $cartItemId,
            'token'        => Str::uuid()->toString(),
            'is_claimed'   => false,
            'claimed_at'   => null,
        ]);
    }

    /**
     * Scan and claim a token by its UUID string.
     * Returns the token if valid and unclaimed.
     * Returns null if invalid or already claimed.
     */
    public function claimToken(string $tokenString): ?DeliveryToken
    {
        $token = DeliveryToken::where('token', $tokenString)
            ->with(['user', 'cartItem'])
            ->first();

        // Token not found
        if (! $token) {
            return null;
        }

        // Already claimed — do not allow double-claiming
        if ($token->is_claimed) {
            return null;
        }

        // Mark as claimed
        $token->update([
            'is_claimed' => true,
            'claimed_at' => now(),
        ]);

        return $token;
    }
}