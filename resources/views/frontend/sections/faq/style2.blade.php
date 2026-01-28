<div class="faq-area pos-rel {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>
 @php $faq_image = customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'faq_image'); @endphp
    <div class="faq-one-bg d-none d-lg-block" style="background-image: url('{{ $faq_image['original'] }}')"></div>

    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 align-self-end">
                <div class="row g-lg-0 g-4 ms-lg-5">
                    <div class="col-lg-6">
                        <div class="faq-counter">
                            <h3 class="heading-big mb-0">{{ customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'label_one_value') }}</h3>
                            <p class="faq-count-text mb-0">{!! customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'label_one_title') !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="faq-counter two">
                            <h3 class="heading-big mb-0">{{ customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'label_two_value') }}</h3>
                            <p class="faq-count-text mb-0">{!! customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'label_two_title') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="section-title mb-50">
                    <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'section_tagline') }}</span>
                    <h2 class="hero-title-3">{{ customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'section_title') }}</h2>
                    <p class="mb-0">{!! customSection(\Modules\Section\Enums\Type::FAQ_STYLE_TWO, 'description') !!}</p>
                </div>
                <div class="accordion accordion-one" id="accordionExample">

                    @foreach($faqs as $key=>$faq)

                    @if($key >=0 && $key <=10 ) <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne{{$faq->id}}">
                            <button class="accordion-button {{$key == 0? '':'collapsed'}} " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$faq->id}}" aria-expanded="{{$key == 0? 'true':'false'}}" aria-controls="collapseOne{{$faq->id}}"> {{$faq->title}} </button>
                        </h2>
                        <div id="collapseOne{{$faq->id}}" class="accordion-collapse collapse {{$key == 0? 'show':''}}" aria-labelledby="headingOne{{$faq->id}}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="mb-0"> {{$faq->description}} </p>
                            </div>
                        </div>
                </div>
                @endif

                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
</div>
