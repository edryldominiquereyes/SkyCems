@extends('layouts.organizer')

@section('title', 'Manage Event -')

@section('content')
<div class="container">
    <h2>Manage Event</h2>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Facility</th>
                            <th scope="col">Address</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Date and Time</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr class="active-row">
                            <td>{{$event['facility']}}</td>
                            <td>{{$event['address']}}</td>
                            <td>{{$event['reason']}}</td>
                            <td>{{$event['contact']}}</td>
                            <td>{{date('F d, Y h:i a', strtotime($event['start_datetime']))}} - {{date('F d, Y h:i a', strtotime($event['end_datetime']))}} </td>
                            <td><a type="button" class="btn btn-success" 
                                    href="{{ route('event.view', $event['event_id']) }}">View</a></td>
                        </tr>
                        @empty
                        <td colspan="7" class="text-center">You have no events scheduled.</td>
                       @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
 