@extends('layouts.organizer')

@section('title', 'Profile -')

@section('content')
<h2>Personal Info</h2>
<hr>

@if(session('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif
@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

<div class="row d-flex justify-content-center align-items-center">

    <!-- edit form column -->
    <div class="col-10 col-md-8 col-lg-6">

        <form enctype="multipart/form-data" role="form" action="{{ route('org_profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="text-center">
                <img src="/uploads/avatars/{{ $user->avatar }}" width="30%" height="40%" class="img-thumbnail @error('avatar') is-invalid @enderror">
                <h6>Profile Picture</h6>
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @error('avatar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!-- <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name"
                    value="{{ Auth::user()->firstname }}">

            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name"
                    value="{{ Auth::user()->lastname }}">

            </div> -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                    value="{{ Auth::user()->email }}" name="email">

            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                    value="{{ Auth::user()->address }}" name="address">

            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"
                    value="{{ Auth::user()->phone }}" name="phone">

            </div>
            <div class="mt-4 mb-3">
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Save Changes">
                </div>
            </div>
        </form>
    </div>
</div>

<hr>
<h2>Change Password</h2>

<div class="row d-flex justify-content-center ">

    <!-- edit form column -->
    <div class="col-10 col-md-8 col-lg-6">

        <form role="form" action="{{ route('org_profile.updatePassword') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="oldpassword">Current Password:</label>
                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                    id="old_password" name="old_password" placeholder="Current Password" name="oldpassword">

                @error('old_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">

                <label for="password">New Password:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="New Password" name="npassword">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group">
                <label for="cpassword">Confirm Password:</label>
                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                    id="confirm_password" name="confirm_password" placeholder="Confirm Password" name="cpassword">

                @error('confirm_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <div class="mt-4 mb-4">
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Change Password" required>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
