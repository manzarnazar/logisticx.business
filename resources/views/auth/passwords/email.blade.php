@include('backend.partials.header')

<!-- email verification password  -->
<div class="splash-container">
    <div class="card">
        <div class="row">
            <div class="col-lg-6 offset-3">
                <div class="card-header d-flex">
                    <div class="m-auto text-center">
                        <a href="{{url('/')}}" class="navbar-brand">
                            <img class="logo-img" src="{{ logo(settings('light_logo')) }}" class="logo" alt="logo">
                        </a>
                        <span class="splash-description">Reset Password</span>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert"> {{ session('status') }} </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <p>Don't worry, we'll send you an email to reset your password.</p>
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                            @error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-primary ml-0">Send Password Reset Link</button>
                    </form>
                </div>
                <div class="card-footer text-center bg-none">
                    {{-- <span>Don't have an account? <a href="{{ route('register') }}">Sign Up</a> | <a href="{{ route('login') }}">Sign In</a></span> --}}
                    <span>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a> | <a href="{{ route('signin') }}">Sign In</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end email verification password  -->
@include('backend.partials.footer')
