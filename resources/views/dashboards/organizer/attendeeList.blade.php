@extends('layouts.organizer')

@section('title', 'Manage -')

@section('content')

@push('print')
<script type="text/javascript" src="{{ asset('js/print.js') }}"></script>
@endpush

<div class="container">
    <h2>Attendee List</h2>
    <hr>
    @if(session('delete'))
    <div class="alert alert-danger">
        {{session('delete')}}
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif

    <div class="row justify-content-center">

        <div class="col-auto float-right ml-auto">
            <button onclick="printFunction()" class="btn btn-white"><i class="fa fa-print fa-lg">PDF</i></button>
        </div>

        <div class="col-md-12" id="print">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr style="text-align:center">
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approve as $approves)
                        <tr class="table-success" style="text-align:center">
                            <td>{{$approves['firstname']}} {{$approves['lastname']}}</td>
                            <td>{{$approves['phone']}}</td>
                            <td>{{$approves['email']}}</td>
                        
                        </tr>
                        @empty
                        <td colspan="5" class="text-center">You have no attendees</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


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
    </div>
</div>
@endsection
