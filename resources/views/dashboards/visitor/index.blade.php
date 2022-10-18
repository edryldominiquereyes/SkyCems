@extends('layouts.visitor')

@section('title', 'Home -')

@section('facility')

<div class="row">
    @forelse($host as $hosts)
    <div class="card mt-4 barangay-img">
    <img class="card-img-top" src="/uploads/avatars/{{ $hosts->avatar }}" alt="">
        <div class="card-body">
            <h3 class="card-title">{{$hosts['brgy']}}</h3>
            <hr>
            <p class="card-text">{{$hosts['firstname']}} {{$hosts['lastname']}} </p>
            <p class="card-text">{{$hosts['address']}}</p>
            <p class="card-text">{{$hosts['phone']}}</p>

        </div>
        <div class="mb-3">
            <a type="button" href="{{ route('visitor.brgy', $hosts['id']) }}">View Events</a>
        </div>
    </div>

    @empty
    <h4>No Available Barangay</h4>
    @endforelse
    <div class="mt-5">
        <h2>Upcoming Events</h2>
        <hr>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Facility</th>
                        <th scope="col">Address</th>
                        <th scope="col">Description</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Date and Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event as $events)
                    @if($events->start_datetime > $hide)
                    <tr class="active-row">
                        <td>{{$events['facility']}}</td>
                        <td>{{$events['address']}}</td>
                        <td>{{$events['reason']}}</td>
                        <td>{{$events['contact']}}</td>
                        <td>{{date('F d, Y h:i a', strtotime($events['start_datetime']))}} -
                            {{date('F d, Y h:i a', strtotime($events['end_datetime']))}} </td>
                    </tr>
                    @endif
                    @empty
                    <td colspan="7" class="text-center">No Events Today.</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
