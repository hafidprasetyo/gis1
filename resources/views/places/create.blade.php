@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">Tambah Rumah Sakit</div>
                <div class="card-body">
                    <form action="{{ route('places.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label for="">Nama Rumah Sakit</label>
                                    <input type="text" name="nama" class="form-control @error ('nama') is-invalid @enderror" placeholder="Tuliskan nama rumah sakit....">
                                    @error('nama')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="">Status Akreditasi</label>
                                    <input type="text" name="status_akreditasi" class="form-control @error ('status_akreditasi') is-invalid @enderror" placeholder="Tuliskan status akreditasi....">
                                    @error('status_akreditasi')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-row mb-2">
                                    <div class="col">
                                        <label for="">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" class="form-control @error ('latitude') is-invalid @enderror" placeholder="latitude">
                                        @error('latitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="">Longitude</label>
                                        <input type="text" name="longitude" id="longitude" class="form-control @error ('longitude') is-invalid @enderror" placeholder="longitude">
                                        @error('longitude')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                    <div>
                                        <label for="">Alamat</label>
                                        <textarea name="alamat" placeholder="Tuliskan alamat..." class="form-control @error ('alamat') is-invalid @enderror" cols="4" rows="8"></textarea>
                                        @error('alamat')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-row mb-2">
                                <div class="col">
                                    <label for="">No Telepon</label>
                                    <input type="text" name="notelp" class="form-control @error ('notelp') is-invalid @enderror" placeholder="Tuliskan no telepon....">
                                    @error('notelp')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="">Website</label>
                                    <input type="text" name="website" class="form-control @error ('website') is-invalid @enderror" placeholder="Tuliskan website....">
                                    @error('website')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="container" id="mapid"></div>
                        <div class="form-group float-right mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Tambah Rumah Sakit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Leaflet CSS -->
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""/>
    <style>
      #mapid { min-height: 500px; }
    </style>
@endsection

@push('scripts')

<!-- Leaflet JavaScript -->
      <!-- Make sure you put this AFTER Leaflet's CSS -->
      <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
          integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
          crossorigin="">
      </script>

<script>
    var mapCenter = [
            {{ config('leafletsetup.map_center_latitude') }},
            {{ config('leafletsetup.map_center_longitude') }},
    ];
    var map = L.map('mapid').setView(mapCenter,{{ config('leafletsetup.zoom_level') }});
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);

    function updateMarker(lat,lng){
        marker
        .setLatLng([lat,lng])
        .bindPopup("Your location :" + marker.getLatLng().toString())
        .openPopup();
        return false;
    };

    map.on('click',function(e) {
        let latitude  = e.latlng.lat.toString().substring(0,15);
        let longitude = e.latlng.lng.toString().substring(0,15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude,longitude);
    });

    var updateMarkerByInputs = function () {
        return updateMarker( $('#latitude').val(), $('#longitude').val());
    }
    $('#latitude').on('input',updateMarkerByInputs);
    $('#longitude').on('input',updateMarkerByInputs);

</script>
@endpush