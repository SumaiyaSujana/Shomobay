<!DOCTYPE html>
<html>
<head>
    <title>Vendor Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Vendor Revenue Analytics</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Monthly Earnings (৳)</h3>
                <canvas id="earningsChart"></canvas>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Most Requested Items (kg)</h3>
                <canvas id="itemsChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const earningsData = @json($monthlyEarnings);
        const itemsData = @json($popularItems);

        new Chart(document.getElementById('earningsChart'), {
            type: 'bar',
            data: {
                labels: earningsData.labels,
                datasets: [{
                    label: 'Revenue ৳',
                    data: earningsData.data,
                    backgroundColor: 'rgba(59, 130, 246, 0.6)'
                }]
            }
        });

        new Chart(document.getElementById('itemsChart'), {
            type: 'doughnut',
            data: {
                labels: itemsData.labels,
                datasets: [{
                    data: itemsData.data,
                    backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa']
                }]
            }
        });
    </script>

</body>
</html>