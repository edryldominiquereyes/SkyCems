@extends('layouts.host')

@section('title', 'Reservation Logs -')

@section('content')
<h2>Reservation Logs</h2>
<hr>
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
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Address</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Date and Time</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="active-row">
                        <td>{{$log['organizer']}}</td>
                        <td>{{$log['contact']}}</td>
                        <td>{{$log['facility']}}</td>
                        <td>{{$log['address']}}</td>
                        <td>{{$log['reason']}}</td>
                        <td>{{date('F d, Y h:i a', strtotime($log['start_datetime']))}} - {{date('F d, Y h:i a', strtotime($log['end_datetime']))}}</td>
                        <td><a type="button" class="btn btn-success"
                                href="{{ route('reservation.view', $log['event_id']) }}">View</a></td>
                        <td><a type="button" class="btn btn-danger"
                                href="{{ route('reservation.delete', ['id'=>$log->event_id]) }}">Delete</a></td>
                    </tr>
                    @empty
                    <td colspan="9" class="text-center">You have no scheduled events</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
