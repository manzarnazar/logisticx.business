@extends('frontend.master')

@section('title')
{{ ___('label.blog') . ' | ' . settings('name') }}
@endsection


@section('main')

<!-- Start Breadcrumb
      ============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'blog-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{ route('/') }}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.latest_blogs') }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->


<!-- Blog Area Start -->
<div class="blog__one py-80">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="section-title text-center mb-50 mx-auto">
					<span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::BLOGS, 'short_title') }}</span>
					<h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::BLOGS, 'title') !!}</h2>
					<p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::BLOGS, 'short_description') }}</p>
				</div>
			</div>
		</div>
		<div class="row g-4">
            <div class="col-xl-12">
                <div class="flex justify-content-between mb-30">
                    @if (request()->input('q') != null)
                    <p class="title-page  ">{{ ___('label.showing_results_for') }} : {{ request()->input('q') }}</p>
                    @else
                    <h4 class="title-page  ">{{ ___('label.recent_posts') }}</h4>
                    @endif

                    <div class="blog-search">
                        <form class="blog-search-form" action="{{ route('frontend.blogs') }}">
                            <input type="text" name="q" class="form-control shadow-none" placeholder="{{ ___('placeholder.search') }}">
                            <button type="submit" class="blog-btn-v"> <i class="ti-search"></i> </button>
                        </form>
                    </div>
                </div>
            </div>

			@forelse ($blogs as $blog)
			<div class="col-xl-4 col-lg-4 col-md-6">
				<div class="blog__one-item card border-0 rounded-3 overflow-hidden shadow">
					<div class="blog__one-item-image card-img-top">
						<a href="{{ route('frontend.blog-single', $blog->slug) }}">
							<img src="{{ getImage($blog->upload, 'original') }}" alt="liability-insurance">
						</a>
						<div class="blog__one-item-image-date">
							<h5 class="mb-0">{{$blog->created_at->format('d')}}</h5>
							<span>{{$blog->created_at->format('M')}}</span>
						</div>
					</div>
					<div class="blog__one-item-content card-body p-4">
						<div class="blog__one-item-content-meta">
							<ul>
								<li><a><i class="far fa-user"></i>{{ @$blog->user->name }}</a></li>
								{{-- <li><a href="single-left-sidebar.html"><i class="far fa-comment-dots"></i>Comments (3)</a></li> --}}
							</ul>
						</div>
						<h4 class="text-truncate"><a href="{{ route('frontend.blog-single',$blog->slug) }}">{{$blog->title}}</a></h4>

						<p>{!! Str::limit($blog->description, 69) !!}</p>
						
					</div>
					<div class="blog__one-item-btn border-top">
						<a href="{{ route('frontend.blog-single',$blog->slug) }}">{{ ___('label.read_more') }}<span><i class="fas fa-arrow-right-long"></i></span></a>
					</div>
				</div>
			</div>
			@empty
				<p>No result pound!</p>
			@endforelse

			<div class="row align-items-center">
				<div class="col-md-12 ">
					<div class="pagination-custom mt-lg-5 mt-4">
						{{ $blogs->links() }}
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
	<!-- Blog Area End -->

<!-- Start Blog
      ============================================= -->
<!-- End Blog -->
@endsection
