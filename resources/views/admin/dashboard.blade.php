<!DOCTYPE html>
<html>
<head>
    <title>Shomobay Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 p-10 text-white">

    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-6 shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-12 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-white mb-2">New Vendor Applications 🧑‍🌾</h2>
            <p class="text-gray-400">Review Trade Licenses and approve new wholesalers.</p>
        </div>
        <a href="{{ url('/vendor/register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg shadow-lg transition">
            ➕ Open Vendor Portal
        </a>
    </div>

    @if($applications->isEmpty())
        <div class="bg-[#1e293b] p-6 rounded-lg text-gray-400 border border-gray-700 text-center">
            No pending vendor applications found.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($applications as $app)
                <div class="bg-[#1e293b] p-6 rounded-lg border border-gray-700 shadow-lg">
                    <h3 class="text-xl font-bold text-blue-400 mb-2">{{ $app->business_name }}</h3>
                    <p class="text-gray-300 mb-4">Status: 
                        <span class="px-2 py-1 rounded text-xs font-bold uppercase 
                            {{ $app->status == 'approved' ? 'bg-green-900 text-green-400' : ($app->status == 'rejected' ? 'bg-red-900 text-red-400' : 'bg-yellow-900 text-yellow-400') }}">
                            {{ $app->status }}
                        </span>
                    </p>
                    
                    <a href="{{ asset('storage/' . $app->document_path) }}" target="_blank" class="inline-block bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded mb-6 transition w-full text-center">
                        📄 View Document
                    </a>

                    <div class="flex gap-4">
                        <form action="{{ route('admin.vendor.approve', $app->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded transition">Approve</button>
                        </form>

                        <form action="{{ route('admin.vendor.reject', $app->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded transition">Reject</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</body>
</html>