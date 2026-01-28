{{-- <div class="service-area-2 bg d-none {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="service-wpr service-style-2 grid-3">
            <div class="section-title text-start mb-20">
                <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block"> {{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'short_title') }}</p>
                <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'title') !!}</h2>
                <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'description') }}</p>
            </div>

            @foreach($services->slice(0,5) as $service)
            <div class="service-box rounded-3 overflow-hidden">
                @if ($service->upload)
                <div class="service-icon">
                    <i> <img src="{{ getImage($service->upload, 'original','default-image-80x80.png') }}" alt="no image"> </i>
                </div>
                @endif
                <div class="service-desc">
                    <h5 class="heading-5">{{$service->title}}</h5>
                    <p class="mb-4">{!! Str::words($service->short_description, 30, '...') !!}
                    </p>
                    <a href="{{ route('frontend.service_details',$service->id) }}" class="blog-btnn"> {{ ___('label.read_more')}} <i class="ti-arrow-right"></i> </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div> --}}

<!----------- service style one start ----------->

<section class="service-one position-relative {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>
    <div class="container">

        <div class="section-title mb-50 text-center mx-auto">
            <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'section_tagline') }}</span>
            <h2 class="hero-title-3 mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'section_main_title') }}</h2>
        </div>

        <div class="shape-1 to-left d-none d-xl-block"> <img src="{{ asset('frontend/assets/img/logistics-img/plane-1.png') }}" alt="Ocean Freight" class="img-fluid"></div>

        <div class="row g-4">
            <!-- Card 1 -->
            @foreach ($services as $service )
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card card-logistics">
                    <div class="position-relative">
                        <a href="{{ route('frontend.service_details',$service->id) }}" class="d-block">
                            <div class="card-thumb">
                                <img src="{{ getImage($service->bannerImage, 'original','default-image-80x80.png') }}" alt="Ocean Freight">
                            </div>
                        </a>
                        <div class="icon-box">
                            <div class="icon">
                                <i class="icofont-ship"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="{{ route('frontend.service_details',$service->id) }}">{{$service->title}}</a></h5>
                        <p>{!! Str::words($service->short_description, 30, '...') !!}</p>
                    </div>

                    <div>
                        <a href="{{ route('frontend.service_details',$service->id) }}" class="read-more">{{ ___('label.read_more') }} <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            @endforeach




            {{-- <!-- Card 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-logistics">
                    <div class="position-relative">
                        <a href="{{ route('frontend.service_details',$service->id) }}" class="d-block">
                            <div class="card-thumb">
                                <img src="{{ asset('frontend/assets/img/logistics-img/ship-3.jpg') }}" alt="Ocean Freight">
                            </div>
                        </a>
                        <div class="icon-box">
                            <div class="icon">
                                <i class="icofont-airplane-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="{{ route('frontend.service_details',$service->id) }}">Ocean Freight</a></h5>
                        <p>Arki features minimal and stylis main theme is well crafted for logistics</p>
                    </div>
                    <div>
                        <a href="#" class="read-more">READ MORE <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-logistics">
                    <div class="position-relative">
                        <a href="{{ route('frontend.service_details',$service->id) }}" class="d-block">
                            <div class="card-thumb">
                                <img src="{{ asset('frontend/assets/img/logistics-img/img-2.jpg') }}" alt="Ocean Freight">
                            </div>
                        </a>
                        <div class="icon-box">
                            <div class="icon">
                                <i class="icofont-fast-delivery"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="{{ route('frontend.service_details',$service->id) }}">Ocean Freight</a></h5>
                        <p>Arki features minimal and stylis main theme is well crafted for logistics</p>
                    </div>

                    <div>
                        <a href="#" class="read-more">READ MORE <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-logistics">
                    <div class="position-relative">
                        <a href="{{ route('frontend.service_details',$service->id) }}" class="d-block">
                            <div class="card-thumb">
                                <img src="{{ asset('frontend/assets/img/logistics-img/ship-1.jpg') }}" alt="Ocean Freight">
                            </div>
                        </a>
                        <div class="icon-box">
                            <div class="icon">
                                <i class="icofont-train-line"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="{{ route('frontend.service_details',$service->id) }}">Ocean Freight</a></h5>
                        <p>Arki features minimal and stylis main theme is well crafted for logistics</p>
                    </div>

                    <div>
                        <a href="#" class="read-more">READ MORE <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>

<!----------- service style one Ends ----------->
