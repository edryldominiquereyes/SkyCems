@extends('layouts.host')

@section('title', 'Update Facility -')

@section('content')
<h2>Edit Facility</h2>
<hr>
@if(session('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif
@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif
<div class="row d-flex justify-content-center align-items-center">
    <div class="col-10 col-md-8 col-lg-6">
        <form enctype="multipart/form-data" role="form" class="form-horizontal" action="{{ route('facility.update') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{$facilities['facility_id']}}">

            <div class="text-center">
                <img class="img-thumbnail" src="/image/{{ $facilities->image }}" style="width: 250px;height: 210px;">
                <h6>Facility Picture</h6>
                <input type="file" name="image">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>

            <div class="form-group">
                <label for="facility">Facility Name:</label>
                <input name="facility" type="text" class="form-control @error('facility') is-invalid @enderror" id="facility" value="{{old('facility',$facilities->facility)}}" required autocomplete="facility">

                @error('facility')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description:</label>

                <input name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="" rows="3" value="{{old('description',$facilities->description)}}">

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <!-- <div class="form-group">
                <div class="col-sm-10">
                    <input name="address" type="hidden" class="form-control" id="address" aria-describedby="address" value="{{old('address',$facilities->address)}}">
                </div>
            </div> -->

            <div class="form-group">
                <label for="address">Address:</label>

                <input id="pac-input" autocomplete=false name="address" value="{{old('address',$facilities->address)}}" type="text" class="form-control" placeholder="Search Here">
                <input id="lat-input" autocomplete=false name="lat" value="{{old('lat',$facilities->lat)}}" type="hidden">
                <input id="lng-input" autocomplete=false name="lng" value="{{old('lng',$facilities->lng)}}" type="hidden">
            </div>

            <div class="form-group">
                <div id="map-canvas" style="height: 500px; margin:0px; padding: 0px;"></div>
            </div>

            <div class="form-group">
                <label for="capacity">Maximum Capacity:</label>

                <input name="capacity" type="text" class="form-control @error('capacity') is-invalid @enderror" id="capacity" value="{{old('capacity',$facilities->capacity)}}" aria-describedby="capacity">

                @error('capacity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <label class="control-label" for="field1">Items Available:</label>
            @foreach(explode(',', $facilities->itemList) as $info)
            <div class="form-group">
                <input type="hidden" name="count" value="1" />
                <div class="control-group" id="fields">
                    <div class="controls" id="profs"> 
                        <div class="input-append">
                            <button id="b1" class="btn add-more" type="button">+</button>
                            <div id="field"><input autocomplete="off" class="form-control" id="field1" name="itemList[]" type="text" value="{{$info}}"  data-items="8"/></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <div class="mt-4 mb-4">
                    <input type="submit" class="btn btn-success" value="Save Changes">
                    <a type="button" href="{{ route('facility.index') }}" class="btn btn-danger">Discard Changes</a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('map')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBm5P7yY5absXGyhbm_tUMNrLFuTkNoFXk&libraries=drawing,places&v=3.45.8"></script>
<script>
    var map;

    function initialize() {
        let markers = [];
        var myLatlng = {
            lat: parseFloat("{{old('lat',$facilities->lat)}}"),
            lng: parseFloat("{{old('lng',$facilities->lng)}}")
        };

        var myOptions = {
            zoom: 11,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

        const origPlace = {
            size: new google.maps.Size(75, 75),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(30, 30),
        };

        // Create a marker for each place.
        markers.push(
            new google.maps.Marker({
                map,
                origPlace,
                title: "{{old('address',$facilities->address)}}",
                position: myLatlng,
            })
        );

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const icon = {
                    size: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(30, 30),
                };

                $('#lat-input').val(place.geometry.location.lat());
                $('#lng-input').val(place.geometry.location.lng());

                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    $(document).on('ready', function() {});
</script>
<script>
$(document).ready(function(){
    var next = 1;

    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="itemList[]" type="text">';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });
    
});

</script>
@endpush
@endsection