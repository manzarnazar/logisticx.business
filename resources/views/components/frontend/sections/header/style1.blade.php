<!-- Start Topbar
    ============================================= -->
<div class="top-bar-area pos-rel bg-theme-2 topbar-white py-3">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Top left part -->
            <div class="col-xl-6 col-lg-6">
                <div class="top-box-wrp-1">
                    <div class=" top-box">
                        <ul class="top-adss">
                            <li>
                                <i>
                                    <img src="{{asset('frontend')}}/assets/img/icon/icon-top-1-wh.png" alt="no image">
                                </i>
                                <span>+012345678910</span>
                            </li>
                            <li>
                                <i>
                                    <img src="{{asset('frontend')}}/assets/img/icon/icon-top-2-wh.png" alt="no image">
                                </i>
                                <span>{{ settings('email') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Top left part -->

            <!-- Top Right part -->
            <div class="col-xl-6 col-lg-6">
                <div class="top-box-wrp">
                    <div class="drop-box">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                En
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Bd</a></li>
                                <li><a class="dropdown-item" href="#">Jy</a></li>
                            </ul>
                        </div>
                        <ul class="top-social-2 d-flex">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Top Right part -->

        </div>
    </div>
</div>
<!-- Start Topbar-->

<!-- Start header
    ============================================= -->
<header class="header">
    <div class="main-navigation">
        <div class="main-wrapper">
            <div class="navbar navbar-expand-lg bsnav bsnav-sticky bsnav-sticky-slide">
                <div class="container">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img src="{{asset('frontend')}}/assets/img/logo/logo.png" class="logo-display" alt="thumb">
                        <img src="{{asset('frontend')}}/assets/img/logo/logo.png" class="logo-scrolled" alt="thumb">
                    </a>
                    <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>

                    <!-- Top Menu  -->

                    <div class="collapse navbar-collapse justify-content-md-center">
                        <ul class="navbar-nav navbar-mobile mr-0">
                            <li class="nav-item dropdown fadeup">
                                <a class="nav-link" href="#">Home <i class="ti-angle-down"></i></a>
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a class="nav-link" href="{{route('frontend.home1')}}">Home Version 1</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{route('frontend.home2')}}">Home Version 2</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown fadeup">
                                <a class="nav-link" href="#">Pages <i class="ti-angle-down"></i></a>
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a class="nav-link" href="{{route('frontend.about')}}">About Us</a></li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('frontend.privacy_return')}}">
                                            Privacy & Return Policy
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('frontend.terms_condition')}}">
                                            Terms & Conditions
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('frontend.signup')}}">
                                            Sign up
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('frontend.signin')}}">
                                            Sign In
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('frontend.track')}}">
                                            Tracking Parcel
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.charges')}}">Charges</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.coverage')}}">Coverages</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.blog')}}">Blogs</a></li>
                            <!-- <li class="nav-item dropdown fadeup">
									<a class="nav-link" href="#">Blog <i class="ti-angle-down"></i></a>
									<ul class="navbar-nav">
										<li class="nav-item"><a class="nav-link" href="{{route('frontend.blog')}}">Blog</a></li>

									</ul>
								</li> -->
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.contactUs')}}">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- Top Menu  -->

                    <!-- Sign In  -->

                    <div class="search-cart nav-profile">
                        <a href="{{route('frontend.signin')}}" class="btn-1 btn-second btn-sm btn-lgn">
                            <i class="site-login">
                                <img src="{{asset('frontend')}}/assets/img/icon/log-in.png" alt="no image">
                            </i>
                            Sign In
                        </a>
                    </div>

                    <!-- End Sign In   -->
                </div>
            </div>
            <div class="bsnav-mobile">
                <div class="bsnav-mobile-overlay"></div>
                <div class="navbar">
                    <img src="{{asset('frontend')}}/assets/img/logo/logo.png" class="logo-scrolled" alt="thumb">
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End header -->
