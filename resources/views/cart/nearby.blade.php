<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Group Carts - Shomobay</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen">

<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="mb-8">
        <h1 class="text-4xl font-bold text-green-800">
            Nearby Group Carts
        </h1>

        <p class="text-gray-600 mt-2">
            Showing group buying opportunities within a 1km radius.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        @if($nearbyCarts->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-green-100 text-green-900">
                            <th class="text-left px-4 py-3">Neighborhood</th>
                            <th class="text-left px-4 py-3">Target Weight</th>
                            <th class="text-left px-4 py-3">Current Weight</th>
                            <th class="text-left px-4 py-3">Distance</th>
                            <th class="text-left px-4 py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($nearbyCarts as $cart)

                            <tr class="border-b">

                                <td class="px-4 py-3 font-semibold">
                                    {{ $cart->neighborhood_name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $cart->target_weight_kg }} kg
                                </td>

                                <td class="px-4 py-3">
                                    {{ $cart->current_weight_kg }} kg
                                </td>

                                <td class="px-4 py-3 text-blue-700 font-semibold">
                                    {{ number_format($cart->distance, 2) }} km
                                </td>

                                <td class="px-4 py-3">

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                        {{ $cart->status }}
                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-12">

                <h2 class="text-2xl font-bold text-gray-700 mb-3">
                    No Nearby Group Carts Found
                </h2>

                <p class="text-gray-500">
                    There are currently no active carts within your 1km area.
                </p>

            </div>

        @endif

    </div>

</div>

</body>
</html>