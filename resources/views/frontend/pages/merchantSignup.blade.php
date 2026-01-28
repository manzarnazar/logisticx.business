@extends('frontend.master')

@section('main')

<!-- Start Breadcrumb
		============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">Sign up with Merchant</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="index.html">Home</a></li>
                <li class="active">Sign up with Merchant</li>
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
                    <div class="contact-form-title mb-20">
                        <h5 class="heading-5">
                            Sign up with Merchant
                        </h5>
                    </div>
                    <form class="contact-form-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="label-page">Shop Name</label>
                                    <input type="text" class="form-control input-style-contact" placeholder="Shop Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="label-page">Shop Address</label>
                                    <textarea class="form-control input-style-t input-style-contact" placeholder="Shop Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-page">Your First Name</label>
                                    <input type="text" class="form-control input-style-contact" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-page">Your Last Name</label>
                                    <input type="text" class="form-control input-style-contact" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-page">Phone Number</label>
                                    <input type="text" class="form-control input-style-contact" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-page">Email</label>
                                    <input type="email" class="form-control input-style-contact" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-page">Password</label>
                                    <input type="password" class="form-control input-style-contact" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-page">Confirm Password</label>
                                    <input type="password" class="form-control input-style-contact" placeholder="Confirm">
                                </div>
                            </div>
                        </div>
                        <div class="contact-sub-btn">
                            <button type="submit" class="btn-1 btn-sm w-100">
                                Send Message
                            </button>
                        </div>
                        <div class="contact-btm-text text-center">
                            <span>
                                Already have an account?
                                <a href="login.html">Login</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="contact-style-right">
                <img src="{{asset('frontend/assets/img/pictures/contact-right-1.jpg')}}" alt="no image">
            </div>
        </div>
    </div>
</div>
<!-- End Merchant -->



@endsection
