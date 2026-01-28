<div class="cta-area {{ implode(' ', $widget->section_padding) }}"
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container mt-lg-5 pt-lg-5">
        <div class="cta-wpr bg-theme grid-2">
            <div class="cta-left">
                <span>{{ customSection(\Modules\Section\Enums\Type::CTA, 'short_title') }}</span>
                <h3 class="heading-3"> {!! customSection(\Modules\Section\Enums\Type::CTA, 'title') !!} </h3>
                <a href="{{route('signup')}}" class="btn-2 rounded-pill">{{ ___('label.become_merchant') }} <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="cta-right">
                <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::CTA,'cta-bg-image'), 'image_one') }}" class="cta-gari to-left" alt="CTA IMAGE">
            </div>
        </div>
    </div>
</div>
<!-- End CTA -->
