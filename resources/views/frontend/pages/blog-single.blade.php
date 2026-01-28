@extends('frontend.master')

@section('main')
<!-- Start Breadcrumb
      ============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'blog-single-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{ route('/') }}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.blog_details') }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- End  Breadcrumb -->

<!-- Start Blog Single
      ============================================= -->
<div class="blog-expand py-80">
    <div class="container">
        <div class="blog-expand-wpr">
            <div class="row g-5 mb-4">
                <div class="col-xl-8">
                    <div class="blog-pp">
                        <div class="blog-single-2">
                            <div class="blog-pic-2">
                                <img class="rounded" src="{{ getImage($blog->upload, 'image_three', 'default-image-620x310.png') }}" alt="no image">
                            </div>
                            <div class="blog-desc-2 p-4">
                                <ul class="blog-meta-2">
                                    <li> <i class="ti-timer"></i> <span>{{ dateFormat($blog->date) }}</span> </li>
                                    <li> <i class="ti-user"></i> <span>{{ $blog->user->name }}</span> </li>
                                </ul>
                                <div class="blog-text">
                                    <h3 class="fs-2"> {{ $blog->title }} </h3>
                                    <p class="mb-0"> {!! $blog->description !!} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="blog-sidebar">

                        <!-- Search Widget -->
                        <div class="blog-search mb-30">
                            <form class="blog-search-form" action="{{ route('frontend.blogs') }}">
                                <input type="text" name="q" class=" form-control" placeholder="{{ ___('placeholder.search') }}">
                                <button type="submit" class="blog-btn-v"> <i class="ti-search"></i> </button>
                            </form>
                        </div>

                        <!-- Post Widget -->
                        <div class="blog_ex blog-post-v rounded">
                            <h4 class="work-title">{{ ___('label.recent_posts') }}</h4>
                            @foreach ($blogs as $blog)
                            <div class="blog-post-v-single d-flex gap-3 align-items-center">
                                <div class="blg-detail-thumb flex-shrink-0">
                                    <a href="{{ route('frontend.blog-single', $blog->slug) }}"><img src="{{ asset('frontend/assets/img/pictures/about-home-2.jpg') }}" alt=""></a>
                                </div>
                                <div>
                                    <a href="{{ route('frontend.blog-single', $blog->slug) }}">
                                        <h6 class="heading-6"> {{ $blog->title }} </h6>
                                    </a>
                                    <span>{{ dateFormat($blog->date) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="share-recent-post">
                        <h4 class="title-page mb-20">{{ ___('label.recent_post') }}</h4>
                        <div class="blog-sldr-2 swiper swiper-margin pt-3 px-3 ">
                            <div class="swiper-wrapper">
                                @foreach ($blogs as $key => $blog)
                                <x-frontend.blog-single-view :blog="$blog" />
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Blog Single -->
@endsection
