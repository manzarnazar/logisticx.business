{{--
<!---------- service style two start ---------->
<section class="service-two position-relative {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="section-title mb-40 text-center">
            <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'section_tagline') }}</span>
            <h2 class="hero-title-3 mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'section_main_title') }}</h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1 g-lg-0">
            @foreach($services->slice(0,4) as $key => $service)
            <div class="cols">
                <div class="card service-card-two rounded-0">
                    <div class="position-relative">
                        <a href="{{ route('frontend.service_details',$service->id) }}" class="d-block">
                            <div class="card-thumb">
                                <img src="{{ getImage($service->bannerImage, 'original','default-image-80x80.png') }}" alt="Ocean Freight">
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="icon">
                            <i><img width="50" src="{{ getImage($service->upload, 'original','default-image-80x80.png') }}" alt="no image"></i>
                        </div>
                        <h4 class="sr-title"><a href="{{ route('frontend.service_details',$service->id) }}">{{$service->title}}</a></h4>
                        <p>{{ \Illuminate\Support\Str::limit($service->short_description, 49) }}</p>
                        <h4 class="sr-title-2"><a href="{{ route('frontend.service_details',$service->id) }}" class="text-btn">{{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'read_more') }}<i class="fa-solid fa-arrow-right"></i></a></h4>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section> --}}

<!---------- service style two Ends ---------->


<!--------- How it works start -------->

<section class="how-work {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="section-title mb-50 mx-auto">
                    <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::HOW_WE_WORK, 'section_tagline') }}</span>
                    <h2 class="hero-title-3 mb-0">{{ customSection(\Modules\Section\Enums\Type::HOW_WE_WORK, 'section_main_title') }}</h2>
                </div>

                <div class="how-we-img"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::HOW_WE_WORK, 'HowWeWork_image'), 'original') }}" class="img-fluid" alt=""></div>
            </div>

            <div class="col-lg-6">
                <div class="accordion how-work-accordion ps-xl-5" id="workAccordion">

                @foreach($faqs as $key => $faq)
                    <div class="accordion-item">
                        <span>{{ $faq->position }}</span>
                        @if(!empty($faq->icon))
                            <div class="icon"><i class="{{ $faq->icon }}"></i></div>
                        @endif
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $key !== 0 ? 'collapsed' : '' }}" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $key }}"
                                aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $key }}">
                                {{ $faq->title }}
                            </button>
                        </h2>
                        <div id="collapse{{ $key }}" class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}" data-bs-parent="#workAccordion">
                            <div class="accordion-body">
                                <p>{{ $faq->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach



                </div>
            </div>
        </div>
    </div>
</section>

<!--------- How it works Ends -------->



