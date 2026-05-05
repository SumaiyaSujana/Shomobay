<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shomobay - Community Bulk Buying</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="absolute top-4 right-6 space-x-4 z-50">
        @auth
            <a href="{{ url('/dashboard') }}" class="font-bold text-green-700 hover:text-green-900 bg-white px-4 py-2 rounded shadow">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-green-700">Log in</a>
            <a href="{{ route('register') }}" class="font-semibold text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded shadow">Register</a>
        @endauth
    </div>

    <div class="text-center pt-20 pb-10">
        <h1 class="text-5xl font-extrabold text-green-700 tracking-tight">🛒 Shomobay</h1>
        <p class="text-gray-500 mt-3 text-lg max-w-2xl mx-auto">Join your neighbors to buy fresh groceries in bulk directly from farmers. Beat the syndicate, save money together!</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Active Community Buys</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($products as $product)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 border border-gray-100">
                <div class="h-48 bg-gray-200 flex items-center justify-center text-5xl">
                    {{ $product->emoji_icon ?? '📦' }}
                </div>
                
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800">{{ $product->name }}</h3>
                    <p class="text-green-600 font-bold mt-1">৳ {{ number_format($product->price_per_kg, 2) }} / kg</p>
                    
                    <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
                        <span>Target: {{ $product->target_weight_kg }}kg</span>
                        @if($product->current_weight_kg >= $product->target_weight_kg)
                            <span class="text-green-500 font-semibold">Threshold Met!</span>
                        @else
                            <span class="text-orange-500 font-semibold">
                                {{ $product->target_weight_kg - $product->current_weight_kg }}kg needed
                            </span>
                        @endif
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                        @php
                            $percentage = ($product->current_weight_kg / $product->target_weight_kg) * 100;
                            $percentage = $percentage > 100 ? 100 : $percentage;
                        @endphp
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>

                    @if($product->current_weight_kg >= $product->target_weight_kg)
                        <button class="w-full mt-5 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                            Proceed to Bidding
                        </button>
                    @else
                        <button class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                            Join Group Buy
                        </button>
                    @endif
                </div>
            </div>
            @endforeach

        </div>
    </div>
    
</body>
</html>