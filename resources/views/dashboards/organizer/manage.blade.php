@extends('layouts.organizer')

@section('title', 'Manage -')

@section('content')
<div class="container">
    <h2>Manage Reservation Status</h2>
    <hr>
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    @if(session('delete'))
    <div class="alert alert-success">
        {{session('delete')}}
    </div>
    @endif

    <div class="mb-3">
        <select class="btn btn-secondary" id="fetchval">
            <option value="">Sort By</option>
            @if(count($filter)>0)
            @foreach ($filter as $filters )
                <option value="{{$filters->event_id}}">{{$filters->status}}</option>
            @endforeach
            @endif
        </select>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Facility</th>
                            <th scope="col">Address</th>
                            <th scope="col">Map</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Borrow Equipment</th>
                            <th scope="col">Date and Time</th>
                            <th scope="col">Status</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @if(count($filter) > 0)
                        @forelse($events as $event)
                        <tr class="active-row">
                            <td>{{$event['facility']}}</td>
                            <td>{{$event['address']}}</td>
                            <td><a href="https://maps.google.com/?q={{$event['lat']}},{{$event['lng']}}" target="_blank">Google Map Link</a></td>
                            <td>{{$event['contact']}}</td>
                            <td>{{$event['reason']}}</td>
                            <td>{{$event['borrow']}}</td>
                            <td>{{date('F d, Y h:i a', strtotime($event['start_datetime']))}} -
                                {{date('F d, Y h:i a', strtotime($event['end_datetime']))}}</td>
                            <td>@if($event->status == "Pending")<span
                                    class="badge bg-warning text-dark">Pending</span>@elseif($event->status ==
                                'Approved')<span class="badge bg-success">Approved</span>@elseif($event->status ==
                                'Denied')<span class="badge bg-danger">Denied</span>@endif {{$event['remark']}}</td>
                            <td>@if($event->status == "Pending")
                                <a type="button" class="btn btn-danger"
                                    href="{{ route('manage.cancel', ['id'=>$event->event_id]) }}">Cancel</a></td>
                            @elseif($event->status == 'Approved')
                            <form id="done" method="POST" action="{{ route('manage.delete', $event->event_id) }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit" class="btn btn-danger donebtn">Done</button>
                            </form>
                            @elseif($event->status == 'Denied')
                            <a id="delete" type="button" class="btn btn-danger"
                                href="{{ route('manage.cancel', ['id'=>$event->event_id]) }}"
                                onClick="return confirm('ALERT: Are You Sure?');">Delete</a></td>
                            @endif
                        </tr>
                        @empty
                        <td colspan="10" class="text-center">You have no events scheduled.</td>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center text-center">
        {{$events->links()}}
        </div>
    </div>
</div>


    
@push('sort')
<script>
$(document).ready(function(){
  $("#fetchval").on('change', function(){
    var filter = $(this).val();
    var getForm = document.getElementsByName('done'); 
    //alert(filter);
    
    $.ajax({
        url: "{{ route('manage.index') }}",
        type: "GET",
        data: {'filter':filter},
        success:function(data){   
            var events = data.events;
            var html = '';
            var done = "{{ route('manage.delete', $event->event_id) }}";
            var denied = "{{ route('manage.cancel', ['id'=>$event->event_id]) }}";
            var pending = "{{ route('manage.cancel', ['id'=>$event->event_id]) }}";

            if(events.length > 0)
            {
                for(let i = 0; i<events.length; i++)
                {
                    if(events[i]['status'] == "Approved")
                    {
                        html +='<tr class="active-row">\
                        <td>'+events[i]['facility']+'</td>\
                        <td>'+events[i]['address']+'</td>\
                        <td><a href="https://maps.google.com/?q='+events[i]['lat']+','+events[i]['lng']+'" target="_blank">Google Map Link</a></td>\
                        <td>'+events[i]['contact']+'</td>\
                        <td>'+events[i]['reason']+'</td>\
                        <td>'+events[i]['borrow']+'</td>\
                        <td>'+events[i]['start_datetime']+'-'+events[i]['end_datetime']+'</td>\
                        <td><span class="badge bg-success text-white">Approved</span></td>\
                        <td><form id="done" method="POST" action="'+ done +'">@csrf<input type="hidden" name="_method" value="DELETE" /><button type="submit" class="btn btn-danger donebtn">Done</button></form></td>\
                        </tr>';
                    }
                    else if(events[i]['status'] == "Denied")
                    {
                        html +='<tr class="active-row">\
                        <td>'+events[i]['facility']+'</td>\
                        <td>'+events[i]['address']+'</td>\
                        <td><a href="https://maps.google.com/?q='+events[i]['lat']+','+events[i]['lng']+'" target="_blank">Google Map Link</a></td>\
                        <td>'+events[i]['contact']+'</td>\
                        <td>'+events[i]['reason']+'</td>\
                        <td>'+events[i]['borrow']+'</td>\
                        <td>'+events[i]['start_datetime']+'-'+events[i]['end_datetime']+'</td>\
                        <td><span class="badge bg-danger">Denied</span>'+events[i]['remark']+'</td>\
                        <td><a id="delete" type="button" class="btn btn-danger" href="'+ denied +'">Delete</a></td>\
                        </tr>';
                    }
                    else if(events[i]['status'] == "Pending")
                    {
                        html +='<tr class="active-row">\
                        <td>'+events[i]['facility']+'</td>\
                        <td>'+events[i]['address']+'</td>\
                        <td><a href="https://maps.google.com/?q='+events[i]['lat']+','+events[i]['lng']+'" target="_blank">Google Map Link</a></td>\
                        <td>'+events[i]['contact']+'</td>\
                        <td>'+events[i]['reason']+'</td>\
                        <td>'+events[i]['borrow']+'</td>\
                        <td>'+events[i]['start_datetime']+'-'+events[i]['end_datetime']+'</td>\
                        <td><span class="badge bg-warning text-dark">Pending</span></td>\
                        <td><a type="button" class="btn btn-danger" href="'+ pending +'">Cancel</a></td>\
                        </tr>';
                    }
                    //document.getElementById("done").innerHTML
                  
                }
            }
            else
            {
                html +='<tr colspan="10" class="text-center">No data found...\
                </tr>';
            }
                  
            $("#tbody").html(html);
        }
    });
  });
});
</script>
@endpush
@endsection
