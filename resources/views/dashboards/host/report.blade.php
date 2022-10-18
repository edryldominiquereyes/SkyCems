@extends('layouts.host')

@section('content')
<div class="container">
    <h2>Reports</h2>
    <hr>

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
@endsection
