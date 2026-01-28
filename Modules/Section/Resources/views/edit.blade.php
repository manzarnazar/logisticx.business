@extends('backend.partials.master')
@section('title')
{{ $sectionType}} {{ ___('label.edit') }}
@endsection

@section('maincontent')


<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('dashboard.website_Setup')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('section.index') }}" class="breadcrumb-link">{{ ___('label.sections') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ $sectionType }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('section.update',['type'=>$type]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">

                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('label.sections') }} </h4>
                        </div>

                        <div class="form-row">

                            @switch($type)

                            @case(Modules\Section\Enums\Type::CONTACT_US)
                            @include('section::form.contact_us')
                            @break

                            {{-- @case(Modules\Section\Enums\Type::COUNT)
                            @include('section::form.counter')
                            @break --}}

                            {{-- @case(Modules\Section\Enums\Type::HEADER)
                            @include('section::form.header')
                            @break --}}

                            @case(Modules\Section\Enums\Type::HERO_SECTION)
                            @include('section::form.hero_section')
                            @break

                            @case(Modules\Section\Enums\Type::ABOUT_US)
                            @include('section::form.about_us')
                            @break

                            @case(Modules\Section\Enums\Type::OUR_ACHIEVEMENT)
                            @include('section::form.our_achievement')
                            @break
                            
                            @case(Modules\Section\Enums\Type::OUR_ACHIEVEMENT_TWO)
                            @include('section::form.our_achievement_two')
                            @break

                            @case(Modules\Section\Enums\Type::DELIVERY_SUCCESS)
                            @include('section::form.delivery_success')
                            @break

                            @case(Modules\Section\Enums\Type::OUR_BEST_SERVICE)
                            @include('section::form.our_best_service')
                            @break

                            @case(Modules\Section\Enums\Type::FAQ)
                            @include('section::form.faq')
                            @break
                           
                            @case(Modules\Section\Enums\Type::FAQ_STYLE_TWO)
                            @include('section::form.faq_two')
                            @break
                           
                            @case(Modules\Section\Enums\Type::HOW_WE_WORK)
                            @include('section::form.how_we_work')
                            @break

                            @case(Modules\Section\Enums\Type::CLIENT_REVIEW)
                            @include('section::form.client_review')
                            @break

                            @case(Modules\Section\Enums\Type::BLOGS)
                            @include('section::form.blogs')
                            @break

                            @case(Modules\Section\Enums\Type::CLIENT_SECTION)
                            @include('section::form.client_section')
                            @break

                            @case(Modules\Section\Enums\Type::SIGNIN)
                            @include('section::form.signin')
                            @break

                            @case(Modules\Section\Enums\Type::SIGNUP)
                            @include('section::form.signup')
                            @break

                            @case(Modules\Section\Enums\Type::BREADCRUMB)
                            @include('section::form.breadcrumb')
                            @break

                            @case(Modules\Section\Enums\Type::DELIVERY_CALCULATOR)
                            @include('section::form.delivery_calculator')
                            @break
                            
                            @case(Modules\Section\Enums\Type::DELIVERY_CALCULATOR_TWO)
                            @include('section::form.delivery_calculator_two')
                            @break

                            @case(Modules\Section\Enums\Type::CHARGE_LIST)
                            @include('section::form.charge_list')
                            @break

                            @case(Modules\Section\Enums\Type::COVERAGE_AREA)
                            @include('section::form.coverage_area')
                            @break

                            @case(Modules\Section\Enums\Type::CTA)
                            @include('section::form.cta_form')
                            @break

                            @case(Modules\Section\Enums\Type::THEME_APPEARANCE)
                            @include('section::form.theme_appearance')
                            @break

                            @case(Modules\Section\Enums\Type::FEATURES)
                            @include('section::form.features')
                            @break

                            @case(Modules\Section\Enums\Type::GALLERY)
                            @include('section::form.gallery')
                            @break

                            @case(Modules\Section\Enums\Type::POPUP_CONTENT)
                            @include('section::form.popups_content')
                            @break

                            @endswitch

                        </div>
                        <div class="form-row">
                            <div class="j-create-btns ml-1">
                                <div class="drp-btns">
                                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                                    <a href="{{ route('section.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
