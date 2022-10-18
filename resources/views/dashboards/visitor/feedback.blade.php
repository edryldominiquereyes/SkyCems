@extends('layouts.visitorContent')

@section('title', 'Feedback -')

@section('content')

<div class="container rounded bg-white mt-5 mb-5">
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    <h1 class="agile_head text-center">Feedback Form</h1>

    <div class="container">
        <h2>Please help us to serve you better by taking a couple of minutes.</h2>
        <form class="form-horizontal" method="POST" action="{{ route('manage_event.store')}}">
            @csrf
            <input name="event_id" type="hidden" value="{{$event_id}}">
            <h3>How satisfied were you with our service?</h3>
            <ul class="agile_info_select">

                <div class="check w3">
                    <input type="radio" name="rating" value="excellent" id="rating" required>
                    <label for="rating" value="excellent">Excellent</label>           
                </div>

                <div class="check w3">
                    <input type="radio" name="rating" value="good" id="rating">
                    <label for="rating">Good</label>
                </div>

                <div class="check w3ls">
                    <input type="radio" name="rating" value="neutral" id="rating">
                    <label for="rating">Neutral</label>
                </div>

                <div class="check wthree">
                    <input type="radio" name="rating" value="poor" id="rating">
                    <label for="rating">Poor</label> 
                </div>

            </ul>
            <h3>If you have specific feedback, please write to us.</h3>
            <textarea placeholder="Additional comments" class="container" id="comment" name="comment"
                required=""></textarea>
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 text-center">
                        <input type="submit" class="btn btn-success" value="Submit Feedback">
                    </div><br>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
