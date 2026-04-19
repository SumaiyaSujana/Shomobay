<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shomobay – My Wallet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- ── Header ── --}}
    <header class="bg-green-700 text-white px-6 py-4 shadow">
        <h1 class="text-2xl font-bold tracking-tight">🛒 Shomobay</h1>
        <p class="text-sm text-green-200">Community Bulk Buying Cooperative</p>
    </header>

    <main class="max-w-3xl mx-auto py-10 px-4 space-y-8">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- ── Wallet Balance Card ── --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">💰 My Escrow Wallet</h2>

            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-green-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Total Balance</p>
                    <p class="text-2xl font-bold text-green-700">
                        ৳{{ $wallet->balanceInTaka() }}
                    </p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Held in Escrow</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        ৳{{ $wallet->heldInTaka() }}
                    </p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Available</p>
                    <p class="text-2xl font-bold text-blue-700">
                        ৳{{ $wallet->availableInTaka() }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ── Deposit Form ── --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">➕ Top Up Wallet</h2>

            <form action="/finance/deposit" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ $wallet->user_id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Amount (Taka)
                    </label>
                    <input
                        type="number"
                        name="amount_taka"
                        min="1"
                        step="0.01"
                        placeholder="e.g. 500"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    >
                    @error('amount_taka')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                    Add Money to Wallet
                </button>
            </form>
        </div>

        {{-- ── Hold for Cart Form ── --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-1">🔒 Join a Cart (Hold Funds)</h2>
            <p class="text-sm text-gray-500 mb-4">
                Minimum contribution is <span class="font-semibold text-red-500">৳50.00</span>
            </p>

            <form action="/finance/hold" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ $wallet->user_id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cart ID</label>
                    <input
                        type="number"
                        name="cart_id"
                        placeholder="e.g. 1"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    >
                    @error('cart_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Amount to Hold (Taka)
                    </label>
                    <input
                        type="number"
                        name="amount_taka"
                        min="50"
                        step="0.01"
                        placeholder="Minimum ৳50"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    >
                    @error('amount_taka')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded-lg transition">
                    Lock Funds into Escrow
                </button>
            </form>
        </div>

        {{-- ── Transaction History ── --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📋 Transaction History</h2>

            @if($transactions->isEmpty())
                <p class="text-gray-400 text-sm text-center py-4">No transactions yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transactions as $tx)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">
                                        @php
                                            $badges = [
                                                'deposit' => 'bg-green-100 text-green-700',
                                                'hold'    => 'bg-yellow-100 text-yellow-700',
                                                'release' => 'bg-blue-100 text-blue-700',
                                                'deduct'  => 'bg-red-100 text-red-700',
                                                'refund'  => 'bg-purple-100 text-purple-700',
                                            ];
                                            $badge = $badges[$tx->type] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ strtoupper($tx->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 font-semibold">
                                        ৳{{ $tx->amountInTaka() }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-500">
                                        {{ $tx->description }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-400">
                                        {{ $tx->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>
</body>
</html>