<section class="hero-area mt-90 pos-rel d-none {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" @endif>
 {{-- @dd($homePageSlider); --}}
    <div class="hero-single-2 bg-position-bottom-2">

        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <div class="hero-content hero-content-white">
                        <div class="hero-content-desc mb-40">
                            <span class="title-up">{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'short_title') }}</span>
                            <h2 class="hero-title mb-30"> {!! customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_section_title') !!} </h2>
                            <p class="para"> {{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_section_short_description') }} </p>
                        </div>
                        <div class="hero-track">
                            <form class="hero-track-form d-flex align-items-center" action="{{ route('parcel.track') }}">
                                <input type="text" name="tracking_id" class="inp-white-clr rounded" placeholder="{{ ___('placeholder.enter_tracking_id') }}">
                                <button type="submit" class="btn-1 ">{{ ___('label.track')}}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-thumb">
                        @php $hero_image = customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_image'); @endphp
                        <img src="{{ isset($hero_image['original']) ? $hero_image['original'] : asset('frontend/assets/img/bg/delivery-truck.jpg') }}" loading="lazy" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- @dd($homePageSlider) --}}
<section class="pos-rel">
    <div class="swiper hero-one">
        <div class="swiper-wrapper">
            @foreach ($homePageSlider as $slider)
                <div class="swiper-slide">
                    <div class="item">
                        <div class="slider-bg" style="background-image: url('{{ getImage($slider->banner, 'original') }}');"></div>

                        <div class="container">
                            <div class="slider-content col-lg-7">
                                <span class="slider-subtitle">{{$slider->small_title }}</span>
                                <h2 class="slider-title">{{ $slider->title }}</h2>
                                <p>{{ $slider->description }}</p>

                                <div class="slider-btn d-flex align-items-center gap-4 gap-lg-5 flex-wrap">
                                    <a href="{{ $slider->page_link }}" class="btn-1 two rounded-pill">
                                        {{ ___('label.Get_a_quote')}} 
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>

                                    <div class="video-container d-flex align-items-center">
                                        <div class="video-icon" data-bs-toggle="modal" data-bs-target="#videoModal-{{$slider->id}}" role="button">
                                            <i class="fa-solid fa-play"></i>
                                            <i class="ripple"></i>
                                        </div>
                                        <h4 class="video-text mb-0">{{___('label.show_reel')}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="swiper-pagination"></div>
    </div>
</section>

<!--------- video modal start ---------->

<!-- ✅ All modals OUTSIDE swiper -->
@foreach ($homePageSlider as $slider)
    <div class="modal fade video-modal" id="videoModal-{{$slider->id}}" tabindex="-1" aria-labelledby="videoModalLabel{{$slider->id}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded overflow-hidden">
                <div class="modal-body p-3">
                    <div class="video-wrapper">
                        <iframe src="{{ $slider->video_link }}" 
                                title="{{ $slider->title }}" 
                                allowfullscreen 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!--------- video modal Ends ---------->
