<!-- Service Start -->
<section class="container-fluid container-service {{ implode(' ', $widget->section_padding) }}" 
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}" 
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" 
    @endif> 

    <div class="container">
        <div class="section-title text-center mb-50 mx-auto">
            <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block"> {{ customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'short_title') }}</p>
            <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::OUR_BEST_SERVICE, 'title') !!}</h2>
        </div>
        <div class="row g-4">
            @foreach ($services->slice(0,8) as $service)
                <div class="col-lg-3 col-md-6" >
                    <div class="service-item shadow active">
                        <div class="icon-box-primary mb-4">
                            @if ($service->upload)
                                <div class="service-icon">
                                    <i> <img src="{{ getImage($service->upload, 'original','default-image-80x80.png') }}" alt="no image" > </i>
                                </div>
                            @endif
                        </div>
                        <h5 class="mb-3">{{ $service->title }}</h4>
                            <p class="mb-4">{{ \Illuminate\Support\Str::limit($service->short_description, 40) }}</p>
                        <a class="btn rounded btn-light fs-4 px-3" href="{{ route('frontend.service_details', $service->id) }}">{{ ___('label.read_more') }}<i class="bi bi-chevron-double-right ms-1"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Service End -->
