<!DOCTYPE html>
<html>
<head>
    <title>Vendor Verification Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg border-t-4 border-green-600">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Vendor Verification Portal 🧑‍🌾</h2>
        <p class="text-gray-600 mb-6">Upload your Trade License or NID to bid on neighborhood bulk carts.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6 font-semibold">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 border border-red-300 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/vendor/register" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">Business / Farm Name</label>
                <input type="text" name="business_name" placeholder="e.g., Rahim Organics" required 
                       class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Trade License or NID (PDF/JPG/PNG)</label>
                <div class="border border-gray-300 p-3 rounded bg-gray-50">
                    <input type="file" name="document" required class="w-full text-gray-600">
                </div>
                <p class="text-sm text-gray-500 mt-2">Maximum file size: 2MB.</p>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded transition duration-200">
                Submit for Verification
            </button>
        </form>
    </div>

</body>
</html>