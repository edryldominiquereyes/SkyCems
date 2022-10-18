@extends('layouts.host')

@section('title', 'Manage Request -')

@section('content')

<h2>Request Status</h2>
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
                        <th scope="col">Organizer</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Address</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Borrow</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Status</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $pendings)
                    <tr class="active-row">
                        <td>{{$pendings['organizer']}}</td>
                        <td>{{$pendings['contact']}}</td>
                        <td>{{$pendings['facility']}}</td>
                        <td>{{$pendings['address']}}</td>
                        <td>{{$pendings['reason']}}</td>
                        <td>{{$pendings['borrow']}}</td>
                        <td>{{date('F d, Y h:i a', strtotime($pendings['start_datetime']))}} -
                            {{date('F d, Y h:i a', strtotime($pendings['end_datetime']))}}</td>
                        <td>@if($pendings->status == "Pending")<span class="badge bg-warning text-dark">Pending</span>
                            @endif

            
                            @if($pendings->start_datetime && $pendings->end_datetime >= $approves ) <span
                                class="badge bg-danger text-dark">Conflict Schedule</span>
                            @endif
                    

                        </td>
                        <td><a type="button" class="btn btn-success"
                                href="{{ route('status.approve', ['id'=>$pendings->event_id]) }}">Approved</a></td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{$pendings->event_id}}">
                                Deny
                            </button>
                        </td>
                        <td><a type="button" class="btn btn-danger"
                                href="{{ route('status.delete', ['id'=>$pendings->event_id]) }}">Delete</a></td>
                    </tr>

                    @empty
                    <td colspan="10" class="text-center">No pending status</td>
                    @endforelse
                </tbody>
            </table>
            {{$pending->links()}}
        </div>
        @foreach ($pending as $pendings)
        <!-- Modal -->
        <div class="modal fade" id="exampleModal{{$pendings->event_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Remarks:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form role="form" method="POST" action="{{ route('status.deny', ['id'=>$pendings->event_id]) }}">
                        @csrf
                        <div class="modal-body">

                            <label for="remark">Reason for deny</label>

                            <textarea id="remark" name="remark" rows="4" cols="50"></textarea>

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

<hr>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Organizer</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Address</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Borrow</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Status</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approves as $approve)
                    <tr class="active-row table-success">
                        <td>{{$approve['organizer']}}</td>
                        <td>{{$approve['contact']}}</td>
                        <td>{{$approve['facility']}}</td>
                        <td>{{$approve['address']}}</td>
                        <td>{{$approve['reason']}}</td>
                        <td>{{$approve['borrow']}}</td>
                        <td>{{date('F d, Y h:i a', strtotime($approve['start_datetime']))}} -
                            {{date('F d, Y h:i a', strtotime($approve['end_datetime']))}}</td>
                        <td>@if($approve->status == 'Approved')<span
                                class="badge bg-success">Approved</span>@elseif($approve->status == 'Denied')<span
                                class="badge bg-danger">Denied</span>@endif</td>
                        <!-- <td><a type="button" class="btn btn-danger"
                                href="{{ route('status.deny', ['id'=>$approve->event_id]) }}">Deny</a></td> -->
                        <td><a type="button" class="btn btn-danger"
                                href="{{ route('status.delete', ['id'=>$approve->event_id]) }}"
                                onClick="return confirm('Are You Sure? This will finish the event and notify the user.');">Finished</a>
                        </td>
                    </tr>
                    @empty
                    <td colspan="10" class="text-center">No Reservation Request</td>
                    @endforelse

                </tbody>
                <tbody>
                @foreach($denies as $denied)
                    <tr class="active-row table-danger">
                        <td>{{$denied['organizer']}}</td>
                        <td>{{$denied['contact']}}</td>
                        <td>{{$denied['facility']}}</td>
                        <td>{{$denied['address']}}</td>
                        <td>{{$denied['reason']}}</td>
                        <td>{{$denied['borrow']}}</td>
                        <td>{{date('F d, Y h:i a', strtotime($denied['start_datetime']))}} -
                            {{date('F d, Y h:i a', strtotime($denied['end_datetime']))}}</td>
                        <td>@if($denied->status == 'Approved')<span
                                class="badge bg-success">Approved</span>@elseif($denied->status == 'Denied')<span
                                class="badge bg-danger">Denied</span>{{$denied['remark']}} @endif</td>
                        <!-- <td><a type="button" class="btn btn-success"
                                href="{{ route('status.approve', ['id'=>$denied->event_id]) }}">Approved</a></td> -->
                        <td><a type="button" class="btn btn-danger"
                                href="{{ route('status.delete', ['id'=>$denied->event_id]) }}"
                                onClick="return confirm('Are You Sure? This will delete the event and notify the user.');">Delete</a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
