@extends('layouts.dashboard-volt')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #mapid {
            height: 60vh;
            z-index: 10;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row flex justify-content-center">
            <div class="col-md-8 flex">
                <div id="reader" class="mb-2"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <form action="" id="searchForm" class="mb-2">
                    <label for="cameraValue" class="form-label">Product ID</label>
                    <input type="text" class="form-control" id="cameraValue" value="1234567890123"
                        placeholder="[13 Digit]">
                    <label for="radiusInput">Radius</label>
                    <input class="w-100 m-0" type="range" id="radiusInput" min="10" max="10000" step="10"
                        value="5000">
                    <span id="radiusValue">3500</span> Meter
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
            <div class="col">
                <div class="card">
                    <!-- Create a div for the map -->
                    <div id="mapid"></div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- API search qr-code --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    {{-- access data location --}}
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        var productID = document.getElementById('cameraValue').value;
        console.log("product id: ",productID);
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 150
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render((decodedText, decodedResult) => {
            productID.value = decodedText;
            p.value = decodedText;
        }, (error) => {
            console.warn(`Code scan error = ${error}`);
        });

        let radiusInput = document.getElementById('radiusInput');
        let radiusValue = document.getElementById('radiusValue');

        var userLocation;
        var circle;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                userLocation = [position.coords.latitude, position.coords.longitude];
                initMap(userLocation);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        function initMap(center) {
            // Initialize the map
            var map = L.map('mapid').setView(center, 13);

            // Add a tile layer (you can use any tile provider)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            var myIcon = L.divIcon({
                className: 'fa-solid fa-circle'
            });
            var marker = L.marker(center, {
                icon: myIcon
            }).addTo(map);

            // Add a circle to represent the radius
            circle = L.circle(center, {
                color: '#AA0000',
                fillColor: '#AA0000',
                fillOpacity: 0.2,
                radius: 3500, // Example radius
            }).addTo(map);

            // Event listener for radius input
            document.getElementById('radiusInput').addEventListener('input', function() {
                const newRadius = parseInt(this.value);
                document.getElementById('radiusValue').textContent = newRadius;
                circle.setRadius(newRadius);
            });

            // Fetch and show shops within the radius
            document.getElementById("searchForm").addEventListener("submit", function(event) {
                event.preventDefault();
                fetchShops(map, center);
            });
        }

        function fetchShops(map, center) {
            var radius = circle.getRadius();
            axios.get(`{{ route('products.api') }}/${productID}`)
                .then(function(response) {
                    var geojsonData = {
                        "type": "FeatureCollection",
                        "features": []
                    };
                    console.log("lihat hasil response.data: ", response.data);

                    response.data.forEach(function(shop) {
                        console.log("cek tiap features: ", shop);
                        var distance = calculateDistance(center, [shop.lat, shop.lng]);
                        if (distance <= radius) {
                            console.log("distance <= radius =", distance," <= ", radius)
                            geojsonData.features.push({
                                "type": "Feature",
                                "geometry": {
                                    "type": "Point",
                                    "coordinates": [shop.lng, shop.lat] //lokasi nya memang dibuat terbalik
                                },
                                "properties": {
                                    "name": shop.shop_name,
                                    "price": shop.price,
                                    "description": "Shop: " + shop.shop_name + "<br>Price: " + shop
                                        .price,
                                    "color": "#ff7800"
                                }
                            });
                        }
                    });

                    console.log("geojsonData: ", geojsonData);

                    // Add GeoJSON data to map
                    L.geoJSON(geojsonData, {
                        style: function(feature) {
                            return {
                                color: feature.properties.color
                            };
                        },
                        pointToLayer: function(feature, latlng) {
                            return L.marker(latlng);
                        }
                    }).bindPopup(function(layer) {
                        return layer.feature.properties.description;
                    }).addTo(map);
                })
                .catch(function(error) {
                    console.log("waduh!", error);
                });
        }

        function calculateDistance(pointA, pointB) {
            var R = 6371e3; // Radius of the Earth in meters
            var φ1 = pointA[0] * Math.PI / 180;
            var φ2 = pointB[0] * Math.PI / 180;
            var Δφ = (pointB[0] - pointA[0]) * Math.PI / 180;
            var Δλ = (pointB[1] - pointA[1]) * Math.PI / 180;

            var a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            var distance = R * c;
            return distance;
        }
    </script>
@endpush
