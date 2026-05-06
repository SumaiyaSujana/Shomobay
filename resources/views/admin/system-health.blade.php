<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Health Dashboard - Shomobay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen">

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-8">
        <h1 class="text-4xl font-bold text-green-800">
            Admin System Health Dashboard
        </h1>

        <p class="text-gray-600 mt-2">
            Monitor platform activity, wallet transactions, and group buying metrics.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Total Group Carts</h2>
            <p class="text-3xl font-bold text-green-700 mt-2">
                {{ $totalCarts }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Active Carts</h2>
            <p class="text-3xl font-bold text-blue-700 mt-2">
                {{ $activeCarts }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Completed Carts</h2>
            <p class="text-3xl font-bold text-purple-700 mt-2">
                {{ $completedCarts }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Wallet Balance</h2>
            <p class="text-3xl font-bold text-emerald-700 mt-2">
                ৳{{ number_format($totalWalletBalance, 2) }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Wallet Transactions</h2>
            <p class="text-3xl font-bold text-orange-700 mt-2">
                {{ $totalTransactions }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Registered Vendors</h2>
            <p class="text-3xl font-bold text-red-700 mt-2">
                {{ $totalVendors }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Neighbors</h2>
            <p class="text-3xl font-bold text-indigo-700 mt-2">
                {{ $totalNeighbors }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-gray-500 text-sm">Vendor Bids</h2>
            <p class="text-3xl font-bold text-pink-700 mt-2">
                {{ $totalBids }}
            </p>
        </div>

    </div>

</div>

</body>
</html>