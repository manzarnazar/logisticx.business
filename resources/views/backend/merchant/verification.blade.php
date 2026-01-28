@include('backend.partials.header')
<!-- email verification password  -->
<div class="splash-container">
    <div class="card">
        <div class="row">
            <div class="col-12 col-md-6 offset-3">
                <div class="card-header d-flex">
                    <div class="m-auto text-center">
                        <a href="{{url('/')}}">
                            <img class="logo-img" src="{{ logo(settings('light_logo')) }}" alt="logo">
                        </a> <br>
                        <span class="splash-description">Confirm OTP</span>
                    </div>
                </div>
                <div class="card-body">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p class="text-center">{!! \Session::get('success') !!}</p>
                    </div>
                    @elseif (\Session::has('warning'))
                    <div class="alert alert-warning">
                        <p class="text-center">{!! \Session::get('warning') !!}</p>
                    </div>
                    @endif
                    <form method="POST" action="{{route('merchant.otp-verification')}}">
                        @csrf
                        <p class="text-center">Check Your Phone. We have sent you a 5 digit OTP. Please confirm that OTP to verify you phone number for registration. <br><strong>{{ substr(session('mobile'), 0, 2).'********'.substr(session('mobile'), -2)}}<br>
                            </strong> <br>
                        </p>
                        <div class="form-group">
                            <input type="hidden" name="mobile" value="{{session('mobile')}}">
                            <input id="otp" type="number" class="form-control input-style-1" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus placeholder="OTP *">
                            @error('otp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-primary btn-xl">Submit</button>
                    </form>
                    <form id="resend" method="POST" action="{{route('merchant.resend-otp')}}">
                        @csrf
                        <input type="hidden" name="mobile" value="{{session('mobile')}}">
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
