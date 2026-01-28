<!-- Testimonial Start -->
<div class="testimonial mt-80 position-relative  {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="shape-1"><img src="{{ asset('frontend/assets/img/shape/shape-18.png') }}" alt=""></div>

    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="section-title text-center text-lg-start">
                    <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::CLIENT_REVIEW, 'short_title') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CLIENT_REVIEW, 'title') !!}</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::CLIENT_REVIEW, 'description') }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="swiper-nav text-center text-lg-end">
                    {{-- <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div> --}}
                    <a href="#" class="btn-1 rounded-pill "> {{ ___('label.View_All_Reviews')}} <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="swiper testimonial-carousel px-3 swiper-margin pt-80 pb-3">
            <div class="swiper-wrapper">

                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="testimonial-item shadow-xs">
                        <div class="d-flex gap-3 gap-lg-4 align-items-center mb-3">
                            <div class="img-thumb flex-shrink-0">
                                <img class="mb-4" src="{{ getImage($testimonial->upload, 'image_one','default-image-80x80.png') }}" alt="">
                            </div>
                            <div class="d-flex gap-1 flex-column">
                                <div>
                                    <h5 class="mb-0 heading-5"><a href="#">{{$testimonial->client_name}}</a></h5>
                                    <span class="designation">{{$testimonial->designation}}</span>
                                </div>
                                <div class="lh-1 text-warning">
                                    {!! $testimonial->my_rating !!}
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">{{Str::limit($testimonial->description, 100)}}</p>

                    </div>
                </div>
                @endforeach

            </div>
            <div class="swiper-pagination pt-4"></div>
        </div>

    </div>
</div>
<!-- Testimonial End -->

@push('styles')
<script src="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
@endpush
