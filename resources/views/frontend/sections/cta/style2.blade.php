
<section class="cta-section pos-rel {{ implode(' ', $widget->section_padding) }}"
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}" 
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" 
    @endif> 
    
    <div class="container-fluid">
        <div class="row g-lg-0 align-items-center">
            <div class="col-lg-4">
                <div class="cta-left-image pos-rel" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::CTA,'cta-bg-image'), 'image_one') }}" >
                    <div class="icon-box d-none d-lg-block"><i class="flaticon-food-delivery"></i></div>
                </div>
            </div>
            <div class="col-lg-8 cta-right d-flex align-items-center gap-lg-4 gap-3 justify-content-between flex-wrap">
                <div class="title-box text-white">
                    <h4 class="text-white">{!! customSection(\Modules\Section\Enums\Type::CTA, 'title') !!} </h4>
                    <span>{{ customSection(\Modules\Section\Enums\Type::CTA, 'short_title') }}</span>
                </div>
                <div class="link-button">
                    <a href="{{route('signup')}}" class="btn-2nd py-4 rounded-pill"><i class="flaticon-document"></i>{{ ___('label.become_merchant') }}</a>
                </div>
            </div>
        </div>
    </div>
   
</section>
