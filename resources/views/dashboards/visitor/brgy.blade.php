@extends('layouts.visitorContent')

@section('title', 'Barangay -')

@section('content')

<h4>Select a Facility</h4>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Barangay</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Address</th>
                        <th scope="col">Map</th>
                        <th scope="col">Contact</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                    <tr class="active-row">
                        <td>{{$facility['brgy']}}</td>
                        <td><img class="card-img-top facility-img" src="{{asset('image/'.$facility->image)}}"></td>
                        <td>{{$facility['address']}}</td>
                        <td><a href="https://maps.google.com/?q={{$facility['lat']}},{{$facility['lng']}}" target="_blank">Google Map Link</a></td>
                        <td>{{$facility['phone']}}</td>
                        <td><a type="button" class="btn btn-success" href="{{route('visitor.viewEvents', $facility['facility_id']) }}">View Events</a></td>
                    </tr>
                    @empty
                    <td colspan="8" class="text-center">No facility</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection