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
@php
@endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 flex justify-center">
                <a href="/places" class="btn btn-secondary btn-sm mb-2">&larr; Back</a>
            </div>
            <div class="col-md-6 mb-2">
                <div class="card">
                    <div id="mapid"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('places.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="form-row row">
                                    <div class="col-md-6 mb-2">
                                        <label for="">Longitude</label>
                                        <input type="text" name="longitude" id="longitude"
                                            class="form-control @error('longitude') is-invalid @enderror" readonly
                                            placeholder="longitude" value="{{ old('longitude') }}">
                                        @error('longitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                                            class="form-control @error('latitude') is-invalid @enderror"
                                            placeholder="latitude" readonly>
                                        @error('latitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row row">
                                    <div class="col-md-6 mb-2">
                                        <label for="">Place Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Place name here..." value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="">Upload image</label>
                                        <input type="file" name="image" value="{{ old('image') }}"
                                            class="form-control @error('image') is-invalid @enderror"
                                            placeholder="file image">
                                        <small><strong>**let empty if there is no image to upload</strong></small>
                                        @error('image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row row">
                                    <div class="col-md-6 mb-2">
                                        <label for="">Address</label>
                                        <input name="address" placeholder="Address here..." class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address') }}"></input>
                                        @error('address')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="">Description</label>
                                        <input name="description" placeholder="Description here..."
                                            class="form-control @error('description') is-invalid @enderror"></input>
                                        @error('description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group float-right mt-4">
                                <button type="submit" class="btn btn-primary bg-black">Add Place</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    
    <script>
        var mapCenter = [
            {{ config('leafletsetup.map_center_latitude') }},
            {{ config('leafletsetup.map_center_longitude') }},
        ];
        var map = L.map('mapid').setView(mapCenter, {{ config('leafletsetup.zoom_level') }});
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);

        function updateMarker(lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Your location :" + marker.getLatLng().toString())
                .openPopup();
            return false;
        };

        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            updateMarker(latitude, longitude);
        });

        var updateMarkerByInputs = function() {
            return updateMarker($('#latitude').val(), $('#longitude').val());
        }
        $('#latitude').on('input', updateMarkerByInputs);
        $('#longitude').on('input', updateMarkerByInputs);
    </script>
@endpush
