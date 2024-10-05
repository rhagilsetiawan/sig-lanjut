@extends('layouts.dashboard-volt')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map {
            height: 60vh;
            z-index: 10;
        }
        .leaflet-popup-content-wrapper {
            width: auto;
        }

        .leaflet-popup-content {
            margin: 3px;
            width: 200px;
        }
        .leaflet-popup-content > div {
            margin: 0 !important;
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0 m-2">
        <h1 class="h3 mb-3">Mencari <strong>Hotel</strong></h1>
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h1 class="card-title"></h1>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Fitur Sistem Informasi Geografi
                        </h6>
                        <p class="card-text">Pilih Berdasarkan menu di bawah ini</p>
                        @foreach ($places as $place)
                            <button class="btn btn-primary" id="{{ $place->id }}">{{ $place->name }}1</button>
                        @endforeach
                        <button class="btn btn-primary" id="pr1">SPBU 1</button>
                        <button class="btn btn-primary" id="pr2">SPBU 2</button>
                        <button class="btn btn-primary" id="pr3">SPBU 3</button>

                    </div>
                    <div class="card-body w-100">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    {{-- access data location --}}
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script type="text/javascript">
        // inisialisasi map
        const map = L.map("map").setView(
            [-0.05545174198124447, 109.34945449188419],
            12
        );
        const tiles = L.tileLayer(
            "https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                Zoom: 15,
            }
        ).addTo(map);

        const LocIcon = L.Icon.extend({
            options: {
                iconSize: [50, 50],
                iconAnchor: [25, 50],
                popupAnchor: [0, -50]
            }
        });

        // buat item marker
        const manIcon = new LocIcon({
            iconUrl: 'img/human.png'
        });
        const gasIcon = new LocIcon({
            iconUrl: 'img/hotel.png'
        });

        // tampilkan seluruh lokasi pakai axios
        axios.get("{{ route('places.api') }}")
            .then(function(response) {
                L.geoJSON(response.data, {
                    pointToLayer: function(geoJsonPoint, latlng) {
                        return L.marker(latlng, {
                            icon: gasIcon
                        });
                    }
                }).addTo(map);
            }).catch(function(error) {
                alert('gagal ambil data ' + error)
            });


        // Posisi tiap marker
        var locAnda = [-0.05545174198124447, 109.34945449188419];
        var gas1 = [-0.05376903078249141, 109.3630338704059];
        var gas2 = [-0.07314920036638735, 109.37197961552062];
        var gas3 = [-0.033066287197507184, 109.33378495951881];

        //combines item dan posisi
        let manMarker = L.marker(locAnda, {
                icon: manIcon,
                draggable: true,
            })
            .bindPopup("Lokasi Anda")
            .addTo(map);

        const pertamina1 = L.marker(gas1, {
                icon: gasIcon
            })
            .bindPopup("SPBU Pertamina 1")
            .addTo(map);
        const pertamina2 = L.marker(gas2, {
                icon: gasIcon
            })
            .bindPopup("SPBU Pertamina 2")
            .addTo(map);
        const pertamina3 = L.marker(gas3, {
                icon: gasIcon
            })
            .bindPopup("SPBU Pertamina 3")
            .addTo(map);

        let myPos = L.latLng(locAnda);
        manMarker.on('move', function(event) {
            myPos = event.latlng;
        });

        // inisialisasi fungsi pencarian
        var routeControl = null;

        function carigas(gas) {
            if (routeControl != null) {
                map.removeControl(routeControl);
            };
            routeControl = L.Routing.control({
                waypoints: [myPos, L.latLng(gas[0], gas[1])],
                routeWhileDragging: true,
                //geocoder: L.Control.Geocoder.nominatim()
            }).addTo(map);
        }

        function createButton(label, container) {
            var btn = L.DomUtil.create('button', '', container);
            btn.setAttribute('type', 'button');
            btn.setAttribute('class', 'btn btn-primary m-1');
            btn.innerHTML = label;
            return btn;
        }

        let control = L.Routing.control({
            waypoints: [myPos, L.latLng(gas1)],
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim()
        }).addTo(map);

        map.on('click', function(e) {
            var container = L.DomUtil.create('div'),
                startBtn = createButton('Start from this location', container),
                destBtn = createButton('Go to this location', container);

            L.popup()
                .setContent(container)
                .setLatLng(e.latlng)
                .openOn(map);

            L.DomEvent.on(startBtn, 'click', function() {
                control.spliceWaypoints(0, 1, e.latlng);
                map1.closePopup();
            });

            L.DomEvent.on(destBtn, 'click', function() {
                control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng);
                map1.closePopup();
            });
        });


        // setup event trigger
        //for(let i = 0; i<5; i++){
        //    document.getElementById("pr1").addEventListener("click", ()=>{carigas(gas1);});
        // }
        document.getElementById("pr1").addEventListener("click", () => {
            carigas(gas1);
        });
        document.getElementById("pr2").addEventListener("click", () => {
            carigas(gas2);
        });
        document.getElementById("pr3").addEventListener("click", () => {
            carigas(gas3);
        });
    </script>
@endpush
