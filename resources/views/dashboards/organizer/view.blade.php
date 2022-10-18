@extends('layouts.organizer')

@section('title', 'Manage -')

@section('content')

@push('print')
<script type="text/javascript" src="{{ asset('js/print.js') }}"></script>
@endpush

<div class="container">
<h2>ATTENDEE'S LIST</h2>
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

    <div class="row justify-content-center">
        <div class="container p-3 my-5 border bg-dark text-white">
            <h4>Facility: {{$capacity->facility}}</h4>
            <h4>Location: {{$capacity->address}}
                <h4>Capacity: {{$capacity->capacity}}</h4>
                <h4>Approved Attendees: {{$count}} / {{$capacity->capacity}} </h4>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <a type="button" href="" class="btn btn-success" id="approveAll">Approve Selected</a>
            </div>
            <div class="mb-2">
                <button onclick="printFunction()" class="btn btn-white"><i class="fa fa-print fa-lg">PDF</i></button>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><input type="checkbox" id="checkAll"/></th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th colspan="5">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendees as $attendee)
                        <tr id="sid{{$attendee->id}}">
                            <td><input type="checkbox" name="ids" class="checkBoxClass" value="{{$attendee->id}}" /></td>
                            <td>{{$attendee['firstname']}} {{$attendee['lastname']}}</td>
                            <td>{{$attendee['phone']}}</td>
                            <td>{{$attendee['email']}}</td>
                            <td>@if($attendee->remark == "Pending")<span
                                    class="badge bg-warning text-dark">Pending</span>@elseif($attendee->remark ==
                                'Approved')<span class="badge bg-success">Approved</span>@elseif($attendee->remark
                                == 'Denied')<span class="badge bg-danger">Denied</span>@endif
                                @if($count ==
                                $capacity->capacity)<span class="badge bg-danger">Overcapacity</span>@endif
                            </td>
                            <td colspan="3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#approveModal{{$attendee->id}}">
                                    Approve
                                </button>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{$attendee->id}}">
                                    Deny
                                </button>

                            </td>
                            <td><a type="button" class="btn btn-danger"
                                    href="{{ route('event.delete', ['id'=>$attendee->id]) }}">Remove</a></td>
                        </tr>
                        @empty
                        <td colspan="6" class="text-center">You have no pending attendees</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>

        <div class="col-md-12" id="print">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr style="text-align:center">
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <!-- <th scope="col">Status</th> -->
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approve as $approves)
                        <tr class="table-success" style="text-align:center">
                            <td>{{$approves['firstname']}} {{$approves['lastname']}}</td>
                            <td>{{$approves['phone']}}</td>
                            <td>{{$approves['email']}}</td>
                            <!-- <td>@if($approves->remark == "Pending")<span
                            class="badge bg-warning text-dark">Pending</span>@elseif($approves->remark ==
                        'Approved')<span class="badge bg-success">Approved</span>@elseif($approves->remark
                        == 'Denied')<span class="badge bg-danger">Denied</span>@endif</td> -->
                            <td><a type="button" class="btn btn-danger"
                                    href="{{ route('event.delete', ['id'=>$approves->id]) }}">Remove</a></td>
                        </tr>
                        @empty
                        <td colspan="5" class="text-center">You have no attendees</td>
                        @endforelse

                        @forelse($denied as $denies)
                        <tr class="table-danger" style="text-align:center">
                            <td>{{$denies['firstname']}} {{$denies['lastname']}}</td>
                            <td>{{$denies['phone']}}</td>
                            <td>{{$denies['email']}}</td>
                            <!-- <td>@if($denies->remark == 'Denied')<span class="badge bg-danger">Denied</span>@endif</td> -->
                            <td><a type="button" class="btn btn-danger"
                                    href="{{ route('event.delete', ['id'=>$denies->id]) }}">Remove</a></td>
                        </tr>
                        @empty
                        <!-- <td colspan="5" class="text-center">You have no denied attendees</td> -->
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">

                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div> -->

        <h4>Feedback</h4>

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Experience</th>
                            <th scope="col">Feedback</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                        <tr>
                            <td>{{$feedback['rating']}}</td>
                            <td>{{$feedback['comment']}}</td>
                            <td><a type="button" class="btn btn-danger"
                                    href="{{ route('event.deleteFeedback', ['id'=>$feedback->id]) }}">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <td colspan="3" class="text-center">No feedback</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @foreach($attendees as $attendee)
        <!-- Modal for deny -->
        <div class="modal fade" id="exampleModal{{$attendee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Remarks:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form role="form" method="POST" action="{{ route('event.deny', ['id'=>$attendee->id]) }}">
                            @csrf
                            <div class="modal-body">

                                <label for="comment">Reason for deny</label>

                                <textarea id="comment" name="comment" rows="4" cols="50"></textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal for approve -->
            <div class="modal fade" id="approveModal{{$attendee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModal">Remarks:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form role="form" method="POST" action="{{ route('event.approve', ['id'=>$attendee->id]) }}">
                            @csrf
                            <div class="modal-body">

                                <label for="comment">Reason for approve</label>

                                <textarea id="comment" name="comment" rows="4" cols="50"></textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('checkbox')
<script>
$(function(e){
    $("#checkAll").click(function(){
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

    $("#approveAll").click(function(e){
        e.preventDefault();
        var allids = [];

        $("input:checkbox[name=ids]:checked").each(function(){
            allids.push($(this).val());
        });

        $.ajax({
           url:"",
           type:"",
           data:{
               ids:allids
           }, 
           success:function(response){
               $.each(allids, function(key,val){
                   $("#sid"+val).append();
               })
           }
        });
    })
});
</script>
@endpush

@endsection