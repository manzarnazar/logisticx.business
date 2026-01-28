@extends('frontend.master')

@section('main')

<!-- Start Breadcrumb ============================================= -->
<div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'privacy-return-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{route('/')}}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.privacy_and_return_policy') }} </li>
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
