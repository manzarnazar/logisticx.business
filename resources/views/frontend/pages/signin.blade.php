@extends('frontend.master')

@section('title')
{{ ___('frontend.signin')}}
@endsection

@section('main')

<!-- Start Breadcrumb
		============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
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

<!-- Start Merchant
		============================================= -->

<section class="new-login-form py-80 max-form">
    <div class="container">
        <div class="row g-lg-5 align-items-stretch">
            <div class="col-lg-6 d-flex flex-grow-1 flex-column ">
                <div class="form-left h-100 d-lg-block d-none">
                    <div class="img-thumb">
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::SIGNIN, 'singin_image'), 'original') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex flex-grow-1 flex-column">
                <div class="card border-0 shadow position-relative h-100">
                    <div class="card-header border-bottom px-0 pb-4 mb-4">
                        <div>
                            <!-- <h4 class="mb-2">Welcome</h4>
                                    <p class="mb-0">Sign In Your Accout</p> -->
                            <h2 class=" hero-title-2 border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fw-semibold d-inline-block">{{ ___('label.signin') }}</h2>
                            <p class="mb-0 lh-1">{{ ___('label.Sign_In_Your_Accout') }}</p>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form method="POST" action="{{ route('signin') }}" autocomplete="off">
                            @csrf
                            <div class="row g-3 g-md-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input id="email" type="email" name="email" class="form-control rounded-pill" placeholder="{{ ___('label.enter_email') }}" @if(Cookie::has('useremail')) ? value="{{Cookie::get('useremail')}}" : value="{{ old('email') }}" @endif>
                                        <span class="first-icon"><i class="fa-solid fa-envelope"></i></span>

                                        @error('email') <p class="text-danger mt-2 mb-0">{{$message}}</p> @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="password" class="form-control c-password rounded-pill" id="password" name="password" placeholder="{{ ___('label.enter_password') }}" @if(Cookie::has('userpassword')) value="{{Cookie::get('userpassword')}}" @endif>
                                        <span class="second-icon"><i class="fa-regular fa-eye-slash"></i></span>
                                        <span class="first-icon"><i class="fa-solid fa-lock"></i></span>
                                        @error('password') <p class="text-danger mt-2 mb-0">{{$message}}</p> @enderror
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
                                <div class="col-12">
                                    <div class="form-group d-flex align-items-center gap-2 justify-content-between">
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} @if(Cookie::has('useremail')) checked @endif>
                                            <label class="form-check-label" for="remember">{{ ___('label.remember_me') }}</label>
                                        </div>
                                        <a href="{{ route('forgotPasswordForm') }}" class="fw-normal">{{ ___('label.forgot_password')}} ?</a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn-1 rounded-pill w-100">{{ ___('label.signin') }}</button>
                                    </div>

                                    @if(config('app.app_demo'))
                                    <p class="text-center py-3 border-bottom">{{ ___('label.try_login_as') }}</p>

                                    <div class="row g-1 gx-sm-3 align-items-center">
                                        @foreach (demoUsers() as $user )
                                        <div class="col-6 px-2">
                                            <a href="{{ route('demo.login',['email'=>$user->email]) }}" class="btn-1 rounded-pill w-100">{{ $user->name }}</a>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <hr class="horizontal mt-3 mb-4">

                                    <p class=" text-center mb-0">{{ ___('label.Dont_Have_An_Account?') }}  <a href="{{route('signup')}}" class="text-primary">{{ ___('label.sign_up') }}</a></p>
                                </div>
                            </div>
                        </form>

                        @if(settings('facebook_status') || settings('google_status'))
                        <div class="bottom-btn d-flex flex-wrap flex-md-nowrap justify-content-center align-items-center gap-4 mt-3">

                            @if(settings('google_status') == App\Enums\Status::ACTIVE)
                            <a href="{{ route('social.login',['social' => 'google']) }}" class="form-btn d-flex align-items-center justify-content-center"><i class="fa-brands fa-google me-3 fs-2"></i>{{ ___('label.Signin_with_Google') }}</a>
                            @endif

                            @if(settings('facebook_status') == App\Enums\Status::ACTIVE)
                            <a href="{{ route('social.login',['social' => 'facebook']) }}" class="form-btn d-flex align-items-center justify-content-center"><i class="fa-brands fa-facebook me-3 fs-2"></i>{{ ___('label.signin_with_facebook') }}</a>
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
