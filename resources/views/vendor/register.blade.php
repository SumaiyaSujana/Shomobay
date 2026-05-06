<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration - Shomobay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-green-700">🛒 Shomobay</h2>
            <p class="text-gray-500 mt-2">Become a Verified Vendor</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/vendor/register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Business or Farm Name</label>
                <input type="text" name="business_name" required 
                       class="w-full border @error('business_name') border-red-500 @else border-gray-300 @enderror p-3 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" 
                       placeholder="e.g. Karim Organic Farms"
                       value="{{ old('business_name') }}">
                @error('business_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Verification Document (NID/Trade License)</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-green-500 transition bg-gray-50">
                    <input type="file" name="document" required 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="text-center">
                        <span class="text-gray-400 block mb-1">Click to upload or drag & drop</span>
                        <span class="text-xs text-gray-400">PDF, JPG, or PNG (Max 2MB)</span>
                    </div>
                </div>
                @error('document')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transform active:scale-95 transition duration-150">
                Submit for Verification
            </button>

            <div class="text-center">
                <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-green-600 transition">← Back to Homepage</a>
            </div>
        </form>
    </div>

</body>
</html>