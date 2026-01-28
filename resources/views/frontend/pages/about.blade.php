@extends('frontend.master')
@section('title')
{{ ___('frontend.about_us')}}
@endsection

@section('main')

<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'aboutus-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{route('/')}}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.about_us') }} </li>
            </ul>
        </div>
    </div>
</div>

<div class="about-area pt-80">

    <x-frontend.about-section-card />

</div>

<div id="about-us" class="About-page pt-0 py-80">
    <div class="container">
        <div class="about-page-wpr">
            {!! $page->description !!}
        </div>
    </div>
</div>

@endsection
