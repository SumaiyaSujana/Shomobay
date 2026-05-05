<!DOCTYPE html>
<html>
<head>
    <title>Neighborhood Group Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Neighborhood Cart: {{ $cart->neighborhood_name }}</h2>
        
        <div class="bg-blue-50 p-4 rounded border border-blue-200 mb-6">
            <p class="text-lg"><strong>Target Weight:</strong> {{ $cart->target_weight_kg }} kg</p>
            <p class="text-lg text-blue-700"><strong>Current Weight:</strong> {{ $cart->current_weight_kg }} kg</p>
            
            @if($cart->status == 'Open')
                <p class="text-lg font-bold mt-2 text-green-600">Status: Open ✅</p>
            @elseif($cart->status == 'Locked (Ready for Bidding)')
                <p class="text-lg font-bold mt-2 text-red-600">Status: {{ $cart->status }} 🔒</p>
            @else
                <p class="text-lg font-bold mt-2 text-purple-600">Status: {{ $cart->status }} 📦</p>
            @endif
        </div>

        @if($cart->status == 'Closed (Order Placed)' && isset($acceptedBid))
            <div class="bg-green-100 border-l-4 border-green-500 p-6 mb-6 shadow-sm rounded-r-lg">
                <h3 class="text-2xl font-bold text-green-800 mb-2">🎉 Deal Closed!</h3>
                <p class="text-lg text-green-800">The winning wholesaler is <strong>{{ $acceptedBid->vendor_name }}</strong>.</p>
                <p class="text-lg text-green-800">The final locked-in price is <strong>৳{{ number_format($acceptedBid->price_per_kg, 2) }} / kg</strong>!</p>
            </div>
        @else
            <div class="bg-yellow-50 p-6 rounded-lg border-2 border-yellow-400 mb-6 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-yellow-800 mb-1">Dynamic Price Calculator 📉</h3>
                        <p class="text-gray-700">The more your neighborhood buys, the cheaper it gets!</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg text-gray-500 line-through">Base: ৳{{ $basePricePerKg }}/kg</p>
                        <p class="text-3xl font-extrabold text-green-600">Current: ৳{{ $currentPricePerKg }}/kg</p>
                    </div>
                </div>
            </div>
        @endif

        @if($cart->status == 'Open')
            <form action="/cart/add" method="POST" class="mb-8 bg-gray-50 p-4 rounded border">
                @csrf
                <h3 class="text-xl font-bold mb-4">Add Your Groceries</h3>
                <div class="flex gap-4">
                    <input type="text" name="vegetable_name" placeholder="E.g., Potatoes" required class="border p-2 rounded w-full">
                    <input type="number" name="weight_kg" placeholder="Weight (kg)" required min="1" class="border p-2 rounded w-1/3">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 font-bold">Add to Cart</button>
                </div>
            </form>
        @elseif($cart->status == 'Locked (Ready for Bidding)')
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                <p class="font-bold">Cart is Locked!</p>
                <p>This neighborhood has reached its 50kg goal. We are now accepting bids from wholesalers.</p>
            </div>
        @endif

        <h3 class="text-xl font-bold mb-4 mt-8 text-gray-800">Automated Split-Bill 🧾</h3>
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-left border-collapse bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b border-gray-200">
                        <th class="p-4 font-semibold">Neighbor</th>
                        <th class="p-4 font-semibold">Item</th>
                        <th class="p-4 font-semibold">Weight</th>
                        <th class="p-4 font-semibold text-right">Total Owed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4"><strong>{{ $item->neighbor_name }}</strong></td>
                            <td class="p-4 text-gray-600">{{ $item->vegetable_name }}</td>
                            <td class="p-4 text-gray-600">{{ $item->weight_kg }} kg</td>
                            <td class="p-4 text-right font-bold {{ $cart->status == 'Closed (Order Placed)' ? 'text-green-600' : 'text-red-600' }}">
                                ৳{{ number_format($item->weight_kg * $currentPricePerKg, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">No items added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>