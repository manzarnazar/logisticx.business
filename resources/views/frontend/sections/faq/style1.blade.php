<div class="faq-one position-relative {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="row justify-content-between g-4">
            <div class="col-lg-6 pe-lg-5">
                <div class="section-title mb-50">
                    <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::FAQ, 'short_title') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::FAQ, 'title') !!}</h2>
                    <p class=" mb-0">{{ customSection(\Modules\Section\Enums\Type::FAQ, 'description') }}</p>
                </div>
                <div class="img-thumb rounded-4 overflow-hidden">
                    <img src=" {{ data_get(customSection(\Modules\Section\Enums\Type::FAQ,'faq_image'), 'image_one') }}" class="w-100 h-100 object-fit-cover" alt="FAQ image">
                </div>
            </div>
{{-- @dd($faqs) --}}
            <div class="col-lg-6 ps-lg-4">
             <div class="accordion accordion-two h-100" id="accordionTwo">
                    @foreach($faqs as $key=>$faq)
                        @if ($key <= 10)
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
</div>
</div>
<!-- End Faq -->
