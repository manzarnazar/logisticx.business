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
<div class="contact-style de-padding">
    <div class="container">
        <div class="contact-style-wpr grid-2">
            <div class="contact-style-left">
                <div class="contact-page-3">
                    <div class="contact-form-title d-flex align-items-center justify-content-between mb-30">
                        <h5 class="heading-5 mb-0">{{ ___('common.sign_up') }} </h5>
                        <div class="contact-phone d-flex align-items-center">
                        </div>
                    </div>
                    <form class="contact-form-1" method="POST" action="{{ route('signUpStore') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_name" class="label-page">{{ ___('label.business_name') }} <span class="text-danger">*</span></label>
                                    <input id="business_name" type="text" class="form-control input-style-contact" name="business_name" value="{{ old('business_name') }}" autocomplete="business_name" autofocus placeholder="{{ ___('label.business_name') }}">
                                    @error('business_name') <span class="text-danger small">{{ $message }} </span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name" class="label-page">{{ ___('label.full_name') }} <span class="text-danger">*</span></label>
                                    <input id="full_name" type="text" class="form-control input-style-contact" name="full_name" value="{{ old('full_name') }}" placeholder="{{ ___('label.full_name') }}">
                                    @error('full_name') <span class="text-danger small">{{ $message }} </span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile" class="label-page">{{ ___('label.mobile_number') }} <span class="text-danger">*</span></label>
                                    <input type="tel" name="mobile" id="mobile" class="form-control input-style-contact" placeholder="{{ ___('label.mobile_number') }}" value="{{ old('mobile') }}" autocomplete="mobile" pattern="^\+?[0-9]{1,4}-?[0-9]{7,14}$">
                                    @error('mobile') <span class="text-danger small">{{ $message }} </span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="label-page">{{ ___('label.email') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control input-style-contact" placeholder="{{ ___('label.email') }}" value="{{ old('email') }}" autocomplete="email">
                                    @error('email') <span class="text-danger small">{{ $message }} </span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="label-page">{{ ___('label.password') }} <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control input-style-contact" value="{{ old('password') }}" placeholder="{{ ___('label.password') }}">
                                    @error('password') <span class="text-danger small">{{ $message }} </span> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="hub" class="label-page">{{ ___('menus.hub') }} <span class="text-danger">*</span> </label>
                                <select name="hub" id="hub" class="form-control input-style-contact form-select select2">
                                    <option value="" @selected(true)>{{ ___('label.select_hub') }}</option>
                                    @foreach($hubs as $hub)
                                    <option value="{{ $hub->id}}" @selected(old('hub')==$hub->id)> {{ $hub->name }}</option>
                                    @endforeach
                                </select>
                                @error('hub') <small class="text-danger small">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="label-page"> {{ ___('label.address') }} <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control input-style-contact" placeholder="{{ ___('label.address') }}" rows="5">{{ old('address')  }}</textarea>
                                @error('address') <span class="text-danger small">{{ $message }} </span> @enderror
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <div class="form-check ml-2">
                                        <input class="form-check-input" type="checkbox" name="policy" id="policy" @checked(old('policy',true))>
                                        <label class="form-check-label" for="policy">{{___('common.i_agree_to') }} <a href="{{ route('/') }}" class="text-primary">{{ settings('name') }}</a> {{___('common.privacy_policy_terms')}} </label>
                                        @error('policy') <span class="text-danger small">{{ $message }} </span> @enderror
                                    </div>
                                </div>
                            </div>

                            @if(settings('recaptcha_status') && settings('recaptcha_status') == 1)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <div class="g-recaptcha" data-sitekey="{{ settings('recaptcha_site_key') }}"></div>
                                        @error('g-recaptcha-response') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>
                            @endif

                        </div>
                        <div class="contact-sub-btn">
                            <button type="submit" class="btn-1 btn-sm w-100"> {{ ___('label.register_my_account')}} </button>
                        </div>
                        <div class="contact-btm-text mb-30 text-center">
                            <span> {{___('frontend.already_have_an_account')}} <a href="{{ route('signin') }}"> {{ ___('label.sign_in') }}</a> </span>
                        </div>

                        @if(settings('facebook_status') || settings('google_status'))
                        <div class="contact-btm-social">
                            <ul class="contact-ll-sc">
                                @if(settings('google_status') == App\Enums\Status::ACTIVE)
                                <li>
                                    <a href="{{ route('social.login','google') }}">
                                        <img src="{{asset('frontend/assets/img/icon/icon-google.png')}}" alt="no image">
                                        <span>{{ ___('label.signup_with_google') }}</span>
                                    </a>
                                </li>
                                @endif
                                @if(settings('facebook_status') == App\Enums\Status::ACTIVE)
                                <li>
                                    <a href="{{ route('social.login','facebook') }}">
                                        <img src="{{asset('frontend/assets/img/icon/icon-fb.png')}}" alt="no image">
                                        <span>{{ ___('label.signup_with_facebook') }}</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="contact-style-right">
                <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::SIGNUP,'signup-image'), 'image_one') }}" alt="Signup image">
            </div>
        </div>
    </div>
</div>
<!-- End Merchant -->

@endsection
