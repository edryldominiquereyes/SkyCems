@extends('layouts.calendar')

@section('title', 'Reservation -')

@section('content')

@push('calendar')
<!-- Fullcalendar Integration -->
<link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}" />
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
@endpush

<h2>Reservation</h2>
<hr>
@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif


<div class="row">
    <div class="col-md-9">
        <!-- Button trigger modal -->
        <div style="position:relative;z-index:-0;">
            <div id="calendar"></div>
        </div>

        <!-- <div class="form-group">
            <label for="address">Address:</label>

            <input id="pac-input" autocomplete=false name="address" value="{{$facility->address}}" type="text" class="form-control" placeholder="Search Here">
            <input id="lat-input" autocomplete=false name="lat" value="{{$facility->lat}}" type="hidden">
            <input id="lng-input" autocomplete=false name="lng" value="{{$facility->lng}}" type="hidden">
        </div> -->

        <div class="form-group">
            <div id="map-canvas" style="height: 500px; margin:0px; padding: 0px;"></div>
        </div>
    </div>
    <div class="col-md-3 mt-5">

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Report Facility</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" action="{{route('reserve.report')}}">
                            @csrf
                            <input name="facility_id" type="hidden" placeholder="" value="{{$facility_id}}">

                            <div class="mb-3">
                                <label for="issue">Description:</label>
                                <textarea name="issue" class="form-control @error('issue') is-invalid @enderror" id="issue" rows="3" required></textarea>

                                @error('issue')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="text-left mb-5">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="cardt rounded-0 shadow">
            <div class="card-header bg-gradient bg-primary text-light">
                <h5 class="card-title">Reservation Details</h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form role="form" method="POST" action="{{route('reserve.create')}}">
                        @csrf

                        <input name="facility_id" type="hidden" placeholder="" value="{{$facility_id}}">
                        <div class="mb-3">
                            <label for="reason">Reason for reservation?</label>
                            <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" id="reason" rows="3"></textarea>

                            @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- <div class="mb-3">
                            <label for="borrow">What are the things you need to borrow from the barangay?</label>
                            <textarea name="borrow" class="form-control @error('borrow') is-invalid @enderror"
                                id="reason" rows="3" placeholder="If none leave it blank."></textarea>

                            @error('borrow')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> -->

                        <div class="mb-3">
                        <label for="borrow">What are the things you need to borrow from the barangay?</label>
                        
                        @foreach (explode(",", $listItem) as $listItems )
                        @if($listItems != null)
                            <input type="checkbox" id="borrow" name="borrow[]" value="{{$listItems}}">
                            <label for="borrow">{{$listItems}}</label><br> 
                        @else
                        <p>No Available Items</p>
                        @endif
                        @endforeach                            
                            <!-- <input type="checkbox" id="borrow" name="borrow[]" value="Table">
                            <label for="borrow">Table</label><br>

                            <input type="checkbox" id="borrow" name="borrow[]" value="Speaker">
                            <label for="borrow">Speaker</label><br>

                            <input type="checkbox" id="borrow" name="borrow[]" value="Microphone">
                            <label for="borrow">Microphone</label><br> -->
                            <!-- @error('borrow')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror -->
                        </div>

                        <div class="mb-3">
                            <label for="start_datetime">Start Date Time:</label>
                            <input name="start_datetime"  id="start_datetime" class="form-control @error('start_datetime') is-invalid @enderror" readonly>

                            @error('start_datetime')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_datetime">End Date Time:</label>
                            <input name="end_datetime" id="end_datetime" class="form-control @error('end_datetime') is-invalid @enderror" readonly>

                            @error('end_datetime')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- <div class="mb-3">
                            <label for="end_time">End Time:</label>
                            <input name="end_time" type="time"
                                class="form-control @error('end_time') is-invalid @enderror" id="end_time">

                            @error('end_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> -->

                        <div class="text-left mb-5">
                            <button type="submit" class="btn btn-primary button-prevent-multiple-submits">Submit</button>
                            <a class="btn btn-danger" href="{{route('visitor.index')}}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer text-center">
            <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#exampleModal">
            Report Facility
            </button>
            </div>
        </div> 
    </div>
</div>

@push('submit')
<script type="text/javascript" src="{{ asset('js/submit.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd4I4XlnPTLA6G8iZqBQFDy0GhfZDY5xo&libraries=drawing,places&v=3.45.8"></script>
<script>
    var map;

    function initialize() {
        let markers = [];
        var myLatlng = {
            lat: parseFloat("{{$facility->lat}}"),
            lng: parseFloat("{{$facility->lng}}")
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
                title: "{{$facility->address}}",
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

<script type="text/javascript" src="{{ asset('js/submit.js') }}"></script>

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.datetimepicker.full.js') }}"></script>

<script>

    var today = new Date();
    today = new Date(today.setDate(today.getDate() + 40)).toISOString().slice(0, 16);

    $('#start_datetime').datetimepicker({
        locale: 'en',
        formatTime: 'h:i A',
        minDate:'0',
        maxDate: today,
        allowTimes:['08:00', '09:00', '10:00 ','11:00', 
        '12:00', '13:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'
        ],  
    
    });
</script>

<script>
    
    var today = new Date();
    today = new Date(today.setDate(today.getDate() + 40)).toISOString().slice(0, 16);

    $('#end_datetime').datetimepicker({
        locale: 'en',
        formatTime: 'h:i A',
        minDate: '0',
        maxDate: today,
        allowTimes:['08:00', '09:00', '10:00 ','11:00', 
        '12:00', '13:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'
        ],
    
    });
</script>
@endpush

@endsection