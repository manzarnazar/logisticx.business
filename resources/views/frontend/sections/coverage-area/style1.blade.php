<div class="coverage-area {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="section-title mb-50 text-center mx-auto">
                    <span class="section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_title') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'title') !!}</h2>
                    <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_description') }} </p>
                </div>
            </div>
        </div>

        {{-- <div class="coverage-wpr">
            <div class="row align-items-center">
                <div class="col-xl-5">
                    <div class="section-title mb-50">
                        <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-light fw-semibold d-inline-block">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_title') }}</p>
        <h2 class="hero-title-3 text-light">{!! customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'title') !!}</h2>
        <p class="mb-0 text-light">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_description') }}</p>
    </div>
    <a href="{{route('frontend.coverage') . '#covarage-list'}}" class="btn-two py-4 px-5 rounded">{{ ___('label.see_all_area') }}</a>
</div>
<div class="col-xl-7">
    <div class="coverage-right">
        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA,'bg_image'), 'image_one') }}" alt="Coverage Area">
    </div>
</div>
</div>
</div> --}}
</div>

<div class="container-fluid google-map">
    <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3672.255260360074!2d91.39756537603625!3d23.014398016631734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3753683418d4ffaf%3A0xbc3df1b098acdff1!2sPicLand%20photography%20and%20cinematography!5e0!3m2!1sen!2sbd!4v1750339005153!5m2!1sen!2sbd" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

</div>
