@extends('layouts.admin')

@section('title', 'Dashboard -')

@section('content')
<h2>Host Management</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Barangay</th>
                            <th>Role</th>
                            <th>Proof of Payment</th>
                            <th>Barangay ID</th>
                            <th>Status</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->brgy }}</td>
                            <td>{{ $user->role }}</td>
                            <td><img style="width: 250px;height: 210px;" class="profile_image"
                                src="{{ asset('proof/' . $user->proofPayment) }}" alt=""></td>
                            <td><img style="width: 250px;height: 210px;" class="profile_image"
                                src="{{ asset('proof/' . $user->brgyID) }}" alt=""></td>
                            <td>@if($user->status == 1)<span
                                class="badge bg-success">Active</span>
                                @elseif($user->status == 0)<span
                                class="badge bg-danger">Inactive</span>
                                @endif</td>
                            <td><a type="button" class="btn btn-success"
                                    href="{{ route('status', ['id'=>$user->id]) }}">@if($user->status == 1)
                                    Inactivate
                                    @else Activate @endif</a></td>
                            <td><a type="button" class="btn btn-danger"
                                    href="{{ route('deleteUser', ['id'=>$user->id]) }}">Delete</a></td>
                        </tr>
                        @empty
                        <td colspan="7" class="text-center">No Host Account</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center text-center">
    {{$users->links()}}
    </div>
</div>
@endsection
