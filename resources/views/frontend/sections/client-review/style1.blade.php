<div class="review-area pos-rel {{ implode(' ', $widget->section_padding) }}" dir="ltr" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="row align-items-center mb-50">
            <div class="col-lg-6 mx-auto">
                <div class="section-title">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::CLIENT_REVIEW, 'short_title') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CLIENT_REVIEW, 'title') !!}</h2>
                    <p class="mb-0"> {{ customSection(\Modules\Section\Enums\Type::CLIENT_REVIEW, 'description') }} </p>
                </div>
            </div>
            <div class="col-md-6 text-end d-none d-lg-block">
                <div class="swiper-navigation">
                    <div class="swiper-button-prev me-3"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <div class="rev-sldr px-3 swiper-margin pt-3 pb-3 swiper">
            <div class="swiper-wrapper">

                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="review-single shadow-xs">
                        <div class="shape-1"><img src="{{ asset('frontend/assets/img/shape/dot-circle.png') }}" class="img-fluid" alt=""></div>
                        <div class="shape-2"></div>
                        <div class="content">
                            <div class="review-star text-warning"> {!! $testimonial->my_rating !!} </div>
                            <p class="review-quote"> {{Str::limit($testimonial->description, 100)}} </p>

                            <div class="review-user-bio">
                                <div class="review-bio-pic">
                                    <img src="{{ getImage($testimonial->upload, 'image_one','default-image-80x80.png') }}" alt="image" class="object-fit-cover w-100 h-80">
                                </div>
                                <div class="review-bio-text">
                                    <h5 class="heading-5"><a href="#">{{$testimonial->client_name}}</a></h5>
                                    <span>{{$testimonial->designation}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
