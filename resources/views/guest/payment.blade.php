@extends('layouts.visitorcontent')

@section('title', 'Payment -')

@section('content')
<div class="container">
    <h2>Payment Options</h2>
    <hr>
    <p>*For Barangay Staff/Officials. 1 time payment for account activation</p>
    <b>GCash Payment</b>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gcash">
        View QR Code
    </button>
    <p>Step 1: Open your GCash App, tap on 'Pay QR' then tap 'Scan QR Code'.</p>
    <p>Step 2: Align your mobile phone's camera over the GCash QR code to scan it. Wait for the next page to load.</p>
    <p>Step 4: Select whether to pay with GCash or with GCredit. Double check all details then select Pay to confirm.
    </p>
    <p>Step 5: You will see your in-app receipt on the screen.
        Click the download button on the upper right hand side, which allows the receipt to be saved as a photo in your
        Computer or phone's gallery.
        A pop-up message will confirm if you were able to successfully screenshot the receipt. Upload the receipt in the
        barangay account registration.</p>

    <b>Paymaya Payment</b>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymaya">
        View QR Code
    </button>
    <p>Step 1: Tap “Send Payment” or “Pay”</p>
    <p>Step 2: Scan the merchant’s QR code displayed in the PayMaya One device</p>
    <p>Step 3: The merchant name and total amount to be paid will be reflected in your screen </p>
    <p>Step 4: Click “Send Payment” or “Pay”</p>
    <p>Step 5: You will receive a confirmation message in the app and via SMS for your successful transaction </p>
    <p>Step 6: Take a screenshot of the confirmation message and upload it in the barangay account registration.</p>

    <!-- <a href="{{ route('guest.upload') }}">Upload Proof of Payment</a> -->
</div>

<!-- Modal for Gcash -->
<div class="modal fade" id="gcash" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">GCASH QR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
            <img class="py-4" style="width: 80%;height: 50%;" class="rounded" src="{{ url('/images/gcashQrCode.jpg') }}" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for paymaya -->
<div class="modal fade" id="paymaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PAYMAYA QR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
            <img class="py-4" style="width: 80%;height: 50%;" class="rounded" src="{{ url('/images/paymayaQrCode.jpg') }}" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection




