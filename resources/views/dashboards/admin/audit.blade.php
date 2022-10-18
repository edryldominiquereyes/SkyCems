@extends('layouts.admin')

@section('title', 'Audit Logs -')

@section('content')

<h2>Audit Logs</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">User Action</th>
                            <th scope="col">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($log as $logs)
                        <tr>
                            <td>{{$logs['firstname']}} {{$logs['lastname']}}</td>
                            <td>{{$logs['role']}}</td>
                            <td>{{$logs['audit_desc']}}</td>
                            <td>{{date('F d, Y h:i a', strtotime($logs['date']))}}</td>
                        </tr>
                        @empty
                        <td colspan="4" class="text-center">No records</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center text-center">
        {{$log->links()}}
    </div>

</div>
@endsection
