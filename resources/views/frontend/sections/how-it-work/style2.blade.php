
<!-- Work Area Start -->
<section class="work__area {{ implode(' ', $widget->section_padding) }}" 
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}" 
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" 
    @endif> 

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-title text-center mb-50 mx-auto">
                    <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block">{{ customSection(\Modules\Section\Enums\Type::FEATURES, 'short_title') }}</p>
                    <h2 class="hero-title-3">{{ customSection(\Modules\Section\Enums\Type::FEATURES, 'title') }}</h2>
                </div>
            </div>
        </div>
        <div class="row work-n">
            
            @foreach($features->take(4) as $key => $feature)

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="work__area-item">
                        <div class="work__area-item-icon">
                            {{-- <i class=""><img src="{{ getImage($feature->upload, 'original', 'default-image-40x40.png') }}" alt="no image"></i> --}}
                            <i class="fa-regular fa-heart"></i>
                            <span>0{{$key}}</span>
                        </div>
                        <div class="work__area-item-content">
                            <h5>{{$feature->title}}</h5>
                            <p>{{$feature->description}}</p>
                        </div>
                    </div>
                </div>

            @endforeach

            {{-- <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="work__area-item">
                    <div class="work__area-item-icon">
                    <i class="fa-regular fa-heart"></i>
                        <span>02</span>
                    </div>
                    <div class="work__area-item-content">
                        <h5>Bike Transport</h5>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered in some form There are many variations</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="work__area-item">
                    <div class="work__area-item-icon">
                        <i class="fa-solid fa-quote-left"></i>
                        <span>03</span>
                    </div>
                    <div class="work__area-item-content">
                        <h5>Boat Service</h5>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered in some form There are many variations</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="work__area-item">
                    <div class="work__area-item-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                        <span>04</span>
                    </div>
                    <div class="work__area-item-content">
                        <h5>Air Transport</h5>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered in some form There are many variations</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
	<!-- Work Area End -->
