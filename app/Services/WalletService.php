<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletService
{
    // ── Create a wallet for a new user ──────────────────
    public function createWallet(int $userId): Wallet
    {
        return Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance_poisha' => 0, 'held_poisha' => 0]
        );
    }

    // ── Deposit money into wallet ────────────────────────
    public function deposit(int $userId, float $amountTaka, string $description = 'Deposit'): array
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return ['success' => false, 'message' => 'Wallet not found for this user.'];
        }

        $amountPoisha = (int) round($amountTaka * 100);

        $wallet->balance_poisha += $amountPoisha;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id'     => $wallet->id,
            'type'          => 'deposit',
            'amount_poisha' => $amountPoisha,
            'description'   => $description,
            'cart_id'       => null,
        ]);

        return [
            'success' => true,
            'message' => '৳' . number_format($amountTaka, 2) . ' has been added to your wallet.',
        ];
    }

    // ── Hold funds in escrow when joining a cart ─────────
    public function holdForCart(int $userId, float $amountTaka, int $cartId): array
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return ['success' => false, 'message' => 'Wallet not found.'];
        }

        $amountPoisha = (int) round($amountTaka * 100);

        // Minimum Contribution Limiter (50 taka = 5000 poisha)
        if ($amountPoisha < 5000) {
            return ['success' => false, 'message' => 'Minimum contribution is ৳50.00.'];
        }

        // Check available balance
        if ($wallet->availableBalance() < $amountPoisha) {
            return ['success' => false, 'message' => 'Insufficient available balance.'];
        }

        $wallet->held_poisha += $amountPoisha;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id'     => $wallet->id,
            'type'          => 'hold',
            'amount_poisha' => $amountPoisha,
            'description'   => 'Funds locked for Cart #' . $cartId,
            'cart_id'       => $cartId,
        ]);

        return [
            'success' => true,
            'message' => '৳' . number_format($amountTaka, 2) . ' locked into escrow for Cart #' . $cartId . '.',
        ];
    }

    // ── Refund held funds if cart threshold fails ─────────
    public function refundHeld(int $userId, float $amountTaka, int $cartId): array
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return ['success' => false, 'message' => 'Wallet not found.'];
        }

        $amountPoisha = (int) round($amountTaka * 100);

        if ($wallet->held_poisha < $amountPoisha) {
            return ['success' => false, 'message' => 'Held amount is less than the refund requested.'];
        }

        $wallet->held_poisha -= $amountPoisha;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id'     => $wallet->id,
            'type'          => 'refund',
            'amount_poisha' => $amountPoisha,
            'description'   => 'Refund — Cart #' . $cartId . ' did not meet threshold.',
            'cart_id'       => $cartId,
        ]);

        return [
            'success' => true,
            'message' => '৳' . number_format($amountTaka, 2) . ' has been refunded to your wallet.',
        ];
    }

    // ── Split-Bill Calculator ─────────────────────────────
    // $contributions = [['user_id' => 1, 'weight_kg' => 5.5], ...]
    public function calculateSplitBill(float $totalBillTaka, array $contributions): array
    {
        $totalBillPoisha = (int) round($totalBillTaka * 100);
        $totalWeight     = array_sum(array_column($contributions, 'weight_kg'));

        if ($totalWeight <= 0) {
            return [];
        }

        $splits = [];
        $allocatedPoisha = 0;

        foreach ($contributions as $index => $c) {
            $isLast = ($index === array_key_last($contributions));

            if ($isLast) {
                // Give the last person the remainder to avoid rounding loss
                $owesPoisha = $totalBillPoisha - $allocatedPoisha;
            } else {
                $owesPoisha = (int) round(($c['weight_kg'] / $totalWeight) * $totalBillPoisha);
                $allocatedPoisha += $owesPoisha;
            }

            $splits[] = [
                'user_id'    => $c['user_id'],
                'weight_kg'  => $c['weight_kg'],
                'owes_taka'  => intdiv($owesPoisha, 100),
                'owes_poisha'=> $owesPoisha % 100,
            ];
        }

        return $splits;
    }
}