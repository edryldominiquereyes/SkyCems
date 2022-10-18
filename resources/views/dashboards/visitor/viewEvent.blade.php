@extends('layouts.visitorContent')

@section('title', 'Events -')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

<h4>Join an event</h4>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Organizer</th>
                <th scope="col">Facility</th>
                <th scope="col">Picture</th>
                <th scope="col">Start Date</th>
                <th scope="col">Contact No.</th>
                <th scope="col">Description</th>
                <th scope="col">Capacity</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($facilities as $facility)
            @if($facility->start_datetime > $hide)
            <tr>
                <td>{{$facility['firstname']}} {{$facility['lastname']}}</td>
                <th>{{$facility['facility']}}</th>
                <td><img class="card-img-top facility-img"
                        src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                <td>{{date('F d, Y', strtotime($facility['start_datetime']))}}</td>
                <td>{{$facility['contact']}}</td>
                <td>{{$facility['reason']}}</td>
                <td>{{$facility['capacity']}}</td>
                <td>
                    <a type="button" class="btn btn-success"
                        href="{{ route('join.view', $facility['event_id']) }}">Join</a></td>

            </tr>
            @else
            <tr>
                <td>{{$facility['firstname']}} {{$facility['lastname']}}</td>
                <th>{{$facility['facility']}}</th>
                <td><img class="card-img-top facility-img"
                        src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                <td>{{date('F d, Y', strtotime($facility['start_datetime']))}}</td>
                <td>{{$facility['contact']}}</td>
                <td>{{$facility['reason']}}</td>
                <td>{{$facility['capacity']}}</td>
                <td><a>Closed</a></td>

            </tr>
            @endif
            @empty
            <td colspan="8" class="text-center">No available events</td>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
