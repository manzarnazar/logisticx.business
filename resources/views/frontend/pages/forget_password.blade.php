@extends('frontend.master')

@section('main')



<!-- Start Merchant
		============================================= -->
<div class="contact-style de-padding new-login-form">
    <div class="container">
        <div class="contact-style-wpr ">
            <div class="contact-style-left">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                            <div class="card border-0 shadow position-relative h-100">
                                <div class="card-header px-0 pb-3 mb-3 border-bottom">
                         


                                    <div>
                                        <!-- <h4 class="mb-2">Welcome</h4>
                                        <p class="mb-0">Sign In Your Accout</p> -->
                                        <h2 class=" hero-title-2 border-start ps-3 border-3 border-primary text-left lh-1 mb-4 text-dark fw-semibold d-inline-block"> {{ ___('common.forgot_your_password') }}</h2>
                                        <p class="mb-0">{{___('common.forgot_password_msg')}}</p>
                                    </div>


                                </div>
                                <div class="card-body p-0">
                                    <form method="POST" action="{{ route('forgotPassword') }}">
                                        @csrf



                                        <div class="form-group mb-4">

                                            <label for="email" class="form-label mb-2 text-dark">{{ ___('label.email')
                                                }} <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email"
                                                class="form-control ps-4 rounded-pill"
                                                placeholder="{{ ___('label.email') }}" value="{{ old('email') }}"
                                                autocomplete="email">
                                            @error('email') <span class="text-danger small">{{ $message }} </span>
                                            @enderror


                                        </div>


                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn-1 rounded-pill w-100" >{{___('frontend.send_reset_code') }}</button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr class="horizontal my-4">

                                            <p class=" text-center mb-0 lh-1">{{ ___('frontend.know_your_password') }} <a href="{{route('signin')}}" class="text-primary">{{ ___('frontend.signin_here') }}</a></p>
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