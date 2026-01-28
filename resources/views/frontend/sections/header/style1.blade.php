<!-- Start Topbar    ============================================= -->

<div class="top-bar-area d-none d-xl-block" @if($header->background === 'bg_color') data-background-color="{{ $header->bg_color }}"
    @elseif($header->background === 'bg_image') data-background="{{ getImage($header->upload) }}"
    @endif>
    {{-- @dd($languages) --}}

    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Top left part -->
            <div class="top-box-wrp-1">
                <div class=" top-box">
                    <ul class="top-adss">
                        {{-- <li> <i class="fa-solid fa-phone"></i> <span>{{ settings('phone') }}</span> </li> --}}
                        <li> <i class="fa-solid fa-phone"></i> <a href="#">{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'phone') }}</a> </li>
                        <li> <i class="fa-solid fa-envelope"></i> <a href="#">{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'email') }}</a> </li>
                    </ul>

                </div>
            </div>
            <!-- End Top left part -->

            <!-- Top Right part -->
            <div class="top-box-wrp flex-grow-1">
                <ul class="top-social-2">

                    <li><i class="fa-solid fa-location-dot me-2"></i>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'address') }}</li>

                    <li class="d-flex">
                        <div class="dropdown dropdown-menu-start pe-5 ">
                            <a class="btn dropdown-toggle fw-normal p-0 text-white shadow-none border-0 border-end border-light border-opacity-50 pe-5 lh-sm rounded-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- <img src="{{asset('frontend/assets/img/icon/017-australia.png')}}" alt=""> {{ Str::upper(defaultLanguage()->code) }} --}}
                                <i class="{{ defaultLanguage()->icon_class }}"></i> {{ Str::upper(defaultLanguage()->code) }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                @foreach ($languages as $lang)
                                <li><a class="dropdown-item text-black" href="{{ route('setlocalization', $lang->code) }}"> <i class="{{ @$lang->icon_class }}"></i> {{ @$lang->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            @foreach ($socialLinks as $social )
                            <a href="{{ $social->link }}"><i class=" {{ $social->icon }}"></i></a>
                            @endforeach
                        </div>
                    </li>

                    {{-- <li>
                        
                    </li> --}}

                </ul>
            </div>
        </div>
        <!-- End Top Right part -->

    </div>
</div>
</div>

<!-- End Topbar-->

<!-- Start header one    ============================================= -->
<header class="header">
    <div class="main-navigation">
        <div class="main-wrapper">
            <div class="px-0 py-3 py-lg-0 navbar navbar-expand-lg headerSticky">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img src="{{ logo(settings('dark_logo')) }}" class="logo-display" alt="logo">
                        <img src="{{ logo(settings('light_logo')) }}" class="light-logo" alt="Logo">
                    </a>

                    <div class="d-lg-none d-flex align-items-center gap-3">
                        {{-- <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button> --}}
                        <button class="dark-mode-toggle rounded-circle d-lg-none">
                            <i class="dark-mode-icon {{ session('theme') == 'dark'? 'ti-shine text-white':'fa-solid fa-moon' }}"></i>
                        </button>
                        <div class="menu-bars c-pointer border rounded-circle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" role="button">
                            <i class="fa-solid fa-bars-staggered"></i>
                        </div>
                        
                    </div>

                    <!-- Top Menu  -->

                    <div class="collapse navbar-collapse justify-content-md-center">
                        <ul class="navbar-nav nav-one navbar-mobile me-auto">
                            @if(!config('app.app_demo'))
                            <li class="nav-item"><a class="nav-link" href="{{route('/')}}">{{ ___('label.home')}}</a> </li>
                            @else
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ route('/') }}">{{ ___('label.home')}} <i class="fa-solid fa-chevron-down ms-1"></i></a>



                                <ul class="nav-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{route('/')}}">{{ ___('label.home_one')}}</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('home2')}}"> {{ ___('label.home_two')}} </a> </li>
                                </ul>


                            </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#">{{ ___('label.pages')}} <i class="fa-solid fa-chevron-down ms-1"></i></a>
                                <ul class="nav-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{route('frontend.about')}}">{{ ___('label.about_us')}}</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('frontend.privacy_return')}}"> {{ ___('label.privacy_and_return_policy')}} </a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('frontend.terms_condition')}}"> {{ ___('label.terms_conditions')}} </a> </li>

                                    <li class="nav-item"> <a class="nav-link" href="{{route('parcel.track')}}"> {{ ___('label.parcel_tracking')}} </a> </li>
                                </ul>
                            </li>


                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.charges')}}">{{ ___('label.charge')}}</a> </li>
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.coverage')}}">{{ ___('label.coverage')}}</a> </li>
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.blogs')}}">{{ ___('label.blogs')}}</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('frontend.contactUs')}}">{{ ___('label.contact_us')}}</a></li>
                        </ul>
                    </div>
                    <!-- Top Menu  -->

                    <!-- Sign In  -->

                    <div class="search-cart nav-profile">
                        <div class="d-flex gap-xl-30 gap-3 align-items-center">
                            <button class="dark-mode-toggle rounded-circle">
                                <i class="dark-mode-icon {{ session('theme') == 'dark'? 'ti-shine text-white':'fa-solid fa-moon' }}"></i>
                            </button>

                            <a href="{{route('parcel.track')}}" class="text-btn d-none d-xl-flex align-items-center gap-1"><i class="fa-solid fa-arrow-right"></i> {{ ___('label.track_order') }}</a>
                            
                            @guest
                            <a href="{{ route('signin') }}" class="btn-1 rounded-pill"> {{ ___('label.signin')}} <i class="fa-solid fa-arrow-right"></i></a>
                            @else
                            <a href="{{ route('dashboard.index') }}" class="btn-1 rounded-pill"> {{ ___('label.dashboard')}} <i class="fa-solid fa-arrow-right"></i></a>
                            @endguest
                    </div>

                </div>

                <!-- End Sign In   -->

            </div>
        </div>
       
    </div>
    </div>

    <!----- couriar details offcanvas ------->

    <div class="offcanvas offcanvas-end detail-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{ logo(settings('dark_logo')) }}" class="logo-display" alt="logo">
                    <img src="{{ logo(settings('light_logo')) }}" class="light-logo" alt="Logo">
                </a>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="icofont-close-line"></i></button>
        </div>
        <div class="offcanvas-body">
            <p class="d-none d-lg-block mb-0">{{ settings('official_message' ) }}</p>

            <!--------- mobile menu start ------>
            <nav class="mobile-nav d-lg-none">
                <div>
                    <a class="menu-item d-flex justify-content-between align-items-center gap-2" data-bs-toggle="collapse" href="#menuCollapseOne" role="button" aria-expanded="false" aria-controls="menuCollapseOne">
                        {{ ___('label.Home') }} <i class="fa-solid fa-plus"></i>
                    </a>
                    <div class="collapse" id="menuCollapseOne">
                        <div class="card border-0 rounded-0">
                            <a href="{{route('/')}}" class="menu-item">{{ ___('label.Home_One') }}</a>
                            <a href="{{route('home2')}}" class="menu-item">{{ ___('label.Home_Two') }}</a>
                        </div>
                    </div>
                </div>

                <div>
                    <a class="menu-item d-flex justify-content-between align-items-center gap-2" data-bs-toggle="collapse" href="#menuCollapseTwo" role="button" aria-expanded="false" aria-controls="menuCollapseTwo">
                        {{ ___('label.Pages') }} <i class="fa-solid fa-plus"></i>
                    </a>
                    <div class="collapse" id="menuCollapseTwo">
                        <div class="card border-0 rounded-0">
                            <a class="menu-item" href="{{route('frontend.about')}}">{{ ___('label.about_us')}}</a>
                            <a class="menu-item" href="{{route('frontend.privacy_return')}}"> {{ ___('label.privacy_and_return_policy')}} </a>
                            <a class="menu-item" href="{{route('frontend.terms_condition')}}"> {{ ___('label.terms_conditions')}} </a>
                            <a class="menu-item" href="{{route('parcel.track')}}"> {{ ___('label.parcel_tracking')}} </a>
                        </div>
                    </div>
                </div>

                <a href="{{route('frontend.charges')}}" class="menu-item d-flex justify-content-between align-items-center gap-2">{{ ___('label.Charge') }}</a>
                <a href="{{route('frontend.coverage')}}" class="menu-item d-flex justify-content-between align-items-center gap-2">{{ ___('label.Covarage') }}</a>
                <a href="{{route('frontend.blogs')}}" class="menu-item d-flex justify-content-between align-items-center gap-2">{{ ___('label.Blogs') }}</a>
                <a href="{{route('frontend.contactUs')}}" class="menu-item d-flex justify-content-between align-items-center gap-2">{{ ___('label.Contact Us') }}</a>
            </nav>

            <!--------- mobile menu start ------>

            <ul class="social-icons d-flex align-items-center gap-2">
                @foreach ($socialLinks as $social )
                <li> <a href="{{ $social->link }}"><i class="{{ $social->icon }}"></i></a></li>
                @endforeach
            </ul>

            <div class="gallary-items d-none d-lg-flex align-items-center gap-3 flex-wrap">
                <div><img src="{{ asset('frontend/assets/img/logistics-img/img-1.jpg') }}" alt=""></div>
                <div><img src="{{ asset('frontend/assets/img/logistics-img/img-2.jpg') }}" alt=""></div>
                <div><img src="{{ asset('frontend/assets/img/logistics-img/img-3.jpg') }}" alt=""></div>
                <div><img src="{{ asset('frontend/assets/img/logistics-img/img-4.jpg') }}" alt=""></div>
                <div><img src="{{ asset('frontend/assets/img/logistics-img/img-4.jpg') }}" alt=""></div>
                <div><img src="{{ asset('frontend/assets/img/logistics-img/img-4.jpg') }}" alt=""></div>
            </div>

            <div class="contact">
                <h4 class="heading3 mb-4">{{ ___('label.information') }}</h4>
                <p class="mb-2"><span class="fw-semibold">{{ ___('label.address:') }}</span> {{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'address') }}</p>
                <p class="mb-2"><a href="#"><span class="fw-semibold">Call Us: </span>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'phone') }}</a></p>
                <p class="mb-0"><span class="fw-semibold">{{ ___('label.email:') }}</span>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'email') }}</p>
            </div>

            {{-- <a href="{{ route('frontend.contactUs') }}" class="btn-1 rounded-pill w-100"> {{ ___('label.request a quote')}} <i class="fa-solid fa-arrow-right"></i></a> --}}
             <div class="w-100 mt-3 d-flex flex-column gap-2 justify-content-center">
                @guest
                <a href="{{ route('signin') }}" class="btn-1 rounded-pill w-100"> {{ ___('label.signin')}} <i class="fa-solid fa-arrow-right"></i></a>
                @else
                <a href="{{ route('dashboard.index') }}" class="btn-1 rounded-pill w-100"> {{ ___('label.dashboard')}} <i class="fa-solid fa-arrow-right"></i></a>
                @endguest
            </div>

        </div>
    </div>
</header>
<!-- End header -->
