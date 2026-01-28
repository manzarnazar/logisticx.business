<!--------- How it work two -------->

<section class="how-work-two {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="work-bg" style="background-image: url('{{ data_get(customSection(\Modules\Section\Enums\Type::FEATURES,'bg_image'), 'image_one') }}');"></div>
    <div class="plane-shape up-move"><img src="{{ asset('frontend/assets/img/shape/plane.png') }}" class="w-auto h-auto"  alt=""></div>
    <div class="container">
        <div class="section-title mb-50 text-center mx-auto">
            <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'section_tagline')}}</span>
            <h2 class="hero-title-3 mb-0">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'section_main_title')}}</h2>
        </div>

        <div class="work-step px-lg-3">
            {{-- <div class="work-step-shape d-none d-lg-block"><img src="{{ asset('frontend/assets/img/shape/work-steps-1.png') }}" class="w-auto h-auto"  alt=""></div> --}}
            <ul class="work-step-list">
                <li>
                    <div class="work-step-icon">
                        <div class="step-count"></div>
                        <div class="step-shape-1 overflow-hidden">
                            <img src="{{ asset('frontend/assets/img/logistics-img/breadcrumb-img-4.jpg') }}" class=""  alt="">
                        </div>
                    </div>
                    <p class="step-text"><a href="#">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'process_one')}}</a></p>
                </li>

                <li>
                    <div class="work-step-icon">
                        <div class="step-count"></div>
                        <div class="step-shape-1 overflow-hidden">
                            <img src="{{ asset('frontend/assets/img/logistics-img/delivery-man.jpeg') }}" class=""  alt="">
                        </div>
                    </div>
                    <p class="step-text"><a href="#">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'process_two')}}</a></p>
                </li>

                <li>
                    <div class="work-step-icon">
                        <div class="step-count"></div>
                        <div class="step-shape-1 overflow-hidden">
                            <img src="{{ asset('frontend/assets/img/logistics-img/logistic-truck-1.jpeg') }}" class=""  alt="">
                        </div>
                    </div>
                    <p class="step-text"><a href="#">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'process_three')}}</a></p>
                </li>

                {{-- <li>
                    <div class="work-step-icon">
                        <div class="step-count"></div>
                        <div class="step-shape-1">
                            <img src="{{ asset('frontend/assets/img/shape/work-steps-2.png') }}" class="img-fluid"  alt="">
                        </div>
                        <div class="step-main-icon"><i class="fa-solid fa-truck"></i></div>
                    </div>
                    <p class="step-text"><a href="#">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'process_two')}}</a></p>
                </li>

                <li class="mb-0">
                    <div class="work-step-icon">
                        <div class="step-count"></div>
                        <div class="step-shape-1">
                            <img src="{{ asset('frontend/assets/img/shape/work-steps-2.png') }}" class=""  alt="">
                        </div>
                        <div class="step-main-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    </div>
                    <p class="step-text"><a href="#">{{customSection(\Modules\Section\Enums\Type::FEATURES, 'process_three')}}</a></p>
                </li> --}}
            </ul>
        </div>
    </div>
</section>

<!--------- How it work two -------->
