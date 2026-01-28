@extends('frontend.master')
@section('title')
{{ ___('frontend.terms_condition')}}
@endsection
@section('main')

<!-- Start Breadcrumb ============================================= -->

<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'terms-conditions-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{route('/')}}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.terms_conditions') }} </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<div class="privacy-page py-80">
    <div class="container">
        <div class="privacy-page-wpr">
            {!! $page->description !!}
        </div>
    </div>
</div>

@endsection
