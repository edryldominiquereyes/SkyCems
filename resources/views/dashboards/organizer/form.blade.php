@extends('layouts.organizer')

@section('content')
<div class="container">
<h2>Reservation</h2>
<hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                        <th scope="col">Facility</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Book Facility</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($facilities as $facility)
                    <tr class="active-row">
                        <td>{{$facility['facility']}}</td>
                        <td><img style="width: 250px;height: 210px;" class="profile_image" src="{{ asset('image/' . $facility->image) }}" alt=""></td>
                        <td><a  type="button" class="btn btn-success" href="#">Schedule</a></td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

