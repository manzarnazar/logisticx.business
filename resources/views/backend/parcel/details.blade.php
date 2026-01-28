@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }} {{ ___('label.view') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.index')}}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.details')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap gap-3 mb-3">
                        <div>
                            <h4> {{ @$parcel->tracking_id }} </h4>
                        </div>
                        <div class="d-flex align-items-center gap-1 flex-wrap">
                            <a href="{{ route('parcel.print-label',$parcel->id) }}" class="btn btn-outline-warning"> <i class="fa-solid fa-print"></i> {{ ___('label.print_label') }}</a>
                            <a href="{{ route('parcel.print',$parcel->id) }}" class="btn btn-outline-secondary"> <i class="fa-solid fa-print"></i> {{ ___('label.print') }}</a>
                            <a href="{{ route('parcel.edit',$parcel->id) }}" class="btn btn-outline-primary"> <i class="fas fa-edit"></i> {{ ___('label.edit') }}</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-lg-nowrap gap-4 mb-3">
                        <div class="table-responsive ">
                            <table class="table mb-1">
                                <tbody>
                                    <tr>
                                        <td> <b>{{ ___('label.customer_name')}}</b>: </td>
                                        <td> {{ @$parcel->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b>{{ ___('label.address')}}</b>: </td>
                                        <td> {{ @$parcel->customer_address }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b>{{ ___('label.mobile_number')}}</b>: </td>
                                        <td> {{ @$parcel->customer_phone }}</td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="mt-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-dark p-0">{{ ___('label.tracking_url')}}</span>
                                    <input type="url" class="form-control input-style-1" id="tracking_url" value="{{ route('parcel.track',['tracking_id'=> @$parcel->tracking_id]) }}" onclick="copyText('tracking_url')" readonly>
                                    <button class="btn input-style-1 ml-1 rounded-0" onclick="copyText('tracking_url')"> {{ ___('label.copy')}} </button>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive ">
                            <table class="table table-bordered border-primary">
                                <tbody>
                                    <tr>
                                        <td><b>{{ ___('label.merchant')}}</b></td>
                                        <td> {{ @$parcel->merchant->business_name }} </td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ ___('label.shop')}}</b></td>
                                        <td> {{ @$parcel->shop->name }} </td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ ___('label.pickup_address')}}</b></td>
                                        <td> {{ @$parcel->pickup_address }} </td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ ___('label.date')}}</b></td>
                                        <td> {{ dateFormat(@$parcel->created_at)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-1 flex-wrap">
                            @if (@$parcel->parcelTransaction->cash_collection > 0)
                            <span class="btn btn-outline-danger"> {{ ___('COD') }} : {{ settings('currency') }} {{@$parcel->parcelTransaction->cash_collection}}</span>
                            @endif
                            <a href="{{route('support.add')}}" class="btn btn-outline-secondary"> {{ ___('label.open_ticket') }} </a>
                        </div>
                        <div>
                            {!! $parcel->parcel_status !!} {!! $parcel->payment_status !!}
                        </div>
                    </div>

                    @if(@$parcel->note)
                    <div class="mt-3 small"> <b>{{ ___('label.note')}}</b> : {{ @$parcel->note }}</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 col-xl-4">
            <div class="j-eml-card">
                <h5 class="heading-5 mb-0 px-4">{{ ___('label.other_info') }}</h5>
                <div class="card-body p-4 table-responsive">
                    <table class="table table-bordered border-primary">
                        <tbody>
                            <tr>
                                <td>{{ ___('charges.product_category')}}</td>
                                <td>{{ @$parcel->productCategory->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.service_type')}}</td>
                                <td>{{ @$parcel->serviceType->name }}</td>
                            </tr>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.area')}}</td>
                                <td>{{ @$parcel->AreaName }}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.charge')}}</td>
                                <td>{{ settings('currency') }} {{@number_format(($parcel->parcelTransaction->charge),2)}}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.cod_charge')}}</td>
                                <td>{{ settings('currency') }} {{@number_format(($parcel->parcelTransaction->cod_charge),2)}}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.vas_charge')}}</td>
                                <td>{{ settings('currency') }} {{@number_format(($parcel->parcelTransaction->vas_charge),2)}}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.liquid_fragile')}}</td>
                                <td>{{ settings('currency') }} {{@number_format(($parcel->parcelTransaction->liquid_fragile_charge),2)}}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('charges.discount')}}</td>
                                <td>{{ settings('currency') }} {{@number_format(($parcel->parcelTransaction->discount),2)}}</td>
                            </tr>
                            <tr>
                                <td>{{ ___('label.vat_amount')}}</td>
                                <td>{{ settings('currency') }} {{@number_format(($parcel->parcelTransaction->vat_amount),2)}}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ ___('label.total_cost')}}</strong></td>
                                <td><strong>{{ settings('currency') }} {{@$parcel->parcelTransaction->total_charge}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>{{ ___('label.is_charge_paid')}}</strong></td>
                                <td>
                                    @if (@$parcel->is_charge_paid)
                                    <span class="bullet-badge  bullet-badge-success"> {{ ___('label.yes')  }} </span>
                                    @else
                                    <span class="bullet-badge  bullet-badge-danger"> {{ ___('label.no')  }} </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ ___('label.current_payable')}}</td>
                                <td> {{ settings('currency') }} {{ @$parcel->parcelTransaction->current_payable }} </td>
                            </tr>
                            <tr>
                                <td>{{ ___('label.amount_to_collect')}}</td>
                                <td>{{ settings('currency') }} {{@$parcel->parcelTransaction->cash_collection}}</td>
                            </tr>

                            @if(@$parcel->parcelTransaction->cash_collection > 0)
                            <tr>
                                <td>{{ ___('label.cash_collection_status')}}</td>
                                <td>{!! @$parcel->CashCollectStatus !!}</td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-8">
            <div class="j-eml-card">
                <h5 class="heading-5 px-4 mb-0">{{ ___('label.tracking_activity') }}</h5>
                <div class="card-body p-4">

                    <ol class="list-group flex-column-reverse">
                        @foreach ($parcel->parcelEvent as $event )

                        <li class="list-group-item d-flex justify-content-between align-items-start small mb-2 flex-wrap gap-3">
                            <div class="ms-2 me-auto flex-grow-1">
                                <div class="fw-bold">
                                    <span>{{ @dateTimeFormat($event->created_at)  }} </span>

                                    @if($event->parcel_status == \App\Enums\ParcelStatus::PENDING )
                                    <strong>{{ ___('parcel.parcel_create')}}</strong><br>
                                    @else
                                    <strong>{{ $event->StatusName }}</strong>
                                    @endif

                                </div>

                                @if($event->deliveryMan)
                                <div>
                                    <span class="d-block"> <b>{{ ___('parcel.delivery_man')}}</b> : {{ @$event->deliveryMan->user->name }}</span>
                                    <span class="d-block"> <b>{{ ___('label.mobile')}}</b> : {{ @$event->deliveryMan->user->mobile }}</span>
                                </div>
                                @endif

                                @if($event->pickupman)
                                <div>
                                    <span class="d-block"><b>{{ ___('parcel.pickup_man')}}</b> : {{ @$event->pickupman->user->name }}</span>
                                    <span class="d-block"><b>{{ ___('label.mobile')}}</b> : {{ @$event->pickupman->user->mobile }}</span>
                                </div>
                                @endif

                                @if($event->hub)
                                <div>
                                    <span class="d-block"><b>{{ ___('label.hub')}}</b> : {{ @$event->hub->name }}</span>
                                    <span class="d-block"><b>{{ ___('label.mobile')}}</b> : {{ @$event->hub->phone }}</span>
                                </div>
                                @endif

                                @if($event->transferDeliveryman)
                                <div>
                                    <span class="d-block"><b>{{ ___('label.delivery_man')}}</b> : {{ @$event->transferDeliveryman->user->name }}</span>
                                    <span class="d-block"><b>{{ ___('label.mobile')}}</b> : {{ @$event->transferDeliveryman->user->mobile }}</span>
                                </div>
                                @endif

                                @if($event->parcel_status == \App\Enums\ParcelStatus::PENDING )
                                <div>
                                    <span class="d-block"><b>{{ ___('label.merchant')}}</b> : {{ @$parcel->merchant->business_name }}</span>
                                    <span class="d-block"><b>{{ ___('label.email')}}</b> : {{ @$parcel->merchant->user->email }}</span>
                                    <span class="d-block"><b>{{ ___('label.mobile')}}</b> : {{ @$parcel->merchant->user->mobile }}</span>
                                </div>
                                @endif

                                @if(@$event->note)
                                <div> <b>{{ ___('label.note')}}</b> : {{ @$event->note }}</div>
                                @endif

                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-lowercase"> {{ ___('label.by') }} - </span> {{ $event->user->name }}
                            </div>
                        </li>

                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- nd wrapper  -->
@endsection()
