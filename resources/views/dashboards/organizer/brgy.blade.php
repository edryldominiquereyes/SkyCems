@extends('layouts.organizer')

@section('title', 'Barangay -')

@section('content')
<div class="container">
    <h2>Available Facility</h2>
    <hr>

    <a type="button" class="btn btn-danger mb-3" href="{{route('organizer.index')}}">Back</a>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Facility</th>
                            <th scope="col">Picture</th>
                            <th scope="col">Address</th>
                            <th scope="col">Map</th>
                            <th scope="col">Description</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Book Facility</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brgy as $brgys)
                        <tr class="active-row">
                            <td>{{$brgys['facility']}}</td>
                            <td><img class="profile_image facility-img" src="{{asset('image/'.$brgys->image)}}" alt=""></td>
                            <td>{{$brgys['address']}}</td>
                            <td><a href="https://maps.google.com/?q={{$brgys['lat']}},{{$brgys['lng']}}" target="_blank">Google Map Link</a></td>
                            <td>{{$brgys['description']}}</td>
                            <td>{{$brgys['capacity']}}</td>
                            <td><a type="button" class="btn btn-success" href="{{route('reserve.calendar', $brgys['facility_id'])}}">Schedule</a></td>
                        </tr>
                        @empty
                        <td colspan="7" class="text-center">No Facility</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection