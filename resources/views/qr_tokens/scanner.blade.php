<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner - Shomobay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center">

        <h1 class="text-2xl font-bold text-green-700 mb-1">📷 Delivery Scanner</h1>
        <p class="text-gray-500 text-sm mb-6">Scan a neighbor's QR code to confirm their claim</p>

        {{-- QR Scanner box --}}
        <div id="qr-reader" class="mb-6 rounded-xl overflow-hidden"></div>

        {{-- Result box (hidden until scan) --}}
        <div id="result-box" class="hidden rounded-xl p-4 text-left text-sm"></div>

    </div>

    <script>
        const csrfToken = "{{ csrf_token() }}";

        const html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            async (decodedText) => {

                // Stop scanning immediately after first read
                await html5QrCode.stop();

                const resultBox = document.getElementById('result-box');
                resultBox.classList.remove('hidden');
                resultBox.innerHTML = `<p class="text-gray-500">Processing...</p>`;

                try {
                    const response = await fetch("{{ route('qr.claim') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ token: decodedText }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        resultBox.className = 'rounded-xl p-4 text-left text-sm bg-green-50 border border-green-200';
                        resultBox.innerHTML = `
                            <p class="text-green-700 font-bold text-base mb-2">✅ Claimed!</p>
                            <p><span class="text-gray-500">Neighbor:</span> <strong>${data.neighbor}</strong></p>
                            <p><span class="text-gray-500">Item:</span> <strong>${data.vegetable}</strong></p>
                            <p><span class="text-gray-500">Weight:</span> <strong>${data.weight_kg} kg</strong></p>
                            <p><span class="text-gray-500">Time:</span> <strong>${data.claimed_at}</strong></p>
                            <button onclick="location.reload()" class="mt-4 w-full bg-green-600 text-white rounded-lg py-2 font-medium">
                                Scan Next
                            </button>
                        `;
                    } else {
                        resultBox.className = 'rounded-xl p-4 text-left text-sm bg-red-50 border border-red-200';
                        resultBox.innerHTML = `
                            <p class="text-red-700 font-bold text-base mb-2">❌ Failed</p>
                            <p class="text-red-600">${data.message}</p>
                            <button onclick="location.reload()" class="mt-4 w-full bg-red-500 text-white rounded-lg py-2 font-medium">
                                Try Again
                            </button>
                        `;
                    }
                } catch (err) {
                    resultBox.className = 'rounded-xl p-4 text-sm bg-red-50 border border-red-200';
                    resultBox.innerHTML = `<p class="text-red-600">Network error. Please try again.</p>`;
                }
            },
            (errorMessage) => {
                // Scanning errors are silent — no need to show them
            }
        ).catch(err => {
            document.getElementById('qr-reader').innerHTML =
                `<p class="text-red-500 text-sm p-4">Camera access denied. Please allow camera permission.</p>`;
        });
    </script>

</body>
</html>