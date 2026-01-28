{{-- <div class="counter-area bg-whitesmoke d-none {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="counter-wpr grid-2">
            <div class="counter-left pr-30">
                <div class="section-title mb-50">
                    <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 fw-semibold d-inline-block">
                        {{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'title') }}
                    </p>
                    <h2 class="hero-title-3 lh-1"> {{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'our_achievement') }} </h2>
                </div>

                <div class="counter-1 grid-2">
                    <div class="fun-fact">
                        <!-- ICON 1 -->
                        <div class="counter-icon">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT,'counter_1_image'), 'original') }}" alt="Icon-1">
                        </div>
                        <div class="counter time-clr-1">
                            <div class="timer" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_1_number') }}" data-speed="2000"></div>
                            <div class="operator">+</div>
                        </div>
                        <span class="text-dark">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_1_title') }}</span>
                    </div>

                    <div class="fun-fact active">
                        <div class="counter-icon">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_2_image'),'original') }}" alt="Icon-2">
                        </div>
                        <div class="counter time-clr-2">
                            <div class="timer" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_2_number') }}" data-speed="2000"></div>
                            <div class="operator">+</div>
                        </div>
                        <span class="text-dark">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_2_title') }}</span>
                    </div>
                    <div class="fun-fact">
                        <div class="counter-icon">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_3_image'),'original') }}" alt="Icon-3">
                        </div>
                        <div class="counter time-clr-3">
                            <div class="timer" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_3_number') }}" data-speed="2000"></div>
                            <div class="operator">+</div>
                        </div>
                        <span class="text-dark">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_3_title') }}</span>
                    </div>
                    <div class="fun-fact">
                        <div class="counter-icon">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'activity_icon_image'),'original') }}" alt="Icon-4">
                        </div>
                        <div class="counter time-clr-2">
                            <div>{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'activity_number') }}</div>
                        </div>
                        <span class="text-dark">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'activity_title') }}</span>
                    </div>
                </div>
            </div>

            <!-- Big and Small pictures goes here  -->
            <div class="counter-right">
                <div class="counter-pics-wpr">
                    <div class="counter-pics-box">
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'image_one'), 'image_one') }}" class="mb-20 d-block" alt="no image">
                        <div class="counter-clr-box-1 to-left"></div>
                    </div>
                    <div class="counter-pics-box mt-20">
                        <div class="counter-clr-box-2 up-move mb-20"></div>
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'image_two'), 'image_one') }}" alt="no image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!--------- New Achivment start ---------->

<section class="achivment-one {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @else style="background-image: url('frontend/assets/img/logistics-img/img-12.jpeg');"
    @endif>
    <div class="container">
        <div class="row g-4 justify-content-between align-items-center">
            <div class="col-lg-8 col-md-7">
                <div class="section-title">
                    <span class="section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'title') }}</span>
                    <h2 class="hero-title-3 mb-0 ">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'our_achievement') }}</h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 text-md-end">
                <a href="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'button_url') }}" class="btn-1 two rounded-pill">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'button_text') }}<i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="row g-4 counter-wrapper">
            <div class="col-lg-2 col-sm-6">
                <div class="counter-item text-center">
                    <div class="icon"><i class="fa-solid fa-box"></i></div>
                    <h2 class="count-number mb-0"><span class="timer" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'counter_one_value') }}" data-speed="2000"></span></span>+</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'counter_one_title') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="counter-item text-center">
                    <div class="icon"><i class="fa-solid fa-warehouse"></i></div>
                    <h2 class="count-number mb-0"><span class="timer" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'counter_two_value') }}" data-speed="2000"></span>+</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'counter_two_title') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="counter-item text-center">
                    <div class="icon"><i class="fa-solid fa-basket-shopping"></i></div>
                    <h2 class="count-number mb-0"><span class="timer" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'counter_three_value') }}" data-speed="2000"></span>+</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'counter_three_title') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="counter-item text-center">
                    <div class="icon"><i class="fa-solid fa-headset"></i></div>
                    <h2 class="count-number mb-0"><span>{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'activity_value') }}</span></span>+</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO, 'activity_title') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------- New Achivment Ends ---------->
