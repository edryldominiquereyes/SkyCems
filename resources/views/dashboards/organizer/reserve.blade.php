@extends('layouts.organizer')

@section('content')
<div class="container">
    <h2>Reservation</h2>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Facility</th>
                            <th scope="col">Picture</th>
                            <th scope="col">Address</th>
                            <th scope="col">Description</th>
                            <th scope="col">Book Facility</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facilities as $facility)
                        <tr class="active-row">
                            <td>{{$facility['facility']}}</td>
                            <td><img style="width: 250px;height: 210px;" class="profile_image"
                                    src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                            <td>{{$facility['address']}}</td>
                            <td>{{$facility['description']}}</td>   
                            <td><a type="button" class="btn btn-success" href="{{ route('reserve.calendar', $facility['facility_id']) }}">Schedule</a></td> 
                        </tr>
                        @empty
                        <h1>No available facility</h1>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
