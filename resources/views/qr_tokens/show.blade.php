<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Claim Token - Shomobay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-sm w-full text-center">

        {{-- Header --}}
        <h1 class="text-2xl font-bold text-green-700 mb-1">🛒 Shomobay</h1>
        <p class="text-gray-500 text-sm mb-6">Your delivery claim token</p>

        {{-- Order Summary --}}
        <div class="bg-green-50 rounded-xl p-4 mb-6 text-left">
            <p class="text-sm text-gray-500">Item</p>
            <p class="text-lg font-semibold text-gray-800">{{ $cartItem->vegetable_name }}</p>

            <p class="text-sm text-gray-500 mt-2">Quantity</p>
            <p class="text-lg font-semibold text-gray-800">{{ $cartItem->weight_kg }} kg</p>

            <p class="text-sm text-gray-500 mt-2">Neighbor</p>
            <p class="text-lg font-semibold text-gray-800">{{ $cartItem->neighbor_name }}</p>
        </div>

        {{-- QR Code --}}
        <div class="flex justify-center mb-4">
            {!! QrCode::size(200)->generate($token->token) !!}
        </div>

        {{-- Token string (small, for manual fallback) --}}
        <p class="text-xs text-gray-400 break-all mt-2">{{ $token->token }}</p>

        {{-- Claimed badge --}}
        @if($token->is_claimed)
            <div class="mt-4 bg-red-100 text-red-700 rounded-lg px-4 py-2 text-sm font-medium">
                ✅ Already claimed on {{ $token->claimed_at->format('d M Y, h:i A') }}
            </div>
        @else
            <div class="mt-4 bg-green-100 text-green-700 rounded-lg px-4 py-2 text-sm font-medium">
                ⏳ Not yet claimed — show this at the truck
            </div>
        @endif

    </div>

</body>
</html>