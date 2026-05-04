<!DOCTYPE html>
<html>
<head>
    <title>Vendor Bidding Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Wholesaler Bidding Dashboard 🚚</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if($lockedCarts->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow-md text-center border-t-4 border-yellow-400">
                <h3 class="text-xl text-gray-700 font-bold mb-2">No Locked Carts Available</h3>
                <p class="text-gray-500">Wait for neighborhoods to finish their grocery shopping and lock their carts. Check back later!</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($lockedCarts as $cart)
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500 flex justify-between items-center">
                        
                        <div>
                            <h3 class="text-2xl font-bold text-blue-800">{{ $cart->neighborhood_name }}</h3>
                            <p class="text-gray-600 mt-1"><strong>Total Weight Required:</strong> {{ $cart->target_weight_kg }} kg</p>
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 rounded-full uppercase font-semibold tracking-wide mt-2">
                                {{ $cart->status }}
                            </span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded border border-gray-200">
                            <form action="/vendor/bid" method="POST" class="flex flex-col gap-3">
                                @csrf
                                <input type="hidden" name="group_cart_id" value="{{ $cart->id }}">
                                
                                <input type="text" name="vendor_name" placeholder="Your Business Name" required class="border p-2 rounded text-sm w-full">
                                
                                <div class="flex gap-2">
                                    <input type="number" step="0.01" name="price_per_kg" placeholder="Price per kg (৳)" required class="border p-2 rounded w-32 font-bold text-green-700">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold transition">
                                        Submit Bid
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>