<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function triggerAutomatedRefund() {
        
        $coordinatorOriginalBill = 1000; // Mock ৳ amount
        $discountAmount = $coordinatorOriginalBill * 0.05; // 5% discount
        $coordinatorFinalBill = $coordinatorOriginalBill - $discountAmount;

     
        $cartStatus = "Threshold Failed (< 50kg)";
        $refundQueue = [
            ['neighbor' => 'Apartment 4A', 'amount' => 1200, 'status' => 'Refunded to Escrow Wallet'],
            ['neighbor' => 'Apartment 2B', 'amount' => 850, 'status' => 'Refunded to Escrow Wallet'],
            ['neighbor' => 'Apartment 5C', 'amount' => 400, 'status' => 'Refunded to Escrow Wallet']
        ];

        return view('transaction.automated-refunds', compact(
            'coordinatorOriginalBill', 
            'discountAmount', 
            'coordinatorFinalBill', 
            'cartStatus', 
            'refundQueue'
        ));
    }
}