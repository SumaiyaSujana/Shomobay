<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shomobay – Split Bill</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <header class="bg-green-700 text-white px-6 py-4 shadow">
        <h1 class="text-2xl font-bold tracking-tight">🛒 Shomobay</h1>
        <p class="text-sm text-green-200">Split Bill Calculator</p>
    </header>

    <main class="max-w-2xl mx-auto py-10 px-4 space-y-8">

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">🧾 Split Bill Result</h2>

            @if(empty($splits))
                <p class="text-gray-400 text-center py-4">No data to display.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2">User ID</th>
                                <th class="px-4 py-2">Weight (kg)</th>
                                <th class="px-4 py-2">Owes (Taka)</th>
                                <th class="px-4 py-2">Owes (Poisha)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($splits as $split)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 font-semibold">
                                        User #{{ $split['user_id'] }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $split['weight_kg'] }} kg
                                    </td>
                                    <td class="px-4 py-2 font-bold text-green-700">
                                        ৳{{ $split['owes_taka'] }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-400">
                                        {{ $split['owes_poisha'] }} poisha
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-6">
                <a href="javascript:history.back()"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                    ← Back
                </a>
            </div>
        </div>

    </main>
</body>
</html>