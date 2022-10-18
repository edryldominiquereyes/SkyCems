@extends('layouts.hostcalendar')

@section('title', 'Reservation -')

@section('content')

@push('hostcalendar')
<!-- Fullcalendar Integration -->
<link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}" />
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
@endpush



<h2>Reservation</h2>
<hr>
@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif
<!-- Modal -->

<div class="row">
    <div class="col-md-9">
        <div style="position:relative;z-index:-0;">
            <div id="calendar"></div>
            <br>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardt rounded-0 shadow">
            <div class="card-header bg-gradient bg-primary text-light">
                <h5 class="card-title">Reservation Details</h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form role="form" method="POST" action="{{ route('calendar.create') }}">
                        @csrf
                        <input name="facility_id" type="hidden" placeholder="" value="{{$facility_id}}">
                        <div class="mb-3">
                            <label for="reason">Reason for reservation?</label>
                            <textarea name="reason" class="form-control  @error('reason') is-invalid @enderror" required autocomplete="reason" id="reason" rows="3">
                        </textarea>
                        @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                        </div>

                        <div class="mb-3">
                            <label for="start_datetime">Start Date Time:</label>
                            <input name="start_datetime" id="start_datetime" class="form-control @error('start_datetime') is-invalid @enderror" readonly>
                        @error('start_datetime')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror  
                        </div>

                        <div class="mb-3">
                            <label for="end_datetime">End Date Time:</label>
                            <input name="end_datetime"  class="form-control  @error('end_datetime') is-invalid @enderror" id="end_datetime" readonly>
                        @error('end_datetime')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror  
                        </div>

                        <div class="text-left mb-5">
                            <button type="submit" class="btn btn-primary button-prevent-multiple-submits">Submit</button>
                            <a class="btn btn-danger" href="{{ route('calendar.index')}}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>

@push('submit')
<script type="text/javascript" src="{{ asset('js/submit.js') }}"></script>

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.datetimepicker.full.js') }}"></script>

<script>

var today = new Date();
today = new Date(today.setDate(today.getDate() + 40)).toISOString().slice(0, 16);

    $('#start_datetime').datetimepicker({
        locale: 'en',
        formatTime: 'h:i A',
        minDate: '0',
        maxDate: today,
        allowTimes:['08:00', '09:00', '10:00 ','11:00', 
        '12:00', '13:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'
        ],

    });
</script>

<script>
    var today = new Date();
    today = new Date(today.setDate(today.getDate() + 40)).toISOString().slice(0, 16);

    $('#end_datetime').datetimepicker({
        locale: 'en',
        formatTime: 'h:i A',
        minDate: '0',
        maxDate: today,
        allowTimes:['08:00', '09:00', '10:00 ','11:00', 
        '12:00', '13:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'
        ],  
    
    });
</script>
@endpush

@endsection