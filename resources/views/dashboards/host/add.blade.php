@extends('layouts.host')

@section('title', 'Manage Facility -')

@section('content')
<h2>Manage Facility</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="py-2">
            <a type="button" class="btn btn-success" href="{{ route('facility.store') }}">Add Facility</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif
        @if(session('delete'))
        <div class="alert alert-danger">
            {{session('delete')}}
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Facility Name</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Description</th>
                        <th scope="col">Barangay</th>
                        <th scope="col">Map</th>
                        <th scope="col">Capacity</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                    <tr class="active-row">
                        <td>{{$facility['facility']}}</td>
                        <td><img class="profile_image facility-img" src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                        <td>{{$facility['description']}}</td>
                        <td>{{$facility['address']}}</td>
                        <td><a href="https://maps.google.com/?q={{$facility['lat']}},{{$facility['lng']}}" target="_blank">Google Map Link</a></td>
                        <td>{{$facility['capacity']}}</td>
                        <td><a class="btn btn-success" href="{{ route('facility.edit', ['id'=>$facility->facility_id]) }}">Update</a>
                        </td>
                        <td><a class="btn btn-danger" href="{{ route('facility.delete', ['id'=>$facility->facility_id]) }}">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <td colspan="7" class="text-center">You have no facility</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection