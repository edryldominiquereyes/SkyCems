@extends('layouts.host')

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

    
        <div class="container p-3 my-5 border bg-dark text-white">
            <h4>Facility: {{$capacity->facility}}</h4>
            <h4>Location: {{$capacity->address}}
            <h4>Capacity: {{$capacity->capacity}}</h4>
            <h4>Approved Attendees: {{$count}} / {{$capacity->capacity}} </h4>
        </div>
            <button onclick="printFunction()" class="btn btn-white"><i class="fa fa-print fa-lg">PDF</i></button>
        </div>
        <div class="col-md-14">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <!-- <th scope="col">Status</th> -->
                        <th colspan="4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendees as $attendee)
                    <tr>
                        <td>{{$attendee['firstname']}} {{$attendee['lastname']}}</td>
                        <td>{{$attendee['phone']}}</td>
                        <td>{{$attendee['email']}}</td>
                        <td>@if($attendee->remark == "Pending")<span
                                class="badge bg-warning text-dark">Pending</span>@elseif($attendee->remark ==
                            'Approved')<span class="badge bg-success">Approved</span>@elseif($attendee->remark
                            == 'Denied')<span class="badge bg-danger">Denied</span>@endif
                            @if($count ==
                            $capacity->capacity)<span class="badge bg-danger">Overcapacity</span>@endif</td>
                        <td colspan="3"><a type="button" class="btn btn-success"
                                href="{{ route('reservation.approve', ['id'=>$attendee->id]) }}">Approve</a> <a
                                type="button" class="btn btn-danger"
                                href="{{ route('reservation.deny', ['id'=>$attendee->id]) }}">Deny</a></td>
                        <td><a type="button" class="btn btn-danger"
                                href="{{ route('reservation.deleteAttendee', ['id'=>$attendee->id]) }}">Remove</a></td>
                    </tr>
                    @empty
                    <td colspan="5" class="text-center">You have no pending attendee yet</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<h4>Approved Attendees</h4>

<div class="col-md-14" id="print">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr style="text-align:center">
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <!-- <th scope="col">Status</th> -->
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($approve as $approves)
                <tr style="text-align:center">
                    <td>{{$approves['firstname']}} {{$approves['lastname']}}</td>
                    <td>{{$approves['phone']}}</td>
                    <td>{{$approves['email']}}</td>
                    <!-- <td>@if($approves->remark == "Pending")<span
                            class="badge bg-warning text-dark">Pending</span>@elseif($approves->remark ==
                        'Approved')<span class="badge bg-success">Approved</span>@elseif($approves->remark
                        == 'Denied')<span class="badge bg-danger">Denied</span>@endif</td> -->
                    <td><a type="button" class="btn btn-danger"
                            href="{{ route('reservation.deleteAttendee', ['id'=>$approves->id]) }}">Remove</a></td>
                </tr>
                @empty
                <td colspan="6" class="text-center">You have no attendees</td>
                @endforelse

                @forelse($denied as $denies)
                    <tr style="text-align:center">
                        <td>{{$denies['firstname']}} {{$denies['lastname']}}</td>
                        <td>{{$denies['phone']}}</td>
                        <td>{{$denies['email']}}</td>
                        <!-- <td>@if($denies->remark == 'Denied')<span class="badge bg-danger">Denied</span>@endif</td> -->
                        <td><a type="button" class="btn btn-danger"
                                href="{{ route('reservation.deleteAttendee', ['id'=>$denies->id]) }}">Remove</a></td>
                    </tr>
                @empty
                    <!-- <td colspan="5" class="text-center">You have no attendees</td> -->
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <h4>Feedback</h4>

    <div class="col-md-14">
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
                                href="{{ route('reservation.deleteFeedback', ['id'=>$feedback->id]) }}">Delete</a></td>
                    </tr>
                    @empty
                    <td colspan="3" class="text-center">No feedback</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
