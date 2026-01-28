@extends('backend.partials.master')

@section('title')
{{ ___('merchant.merchant_info') }}
@endsection

@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('merchant.dashboard') }}</a></li> --}}
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('menus.merchants') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('merchant.information') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.view') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 col-xxl-3">
            <x-backend.merchant.view-card :merchantId="$merchant_id" />
        </div>

        <div class="col-md-6 col-xxl-4">
            <div class="j-eml-card">
                <h5 class="heading-5"> {{ ___('label.personal_info') }}</h5>
                <ul class="j-eml-list">
                    <li>
                        <h6 class="heading-6">{{ ___('label.name') }}</h6>
                        <span>{{@$merchant->user->name}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.email') }}</h6>
                        <span>{{@$merchant->user->email}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.mobile') }}</h6>
                        <span>{{@$merchant->user->mobile}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.nid') }}</h6>
                        <span>{{@$merchant->user->nid_number}} </span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.address') }}</h6>
                        <span>{{@$merchant->user->address}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.joining_date') }}</h6>
                        <span>{{ @dateFormat($merchant->user->joining_date) }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.status') }}</h6>
                        <span>{!! @$merchant->user->my_status !!}</span>
                    </li>

                </ul>
            </div>
        </div>

        <div class="col-md-6 col-xxl-5">
            <div class="j-eml-card">
                <h5 class="heading-5"> {{ ___('label.business_info') }}</h5>
                <ul class="j-eml-list">
                    <li>
                        <h6 class="heading-6">{{ ___('label.business_name') }}</h6>
                        <span>{{@$merchant->business_name}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.unique_id') }} </h6>
                        <span>{{@$merchant->merchant_unique_id}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.address') }}</h6>
                        <span>{{@$merchant->address}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.hub') }}</h6>
                        <span>{{@$merchant->user->hub->name}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.coverage') }}</h6>
                        <span>{{ @$merchant->coverage->name }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.pickup_slot') }}</h6>
                        <span>{{ @$merchant->pickupSlot->title }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('merchant.shop') }}</h6>
                        <span>{{@$merchant->shops->count()}} {{ ___('merchant.active_shop') }}</span>
                    </li>

                    <li>
                        <h6 class="heading-6">{{ ___('merchant.vat') }}</h6>
                        <span>{{ @$merchant->vat }} % </span>
                    </li>

                    <li>
                        <h6 class="heading-6">{{ ___('label.status') }}</h6>
                        <span>{!! @$merchant->my_status !!}</span>
                    </li>

                </ul>
            </div>
        </div>

        <div class="col-md-6 col-xxl-5">
            <div class="j-eml-card">
                <h5 class="heading-5">{{ ___('label.documents') }}</h5>
                <ul class="j-eml-list">

                    <li class="align-items-center">
                        <h6 class="heading-6">{{ ___('label.nid') }}</h6>
                        <span class="d-flex align-items-center gap-2 gap-md-4 justify-content-end flex-wrap">
                            @if($merchant->nidfile)
                            <a class="bullet-badge-info p-2 me-2" href="{{ @$merchant->nid }}" download="{{ @$merchant->business_name . '-nid'}}"><i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download') }}</a>
                            @endif

                            @if(pathinfo(@$merchant->nid, PATHINFO_EXTENSION) != 'pdf')
                            <img src="{{ @$merchant->nid }}" width="100px" />
                            @endif
                        </span>
                    </li>

                    <li class="align-items-center">
                        <h6 class="heading-6">{{ ___('label.trade_license') }}</h6>
                        <span class="d-flex align-items-center gap-2 gap-md-4 justify-content-end flex-wrap">
                            @if($merchant->licensefile)
                            <a class="bullet-badge-info p-2 me-2" href="{{ @$merchant->trade }}" download="{{ @$merchant->business_name . '-Trade License'}}"><i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download') }}</a>
                            @endif

                            @if(pathinfo(@$merchant->trade, PATHINFO_EXTENSION) != 'pdf')
                            <img src="{{ @$merchant->trade }}" width="100px" />
                            @endif
                        </span>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection()
