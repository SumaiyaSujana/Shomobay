<!DOCTYPE html>
<html>
<head>
    <title>Discounts & Refunds</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Delivery Coordinator Discount</h2>
        <p class="text-gray-600 mb-4">The coordinator receives a 5% discount for managing the delivery drop-off.</p>
        
        <div class="bg-green-50 p-4 rounded border border-green-200">
            <p><strong>Original Bill:</strong> ৳{{ $coordinatorOriginalBill }}</p>
            <p class="text-green-600"><strong>5% Discount Applied:</strong> -৳{{ $discountAmount }}</p>
            <p class="text-xl font-bold mt-2">Final Bill: ৳{{ $coordinatorFinalBill }}</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-red-600">Automated Escrow Refunds</h2>
        <p class="text-gray-600 mb-4">Cart Status: <span class="font-bold">{{ $cartStatus }}</span>. Processing automated refunds to wallets.</p>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-3 border-b">Neighbor</th>
                    <th class="p-3 border-b">Refund Amount</th>
                    <th class="p-3 border-b">Wallet Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($refundQueue as $refund)
                <tr class="border-b">
                    <td class="p-3">{{ $refund['neighbor'] }}</td>
                    <td class="p-3 font-bold text-red-500">৳{{ $refund['amount'] }}</td>
                    <td class="p-3 text-green-600 font-semibold">✅ {{ $refund['status'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>