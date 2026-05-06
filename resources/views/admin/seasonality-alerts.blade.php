<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seasonality Alerts - Shomobay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen text-gray-800">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-800">Seasonality Push Alerts</h1>
            <p class="text-gray-600 mt-2">
                Create alerts when seasonal vegetables reach low wholesale prices.
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-green-700 mb-4">Create New Alert</h2>

                <form method="POST" action="{{ route('admin.seasonality-alerts.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-1">Product Name</label>
                        <input
                            type="text"
                            name="product_name"
                            value="{{ old('product_name') }}"
                            placeholder="Tomato"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Area Name</label>
                        <input
                            type="text"
                            name="area_name"
                            value="{{ old('area_name') }}"
                            placeholder="Bashundhara R/A"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Wholesale Price</label>
                        <input
                            type="number"
                            step="0.01"
                            name="wholesale_price"
                            value="{{ old('wholesale_price') }}"
                            placeholder="45"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Message</label>
                        <textarea
                            name="message"
                            rows="4"
                            placeholder="Tomatoes are now available at the lowest wholesale price this week."
                            class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select
                            name="status"
                            class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        >
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-green-700 text-white font-semibold py-2 rounded-lg hover:bg-green-800 transition"
                    >
                        Save Alert
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-green-700 mb-4">All Seasonality Alerts</h2>

                @if ($alerts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr class="bg-green-100 text-green-900">
                                    <th class="text-left px-4 py-3">Product</th>
                                    <th class="text-left px-4 py-3">Area</th>
                                    <th class="text-left px-4 py-3">Price</th>
                                    <th class="text-left px-4 py-3">Status</th>
                                    <th class="text-left px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alerts as $alert)
                                    <tr class="border-b">
                                        <td class="px-4 py-3">
                                            <div class="font-semibold">{{ $alert->product_name }}</div>
                                            <div class="text-gray-500 text-xs">{{ $alert->message }}</div>
                                        </td>
                                        <td class="px-4 py-3">{{ $alert->area_name ?? 'All areas' }}</td>
                                        <td class="px-4 py-3">৳{{ number_format($alert->wholesale_price, 2) }}</td>
                                        <td class="px-4 py-3">
                                            @if ($alert->status === 'published')
                                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                    Published
                                                </span>
                                            @else
                                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                                    Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2">
                                                @if ($alert->status === 'draft')
                                                    <form method="POST" action="{{ route('admin.seasonality-alerts.publish', $alert) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button
                                                            type="submit"
                                                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700"
                                                        >
                                                            Publish
                                                        </button>
                                                    </form>
                                                @endif

                                                <form method="POST" action="{{ route('admin.seasonality-alerts.destroy', $alert) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('Delete this alert?')"
                                                        class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No seasonality alerts created yet.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>