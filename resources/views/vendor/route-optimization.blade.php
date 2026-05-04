<!DOCTYPE html>
<html>
<head>
    <title>Delivery Route Optimization</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold mb-2 text-gray-800">Optimized Delivery Route</h2>
        <p class="text-gray-600 mb-6">Fastest route calculated for today's bulk drop-offs in Dhaka.</p>

        <div id="map" style="height: 500px; border-radius: 8px; z-index: 1;"></div>
    </div>

    <script>

        const stops = @json($deliveryStops);

        const map = L.map('map').setView([stops[0].lat, stops[0].lng], 12);


        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const latlngs = [];
        stops.forEach((stop, index) => {
            L.marker([stop.lat, stop.lng])
             .addTo(map)
             .bindPopup(`<b>${stop.name}</b><br>Stop #${index + 1}`);
            
            latlngs.push([stop.lat, stop.lng]);
        });

    
        const polyline = L.polyline(latlngs, {color: 'blue', weight: 4}).addTo(map);
        map.fitBounds(polyline.getBounds());
    </script>

</body>
</html>