@extends('backend.partials.master')
@section('title')
{{ ___('menus.panel_report') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports.panel') }}" class="breadcrumb-link">{{ ___('menus.panel_report') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{route('reports.panel')}}" method="get">
                        {{-- @csrf --}}
                        <input type="hidden" name="get_report" value="true">

                        <div class=" form-row">

                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1" for="user_type">{{ ___('reports.user_types') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" name="user_type" id="user_type" data-merchant="{{\App\Enums\UserType::MERCHANT }}" data-hub="{{\App\Enums\UserType::HUB }}" data-hero="{{\App\Enums\UserType::DELIVERYMAN }}">
                                    <option disabled selected>{{ ___('menus.select') }} {{ ___('reports.user_types') }}</option>
                                    <option value="{{ \App\Enums\UserType::MERCHANT }}" @selected(old('user_type',request()->input('user_type')) == \App\Enums\UserType::MERCHANT ) >{{ ___('reports.merchant') }}</option>
                                    <option value="{{ \App\Enums\UserType::HUB }}" @selected(old('user_type',request()->input('user_type')) == \App\Enums\UserType::HUB ) >{{ ___('reports.hub') }}</option>
                                    <option value="{{ \App\Enums\UserType::DELIVERYMAN }}" @selected(old('user_type',request()->input('user_type')) == \App\Enums\UserType::DELIVERYMAN )>{{ ___('reports.delivery_man') }}</option>
                                </select>
                                @error('user_type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-lg-6 merchant  d-none">
                                <label class="label-style-1" for="merchant_id">{{ ___('parcel.merchant') }} <span class="text-danger">*</span> </label>
                                <select name="merchant_id" id="merchant_id" class="form-control input-style-1 select2" data-url="{{ route('parcel.merchant.get') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('merchant.merchant') }}</option>

                                    @if(request()->input('merchant_id') )
                                    @php
                                    $merchant = \App\Models\Backend\Merchant::find(request()->input('merchant_id'));
                                    @endphp
                                    <option value="{{ @$merchant->id }}" selected>{{ @$merchant->business_name }}</option>
                                    @endif

                                </select>
                                @error('merchant_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- Hub Search --}}
                            <div class="form-group col-12 col-lg-6 hub  d-none">
                                <label class="label-style-1" for="hub_id">{{ ___('parcel.hub') }} <span class="text-danger">*</span> </label>
                                <select id="hub_id" name="hub_id" class="form-control input-style-1  select2" data-url="{{ route('parcel.hub.get') }}">
                                    <option value="" selected> {{ ___('menus.select') }} {{ ___('hub.title') }}</option>

                                    @if(request()->input('hub_id') )
                                    @php
                                    $hub = \App\Models\Backend\Hub::find(request()->input('hub_id'));
                                    @endphp
                                    <option value="{{ @$hub->id }}" selected>{{ @$hub->name }}</option>
                                    @endif

                                </select>

                                @error('hub_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- delivery man --}}
                            <div class="form-group col-12 col-lg-6 hero d-none">
                                <label class="label-style-1" for="delivery_man_id">{{ ___('parcel.deliveryman') }} <span class="text-danger">*</span> </label>
                                <select id="delivery_man_id" name="delivery_man_id" data-url="{{ route('deliveryman.search') }}" class="form-control input-style-1 select2">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('parcel.parcel') }}</option>

                                    @if(request()->input('delivery_man_id') )
                                    @php
                                    $hero = \App\Models\Backend\DeliveryMan::with('user:id,name')->find(request()->input('delivery_man_id'));
                                    @endphp
                                    <option value="{{ @$hero->id }}" selected>{{ @$hero->user->name }}</option>
                                    @endif

                                </select>
                                @error('delivery_man_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror

                            </div>

                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="text" placeholder= "{{___('placeholder.enter_date_range')}}" id="date" name="date" class="form-control input-style-1 flatpickr-range" value="{{ old('date',request()->input('date')) }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        <div class="d-flex justify-content-between mt-2">

                            <div class="d-flex">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.reports') }}</span></button>
                                <a href="{{ route('reports.panel') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                            </div>

                            @php
                            $reqData = ['print'=> true, 'user_type' => request()->user_type, 'merchant_id' => request()->merchant_id, 'hub_id' => request()->hub_id, 'delivery_man_id' => request()->delivery_man_id, 'date' => request()->date ];
                            @endphp

                            @if(@$reqData && @$report)
                            <a href="{{ route('reports.panel', $reqData) }}" class="j-td-btn" target="_blank">{{ ___('reports.print') }}</a>
                            @endif

                        </div>
                    </form>
                </div>
            </div>

            @if( request()->input('user_type') == \App\Enums\UserType::MERCHANT && @$report)
            @include('backend.reports.panel.merchant')
            @endif

            @if( request()->input('user_type') == \App\Enums\UserType::HUB && @$report)
            @include('backend.reports.panel.hub')
            @endif

            @if( request()->input('user_type') == \App\Enums\UserType::DELIVERYMAN && @$report)
            @include('backend.reports.panel.deliveryman',['col'=>'col-6'])
            @endif

        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()


@push('scripts')

<script src="{{ asset('backend/js/custom/parcel/panel_report.js') }}"></script>

@endpush
