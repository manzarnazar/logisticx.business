<div class="about-area {{ implode(' ', $widget->section_padding) }}" 
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}" 
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" 
    @endif> 

    {{-- about Section --}}
    <x-frontend.about-section-card />

    </div>
</div>
