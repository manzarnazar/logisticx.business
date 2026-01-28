@extends('frontend.master')

@section('main')



<!-- Start Merchant
		============================================= -->
<div class="contact-style de-padding">
    <div class="container">
        <div class="contact-style-wpr ">
            <div class="contact-style-left">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="contact-page-3">
                            <div class="mb-30">
                                <h5 class="heading-5 mb-5 text-center"> {{ ___('common.confirm_code') }}</h5>
                                <p class="text-center" id="show_message">{{ session('details_message') }}</p>
                            </div>
                            <form method="POST" action="{{ route('signup.emailVerification') }}">
                                @csrf

                                <input type="hidden" name="email" value="{{session('email')}}">

                                <div class="form-group mb-5">
                                    {{-- <label for="otp" class="label-page">Verification Code</label> --}}
                                    <input id="otp" type="number" class="form-control input-style-contact" name="otp" value="{{ old('otp') }}" placeholder="Enter Verification Code" required autocomplete="otp" autofocus>
                                    @error('otp') <span class="text-danger small"> {{ $message }} </span> @enderror
                                </div>

                                <div class="contact-sub-btn">
                                    <button type="submit" class="btn-1 btn-sm w-100"> {{ ___('common.verify') }} </button>
                                </div>

                            </form>


                            <form id="resend" method="POST" action="{{route('signup.resendOTP')}}" onsubmit="submitForm(event)">
                                @csrf
                                <input type="hidden" name="email" value="{{session('email')}}">

                                <p class="text-center pt-4">{{ ___('common.dont_get') }} <a href="javascript:$('#resend').submit();" id="resend_code_submit_btn" class="text-primary">{{ ___('common.resend_code') }}</a></p>
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
