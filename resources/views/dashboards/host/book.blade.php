@extends('layouts.host')

@section('title', 'Book -')

@section('content')
<h2>Book a facility</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Facility</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Book Facility</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                    <tr class="active-row">
                        <td>{{$facility['facility']}}</td>
                        <td><img class="profile_image facility-img"
                                src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                        <td><a type="button" class="btn btn-success"
                                href="{{ route('calendar.view', $facility['facility_id']) }}">Schedule</a></td>
                    </tr>
                    @empty
                    <td colspan="3" class="text-center">You have no facility</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
