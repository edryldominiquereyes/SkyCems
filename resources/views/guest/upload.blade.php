@extends('layouts.visitorcontent')

@section('content')
<div class="container">
    <div class=" text-center mt-5 ">
        <h1>Proof of Payment</h1>
    </div>
    <div class="row ">
        <div class="col-lg-7 mx-auto">
            @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <div class="container">
                        <form enctype="multipart/form-data" role="form" method="POST"
                            action="{{ route('guest.create') }}">
                            @csrf
                            <p>Note: Make sure to input your correct account details*</p>
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_name">First Name *</label> <input
                                                id="firstname" type="text" name="firstname"
                                                class="form-control @error('firstname') is-invalid @enderror"
                                                placeholder="Please enter your firstname *">

                                            @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_lastname">Last Name *</label> <input
                                                id="lastname" type="text" name="lastname"
                                                class="form-control @error('lastname') is-invalid @enderror"
                                                placeholder="Please enter your lastname *">

                                            @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_email">Email *</label> <input
                                                id="email" type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Please enter your email *">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_email">Barangay *</label> <input
                                                id="brgy" type="text" name="brgy"
                                                class="form-control @error('brgy') is-invalid @enderror"
                                                placeholder="Please enter your barangay name *">

                                            @error('brgy')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_need">Payment
                                                *</label> <select id="payment" name="payment"
                                                class="form-control @error('payment') is-invalid @enderror">
                                                <option value="" selected disabled>--Select Payment--</option>
                                                <option value="Activation">Account Activation</option>
                                            </select>

                                            @error('payment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="proof" class="">Upload Proof of Payment *</label>

                                            <input type="file" name="image">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-success btn-send pt-2 btn-block "
                                            value="Send">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- /.8 -->
        </div> <!-- /.row-->
    </div>
</div>
@endsection
