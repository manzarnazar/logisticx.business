@extends('frontend.master')

@section('title')
{{ ___('frontend.signup')}}
@endsection

@section('main')

<!-- Start Breadcrumb
		============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ ___('label.signup') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="index.html">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.signup') }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Merchant
		============================================= -->

<section class="new-login-form py-80 w-100">
    <div class="container">
        <div class="row g-lg-5 align-items-stretch">
            <div class="col-lg-6 d-flex flex-grow-1 flex-column">
                <div class="form-left h-100 d-lg-block d-none">
                    <div class="img-thumb ">
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::SIGNUP, 'signup-image'), 'original') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex flex-grow-1 flex-column">
                <div class="card border-0 shadow position-relative h-100">
                    <div class="card-header px-0 pb-4 mb-4 ">
                        <div>
                            <!-- <h4 class="mb-2">Sign Up</h4> -->
                            <h2 class=" hero-title-2 border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fw-semibold d-inline-block">{{ ___('label.sign_up') }}</h2>
                            <p class="mb-0">{{ ___('label.sign_up_your_account') }}</p>
                        </div>
                    </div>
                    <div class="card-body p-0 ">
                        <form class="contact-form-1" method="POST" action="{{ route('signUpStore') }}">
                            @csrf
                            <div class="row g-3 g-md-4">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="business_name" class="form-label mb-2 ">{{ ___('label.business_name') }} <span class="text-danger">*</span></label>
                                        <input id="business_name" type="text" class="form-control ps-4 rounded-pill" name="business_name" value="{{ old('business_name') }}" autocomplete="business_name" autofocus placeholder="{{ ___('label.business_name') }}">
                                        @error('business_name') <span class="text-danger small">{{ $message }} </span> @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="full_name" class="form-label mb-2 ">{{ ___('label.full_name') }} <span class="text-danger">*</span></label>
                                        <input id="full_name" type="text" class="form-control ps-4 rounded-pill" name="full_name" value="{{ old('full_name') }}" placeholder="{{ ___('label.full_name') }}">
                                        @error('full_name') <span class="text-danger small">{{ $message }} </span> @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-0">

                                        <label for="mobile" class="form-label mb-2 ">{{ ___('label.mobile_number') }} <span class="text-danger">*</span></label>
                                        <input type="tel" name="mobile" id="mobile" class="form-control ps-4 rounded-pill" placeholder="{{ ___('label.mobile_number') }}" value="{{ old('mobile') }}" autocomplete="mobile" pattern="^\+?[0-9]{1,4}-?[0-9]{7,14}$">
                                        @error('mobile') <span class="text-danger small">{{ $message }} </span> @enderror

                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-0">

                                        <label for="email" class="form-label mb-2 ">{{ ___('label.email') }} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control ps-4 rounded-pill" placeholder="{{ ___('label.email') }}" value="{{ old('email') }}" autocomplete="email">
                                        @error('email') <span class="text-danger small">{{ $message }} </span> @enderror


                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-0">

                                        <label for="password" class="form-label mb-2 ">{{ ___('label.password') }} <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control ps-4 rounded-pill" value="{{ old('password') }}" placeholder="{{ ___('label.password') }}">
                                        @error('password') <span class="text-danger small">{{ $message }} </span> @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-0">

                                        <label for="hub" class="form-label mb-2 ">{{ ___('menus.hub') }} <span class="text-danger">*</span> </label>
                                        <select name="hub" id="hub" class="form-select ps-4 rounded-pill select2">
                                            <option value="" @selected(true)>{{ ___('label.select_hub') }}</option>
                                            @foreach($hubs as $hub)
                                            <option value="{{ $hub->id}}" @selected(old('hub')==$hub->id)> {{ $hub->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('hub') <small class="text-danger small">{{ $message }}</small> @enderror

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">

                                        <label for="address" class="form-label mb-2 "> {{ ___('label.address') }} <span class="text-danger">*</span></label>
                                        <textarea name="address" id="address" class="form-control ps-4" placeholder="{{ ___('label.address') }}" rows="5">{{ old('address')  }}</textarea>
                                        @error('address') <span class="text-danger small">{{ $message }} </span> @enderror

                                    </div>
                                </div>

                                @if(settings('recaptcha_status') && settings('recaptcha_status') == 1)
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <div class="form-check">
                                            <div class="g-recaptcha" data-sitekey="{{ settings('recaptcha_site_key') }}"></div>
                                            @error('g-recaptcha-response') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                    </div>
                                </div>
                                @endif

                                <div class="col-12">
                                    <div class="form-check mb-0 d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" name="policy" id="policy" @checked(old('policy',true))>
                                        <label class="form-check-label " for="policy">{{___('common.i_agree_to') }} <a href="{{ route('/') }}" class="fw-semibold text-primary">{{ settings('name') }}</a> <a href="#" class="fw-normal"> {{___('common.privacy_policy_terms')}} </a></label>
                                    </div>
                                    @error('policy') <span class="text-danger small">{{ $message }} </span> @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn-1 rounded-pill w-100" >{{ ___('label.register_my_account') }}</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="horizontal mt-3 mb-4 ">

                                    <p class=" text-center">{{ ___('label.Already_Have_An_Account?') }} <a href="{{ route('signin') }}" class="text-primary">{{ ___('label.sign_in') }}</a></p>
                                </div>


                            </div>
                        </form>

                        @if(settings('facebook_status') || settings('google_status'))
                        <div class="bottom-btn d-flex flex-wrap justify-content-center justify-content-center flex-md-nowrap align-items-center gap-4">

                            @if(settings('google_status') == App\Enums\Status::ACTIVE)
                            <a href="{{ route('social.login',['social' => 'google']) }}" class="form-btn d-flex align-items-center justify-content-center"><i class="fa-brands fa-google me-3 fs-2"></i>{{ ___('label.signup_with_google') }}</a>
                            @endif

                            @if(settings('facebook_status') == App\Enums\Status::ACTIVE)
                            <a href="{{ route('social.login',['social' => 'facebook']) }}" class="form-btn d-flex align-items-center justify-content-center"><i class="fa-brands fa-facebook me-3 fs-2"></i>{{ ___('label.signup_with_facebook') }}</a>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- End Merchant -->

@endsection
