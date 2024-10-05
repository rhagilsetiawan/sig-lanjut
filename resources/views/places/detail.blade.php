@extends('layouts.dashboard-volt')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        #mapid {
            height: 60vmin;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header fw-bolder">Detail Place</div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama Tempat</td>
                                    <td>{{ $place->name }}</td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td class="text-wrap">{{ $place->description }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td class="text-wrap">{{ $place->address }}</td>
                                </tr>
                            </tbody>
                            <td><a href="{{ route('places.index') }}" class="btn btn-secondary">&larr; Kembali</a></td>
                        </table>
                    </div>
                </div>
                <img src="{{ $place->getImageAsset() }}" alt="{{ $place->getImageAsset() }}" class="object-fit-contain">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div id="mapid"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        var map = L.map('mapid').setView([{{ $place->latitude }}, {{ $place->longitude }}],
            {{ config('leafletsetup.detail_zoom_level') }});

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([{{ $place->latitude }}, {{ $place->longitude }}]).addTo(map);
    </script>
@endpush
