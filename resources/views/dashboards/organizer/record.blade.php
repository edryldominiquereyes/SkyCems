@extends('layouts.organizer')

@section('title', 'Records -')

@section('content')
<div class="container">
    <h2>Reservation Records</h2>
    <hr>
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
                            <th scope="col">Description</th>
                            <th scope="col">Borrowed Items</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                        <tr class="active-row">
                            <td>{{$record['organizer']}}</td>
                            <td>{{$record['contact']}}</td>
                            <td>{{$record['reason']}}</td>
                            <td>{{$record['borrow']}}</td>
                            <td>{{date('F d, Y', strtotime($record['start_datetime']))}} - {{date('F d, Y', strtotime($record['end_datetime']))}}</td>
                            <td>
                                <a type="button" class="btn btn-success"  href="{{ route('event.attendeeList', $record['event_id']) }}">View</a>
                                <a type="button" class="btn btn-danger" href="{{ route('record.delete', ['id'=>$record->event_id]) }}" onClick="return confirm('ALERT: Are You Sure? This will also delete the attendee list record.');">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <td colspan="6" class="text-center">You have no records</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
