@extends('frontend.master')

@section('title')
{{ ___('frontend.parcel_tracking')}}
@endsection

@section('main')

<!-- Start Breadcrumb
		============================================= -->
<div class="site-breadcrumb " data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'track-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{route('/')}}">{{ ___('label.home')}}</a></li>
                <li class="active">{{ ___('label.tracking_parcel')}} </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Track Order
		============================================= -->
<div class="track-area de-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="track-up text-center">
                    <h4 class="title-page mb-20">{{ ___('parcel.track_your_parcel') }}</h4>
                    <div class="hero-track">
                        <form class="hero-track-form" action="{{ route('parcel.track') }}">
                            <input type="text" name="tracking_id" value="{{ request()->input('tracking_id')}}" placeholder="{{ ___('parcel.enter_tracking_id') }}">
                            <button type="submit" class="btn-sml"> {{ ___('label.track')}} </button>
                        </form>
                    </div>
                </div>
            </div>

            @if( request()->input('tracking_id') && $parcel == null )
            <div class="text-center col-sm-4 mx-auto mt-4 mt-lg-5">
                <img src="{{asset('frontend/assets/img/pictures/empty-box.png')}}" class="img-fluid" alt="">
                <h5 class="fs-3 mt-4">{{ ___('label.no_parcel_found') }}</h5>
            </div>
            @endif

        </div>

        @if($parcel != null)
        <div class="track wpr">
            <h4 class="title-page track-title"> {{ ___('parcel.parcel_tracking') }} </h4>
            <div class="track-timeline-wpr">
                <div class="row">
                    <div class="col-xl-12">
                        <ul class="track-list">


                            @foreach ($parcel->parcelEvent as $log )


                            <li>
                                <div class="track-time-box track-time-clr-1">
                                    <div class="track-time-left">
                                        <p>{{ timeFormat($log->created_at) }}</p>
                                        <span>{{ dateFormat($log->created_at) }}</span>
                                    </div>
                                    <div class="track-time-mid">
                                        <div class="track-time-icon mb-10">
                                            <i> <img src="{{asset('frontend/assets/img/icon/icon-top-3-wh.png')}}" alt="no image"> </i>
                                        </div>

                                        @if(!$loop->last)
                                        <div class="track-line text-center">
                                            <img src="{{asset('frontend/assets/img/icon/line-primary.png')}}" alt="no image">
                                        </div>
                                        @endif

                                    </div>
                                    <div class="track-time-right">
                                        <p> {{ $log->statusName   }}</p>
                                        <span> {{ $log->note   }}</span>
                                    </div>
                                </div>
                            </li>


                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
<!-- End Track Order -->
{{-- @dd($parcel) --}}
<!-- Start Charge Table
		============================================= -->
@if($parcel!=null)
<div class="charge-table-area de-pb">
    <div class="container">
        <h4 class="title-page track-title mb-20"> {{ ___('parcel.parcel_details') }} </h4>
        <div class="charge-table table-responsive m-3">
            <table class="table table-bordered border-primary">
                <thead class="bg">
                    <tr>
                        <th>{{ ___('parcel.service_type') }}</th>
                        <th>{{ ___('parcel.product_category') }}</th>
                        <th>{{ ___('common.from') }}</th>
                        <th>{{ ___('common.to') }}</th>
                        <th>{{ ___('common.total_amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ @$parcel->serviceType->name }}</td>
                        <td>{{ @$parcel->productCategory->name }}</td>
                        <td>{{ @$parcel->pickup_address }}</td>
                        <td>{{ @$parcel->customer_address }}</td>
                        <td>{{ settings('currency') . '    ' . @$parcel->parcelTransaction->total_charge }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
<!-- End Charge Table -->
