<!-- Delivery success carousel Start -->

<section class="delivery__container {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="section-title text-center mb-50">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::GALLERY, 'short_title') }}</span>
                    <h2 class="hero-title-3">{{ customSection(\Modules\Section\Enums\Type::GALLERY, 'title') }}</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::GALLERY, 'short_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Swiper -->
        <div class="swiper delivery__container-inner delivery-success">
            <div class="swiper-wrapper">
                @foreach ($galleries as $gallery)
                <div class="swiper-slide">
                    <div class="img-thumb rounded-2">
                        <img src="{{ getImage($gallery->upload, 'original', 'default-image-80x80.png') }}" class="img-fluid" alt="">
                        <div class="img-overly"></div>
                        <div class="content d-flex align-items-center gap-3 justify-content-between">
                            <div class="img-content">
                                <h3 class="fs-5 mb-2">{{$gallery->title}}</h3>
                                <p class="fs-6 fw-normal text-muted mb-0">{{ Str::limit(strip_tags($gallery->short_description), 69) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Delivery success carousel Ends -->

@push('styles')
<script src="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
@endpush
