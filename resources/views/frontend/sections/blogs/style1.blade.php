<!-- Blog Area Start -->
<div class="blog__one {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-title text-center mx-auto mb-50">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::BLOGS, 'short_title') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::BLOGS, 'title') !!}</h2>
                    <p>{{ customSection(\Modules\Section\Enums\Type::BLOGS, 'short_description') }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4">

            @foreach($blogs->take(6) as $key => $blog)

            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="blog__one-item card border-0 rounded-3 overflow-hidden shadow">

                    <div class="blog__one-item-image card-img-top">
                        <a href="{{ route('frontend.blog-single', $blog->slug) }}">
                            <img src="{{ getImage($blog->upload, 'image_two','default-image-80x80.png') }}" alt="liability-insurance">
                        </a>
                        <div class="blog__one-item-image-date">
                            <h5 class="mb-0">{{ date('d', strtotime($blog->date)) }}</h5>
                            <span>{{ date('M', strtotime($blog->date)) }}</span>
                        </div>
                    </div>

                    <div class="blog__one-item-content card-body p-4">
                        <div class="blog__one-item-content-meta">
                            <ul>
                                <li><a><i class="far fa-user"></i>{{@$blog->user->name}}</a></li>
                            </ul>
                        </div>
                        <h4 class="text-truncate"><a href="{{ route('frontend.blog-single', $blog->slug) }}">{{ Str::limit($blog->title, 35) }}</a></h4>
                        <p>{!! Str::limit(strip_tags($blog->description), 80) !!}</p>
                    </div>

                    <div class="blog__one-item-btn border-top">
                        <a href="{{ route('frontend.blog-single', $blog->slug) }}">{{ ___('label.read_more') }}<span><i class="fas fa-arrow-right-long"></i></span></a>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
</div>
<!-- Blog Area End -->
