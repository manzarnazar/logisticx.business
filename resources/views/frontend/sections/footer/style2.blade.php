<!-- Start Footer	============================================= -->
<footer class="footer two overflow-hidden pos-rel">

    <div class="footer-up  {{ implode(' ', $footer->section_padding) }}" @if($footer->background === 'bg_color') data-background-color="{{ $footer->bg_color }}"
        @elseif($footer->background === 'bg_image') data-background="{{ getImage($footer->upload) }}"
        @endif>

        <div class="container">
            <div class="row g-5">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="footer-widget about-us pr-60">
                        <div class="footer-logo">
                            <img src="{{ logo(settings('light_logo')) }}" alt="Logo">
                        </div>
                        <ul class="footer-adss mb-30">
                            <li>
                                <i> <img src="{{asset('frontend/assets/img/icon/icon-top-3-wh.png')}}" alt="no image"> </i>
                                <span>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'address') }}</span>
                            </li>
                            <li>
                                <i> <img src="{{asset('frontend/assets/img/icon/icon-top-1-wh.png')}}" alt="no image"> </i>
                                <span>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'phone') }}</span>
                            </li>
                            <li>
                                <i> <img src="{{asset('frontend/assets/img/icon/icon-top-2-wh.png')}}" alt="no image"> </i>
                                <span>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'email') }}</span>
                            </li>
                        </ul>
                        <ul class="footer-social">
                            @foreach ($socialLinks as $social )
                            <li><a href="{{ $social->link }}"><i class="{{ $social->icon }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="footer-widget footer-link">
                        <h4 class="footer-heading">{{ ___('label.company') }}</h4>
                        <ul class="footer-list">
                            <li> <a href="{{route('frontend.about')}}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.about_us') }} </a> </li>
                            <li> <a href="{{route('frontend.contactUs')}}"> <i class="fa-solid fa-chevron-right"></i>{{ ___('label.contact_us') }} </a> </li>
                            <li> <a href="{{ route('frontend.privacy_return') }}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.privacy_and_return_policy') }} </a> </li>
                            <li> <a href="{{route('parcel.track')}}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.track_order') }} </a> </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="footer-widget footer-link">
                        <h4 class="footer-heading">{{ ___('label.useful_links') }}</h4>
                        <ul class="footer-list">
                            <li> <a href="{{route('signup')}}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.become_merchant') }} </a> </li>
                            <li> <a href="{{route('frontend.charges')}}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.charge') }} </a> </li>
                            <li> <a href="{{route('frontend.coverage')}}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.coverage') }} </a> </li>
                            <li> <a href="{{route('frontend.blogs')}}"> <i class="fa-solid fa-chevron-right"></i> {{ ___('label.blog') }} </a> </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="footer-item">
                        <h4 class="footer-heading">{{ ___('label.Gallery') }}</h4>
                        <div class="row g-3">
                            <div class="row g-3">


                                @foreach ($galleries as $gallery)
                                <div class="col-4">
                                    <div class="footer-instagram rounded-2 position-relative">
                                        <img src="{{ getImage($gallery->upload, 'original', 'default-image-80x80.png') }}" class="img-fluid gallery-img" alt="Gallery Image" style="cursor: pointer;">

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="copyright py-3">
        <div class="container">
            <div class="copyright-element text-center">
                <p class="mb-0"> {{ @settings('copyright')}} </p>
            </div>
        </div>
    </div>

</footer>




<!-- End Footer -->
