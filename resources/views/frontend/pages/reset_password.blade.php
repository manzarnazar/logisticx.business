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
                                <h2 class=" hero-title-2 border-start ps-3 border-3 border-primary text-left lh-1 mb-4 text-dark fw-semibold d-inline-block">{{ ___('common.reset_password') }}</h2>
                                <p class="mb-0">{{ ___('common.reset_password_message') }}</p>
                            </div>

                        </div>
                        <div class="card-body px-0">

                            <form method="POST" action="{{ route('passwordReset') }}">
                                @csrf

                                <input type="hidden" name="otp" value="{{session('otp')}}">

                                <div class="form-group mb-5">
                                    <label for="password" class="form-label mb-2 text-dark">{{ ___('label.password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control ps-4 rounded-pill" value="{{ old('password') }}" placeholder="Enter Password" required autocomplete="off" autofocus>
                                    @error('password') <span class="text-danger small"> {{ $message }} </span> @enderror
                                </div>

                                <div class="form-group mb-5">
                                    <label for="confirm_password" class="form-label mb-2 text-dark"> {{ ___('common.confirm_password') }} </label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control ps-4 rounded-pill" value="{{ old('confirm_password') }}" placeholder="Enter Confirm Password" required autocomplete="off" autofocus>
                                    @error('confirm_password') <span class="text-danger small"> {{ $message }} </span> @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn-two rounded-pill w-100" value="{{ ___('common.update') }} ">
                                    </div>
                                </div>

                            </form>

                            <div class="col-12">
                                <hr class="horizontal">
                                <p class=" text-center mb-0">  {{ ___('common.know_your_password') }} <a href="{{ route('signin') }}" id="resend_code_submit_btn" class="text-primary">  {{ ___('common.signin_here') }}</a> </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Merchant -->

@endsection
