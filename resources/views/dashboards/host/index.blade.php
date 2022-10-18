@extends('layouts.host')

@section('title', 'Home -')

@section('content')
<div class="container">
    <h2>Welcome! {{auth()->user()->firstname}} {{auth()->user()->lastname}} </h2>
    <hr>
    <div class="row justify-content-center">
        @if($nowTime == auth()->user()->created_at)
        <div class="alert alert-success" role="alert">
            Your account has been activated | {{$nowTime}}
        </div>
        @endif
        <!-- <img src=" {{asset('images/logo.png')}}"  class="img-fluid" alt="Responsive image" >  -->
        <div class="column">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
            </ol> -->
                <div class="carousel-inner">
                    @forelse($event as $key => $events)
                    <div class="carousel-item {{$key == 0 ? 'active' : '' }}">

                        <img src="{{url('image', $events->image)}}" class="d-block w-100"
                            style=" width:640px; height: 500px;" alt="">

                    </div>
                    @empty
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ asset('/images/logo.png') }}"
                            style=" width:640px; height: 500px;" alt="Second slide">

                    </div>
                    @endforelse
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('/images/logo.png') }}"
                            style=" width:640px; height: 500px;" alt="Second slide">
                    </div>
                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"> </span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <div class="card-header">
                    Barangay Reports
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <h5>Total Facility: {{$facility}}</h5>
                    <h5>Approved Events: {{$approved}}</h5>
                    <h5>Pending Events: {{$pending}}</h5>

                </div>
            </div>
        </div>


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
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)

                    <tr class="active-row">
                        <td>{{$data['organizer']}}</td>
                        <td>{{$data['contact']}}</td>
                        <td>{{$data['facility']}}</td>
                        <td>{{$data['address']}}</td>
                        <td>{{$data['reason']}}</td>
                        <td>{{$data['borrow']}}</td>
                        <td>{{date('F d, Y h:i a', strtotime($data['start_datetime']))}} -
                            {{date('F d, Y h:i a', strtotime($data['end_datetime']))}}</td>
                        <td>@if($data->status == "Pending")<span class="badge bg-warning text-dark">Pending</span>
                            @endif</td>
                    </tr>
                    @empty
                    <td colspan="10" class="text-center">No pending events</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('bootstrap')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endpush

@endsection
