<!DOCTYPE html>
<html>
<head>
    <title>Vendor Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Vendor Verification Portal</h2>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="/vendor/verify" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="block mb-2 font-semibold">Upload NID or Trade License (PDF/JPG)</label>
            <input type="file" name="trade_license" required class="mb-4 w-full border p-2 rounded">
            
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                Submit for Approval
            </button>
        </form>
    </div>

</body>
</html>