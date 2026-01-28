<!-- Achievement Start -->
  
<div class="container-fluid our-achievement {{ implode(' ', $widget->section_padding) }}" style="background-image: url('{{ asset('frontend/assets/img/shape/service-shape.png') }}');" 
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}" 
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" 
    @endif> 

    <div class="container">  
        <div class="row gx-lg-5 align-items-center gx-4 gy-4 gy-lg-0 ">
            <div class="col-xl-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="row g-4 achievement-left">
                    <div class="col-12 pe-lg-5">
                        <div class="img__thumb rounded-4 overflow-hidden">
                            <img class="img-fluid container-img" src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'style_two_big_image'), 'image_one') }}">
                            <div class="bg-white img__thumb-inner">
                                <div class="img__thumb-inner-left bg-white">
                                    <div class="">
                                        <h4 class="text-white fw-semibold mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'year_experience_number') }}</h4>
                                        <p class=" text-white fs-3 mb-0">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'year_experience_title') }}</p>
                                    </div>
                                </div>
                                <div class="img__thumb-inner-right bg-white">
                                    <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'style_two_small_image'), 'image_one') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 last-div d-none">
                        <div class="bg-primary rounded-4 overflow-hidden w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                            <div class="icon-box-light display-1">
                                <i class="bi bi-award text-dark"></i>
                            </div>
                            <h1 class="display-1 fw-bold  mb-0" data-toggle="counter-up">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'year_experience_number') }}</h1>
                            <small class="fs-3 ">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'year_experience_title') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="section-title mb-40">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'short_title') }}</span>
                    <h2 class="hero-title-3 "> {!! customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'title') !!}</h2>
                    <p class="mb-0 ">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'our_achievement') }}</p>
                </div>
                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="achievement-fact d-flex align-items-center gap-3 mb-3 mb-sm-0 counter p-4 rounded-3 border-4 border-top border-primary">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT,'counter_3_image'), 'original') }}" alt="Icon-1" width="50" >
                            <div>
                                <div class="d-flex gap-2 align-items-center">
                                    <h2 class=" mb-0 timer fs-3 " data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_3_number') }}" data-speed="2000">9999 </h2>
                                    <span class="operator fs-3 fw-semibold ">+</span>
                                </div>
                                <h4 class=" fs-6 mb-0 mt-1">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_3_title') }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="achievement-fact d-flex align-items-center gap-3  mb-3 mb-sm-0 counter p-4 rounded-3 border-4 border-top border-primary">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT,'counter_1_image'), 'original') }}" alt="Icon-1" width="50">
                            <div>
                                <div class="d-flex gap-2 align-items-center">
                                    <h2 class=" mb-0 timer fs-3" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_1_number') }}" data-speed="2000">9999 </h2>
                                    <span class="operator fs-3 fw-semibold ">+</span>
                                </div>
                                <h4 class=" fs-6 mb-0 mt-1">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_1_title') }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="achievement-fact d-flex align-items-center gap-3 mb-3 mb-sm-0 counter p-4 rounded-3 border-4 border-top border-primary">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT,'counter_2_image'), 'original') }}" alt="Icon-1" width="50">
                            <div>
                                <div class="d-flex gap-2 align-items-center">
                                    <h2 class=" mb-0 timer fs-3" data-to="{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_2_number') }}" data-speed="2000">9999 </h2>
                                    <span class="operator fs-3 fw-semibold ">+</span>
                                </div>
                                <h4 class=" fs-6 mb-0 mt-1">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'counter_2_title') }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="achievement-fact d-flex align-items-center gap-3 mb-3 mb-sm-0 counter p-4 rounded-3 border-4 border-top border-primary">
                            <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT,'activity_icon_image'), 'original') }}" alt="Icon-1" width="50">
                            <div>
                                <div class="d-flex gap-2 align-items-center">
                                    <h2 class=" mb-0 fs-3" >{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'activity_number') }} </h2>
                                </div>
                                <h4 class=" fs-6 mb-0 mt-1">{{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'activity_title') }}</h4>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="d-flex flex-wrap flex-sm-nowrap gap-lg-4 gap-2 mt-40">
                    <ul class="list-group justify-content-start">
                        <li class="list-group-item text-black bg-transparent border-0 p-0 mb-3 lh-lg d-flex align-items-center"><i class="fa-regular fa-circle-check me-2 text-success fs-3"></i> {{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'card_one_title') }}</li>
                        <li class="list-group-item text-black bg-transparent border-0 p-0 mb-3 lh-lg d-flex align-items-center"><i class="fa-regular fa-circle-check me-2 text-success fs-3"></i> {{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'card_two_title') }}</li>           
                    </ul> 
                    <ul class="list-group justify-content-start">
                        <li class="list-group-item text-black bg-transparent border-0 p-0 mb-3 lh-lg d-flex align-items-center"><i class="fa-regular fa-circle-check me-2 text-success fs-3"></i> {{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'card_three_title') }}</li>
                        <li class="list-group-item text-black bg-transparent border-0 p-0 mb-3 lh-lg d-flex align-items-center"><i class="fa-regular fa-circle-check me-2 text-success fs-3"></i> {{ customSection(\Modules\Section\Enums\Type::OUR_ACHIEVEMENT, 'card_four_title') }}</li>           
                    </ul>  
                </div> 

                {{-- <div class="achievement-btn mt-4">
                    <a href="#" class="btn-two rounded btn-md">{{ ___('label.see_more')}}</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
    <!-- About End -->