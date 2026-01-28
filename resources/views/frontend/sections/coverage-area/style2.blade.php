<div class="coverage-area-2 {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="coverage-wpr">
            <div class="row align-items-center g-4">
                <div class="col-xl-6">
                    <div class="me-xl-5">
                        <div class="coverage-right">

                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'big_bg_image'), 'original') }}" class="img-fluid rounded overflow-hidden inner-img" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="coverage-left">
                        <div class="section-title mb-50">
                            <span class="section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_title') }}</span>
                            <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'title') !!}</h2>
                            <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_description') }} </p>
                        </div>
                        <div class="covarage-compo-title">
                            <div class="row g-4 gx-lg-5">
                                <div class="col-md-6">

                                    <div class="left-icons mb-4 d-flex gap-4 align-items-start">
                                        <div>
                                            <div class="icon"><img width="60"  src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_one_image'), 'original') }}" class="img-fluid rounded overflow-hidden inner-img" alt=""></div>
                                            <h5 class="mb-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_title_one') }} </h5>
                                            <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_one_description') }} </p>
                                        </div>
                                    </div>
                                    <div class="left-icons mb-4 d-flex gap-4 align-items-start">
                                        <div>
                                            <div class="icon"><img width="60"  src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_two_image'), 'original') }}" class="img-fluid rounded overflow-hidden inner-img" alt=""></div>
                                            <h5 class="mb-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_title_two') }} </h5>
                                            <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_two_description') }} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="left-icons mb-4 d-flex gap-4 align-items-start">
                                        <div>
                                            <div class="icon"><img width="60"  src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_three_image'), 'original') }}" class="img-fluid rounded overflow-hidden inner-img" alt=""></div>
                                            <h5 class="mb-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_title_three') }} </h5>
                                            <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_three_description') }} </p>
                                        </div>
                                    </div>
                                    <div class="left-icons mb-4 d-flex gap-4 align-items-start">
                                        <div>
                                            <div class="icon"><img width="60"  src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_four_image'), 'original') }}" class="img-fluid rounded overflow-hidden inner-img" alt=""></div>
                                            <h5 class="mb-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_title_four') }} </h5>
                                            <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'card_four_description') }} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('frontend.coverage') . '#covarage-list'}}" class="btn-1 rounded-pill flex-shrink-0">{{ ___('label.see_all_area') }} <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
