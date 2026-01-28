@include('backend.partials.header')

<header>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</header>

<!-- signup form  -->
<form class="splash-container" method="POST" action="{{ route('merchant.sign-up-store') }}">
    @csrf
    <div class="card">
        <div class="row">
            <div class="col-lg-6 offset-3">
                <div class="card-header d-flex">
                    <div class="m-auto text-center">
                        <a href="{{url('/')}}" class="navbar-brand">
                            <img class="logo-img" src="{{ logo(settings('light_logo')) }}" class="logo" alt="logo">
                        </a>
                        <h5 class="mb-1">Registrations Form</h5>
                        <p>Please enter your user information.</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input id="business_name" type="text" class="form-control  input-style-1" name="business_name" value="{{ old('business_name') }}" autocomplete="business_name" autofocus placeholder="Business Name *">
                        @error('business_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>

                    <div class="form-group">
                        <input id="full_name" type="text" class="form-control input-style-1  " name="full_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus placeholder="Full Name*">
                        @error('full_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                    <div class="form-group">
                        <select class="form-control input-style-1 select2" name="hub_id">
                            <option selected disabled>Select Hub</option>
                            @foreach ($hubs as $hub)
                            <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                            @endforeach
                        </select>
                        @error('hub_id')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="mobile" type="number" class="form-control input-style-1  " name="mobile" value="{{ old('mobile',$request->phone ? $request->phone : "") }}" autocomplete="mobile" placeholder="Mobile *">
                        @error('mobile') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control input-style-1 " name="password" autocomplete="new-password" placeholder="Password *">
                        @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>

                    <div class="form-group">
                        <textarea name="address" id="address" class="form-control input-style-1  " placeholder="Address *" rows="5">{{ old('address')  }}</textarea>
                        @error('address') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                    </div>

                    <div class="form-group">
                        <label class=" form-check">
                            <input id="merchant_registration_checkbox" name="policy" class="  form-check-input" type="checkbox"><span class=" ">I agree to <a href="#" class="text-primary">{{ settings('name') }}</a> Privacy Policy & Terms.</span>
                        </label>
                    </div>
                    <div class="form-group pt-2">
                        <button id="merchant_registration_submit" class="btn btn-block btn-primary" type="submit">Register My Account</button>
                    </div>

                </div>
                <div class="card-footer bg-white">
                    <p>Already member? <a href="{{ route('login') }}" class="text-primary">Login Here.</a></p>
                </div>
            </div>
        </div>
    </div>
</form>
@include('backend.partials.footer')
