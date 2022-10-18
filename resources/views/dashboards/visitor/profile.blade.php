@extends('layouts.visitorcontent')

@section('title', 'Profile -')

@section('content')
<form enctype="multipart/form-data" class="form-horizontal" role="form" action="{{ route('visitor_profile.update') }}"
    method="POST">
    @csrf
    @method('PUT')
    <div class="container rounded bg-white mt-5 mb-5">
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
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="img-thumbnail @error('avatar') is-invalid @enderror" src="/uploads/avatars/{{ $user->avatar }}" alt="">
                    <h6>Profile Picture</h6>
                    <input type="file" name="avatar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @error('avatar')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Personal Information</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="control-label">First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname"
                                placeholder="First Name" value="{{ Auth::user()->firstname }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname"
                                placeholder="Last Name" value="{{ Auth::user()->lastname }}" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="control-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                value="{{ Auth::user()->email }}" name="email" readonly>
                        </div>
                        <!-- <div class="col-md-12">
                            <label class="labels">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                                value="{{ Auth::user()->address }}" name="address">
                        </div> -->
                        <div class="col-md-12">
                            <label class="labels">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"
                                value="{{ Auth::user()->phone }}" name="phone">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <input type="submit" class="btn btn-success button-prevent-multiple-submits" value="Save Changes">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<form enctype="multipart/form-data" class="form-horizontal" role="form"
    action="{{ route('visitor_profile.updatePassword') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Change Password</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="control-label">Current Password</label>
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password">

                            @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">New password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Confirm password</label>
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password">

                            @error('confirm_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <input type="submit" class="btn btn-success button-prevent-multiple-submits" value="Change Password">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('submit')
<script type="text/javascript" src="{{ asset('js/submit.js') }}"></script>
@endpush

@endsection
