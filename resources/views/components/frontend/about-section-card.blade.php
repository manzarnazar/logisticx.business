{{-- @php
$aboutUrl = route('frontend.about');
if (request()->is('about')) {
$aboutUrl .= '#about-us';
}
@endphp

<section class="about-section d-none">
    <div class="container">
        <div class="about-wpr grid-2 align-items-center">

            <div class="about-left">
                <div class="about-left-img pt-30 pl-30 pos-rel">
                    <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'about_image'), 'original') }}" alt="About Us Image">
</div>
</div>
<div class="about-right pl-60">
    <div class="section-title text-start mb-50">
        <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'short_title') }}</p>
        <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::ABOUT_US, 'title') !!}</h2>
        <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'short_description') }}</p>
    </div>
    <div class="ab__bottom d-flex gap-4 justify-content-between">
        <div class="flex-grow-1 ab__bottom-left w-100">

            {!! customSection(\Modules\Section\Enums\Type::ABOUT_US, 'description') !!}

        </div>
        <div class="ab__bottom-right flex-shrink-0 border-top border-primary border-4 rounded-4 overflow-hidden bg-light d-flex flex-column justify-content-center align-items-center">
            <h1 class=" display-2 fw-bold counter">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'total_count') }}</h1>
            <h6 class=" fs-3 fw-semibold">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'count_text') }}</h6>
        </div>
    </div>
    <a href="{{ $aboutUrl }}" class="btn-two py-4 px-5 mt-4 rounded">
        {{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'button_text') }}
        <i class="ti-arrow-right ms-2"></i>
    </a>
</div>

</div>
</div>
</section> --}}


<!--------- New about section with images and content ---------->

<section class="about-section">
    <div class="container">
        <div class="row align-items-start g-4">
            <!-- Left Images -->
            <div class="col-lg-6 position-relative">
                <div class="about-container">
                    <div class="about-shape-1 d-none d-md-block"></div>
                    <div class="about-shape-2 float-bob-x d-none d-lg-block"><img src="{{ ('frontend/assets/img/logistics-img/shape-2.png') }}" class="img-fluid" /></div>
                    <div class="ab-img-one">
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'section_image_one'), 'original') }}" class="img-fluid" alt="Cargo Ship" />
                    </div>
                    <div class="satisfied-box">
                        {{-- @php
                            $section = customSection(\Modules\Section\Enums\Type::ABOUT_US, 'client_avatar');
                            dd($section);
                        @endphp --}}
{{-- @dd(data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_image_one'), 'original') ) --}}
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'client_avatar_image'), 'original') }}" alt="Client" />
                        <div>
                            <h3 class="mb-0 lh-1 text-danger">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'total_satisfied_clients')}}</h3>
                            <p class="mb-0 mt-1 lh-1">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'satisfied_clients_label')}}</p>
                        </div>
                    </div>
                    <div class="ab-img-two d-none d-lg-block">
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'section_image_two'), 'original') }}" class="img-fluid" alt="Workers" />
                    </div>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-6">
                <div class="section-title">
                    <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'section_tagline')}}</span>
                    <h2 class="hero-title-3">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'section_main_title')}}</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'section_description')}}</p>
                </div>

                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-center ab-icon-wrapper">
                            {{-- <span class="feature-icon flex-shrink-0"><img src="{{ asset('frontend/assets/img/icon/delivery-man.png') }}" alt=""></span> --}}
                            <span class="feature-icon flex-shrink-0"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_image_one'), 'original') }}" alt=""></span>
                            <div>
                                <h3 class="heading-5 fw-semibold mb-0 lh-sm">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_title1')}}</h3>
                                {{-- <h3 class="heading-5 fw-semibold mb-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'right_service_title')}}</strong> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-center ab-icon-wrapper one">
                            {{-- <span class="feature-icon flex-shrink-0"><img src="{{ asset('frontend/assets/img/icon/save-money.png') }}" alt=""></span> --}}
                            <span class="feature-icon flex-shrink-0"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'right_service_image_one'), 'original') }}" alt=""></span>
                            <div>
                                <h3 class="heading-5 fw-semibold mb-0 lh-sm">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'right_service_title1')}}</h3>
                                {{-- <h3 class="heading-5 fw-semibold mb-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_title')}}</strong> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-center ab-icon-wrapper two">
                            {{-- <span class="feature-icon flex-shrink-0"><img src="{{ asset('frontend/assets/img/icon/time-tracking.png') }}" alt=""></span> --}}
                            <span class="feature-icon flex-shrink-0"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_image_two'), 'original') }}" alt=""></span>
                            <div>
                                <h3 class="heading-5 fw-semibold mb-0 lh-sm">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_title2')}}</h3>
                                {{-- <h3 class="heading-5 fw-semibold mb-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_title')}}</strong> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-center ab-icon-wrapper three">
                            {{-- <span class="feature-icon flex-shrink-0"><img src="{{ asset('frontend/assets/img/icon/warranty.png') }}" alt=""></span> --}}
                            <span class="feature-icon flex-shrink-0"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::ABOUT_US, 'right_service_image_two'), 'original') }}" alt=""></span>
                            <div>
                                <h3 class="heading-5 fw-semibold mb-0 lh-sm">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'right_service_title2')}}</h3>
                                {{-- <h3 class="heading-5 fw-semibold mb-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'left_service_title')}}</strong> --}}
                            </div>
                        </div>
                    </div>

                </div>


                {{-- <p class="text-2 text-danger">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'promotional_red_text')}}</p> --}}

                <div class="d-flex align-items-center gap-3 ab-btn flex-wrap border-top mt-5 pt-5 border-opacity-50">
                    <a href="{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'primary_button_link') }}" class="btn-1 rounded-pill flex-shrink-0">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'primary_button_text')}} <i class="fa-solid fa-arrow-right"></i></a>
                    <div class="d-flex align-items-center gap-2 contact-info">
                        <div class="phone-icon text-primary border"><i class="icofont-phone"></i></div>
                        <div class="call-contact lh-1">
                            <small class="">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'contact_title')}}</small><br/>
                            <h5 class="mb-0 mt-2">{{ customSection(\Modules\Section\Enums\Type::ABOUT_US, 'contact_number')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------- New about section with images and content ---------->
