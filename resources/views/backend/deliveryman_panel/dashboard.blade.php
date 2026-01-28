@extends('backend.partials.master')
@section('title')
{{ ___('menus.dashboard') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <div class="j-container">
        <div class="j-data-recv mb-20 grid-3">

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{asset('backend')}}/icons/icon/box-primary.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_parcel') }}</h6>
                            <span>{{ @$total_parcel }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span>
                        {{-- <i> <img src="{{asset('backend')}}/icons/icon/arrow-up-green.png" alt="no image"> </i> 12% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{asset('backend')}}/images/shape/wave-primary.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{asset('backend')}}/icons/icon/box-ylw.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_delivered') }}</h6>
                            <span>{{ @$total_delivered }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{asset('backend')}}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{asset('backend')}}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i class="fw-semibold"> <img src="{{asset('backend')}}/icons/icon/box-ylw.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_partial_delivered') }}</h6>
                            <span>{{ @$total_partial_delivered }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{asset('backend')}}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{asset('backend')}}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{asset('backend')}}/icons/icon/box-ylw.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_assigned') }}</h6>
                            <span>{{ @$total_assigned   }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{asset('backend')}}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{asset('backend')}}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i class="fa fa-credit-card"></i>

                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_commission_paid') }}</h6>
                            <span>{{settings('currency')}}{{number_format( @$total_commission_paid,2)}}</span>
                        </div>

                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{asset('backend')}}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{asset('backend')}}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i class="fa fa-credit-card"></i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_commission_unpaid') }}</h6>
                            <span>{{settings('currency')}}{{number_format( @$total_commission_unpaid,2)}}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{asset('backend')}}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{asset('backend')}}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>
        </div>


        <div class="j-data-chart mb-20">
            <div class="j-chart-parent-2 grid-3">

                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title">{{ ___('dashboard.weekly_commission') }} </h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>
                    <div class="card-body j-card-flex">
                        <div class="j-card-left">
                            <ul class="j-card-list">
                                <li> <span class="clr-green"></span> {{ ___('dashboard.paid') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('dashboard.unpaid') }} </li>
                                <li> <span></span> {{ ___('dashboard.total') }} </li>
                            </ul>
                        </div>
                        <div id="commission_donut" class="morris_chart_height j-crcl" data-paid="{{ @$last7Day->commission_paid }}" data-unpaid="{{ @$last7Day->commission_unpaid }}"></div>
                    </div>
                </div>

                <div class="card  mb-0">
                    <div class="card-header">
                        <h4 class="card-title">{{ ___('dashboard.daily_commission') }}</h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>
                    <div class="card-body">
                        <div id="commission_morris_line" class="morris_chart_height" data-url="{{ route('hero7DayCommission') }}"></div>
                        <ul class="j-card-list j-card-list-dir">
                            <li> <span class="clr-green"></span> {{ ___('dashboard.paid') }} </li>
                            <li> <span class="clr-red"></span> {{ ___('dashboard.unpaid') }} </li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title">{{ ___('dashboard.cod') }}</h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>

                    <div class="card-body j-card-flex">
                        <div class="j-card-left">
                            <ul class="j-card-list">
                                <li> <span class="clr-green"></span> {{ ___('dashboard.paid') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('dashboard.unpaid') }} </li>
                                <li> <span></span> {{ ___('dashboard.total') }} </li>
                            </ul>
                        </div>
                        <div id="cod_donut" class="morris_chart_height j-crcl" data-paid="{{ @$last7Day->codPayToHub }}" data-payable="{{ @$last7Day->codPayableToHub }}"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid-2">

            <div class="card">
                <div class="card-header">
                    <h4 class="title-site">{{ ___('parcel.recent_pending') }}</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('parcel.tracking_id') }}</th>
                                    <th>{{ ___('label.product') }}</th>
                                    <th>{{ ___('label.service') }}</th>
                                    <th>{{ ___('label.cod') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(@$pendingParcels)
                                @forelse(@$pendingParcels as $parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', $parcel->id) }}">{{ $parcel->tracking_id }}</a></td>
                                    <td> {{ $parcel->productCategory->name }} </td>
                                    <td> {{ $parcel->serviceType->name }}</td>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ dateFormat( $parcel->created_at) }}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
                                @endforelse
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="title-site">{{ ___('parcel.recent_delivered') }}</h4>
                </div>

                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('parcel.tracking_id') }}</th>
                                    <th>{{ ___('label.product') }}</th>
                                    <th>{{ ___('label.service') }}</th>
                                    <th>{{ ___('label.cod') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(@$deliveredParcels)
                                @forelse(@$deliveredParcels as $parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', @$parcel->id) }}">{{ @$parcel->tracking_id }}</a></td>
                                    <td> {{ $parcel->productCategory->name }} </td>
                                    <td> {{ $parcel->serviceType->name }}</td>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ dateFormat( @$parcel->created_at) }}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
                                @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- end wrapper  -->
@endsection



@push('scripts')

<!-- Chart Morris plugin files -->
<script src="{{asset('backend')}}/vendor/raphael/raphael.min.js"></script>
<script src="{{asset('backend')}}/vendor/morris/morris.min.js"></script>

{{-- update chart --}}

<script type="text/javascript" src="{{ asset('backend/js/custom/dashboard/hero_morris_chart.js') }}"></script>
@endpush
