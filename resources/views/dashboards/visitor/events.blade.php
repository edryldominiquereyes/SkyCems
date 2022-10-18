@extends('layouts.visitorContent')

@section('title', 'Events -')

@section('content')

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
<h4>Events Today</h4>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Organizer</th>
                <th scope="col">Facility</th>
                <th scope="col">Picture</th>
                <th scope="col">Contact</th>
                <th scope="col">Description</th>
                <th scope="col">Address</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{$event['organizer']}}</td>
                <th>{{$event['facility']}}</th>
                <td><img class="card-img-top facility-img"
                        src="{{ asset('image/' . $event->image) }}" alt=""></td>
                <td>{{$event['contact']}}</td>
                <td>{{$event['reason']}}</td>
                <td>{{$event['address']}}</td>
                
                @if($event->end_datetime < $todayDates)
                <td><a type="button" class="btn btn-success" href="{{ route('manage_event.view', $event['event_id']) }}">Send
                        Feedback</a></td>    
                @else
                    <td>Event starts at {{date('F d, Y', strtotime($event['start_datetime']))}} - {{date('h:i a', strtotime($event['end_datetime']))}}</td>  
                @endif
    
                @empty
                <td colspan="7" class="text-center">You have no events today</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $events->links() }}

    <h4>Records</h4>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Organizer</th>
                <th scope="col">Facility</th>
                <th scope="col">Contact</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Address</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
            <tr>
                <td>{{$record['organizer']}}</td>
                <th>{{$record['facility']}}</th>
                <td>{{$record['contact']}}</td>
                <td>{{$record['reason']}}</td>
                <td>{{$record['address']}}</td>
                
                @empty
                <td colspan="7" class="text-center">You have no past events</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $records->links() }}
</div>

@endsection
