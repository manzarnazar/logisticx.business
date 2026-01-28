<!-- Start header
    ============================================= -->
<header class="header">
    <div class="main-navigation">
        <div class="main-wrapper">

            <!-- Topbar Start -->
            <div class="top-bar-two d-none d-lg-block lh-1" @if($header->background === 'bg_color') data-background-color="{{ $header->bg_color }}"
                @elseif($header->background === 'bg_image') data-background="{{ getImage($header->upload) }}"
                @endif>

                <div class="container">
                    <div class="row gx-0 align-items-center">
                        <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                            <div class="d-flex flex-wrap address">
                                <a href="#" class="text-light me-4"><i class="fas fa-phone-alt  me-2"></i>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'phone') }}</a>
                                <a href="#" class="text-light me-0"><i class="fas fa-envelope  me-2"></i>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'email') }}</a>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end d-flex align-items-center justify-content-lg-end">
                            <div class="dropdown dropdown-menu-start me-4 border-end  pe-4">
                                <a class="btn dropdown-toggle fw-normal d-flex align-items-center p-0 text-white shadow-none border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{-- <img src="{{asset('frontend/assets/img/icon/017-australia.png')}}" alt=""> {{ Str::upper(defaultLanguage()->code) }} --}}
                                    <i class="me-1 {{ defaultLanguage()->icon_class }}"></i> {{ Str::upper(defaultLanguage()->code) }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    @foreach ($languages as $lang)
                                    <li><a class="dropdown-item" href="{{ route('setlocalization', $lang->code) }}"> <i class="{{ @$lang->icon_class }}"></i> {{ @$lang->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="d-flex align-items-center social-icon gap-2 justify-content-end">
                                @foreach ($socialLinks as $social )
                                <a href="{{ $social->link }}"><i class="{{ $social->icon }}"></i></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Topbar End -->

        <div class="header-two headerSticky">

            <!--------- Web Menu start ------------>

            <div class="py-3 py-lg-0 navbar navbar-three navbar-expand-lg shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{route('/')}}">
                        <img src="{{ logo(settings('dark_logo')) }}" class="logo-display" alt="logo">
                        <img src="{{ logo(settings('light_logo')) }}" class="light-logo" alt="Logo">
                    </a>

                    <div class="d-lg-none d-flex align-items-center gap-3">
                        {{-- <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button> --}}
                        <button class="dark-mode-toggle rounded">
                            <i class="dark-mode-icon {{ session('theme') == 'dark'? 'ti-shine text-white':'fa-solid fa-moon' }}"></i>
                        </button>
                        <button class=" navbar-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#headerTwo" aria-controls="headerTwo"><i class="fas fa-bars"></i></button>
                    </div>

                    <!-- Top Menu  -->

                    <div class="collapse navbar-collapse justify-content-md-center">
                        <ul class="navbar-nav navbar-mobile mx-auto">
                            @if(!config('app.app_demo'))
                            <li class="nav-item"><a class="nav-link main-link" href="{{route('/')}}">{{ ___('label.home')}}</a> </li>
                            @else
                            <li class="nav-item dropdown">
                                <a class="nav-link main-link" href="#">{{ ___('label.home')}} <i class="fa-solid fa-chevron-down"></i></a>
                                <ul class="nav-menu rounded-3">
                                    <li class="nav-item"><a class="nav-link" href="{{route('/')}}">{{ ___('label.home_one')}}</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('home2')}}"> {{ ___('label.home_two')}} </a> </li>
                                </ul>
                            </li>
                            @endif

                            @if (config('app.app_demo') == true )
                            <li class="nav-item dropdown">
                                <a class="nav-link main-link" href="#">{{ ___('label.pages')}} <i class="fa-solid fa-chevron-down"></i></a>
                                <ul class="nav-menu rounded-3">
                                    <li class="nav-item"><a class="nav-link" href="{{route('frontend.about')}}">{{ ___('label.about_us')}}</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('frontend.privacy_return')}}"> {{ ___('label.privacy_and_return_policy')}} </a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('frontend.terms_condition')}}"> {{ ___('label.terms_conditions')}} </a> </li>

                                    <li class="nav-item"> <a class="nav-link" href="{{route('parcel.track')}}"> {{ ___('label.parcel_tracking')}} </a> </li>
                                </ul>
                            </li>
                            @endif

                            <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.charges')}}">{{ ___('label.charge')}}</a> </li>
                            <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.coverage')}}">{{ ___('label.coverage')}}</a> </li>
                            <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.blogs')}}">{{ ___('label.blog')}}</a></li>
                            <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.contactUs')}}">{{ ___('label.contact_us')}}</a></li>
                        </ul>
                    </div>
                    <!-- Top Menu  -->

                    <!-- Sign In  -->
                    <div class="search-cart nav-profile ">
                        <div class="d-flex gap-2rem align-items-center">
                            <button class="dark-mode-toggle rounded">
                                <i class="dark-mode-icon {{ session('theme') == 'dark'? 'ti-shine text-white':'fa-solid fa-moon' }}"></i>
                            </button>

                            <div class="nav-btn d-flex align-items-center gap-3">
                                @guest
                                <a href="{{route('signin')}}" class="btn-1 rounded-pill"> {{ ___('label.signin')}} <i class="fa-solid fa-arrow-right"></i></a>
                                @else
                                <a href="{{ route('dashboard.index') }}" class="btn-1 rounded-pill "> {{ ___('label.dashboard')}} <i class="fa-solid fa-arrow-right"></i></a>
                                @endguest
                            </div>
                        </div>
                    </div>
                    <!-- End Sign In -->

                </div>
            </div>

            <!--------- Web Menu start ------------>

            <!--------- Mobile Menu start ------------>

            <div class="offcanvas offcanvas-end bg-offcanvas" tabindex="-1" id="headerTwo" aria-labelledby="headerTwoLabel">
                <div class="offcanvas-header p-4 d-lg-none">
                    <h5 class="offcanvas-title" id="headerTwoLabel">
                        <a class="navbar-brand" href="{{route('/')}}">
                            <img src="{{ logo(settings('dark_logo')) }}" class="logo-display" alt="logo">
                            <img src="{{ logo(settings('light_logo')) }}" class="light-logo" alt="Logo">

                        </a>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="offcanvas-body p-4">
                    <div class=" py-lg-0 navbar navbar-three navbar-expand-lg">
                        <div class="collapse navbar-collapse justify-content-md-center d-block">
                            <ul class="navbar-nav navbar-mobile ms-auto">
                                @if(!config('app.app_demo'))
                                <li class="nav-item"><a class="nav-link main-link" href="{{route('/')}}">{{ ___('label.home')}}</a> </li>
                                @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link main-link" href="#">{{ ___('label.home')}} <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="nav-menu w-100 rounded-3">
                                        <li class="nav-item"><a class="nav-link" href="{{route('/')}}">{{ ___('label.home_one')}}</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="{{route('home2')}}"> {{ ___('label.home_two')}} </a> </li>
                                    </ul>
                                </li>
                                @endif

                                @if (config('app.app_demo') == true )
                                <li class="nav-item dropdown">
                                    <a class="nav-link main-link" href="#">{{ ___('label.pages')}} <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="nav-menu w-100 rounded-3">
                                        <li class="nav-item"><a class="nav-link" href="{{route('frontend.about')}}">{{ ___('label.about_us')}}</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="{{route('frontend.privacy_return')}}"> {{ ___('label.privacy_and_return_policy')}} </a> </li>
                                        <li class="nav-item"> <a class="nav-link" href="{{route('frontend.terms_condition')}}"> {{ ___('label.terms_conditions')}} </a> </li>

                                        <li class="nav-item"> <a class="nav-link" href="{{route('parcel.track')}}"> {{ ___('label.parcel_tracking')}} </a> </li>
                                    </ul>
                                </li>
                                @endif

                                <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.charges')}}">{{ ___('label.charge')}}</a> </li>
                                <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.coverage')}}">{{ ___('label.coverage')}}</a> </li>
                                <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.blogs')}}">{{ ___('label.blog')}}</a></li>
                                <li class="nav-item"><a class="nav-link main-link" href="{{route('frontend.contactUs')}}">{{ ___('label.contact_us')}}</a></li>
                            </ul>
                        </div>

                        <div class="w-100 mt-3 d-flex flex-column gap-2 justify-content-center">
                     
                            @guest
                            <a href="{{ route('signin') }}" class="btn-1 rounded-pill w-100"> {{ ___('label.signin')}} <i class="fa-solid fa-arrow-right"></i></a>
                            @else
                            <a href="{{ route('dashboard.index') }}" class="btn-1 rounded-pill w-100"> {{ ___('label.dashboard')}} <i class="fa-solid fa-arrow-right"></i></a>
                            @endguest
                        </div>
                    </div>
                    <!-- Top Menu  -->
                </div>
            </div>

            <!--------- Mobile Menu Ends ------------>
        </div>


    </div>
    </div>
</header>
<!-- End header -->
