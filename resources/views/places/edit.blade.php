@extends('layouts.dashboard-volt')

@section('styles')
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
            <div class="col-12 flex justify-center">
                <a href="/places" class="btn btn-secondary btn-sm mb-2">&larr; Back</a>
            </div>
            <div class="col-md-6 mb-2">
                <div class="card">
                    <div id="mapid"></div>
                    <img class="object-fit-contain" src="{{ $place->getImageAsset() }}" alt="{{ $place->getImageAsset() }}">
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('places.update', $place) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">Update Place</div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row row">
                                    <div class="col-md-6 mb-2">
                                        <label for="">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" readonly
                                            class="form-control @error('latitude') is-invalid @enderror"
                                            value="{{ $place->latitude }}">
                                        @error('latitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="">Longitude</label>
                                        <input type="text" name="longitude" id="longitude" readonly
                                            class="form-control @error('longitude') is-invalid @enderror"
                                            value="{{ $place->longitude }}">
                                        @error('longitude')
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
                                            value="{{ $place->name }}">
                                        @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image">Upload image</label>
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            placeholder="{{ $place->image }}">
                                        <small><strong>**let empty if there is no image to upload</strong></small>
                                        @error('image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-6 mb-2">
                                    <label for="description">Description</label>
                                    <textarea name="description" placeholder="Description here..."
                                        class="form-control @error('description') is-invalid @enderror" cols="3" rows="1">{{ $place->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="address">Address</label>
                                    <textarea name="address" placeholder="address here..." class="form-control @error('address') is-invalid @enderror"
                                        cols="3" rows="1">{{ $place->address }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group float-end">
                                <button type="submit" class="btn btn-primary bg-black">Update Place</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        var mapCenter = [@json($place->latitude), @json($place->longitude)];
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
