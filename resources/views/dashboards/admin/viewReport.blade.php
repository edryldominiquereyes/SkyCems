@extends('layouts.admin')

@section('title', 'Reports -')

@section('content')

<h2>Reports</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">
    <a class="btn btn-danger" href="{{ route('admin.report')}}">Back</a>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Facility Name</th>
                            <th scope="col">Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">Problem/Issue Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($view as $views)
                        <tr class="active-row">
                            <td>{{$views['facility']}}</td>
                            <td>{{$views['firstname']}} {{$views['lastname']}}</td>
                            <td>{{$views['phone']}}</td>
                            <td>{{$views['issue']}}</td>
                        </tr>
                        @empty
                            <td colspan="5" class="text-center">No Reports</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
