<!DOCTYPE html>
<html>
<head>
    <title>Admin Approval Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 p-10 text-white">

    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-white mb-2">Admin Panel: Bid Approvals ⚖️</h2>
        <p class="text-gray-400 mb-6">Review vendor bids and close neighborhood carts.</p>

        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded mb-6 shadow-md font-bold">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($lockedCarts->isEmpty())
            <div class="bg-gray-700 p-8 rounded-lg shadow-md text-center border-t-4 border-yellow-500">
                <h3 class="text-xl font-bold mb-2">No Carts Awaiting Approval</h3>
                <p class="text-gray-400">There are currently no locked carts that need an admin decision.</p>
            </div>
        @else
            <div class="space-y-8">
                @foreach($lockedCarts as $cart)
                    <div class="bg-gray-900 p-6 rounded-lg shadow-lg border border-gray-700">
                        <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-blue-400">{{ $cart->neighborhood_name }}</h3>
                                <p class="text-gray-400 text-sm mt-1">Target: {{ $cart->target_weight_kg }} kg | Status: <span class="text-yellow-400">{{ $cart->status }}</span></p>
                            </div>
                        </div>

                        <h4 class="font-bold text-lg mb-3 text-gray-300">Submitted Bids:</h4>
                        
                        @if($cart->bids->isEmpty())
                            <p class="text-gray-500 italic">No vendors have submitted bids for this cart yet.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($cart->bids as $bid)
                                    <div class="bg-gray-800 p-4 rounded-lg border {{ $bid->status == 'Accepted' ? 'border-green-500' : 'border-gray-600' }}">
                                        <p class="font-bold text-xl text-white">{{ $bid->vendor_name }}</p>
                                        <p class="text-green-400 font-extrabold text-2xl my-2">৳{{ $bid->price_per_kg }} <span class="text-sm text-gray-400 font-normal">/ kg</span></p>
                                        
                                        <form action="/admin/accept-bid/{{ $bid->id }}" method="POST" class="mt-4">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded transition">
                                                Accept This Bid
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>