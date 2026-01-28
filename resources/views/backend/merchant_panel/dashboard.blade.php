<!-- wrapper  -->

@extends('backend.partials.master')
@section('title')
{{ ___('merchant.dashboard') }}
@endsection
@section('maincontent')
<div class="container-fluid">


    <div class="j-container">
        <div class="j-data-recv mb-20 grid-4">

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
                            <span>{{ @$total_delivered + @$total_partial_delivered  }}</span>
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
                            <h6 class="heading-6">{{ ___('dashboard.total_return') }}</h6>
                            <span>{{ @$total_return }}</span>
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
                        <i>
                            <img src="{{asset('backend')}}/icons/icon/box-ylw.png" alt="no image">
                        </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_transit') }}</h6>
                            <span>{{ @$total_parcel - ( @$total_delivered + @$total_partial_delivered + @$total_return)}}</span>
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
                            <h6 class="heading-6">{{ ___('dashboard.total_delivery_fees_paid') }}</h6>
                            <span>{{settings('currency')}}{{number_format(@$total_charge_paid,2)}}</span>
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
                            <h6 class="heading-6">{{ ___('label.total_vat') }}</h6>
                            <span>{{settings('currency')}}{{number_format(@$total_vat,2)}}</span>
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
                            <h6 class="heading-6">{{ ___('dashboard.pending_payments') }}</h6>
                            <span>{{settings('currency')}}{{number_format( @$pending_payments,2)}}</span>
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
                            <h6 class="heading-6">{{ ___('dashboard.processed_payments') }}</h6>
                            <span>{{settings('currency')}}{{number_format( @$processed_payments,2)}}</span>
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

        <div class="j-data-chart">
            <div class="j-chart-parent mb-20">

                <div class="j-chart-box">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ ___('dashboard.parcel_status')  }}</h4>
                            <span>{{___('dashboard.last_30_day')}}</span>
                        </div>
                        <div class="card-body">
                            <div id="line_chart_2" class="morris_chart_height" data-url="{{ route('parcel30DayStatus') }}"></div>
                            <ul class="j-card-list j-card-list-dir">
                                <li> <span></span> {{ ___('parcel.pending') }} </li>
                                <li> <span class="clr-green"></span> {{ ___('parcel.delivered') }} </li>
                                <li> <span class="clr-green"></span> {{ ___('parcel.partial_delivered') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('parcel.returned') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="j-chart-box">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ ___('dashboard.parcel_charge')  }}</h4>
                            <span>{{___('dashboard.last_7_day')}}</span>
                        </div>
                        <div class="card-body">
                            <div id="morris_bar" class="morris_chart_height" data-url="{{ route('dailyMerchantCharge') }}"></div>
                            <ul class="j-card-list j-card-list-dir">
                                <li> <span class="clr-green"></span> {{___('parcel.paid')}} </li>
                                <li> <span class="clr-red"></span> {{___('parcel.unpaid')}} </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="j-chart-parent-2 grid-3">

                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title">{{ ___('dashboard.cod') }}</h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>

                    <div class="card-body j-card-flex">
                        <div class="j-card-left">
                            <ul class="j-card-list">
                                <li> <span></span> {{ ___('dashboard.total') }} </li>
                                <li> <span class="clr-green"></span> {{ ___('dashboard.received') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('dashboard.pending') }} </li>
                            </ul>
                        </div>
                        <div id="morris_donut_cod" class="morris_chart_height j-crcl" data-pending="{{ @$last7Day->codPending }}" data-received="{{ @$last7Day->codReceived }}"></div>
                    </div>
                </div>

                <div class="card  mb-0">
                    <div class="card-header">
                        <h4 class="card-title"> {{___('parcel.daily')}} {{ ___('dashboard.cod') }} </h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>
                    <div class="card-body">
                        <div id="line_chart_1" class="morris_chart_height" data-url="{{ route('cod7day') }}"></div>
                        <ul class="j-card-list j-card-list-dir">
                            <li> <span class="clr-red"></span> {{ ___('dashboard.unpaid') }} </li>
                            <li> <span class="clr-green"></span> {{ ___('dashboard.paid') }} </li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title">{{ ___('dashboard.parcel_charge') }} </h4>
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
                        <div id="morris_donut_charge" class="morris_chart_height j-crcl" data-paid="{{ @$charge_paid }}" data-unpaid="{{ @$charge_unpaid }}"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="j-container mt-20">
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
                                    <th>{{ ___('label.cod') }}</th>
                                    <th>{{ ___('label.charge') }}</th>
                                    <th>{{ ___('label.payable') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(@$pendingParcels)
                                @forelse(@$pendingParcels as $parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', $parcel->id) }}">{{ $parcel->tracking_id }}</a></td>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->total_charge }} </td>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->current_payable }}</td>
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
                                    <th>{{ ___('label.cod') }}</th>
                                    <th>{{ ___('label.charge') }}</th>
                                    <th>{{ ___('label.payable') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(@$deliveredParcels)
                                @forelse(@$deliveredParcels as $d_parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', @$d_parcel->id) }}">{{ @$d_parcel->tracking_id }}</a></td>
                                    <td> {{ settings('currency') }}{{ @$d_parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ settings('currency') }}{{ @$d_parcel->parcelTransaction->total_charge }} </td>
                                    <td> {{ settings('currency') }}{{ @$d_parcel->parcelTransaction->current_payable }}</td>
                                    <td> {{ dateFormat(@$parcel->created_at) }}</td>
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


@endsection()


@push('scripts')

<!-- Chart Morris plugin files -->
<script src="{{asset('backend')}}/vendor/raphael/raphael.min.js"></script>
<script src="{{asset('backend')}}/vendor/morris/morris.min.js"></script>

{{-- update chart --}}

<script type="text/javascript" src="{{ asset('backend/js/custom/dashboard/merchant_morris_chart.js') }}"></script>
@endpush
