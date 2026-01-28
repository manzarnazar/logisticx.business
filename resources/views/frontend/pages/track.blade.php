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



<!--=========== New Tracking page start --==========-->

<section class="track-page py-80">
    <div class="container-fluid track-page">
        <div class="text-center top-text">
            <h4 class="heading-3 fw-bold">{{ ___('parcel.Enter_your_tracking_number') }} </h4>
            <p class="">{{ ___('parcel.to_find_your_shipment') }}</p>
        </div>

        <form class="track-search-bar d-flex justify-content-center align-items-center" action="{{ route('parcel.track') }}">
            <i class="icofont-search"></i>
            <input name="tracking_id" type="text" class="form-control" value="{{ request()->input('tracking_id')}}" placeholder="{{ ___('parcel.enter_tracking_id') }}">
            <button type="submit" class="btn-1">{{ ___('parcel.Search') }}</button>
        </form>

 @if($parcel != null)
        <div class=" info-container rounded border mx-auto">
            <div class="row g-0">
                <div class="col-md-8 border-end">
                    <div class=" delivery-badge mb-md-2 mb-3"><span class="custom-badge badge-primary"> {!! @$parcel->parcel_status !!} </span></div>
                    <div class="delivery-date d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="heading-4 mb-0">{{ dateFormat(@$parcel->created_at) }}</h4>
                        </div>
                        <div class="text-end">
                            <p class="mb-0">{{ dateFormat(@$parcel->created_at) }} {{ timeFormat(@$parcel->created_at) }}</p>
                            <p class="mb-0">Tracking {{ @$parcel->tracking_id  }}</p>
                        </div>
                    </div>

                    <div class="shipment-info">
                        <h5 class="heading-5 info-title mb-0">Shipment Info</h5>

                        <div class="row g-0">
                            <div class="col-md-6 border-end">
                                <div class="sending-info ps-0">
                                    <h5 class="heading-5 lh-1 mb-4 d-flex align-items-center gap-2"><i class="icofont-envelope me-2 icon"></i>Sender from</h5>
                                    <h5 class="sender-name mb-2">{{ @$parcel->merchant->business_name }}</h5>
                                    <span class="address mb-2 d-block">Address: <span>{{ @$parcel->merchant->address }}</span></span>
                                    <span class="address mb-2 d-block">pickup date: <span>{{ dateFormat(@$parcel->created_at)}}</span></span>
                                    <span class="address mb-0 d-block">Phone: <span>{{ @$parcel->pickup_phone }}</span></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sending-info">
                                    <h5 class="heading-5 lh-1 mb-4 d-flex align-items-center gap-2"><i class="icofont-envelope-open me-2 icon"></i>Reciver Info</h5>
                                    <h5 class="sender-name mb-2">{{ @$parcel->customer_name }}</h5>
                                    <span class="address mb-2 d-block">Address: <span>{{ @$parcel->customer_address }}</span></span>
                                    <span class="address mb-0 d-block">Phone: <span>{{ @$parcel->customer_phone }}</span></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="delivery-man-info text-center mt-3">
                        <div class="avatar mx-auto mb-3">
                            <img src="{{ asset('frontend/assets/img/testimonial/person-1.png') }} " alt="">

                        </div>
                        <h5 class="heading-4 mb-2">Jhon Doe</h5>
                        <p class="mb-3 lh-1">+8801627130505</p>
                        <div class="rating text-warning d-flex align-items-center justify-content-center mb-3 gap-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-primary r-number">5</span>
                        </div>
                        <p class="mb-4 lh-1">40 Complete deliveries</p>
                        <a href="#" class="btn-1 w-100">Rate Rider</a>
                    </div>
                </div>
            </div>
        </div>


        <h4 class="heading-3 fw-bold text-center my-5">Enter your tracking number</h4>
        <div class="tracking-container d-flex flex-wrap align-items-center gap-4 border">
            <div class="left-icon flex-shrink-0 d-none d-lg-block">
                <div class="mb-2"><i class="icofont-fast-delivery"></i></div>
                <h5 class="heading-5 mb-0">Destiached</h5>
            </div>
            <div class="timeline">
                <!-- Item 1 -->
                  @foreach ($parcel->parcelEvent??[] as $log )
                        <div class="timeline-item">
                            <div class="flex-shrink-0">
                                <div class="timeline-date">{{ dateFormat($log->created_at) }}</div>
                                <div class="timeline-time"><p>{{ timeFormat($log->created_at) }}</p></div>
                            </div>
                            <div class="timeline-content d-flex gap-3 align-items-center">
                                <i class="icofont-compass"></i>
                                <h5 class=" mb-0"><span> {{ $log->statusName    }}</span></h5>
                                <h5 class=" mb-0"><span> {{ $log->note   }}</span></h5>

                            </div>
                        </div>

                   @endforeach

            </div>
        </div>
       @endif
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



    </div>
</section>

<!--=========== New Tracking page Ends --==========-->


@endsection
