@extends('layouts.verify')

@section('title', 'Register -')

@section('content')
<script>
  
    function changeStatus() {
        var status = document.getElementById("role");
        var textbox = "";
        var paymentUrl = "{{ route('guest.payment') }}";
        var csrfToken = "{{ csrf_token() }}";
        if (status.value == "organizer") 
        {
            var div = document.createElement("div");
                    
                    textbox = '<input id="barangay" type="hidden" class="form-control" name="brgy" autofocus>';
                    div.innerHTML = textbox;
                    hiddenBarangay.appendChild(div);

            var div2 = document.createElement("div");
            
                    textbox2 = '<input type="hidden" name="address" class="form-control id="address" rows="3" placeholder="Complete address">';
                    div2.innerHTML = textbox2;
                    hiddenAddress.appendChild(div2);

            var div3 = document.createElement("div");
            
                    textbox3 = '<input type="hidden" name="proofPayment"><input type="hidden" name="_token" value="'+ csrfToken+ '">';
                    div3.innerHTML = textbox3;
                    hiddenproofPayment.appendChild(div3);
            var div4 = document.createElement("div");
            
                    textbox4 = '<input type="hidden" name="brgyID"><input type="hidden" name="_token" value="'+ csrfToken+ '">';
                    div4.innerHTML = textbox4;
                    hiddenbrgyID.appendChild(div4);

            var olddata1=document.getElementById("barangay").lastChild;
            document.getElementById("barangay").removeChild(olddata1);
            var olddata2=document.getElementById("address").lastChild;
            document.getElementById("address").removeChild(olddata2);
            var olddata3=document.getElementById("proofPayment").lastChild;
            document.getElementById("proofPayment").removeChild(olddata3);
            var olddata4=document.getElementById("brgyID").lastChild;
            document.getElementById("brgyID").removeChild(olddata4);
        }
        else if(status.value == "visitor" )
        {
            var div = document.createElement("div");
                    
                    textbox = '<input id="barangay" type="hidden" class="form-control" name="brgy" autofocus>';
                    div.innerHTML = textbox;
                    hiddenBarangay.appendChild(div);

            var div2 = document.createElement("div");
            
                    textbox2 = '<input type="hidden" name="address" class="form-control id="address" rows="3" placeholder="Complete address">';
                    div2.innerHTML = textbox2;
                    hiddenAddress.appendChild(div2);

            var div3 = document.createElement("div");
            
                    textbox3 = '<input type="hidden" name="proofPayment"><input type="hidden" name="_token" value="'+ csrfToken+ '">';
                    div3.innerHTML = textbox3;
                    hiddenproofPayment.appendChild(div3);
            var div4 = document.createElement("div");
            
                    textbox4 = '<input type="hidden" name="brgyID"><input type="hidden" name="_token" value="'+ csrfToken+ '">';
                    div4.innerHTML = textbox4;
                    hiddenbrgyID.appendChild(div4);
            var olddata1=document.getElementById("barangay").lastChild;
            document.getElementById("barangay").removeChild(olddata1);
            var olddata2=document.getElementById("address").lastChild;
            document.getElementById("address").removeChild(olddata2);
            var olddata3=document.getElementById("proofPayment").lastChild;
            document.getElementById("proofPayment").removeChild(olddata3);
            var olddata4=document.getElementById("brgyID").lastChild;
            document.getElementById("brgyID").removeChild(olddata4);
        }
        else if(status.value == "host")
        {
            var div = document.createElement("div");
                    
            textbox = '<div class="row mb-3"><label class="col-md-4 col-form-label text-md-end" for="brgy">Barangay</label><div class="col-md-6"><input id="barangay" type="text" class="form-control" name="brgy" autofocus></div></div>';
            div.innerHTML = textbox;
            barangay.appendChild(div);

            var div2 = document.createElement("div");
                    
            textbox2 = '<div class="row mb-3"><label class="col-md-4 col-form-label text-md-end" for="brgy">Address</label><div class="col-md-6"><textarea name="address" class="form-control id="address" rows="3" placeholder="Complete address"></textarea></div>';
            div2.innerHTML = textbox2;
            address.appendChild(div2);

            var div3 = document.createElement("div");
                    
            textbox3 = '<div class="row mb-3"><label class="col-md-4 col-form-label text-md-end" for="proofPayment">Proof of Payment <a href="'+ paymentUrl +'"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label><div class="col-md-6"><label for="proofPayment" class="form-control">Upload Proof of Payment *</label><input type="file" name="proofPayment"><input type="hidden" name="_token" value="'+ csrfToken+ '"></div>';
            div3.innerHTML = textbox3;
            proofPayment.appendChild(div3);

            var div4 = document.createElement("div");
                    
            textbox4 = '<div class="row mb-3"><label class="col-md-4 col-form-label text-md-end" for="brgyID">Barangay ID </label><div class="col-md-6"><label for="brgyID" class="form-control">Upload Barangay ID *</label><input type="file" name="brgyID"><input type="hidden" name="_token" value="'+ csrfToken+ '"></div>';
            div4.innerHTML = textbox4;
            brgyID.appendChild(div4);

            var olddata1=document.getElementById("hiddenBarangay").lastChild;
            document.getElementById("hiddenBarangay").removeChild(olddata1);
            var olddata2=document.getElementById("hiddenAddress").lastChild;
            document.getElementById("hiddenAddress").removeChild(olddata2);
            var olddata3=document.getElementById("hiddenproofPayment").lastChild;
            document.getElementById("hiddenproofPayment").removeChild(olddata3);
            var olddata4=document.getElementById("hiddenbrgyID").lastChild;
            document.getElementById("hiddenbrgyID").removeChild(olddata4);
        }
        else
        {
            var div = document.createElement("div");
                    
                    textbox = '<input id="barangay" type="hidden" class="form-control" name="brgy" autofocus>';
                    div.innerHTML = textbox;
                    hiddenBarangay.appendChild(div);

            var div2 = document.createElement("div");
            
                    textbox2 = '<input type="hidden" name="address" class="form-control id="address" rows="3" placeholder="Complete address">';
                    div2.innerHTML = textbox2;
                    hiddenAddress.appendChild(div2);

            var div3 = document.createElement("div");
            
                    textbox3 = '<input type="hidden" name="proofPayment"><input type="hidden" name="_token" value="'+ csrfToken+ '">';
                    div3.innerHTML = textbox3;
                    hiddenproofPayment.appendChild(div3);

            var div4 = document.createElement("div");
            
                    textbox4 = '<input type="hidden" name="brgyID"><input type="hidden" name="_token" value="'+ csrfToken+ '">';
                    div4.innerHTML = textbox4;
                    hiddenbrgyID.appendChild(div4);

            var olddata1=document.getElementById("barangay").lastChild;
            document.getElementById("barangay").removeChild(olddata1);
            var olddata2=document.getElementById("address").lastChild;
            document.getElementById("address").removeChild(olddata2);
            var olddata3=document.getElementById("proofPayment").lastChild;
            document.getElementById("proofPayment").removeChild(olddata3);
            var olddata4=document.getElementById("brgyID").lastChild;
            document.getElementById("brgyID").removeChild(olddata4);
        }
    }
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="firstname"
                                class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text"
                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                    value="{{ old('firstname') }}" autofocus>

                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lastname"
                                class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text"
                                    class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                    value="{{ old('lastname') }}" autofocus>

                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Select Role') }}

                                <a href="#" data-toggle="modal" data-target="#roleModal"><i
                                        class="fa fa-question-circle" aria-hidden="true"></i></a>

                            </label>

                            <div class="col-md-6">
                                <select id="role" name="role" onchange="changeStatus()"
                                    class="form-control my-2 @error('role') is-invalid @enderror">
                                    <option value="">Select</option>
                                    <option value="visitor">Visitor</option>
                                    <option value="host">Barangay Staff</option>
                                    <option value="organizer">Organizer</option>
                                </select>

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="barangay"></div> 
                        <div id="address"></div>
                        <div id="proofPayment"></div>
                        <div id="brgyID"></div>

                        <div id="hiddenBarangay"></div>
                        <div id="hiddenAddress"></div>
                        <div id="hiddenproofPayment"></div>
                        <div id="hiddenbrgyID"></div>


                        <!-- <div id="brgy" class="row mb-3">
                            <label for="brgy" class="col-md-4 col-form-label text-md-end">{{ __('Barangay') }}</label>

                            <div class="col-md-6">
                                <input id="brgy" type="text" class="form-control @error('brgy') is-invalid @enderror"
                                    name="brgy" autofocus>

                                @error('brgy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>  -->

                        <!-- <div id="address" class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <textarea name="address" class="form-control  @error('address') is-invalid @enderror" id="address" rows="3" placeholder="Complete address"></textarea>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" placeholder="Ex. 0995-123-1234" autofocus>

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 pw-meter">

                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div class="pw-display-toggle-btn">
                           
                                </div>
                                <div class="pw-strength">
                                    <span>Weak</span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="form-check-label" for="privacy">
                                <p class="text-center">By creating an account you agree to our <a href="#"
                                        data-toggle="modal" data-target="#exampleModalLong">Terms &
                                        Conditions</a>.
                                    <input type="checkbox" class="@error('terms_and_conditions') is-invalid @enderror"
                                        id="terms_and_conditions" name="terms_and_conditions" value="Agree">

                                    @error('terms_and_conditions')
                                    <span class="invalid-feedback row mb-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </label>
                            </p>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary button-prevent-multiple-submits">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <p style="text-align: right;">Already have an account? <a href="login">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Terms and Conditions -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b>Terms and Conditions.</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>The Website Terms and Conditions, which are contained on this webpage, regulate your use
                    of this website. These Terms shall be fully implemented and will apply to your use of this Website.
                    You agreed to accept all of the terms and conditions contained in this document by using this
                    Website. Users shall not use our website if users disagree with any of the Website Standard Terms
                    and conditions listed below.</p>

                <b>Introduction</b>
                <p>1. These terms and conditions shall govern your use of our website.</p>
                <p>2. Registration for a user account, means that you have agreed on these terms and conditions in full.
                </p>
                <b>Copyright</b>
                <p>1. Copyright 2022 Lesley Andaya, Ryan Cinco, Jonathan Lomat and Edryl Reyes.</p>
                <b>Account Register</b>
                <p>1. By clicking "Register", registering, accessing or using our services means you are agreeing to
                    enter
                    a website or agreeing to our Terms and Conditions. If you do not agree to this agreement ("Terms and
                    Conditions"), do not click "Register" and do not access or otherwise use any of our Services.</p>
                <p>2. Only those who registered can view the features of our website.</p>
                <p>3. When you register for or use SkyCems, you give us certain information. This includes your name,
                    email
                    address, phone number, profile photo, and any other information you give us. We collect information,
                    and details about you.</p>
                <p>4. You will have an account by completing and submitting the requirements needed in the register page
                    on our website.</p>
                <p>5. Data Privacy Act of 2012 (RA 10173) is implied, only you who can use your own account.</p>

                <b>Facility Reservation</b>
                <p>1. SkyCems is not responsible for any damages occured in the barangay.</p>
                <p>2. The barangay is responsible for any events that are happening in the barangay.</p>
                <p>3. For Hosts, you are not allowed to cancel reservations 1 day before the scheduled event.</p>

                <b></b>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Roles-->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleTitle"><b>Roles</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Visitor</b> - Interested in Joining Events</p>
                <p><b>Organizer</b> - Reserve facilities for events and Manage your Events</p>
                <p><b>Barangay Staff</b> -Barangay officer/staff will be able to Manage Facilities</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    function onlyNumberKey(evt) {

        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

</script>
@endsection

@push('submit')
<script type="text/javascript" src="{{ asset('js/submit.js') }}"></script>
@endpush

@push('js')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script type="text/javascript">
</script>
@endpush
