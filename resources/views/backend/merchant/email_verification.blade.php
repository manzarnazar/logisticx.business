@include('backend.partials.header')
<!-- email verification password  -->
<div class="splash-container">
    <div class="card">
        <div class="row">
            <div class="col-12 col-md-6 offset-3">
                <div class="card-header d-flex">
                    <div class="m-auto text-center">
                        <a href="{{url('/')}}"> <img class="logo-img" src="{{ logo(settings('light_logo')) }}" alt="logo"> </a> <br>
                        <span class="splash-description">{{ ___('label.confirm_otp')}}</span>
                    </div>
                </div>
                <div class="card-body">

                    <p class="text-center">We have sent you an OTP to {{session('email')}}. Please confirm that OTP to verify your email address for registration. </p>

                    <form method="POST" action="{{route('signup.emailVerification')}}">
                        @csrf

                        <div class="form-group">
                            <input type="hidden" name="email" value="{{session('email')}}">
                            <input id="otp" type="number" class="form-control" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus placeholder="OTP *">
                            @error('otp') <span class="text-danger"> {{ $message }} </span> @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-primary btn-xl">Submit</button>
                    </form>

                    <form id="resend" method="POST" action="{{route('signup.resendOTP')}}">
                        @csrf
                        <input type="hidden" name="email" value="{{session('email')}}">
                        <p class="text-center pt-4">Didn't get? <a href="javascript:$('#resend').submit();" class="text-primary">Resend Code!</a></p>
                    </form>

                </div>
                <div class="card-footer bg-white ">
                    <p class="text-center">Already member? <a href="{{ route('login') }}" class="text-primary">Login Here.</a></p>
                </div>
            </div>
        </div>


    </div>
</div>
@include('backend.partials.footer')
