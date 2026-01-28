{{-- <div class="partner-area-2 d-none  bg-thm-1 {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="section-title text-center mb-50">
                    <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block"> {{ customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'short_title') }}</p>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'title') !!}</h2>
                    <p class="mb-0"> {{ customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'short_description') }}</p>
                </div>
            </div>
        </div>



        <div class="partner-wpr-2">
            <div class="partner-up-2 grid-5 mb-30">
                @foreach($clients as $key => $client)
                @if ($loop->odd) <div class="partner-up-pic">
                    <img src="{{ getImage($client->upload, 'original','default-image-150x50.png')  }}" alt="{{$client->name}}">
                </div>
                @endif
                @endforeach
            </div>
            <div class="partner-btm-2 grid-4">
                @foreach($clients as $key => $client)
                @if ($loop->even)
                <div class="partner-up-pic">
                    <img src="{{ getImage($client->upload, 'original','default-image-150x50.png')  }}" alt="{{$client->name}}">
                </div>
                @endif
                @endforeach
            </div>
        </div>

    </div>
</div> --}}


<!---------====== Partner Area Start ===---------->

<section class="partner-container {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="section-title text-center mb-50 mx-auto">
            <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'short_title') }}</span>
            <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'title') !!}</h2>
            <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::CLIENT_SECTION, 'short_description') }}</p>
        </div>

        <div class="swiper client-slider-two swiper-margin px-3 pt-3 pb-3">
            <div class="swiper-wrapper">
                @foreach($clients as $key => $client)
                @if ($loop->odd) <div class="swiper-slide d-flex justify-content-center align-items-center">
                    <div class="partner-thumb rounded overflow-hidden p-3 p-lg-4 shadow-sm text-center">
                        <img src="{{ getImage($client->upload, 'original','default-image-150x50.png')  }}" alt="{{$client->name}}">
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<!---------====== Partner Area Ends ===---------->
