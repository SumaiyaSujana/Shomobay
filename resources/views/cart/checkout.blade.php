<!DOCTYPE html>
<html>
<head>
    <title>Cart Checkout Validator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Neighborhood Cart Checkout</h2>
        
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 font-semibold border border-red-300">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 font-semibold border border-green-300">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="/cart/checkout" method="POST">
            @csrf
            
            <label class="block mb-2 font-medium">Target Weight Required (kg):</label>
            <input type="number" name="target_weight" value="50" readonly class="mb-4 w-full border p-2 rounded bg-gray-100 text-gray-500">
            
            <label class="block mb-2 font-medium">Current Group Weight (kg):</label>
            <input type="number" name="current_weight" placeholder="Enter current weight..." required class="mb-6 w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
            
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full font-bold">
                Attempt Checkout
            </button>
        </form>
    </div>

</body>
</html>