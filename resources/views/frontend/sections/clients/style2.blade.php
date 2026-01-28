<div class="partner-area-3 {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>
{{-- @dd($clients) --}}
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <div class="section-title text-center mb-50 mx-auto">
                    <span class="text-primary section-title-tagline"> {{ customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'short_title') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'title') !!}</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'short_description') }}</p>
                </div>
            </div>
        </div>

        <!-- Swiper -->
        <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1 g-4">
             @foreach($clients->take(8) as $key => $client)
            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{ getImage($client->upload, 'original','default-image-150x50.png')  }}" class="img-fluid" alt="{{$client->name}}"></div>
                        <h5 class="heading-5 mb-2"><a href="#">{{$client->name}}</a></h5>
                        <p class="text-capitalize desc">{{ $client->title }}</p>

                        <div class="social-icons">
                            <a href="{{ $client->facebook_id }}" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $client->twitter_id }}" class=""><i class="fab fa-twitter"></i></a>
                            <a href="{{ $client->linkedIn_id }}" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/behance-1.svg')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Behance</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/spotyfy.webp')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Spotify</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/yt-music.png')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Yt Music</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/yt-music.png')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Yt Music</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/behance-1.svg')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Yt Music</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/envato.png')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Yt Music</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cols">
                <div class="card client-slider-1 shadow-xs text-center">
                    <div class="card-body">
                        <div class="partner-logo"><img src="{{asset('frontend/assets/img/logo/netflix.png')}}" class="img-fluid" alt=""></div>
                        <h5 class="heading-5 mb-2"><a href="#">Yt Music</a></h5>
                        <p class="text-capitalize desc">A short description</p>

                        <div class="social-icons">
                            <a href="#" class=""><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class=""><i class="fab fa-twitter"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
</div>

@push('styles')
<script src="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
@endpush
