<!DOCTYPE html>
<html>
<head>
    <title>Vendor Verification Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md border-t-4 border-green-600">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Vendor Verification Portal 🧑‍🌾</h2>
        <p class="text-gray-600 mb-6">Upload your Trade License or NID to bid on neighborhood bulk carts.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/vendor/verify" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">Business / Farm Name</label>
                <input type="text" name="businessName" required class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-green-500" placeholder="e.g., Rahim Organics">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Trade License or NID (PDF/JPG/PNG)</label>
                <input type="file" name="tradeLicenseFile" required class="w-full border border-gray-300 p-3 rounded bg-gray-50 focus:outline-none focus:border-green-500">
                <p class="text-sm text-gray-500 mt-1">Maximum file size: 2MB.</p>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded hover:bg-green-700 transition duration-300">
                Submit for Verification
            </button>
        </form>
    </div>

</body>
</html>