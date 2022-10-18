@extends('layouts.admin')

@section('title', 'Facility -')

@section('content')

<h2>Manage Facility</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Facility Name</th>
                            <th scope="col">Picture</th>
                            <th scope="col">Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">Description</th>
                            <th scope="col">Barangay</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facilities as $facility)
                        <tr class="active-row">
                            <td>{{$facility['facility']}}</td>
                            <td><img style="width: 250px;height: 210px;" class="profile_image"
                                    src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                            <td>{{$facility['firstname']}} {{$facility['lastname']}}</td>    
                            <td>{{$facility['phone']}}</td>      
                            <td>{{$facility['description']}}</td>
                            <td>{{$facility['address']}}</td>
                            <td>{{$facility['capacity']}}</td>
                            <td><a class="btn btn-danger"
                                    href="{{ route('deleteFacility', ['id'=>$facility->facility_id]) }}">Remove</a>
                            </td>
                        </tr>
                        @empty
                        <td colspan="8" class="text-center">Host has not added a facility</td>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center text-center">
    {{$facilities->links()}}
    </div>
</div>
@endsection
