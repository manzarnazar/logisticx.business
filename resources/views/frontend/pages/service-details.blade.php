@extends('frontend.master')

@section('main')
<!-- Start Breadcrumb
      ============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'service-single-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{ route('/') }}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.service_details') }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- End  Breadcrumb -->
<div class="mt-5 servise_container">
    <div class="blog-single-2">
        <div class="service-details-pic">
            <img class=" rounded-2" src="{{ getImage($serviceDetails->bannerImage, 'original', 'default-image-80x80.png') }}" alt="no image">
        </div>
        <div class="blog-desc-2 mt-20">
            <ul class="blog-meta-2">
            </ul>
            <div class="blog-text mb-30">
                <h3 class="heading-5">{{$serviceDetails->title}}</h3>
                <p> {!! $serviceDetails->short_description !!} {{$serviceDetails->title}} </p>
            </div>
        </div>
    </div>
</div>

{{-- @dd($service) --}}
<!-------- New service Details start --------->

<section class="service-details py-80">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 service-detail-sidebar">
                    <div class="card-body">
                        <h5 class="sidebar-title">services </h5>
                        <ul class="service-detail-list">
                            @foreach ($services as $service )
                            <li class="{{ request()->routeIs('frontend.service_details') && request()->id == $service->id ? 'active' : ''}}">
                                <a href="{{ route('frontend.service_details',$service->id) }}">{{ $service->title}} <i class="fa-solid fa-arrow-right"></i></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="need-help">
                    <div class="shape-1"><img src="{{ asset('frontend/assets/img/shape/curve.png') }}" alt=""></div>
                    <div class="need-help-bg" style="background-image: url('frontend/assets/img/pictures/instagram-footer-2.jpg');"></div>
                    <h3 class="help-title">Need Any Types <br> of Service <br> from Us</h3>
                    <div class="help-btn">
                        <a href="#" class="btn-1 rounded-pill">Find Solution</a>
                    </div>
                </div>
                <div class="service-details-contact">
                    <div class="icon"><i class="fa-solid fa-phone-volume"></i></div>
                    <div class="contact-content">
                        <span>You can call anytime </span>
                        <p>Free<a href="{{ settings('phone') }}">{{ settings('phone') }}</a></p>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-7 ps-lg-5">
                <div class="section-title">
                    <h2 class="hero-title-3">{{ $serviceDetails->title }}</h2>
                    <p class="mb-0">{!! $serviceDetails->short_description !!}</p>
                </div>
                <div class="service-detail-img"><img src="{{ getImage($serviceDetails->bannerImage, 'original', 'default-image-80x80.png') }}" class="img-fluid" alt=""></div>
                <div>
                    {!! $serviceDetails->description !!}
                </div>
                {{-- <h3 class="service-detail-title">Shipping Freight</h3>
                <p class="services-details-text-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Maecenas varius tortor nibh, sit amet tempor nibh finibus et. Aenean eu enim justo.
                    Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet augue accumsan
                    tincidunt. Maecenas tincidunt, velit ac porttitor pulvinar, tortor eros facilisis
                    libero, vitae commodo nunc quam et ligula
                </p>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-5">
                        <h3 class="point-title">Our Goals</h3>
                        <ul class="list-unstyled point-list">
                            <li class="d-flex align-items-center">
                                <div class="d-icon text-primary"><i class="fa-solid fa-check"></i></div>
                                <p class="mb-0">Aliquam accumsan et ante id</p>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="d-icon text-primary"><i class="fa-solid fa-check"></i></div>
                                <p class="mb-0">Aliquam accumsan et ante id</p>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="d-icon text-primary"><i class="fa-solid fa-check"></i></div>
                                <p class="mb-0">Aliquam accumsan et ante id</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-7">
                        <h3 class="point-title">The Chalenges</h3>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis sapiente officiis obcaecati odio incidunt, provident illo corrupti accusantium iure.</p>
                    </div>
                </div> --}}

                <div class="accordion accordion-two h-100 mt-lg-5 mt-4" id="accordionTwo">
                    @foreach($faqs as $key=>$faq)
                        @if ($key <= 3)
                         <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne{{$faq->id}}">
                                <button class="accordion-button {{$key == 0? '':'collapsed'}} " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$faq->id}}" aria-expanded="{{$key == 0? 'true':'false'}}" aria-controls="collapseOne{{$faq->id}}">
                                    {{$faq->title}}
                                </button>
                            </h2>
                            <div id="collapseOne{{$faq->id}}" class="accordion-collapse collapse {{$key == 0? 'show':''}}" aria-labelledby="headingOne{{$faq->id}}" data-bs-parent="#accordionTwo">
                                <div class="accordion-body">
                                    <p class="mb-0">
                                        {{$faq->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                      @endif
                   @endforeach
             </div>
        </div>
    </div>
</section>

<!-------- New service Details Ends --------->


@endsection
