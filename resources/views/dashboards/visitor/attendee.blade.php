@extends('layouts.visitorContent')

@section('title', 'Event Info -')

@section('content')


@if(session('success'))

<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

<div class="container px-5 my-5 px-5">
    <div class="container p-3 my-5 border bg-dark text-white">
        <div class="d-flex justify-content-between">
            <div>
                <h4>Event Name: {{$data['reason']}}</h4>
                <h4>Date and Time: <br> {{date('F d, Y h:i a', strtotime($data['start_datetime']))}} -
                    {{date('F d, Y h:i a', strtotime($data['end_datetime']))}} </h4>
                <h4>Contact #: {{$data['contact']}}</h4>
                <h4>Approved Attendees: {{$count}} / {{$data['capacity']}}</h4>
            </div>
            <div>
                <input id="lat-input" autocomplete=false name="lat" value="{{old('lat',$data->lat)}}" type="hidden">
                <input id="lng-input" autocomplete=false name="lng" value="{{old('lng',$data->lng)}}" type="hidden">
                <div id="map-canvas" style="height: 200px; width: 300px; margin:0px; padding: 0px;"></div>
                
            </div>
            
        </div>
        
    </div>

    <div class="py-3">
        <h4>Attendee List</h4>
        <div class="col-md-14">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendees as $attendee)
                        <tr>
                            <td>{{$attendee['firstname']}} {{$attendee['lastname']}}</td>
                            <td>{{$attendee['phone']}}</td>
                            <td>{{$attendee['email']}}</td>
                            <td>@if($attendee->remark == "Pending")<span
                                    class="badge bg-warning text-dark">Pending</span>@elseif($attendee->remark ==
                                'Approved')<span class="badge bg-success">Approved</span>@elseif($attendee->remark
                                == 'Denied')<span class="badge bg-danger">Denied</span>@endif</td>
                            <td>{{date('F d, Y', strtotime($attendee['created_at']))}}</td>
                        </tr>

                        @empty
                        <td colspan="5" class="text-center">No Attendees</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($isAttended == null)
        <form method="POST" action="{{ route('join.store') }}">
            @csrf
            <!--Check if the users already joined the event-->

            <input name="event_id" type="hidden" placeholder="" value="{{$event_id}}">
            <!--Check the user id = current user-->
            <div class="mb-5">
                <button type="submit" class="btn btn-primary button-prevent-multiple-submits" id="sub">Join</button>
            </div>
        </form>
        @else
        <a type="button" class="btn btn-danger" href="{{ route('join.cancel', ['id'=>$isAttended->id]) }}">Cancel</a>
        @endif
    </div>
</div>

@push('submit')
<script type="text/javascript" src="{{ asset('js/submit.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBm5P7yY5absXGyhbm_tUMNrLFuTkNoFXk&libraries=drawing,places&v=3.45.8"></script>
<script>
    var map;

    function initialize() {
        let markers = [];
        var myLatlng = {
            lat: parseFloat("{{old('lat',$data->lat)}}"),
            lng: parseFloat("{{old('lng',$data->lng)}}")
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
                title: "{{old('address',$data->address)}}",
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
@endpush
@endsection
