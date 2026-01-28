@extends('frontend.master')

@section('main')



<!-- Start Merchant
		============================================= -->
<div class="contact-style de-padding new-login-form">
    <div class="container">
        <div class="contact-style-wpr ">
            <div class="contact-style-left">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-0 shadow position-relative h-100">
                            <div class="card-header px-0 pb-4 mb-4">


                            <div>
                                <!-- <h4 class="mb-2">Welcome</h4>
                                <p class="mb-0">Sign In Your Accout</p> -->
                                <h2 class=" hero-title-2 border-start ps-3 border-3 border-primary text-left lh-1 mb-4 text-dark fw-semibold d-inline-block">{{ ___('common.confirm_code') }}</h2>
                                <p class="mb-3">{{ ___('common.confirm_code_message') }}</p>
                                <p class="" id="show_message">{{ session('details_message') }}</p>
                            </div>

                            </div>
                            <div class="card-body px-0">

                            <form method="POST" action="{{ route('password.otpVerification') }}">
                                @csrf

                                <input type="hidden" name="email" value="{{session('email')}}">

                                <div class="form-group mb-4">

                                    <label for="email" class="form-label mb-2 text-dark">{{ ___('common.verification_code') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="otp" id="otp"
                                        class="form-control ps-4 rounded-pill"
                                        placeholder="{{___('placeholder.verification_code')}}" value="{{ old('otp') }}"
                                        autocomplete="otp">
                                    @error('otp') <span class="text-danger small">{{ $message }} </span>
                                    @enderror


                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn-two rounded-pill w-100" value="{{ ___('common.verify') }} ">
                                    </div>
                                </div>

                            </form>

                            <form id="resend" method="POST" action="{{route('forgotPassword')}}" onsubmit="submitForm(event)">
                                @csrf
                                <input type="hidden" name="resend_otp" value="true">
                                <input type="hidden" name="email" value="{{session('email')}}">

                                <div class="col-12">
                                    <hr class="horizontal">
                                    <p class=" text-center mb-0"> {{ ___('common.dont_get') }} <a href="javascript:$('#resend').submit();" id="resend_code_submit_btn" class="text-primary"> {{ ___('common.resend_code') }}</a> </p>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Merchant -->

@endsection

@push('scripts')
<script src="{{asset('frontend')}}/js/send_code.js"></script>

@endpush
