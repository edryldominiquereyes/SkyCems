@extends('layouts.organizer')

@section('title', 'Home -')

@section('content')
<div class="container">
    <h2>Register Event</h2>
    <hr>

    <div class="row">
        @forelse($brgy as $brgys)
        <div class="card mt-2 mb-3 barangay-img">
            <img class="card-img-top" src="/uploads/avatars/{{ $brgys->avatar }}" alt="">
            <div class="text-center">
                <div class="card-body">
                    <h3 class="card-title">{{$brgys['brgy']}}</h3>
                    <hr>
                    <p class="card-text">{{$brgys['firstname']}} {{$brgys['lastname']}}</p>
                    <p class="card-text">{{$brgys['address']}}</p>
                    <p class="card-text">{{$brgys['phone']}}</p>

                </div>
                <div class="mb-3">
                    <a type="button" class="btn btn-success"
                        href="{{ route('organizer.barangay', ['id'=>$brgys->id]) }}">View Facility</a>
                </div>
            </div>
        </div>
        @empty
        <h4>No available barangay</h4>
        @endforelse
    </div>
</div>



@endsection
