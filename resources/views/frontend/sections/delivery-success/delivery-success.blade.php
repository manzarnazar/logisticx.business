<!-- Delivery success carousel Start -->

<section class="delivery__container de-padding" data-background-color="">

    <div class="section-title text-center mb-50">
        <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 fw-semibold d-inline-block"> {{ customSection(\Modules\Section\Enums\Type::DELIVERY_SUCCESS, 'short_title') }}</p>
        <h2 class="hero-title-3 mb-20">{!! customSection(\Modules\Section\Enums\Type::DELIVERY_SUCCESS, 'title') !!}</h2>
        <p>{{ customSection(\Modules\Section\Enums\Type::DELIVERY_SUCCESS, 'short_description') }}</p>
    </div>
    <div class="container-fluid">
         <!-- Swiper -->
        <div class="swiper delivery__container-inner delivery-success">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="img-thumb">
                        <img src="{{asset('frontend/assets/img/blog_img/project-1.jpg')}}" class="img-fluid" alt="">
                        <div class="img-overly"></div>
                        <div class="content d-flex align-items-center gap-3 justify-content-between">
                            <div class="img-content">
                                <h3 class="fs-2 mb-2">Air Transport</h3>
                                <h4 class="fs-4 fw-normal text-muted mb-0">Logistics</h4>
                            </div>
                            <div class="img-btn"><a href="#"><i class="fas fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="img-thumb">
                        <img src="{{asset('frontend/assets/img/blog_img/project-2.jpg')}}" class="img-fluid" alt="">
                        <div class="img-overly"></div>
                        <div class="content d-flex align-items-center gap-3 justify-content-between">
                            <div class="img-content">
                                <h3 class="fs-2 mb-2">Air Transport</h3>
                                <h4 class="fs-4 fw-normal text-muted mb-0">Logistics</h4>
                            </div>
                            <div class="img-btn"><a href="#"><i class="fas fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="img-thumb">
                        <img src="{{asset('frontend/assets/img/blog_img/project-3.png')}}" class="img-fluid" alt="">
                        <div class="img-overly"></div>
                        <div class="content d-flex align-items-center gap-3 justify-content-between">
                            <div class="img-content">
                                <h3 class="fs-2 mb-2">Air Transport</h3>
                                <h4 class="fs-4 fw-normal text-muted mb-0">Logistics</h4>
                            </div>
                            <div class="img-btn"><a href="#"><i class="fas fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="img-thumb">
                        <img src="{{asset('frontend/assets/img/blog_img/blog-3-22.jpg')}}" class="img-fluid" alt="">
                        <div class="img-overly"></div>
                        <div class="content d-flex align-items-center gap-3 justify-content-between">
                            <div class="img-content">
                                <h3 class="fs-2 mb-2">Air Transport</h3>
                                <h4 class="fs-4 fw-normal text-muted mb-0">Logistics</h4>
                            </div>
                            <div class="img-btn"><a href="#"><i class="fas fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="img-thumb">
                        <img src="{{asset('frontend/assets/img/blog_img/blog-2.jpg')}}" class="img-fluid" alt="">
                        <div class="img-overly"></div>
                        <div class="content d-flex align-items-center gap-3 justify-content-between">
                            <div class="img-content">
                                <h3 class="fs-2 mb-2">Air Transport</h3>
                                <h4 class="fs-4 fw-normal text-muted mb-0">Logistics</h4>
                            </div>
                            <div class="img-btn"><a href="#"><i class="fas fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                </div>
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
