@extends('frontend.master')

@section('title')
{{ ___('frontend.signin')}}
@endsection

@section('main')

<!-- Start Breadcrumb
		============================================= -->
<div class="site-breadcrumb" style="background: url({{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'original') }})">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ ___('label.signin') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{route('/')}}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.signin') }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Merchant ============================================= -->
<div class="contact-style de-padding">
    <div class="container">
        <div class="contact-style-wpr grid-2">
            <div class="contact-style-left">
                <div class="contact-page-3">
                    <div class="contact-form-title d-flex align-items-center justify-content-between mb-30">
                        <h5 class="heading-5 mb-0"> {{ ___('label.signin') }} </h5>
                        <div class="contact-phone d-flex align-items-center">
                            {{-- <img src="{{asset('frontend')}}/assets/img/icon/phone.png" class="d-inline-block mr-10" alt="no image"> <span>Phone Sign in</span> --}}
                        </div>

                        @if (session()->has('danger'))
                        <span class="alert alert-danger ">{{ session('danger') }}</span>
                        @endif

                    </div>
                    <form method="POST" action="{{ route('signin') }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email" class="label-page">{{ ___('label.email')}} </label>
                                    <input id="email" type="email" name="email" class="form-control input-style-contact" autofocus placeholder="Enter Email or Mobile" @if(Cookie::has('useremail')) ? value="{{Cookie::get('useremail')}}" : value="{{ old('email') }}" @endif>
                                    @error('email') <span class="text-danger small"> {{ $message }} </span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 my-4">
                                <div class="form-group">
                                    <label for="password" class="label-page label-forgot"> {{ ___('label.password')}} <a href="{{ route('forgotPasswordForm') }}">{{ ___('label.forgot_password')}} ?</a> </label>
                                    <input id="password" type="password" name="password" class="form-control input-style-contact" placeholder="Password" @if(Cookie::has('userpassword')) value="{{Cookie::get('userpassword')}}" @endif>
                                    @error('password') <span class="text-danger small"> {{ $message }} </span> @enderror
                                </div>
                            </div>
                            @if(settings('recaptcha_status') == 1)
                            <div class="col-md-12 my-4">

                                <div class="g-recaptcha" data-sitekey="{{ settings('recaptcha_site_key') }}"></div>

                                @error('g-recaptcha-response')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror

                            </div>
                            @endif
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check ml-2">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} @if(Cookie::has('useremail')) checked @endif>
                                        <label class="form-check-label" for="remember"> {{ ___('label.remember_me') }} </label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="contact-sub-btn">
                            <button type="submit" class="btn-1 btn-sm w-100"> {{ ___('label.signin') }} </button>

                            @if(config('app.app_demo'))
                            <div class="row mt-3">
                                @foreach (demoUsers() as $user )
                                <div class="col-sm-6">
                                    <a href="{{ route('demo.login',['email'=>$user->email]) }}" class="btn-1 btn-sm w-100 mb-3">{{ ___('label.login_as') }} {{ $user->name }}</a>
                                </div>
                                @endforeach
                            </div>
                            @endif

                        </div>


                        <div class="contact-btm-text mb-30 text-center">
                            <span> {{ ___('label.Do_not_have_an_account')}} <a href="{{ route('signup') }}"> {{ ___('label.signup_here') }} </a> </span>
                        </div>

                        @if(settings('facebook_status') || settings('google_status'))
                        <div class="contact-btm-social">
                            <ul class="contact-ll-sc">

                                @if(settings('google_status') == App\Enums\Status::ACTIVE)
                                <li>
                                    <a href="{{ route('social.login','google') }}">
                                        <img src="{{asset('frontend')}}/assets/img/icon/icon-google.png" alt="no image">
                                        <span>{{ ___('label.signup_with_google') }}</span>
                                    </a>
                                </li>
                                @endif
                                @if(settings('facebook_status') == App\Enums\Status::ACTIVE)
                                <li>
                                    <a href="{{ route('social.login','facebook') }}">
                                        <img src="{{asset('frontend')}}/assets/img/icon/icon-fb.png" alt="no image">
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
                <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::SIGNIN,'singin_image'), 'image_one') }}" alt="Signin image">
            </div>
        </div>
    </div>
</div>
<!-- End Merchant -->

@endsection

@push("scripts")

@endpush
