<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Active Bulk Requests (Ready for Bids)</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 font-semibold shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($activeCarts as $cart)
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <h3 class="text-xl font-bold text-gray-700">Request #{{ $cart['id'] }}: {{ $cart['item'] }}</h3>
                    <p class="text-gray-600 mt-2">Target Weight: <span class="font-bold">{{ $cart['targetWeight'] }} kg</span></p>
                    <p class="text-green-600 font-semibold mt-1">Status: Ready for Bidding</p>
                    
                    <form action="/vendor/bid" method="POST" class="mt-4 border-t pt-4">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cart['id'] }}">
                        <label class="block mb-2 font-medium text-gray-700">Your Bid (Price per kg in ৳):</label>
                        <input type="number" step="0.01" name="bid_amount" required class="mb-3 w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full font-bold">
                            Submit Bid
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>