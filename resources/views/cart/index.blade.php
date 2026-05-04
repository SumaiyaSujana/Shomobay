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
            <p class="text-lg font-bold mt-2 text-{{ $cart->status == 'Open' ? 'green' : 'red' }}-600">
                Status: {{ $cart->status }}
            </p>
        </div>

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
        @endif

        <h3 class="text-xl font-bold mb-4">Current Cart Items</h3>
        <ul class="border rounded divide-y">
            @foreach($items as $item)
                <li class="p-4 flex justify-between">
                    <span><strong>{{ $item->neighbor_name }}</strong> added {{ $item->vegetable_name }}</span>
                    <span class="font-bold text-gray-700">{{ $item->weight_kg }} kg</span>
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>