@extends('backend.partials.master')
@section('title')
{{ ___('menus.dashboard') }}
@endsection
@section('maincontent')
<div class="container-fluid">

    {{-- new dashboard --}}

    <div class="j-container">
        <div class="j-data-recv mb-20 grid-4">

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/box-primary.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_parcel') }}</h6>
                            <span>{{ @$total_parcel }}</span>
                        </div>
                    </div>
                </div>

                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-primary.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/user-green.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_user') }}</h6>
                            <span>{{ @$total_user  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-green.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/user-red.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_merchant') }}</h6>
                            <span>{{ @$total_merchant }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-red.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/user-primary-2.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_delivery_man') }}</h6>
                            <span>{{ @$total_delivery_man  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-primary-2.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/home-red.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_hubs') }}</h6>
                            <span>{{ @$total_hubs  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-red.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/dollar-primary-2.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_accounts') }}</h6>
                            <span>{{ @$total_accounts  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-primary-2.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/cart-green.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_partial_delivered') }}</h6>
                            <span>{{ @$total_partial_delivered  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-green.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/box-ylw.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_delivered') }}</h6>
                            <span>{{ @$total_delivered  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <p class="mb-0">
                        <img class="card-img" src="{{ asset('backend') }}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>

        </div>

        <div class="j-data-chart mb-20">
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
                                <li> <span class=""></span> {{ ___('parcel.pending') }} </li>
                                <li> <span class="clr-bullet-1"></span> {{ ___('parcel.delivered') }} </li>
                                <li> <span class="clr-bullet-4"></span> {{ ___('parcel.partial_delivered') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('parcel.returned') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="j-chart-box">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ ___('dashboard.courier_revenue') }}</h4>
                            <span>{{___('dashboard.last_7_day')}}</span>
                        </div>
                        <div class="card-body">
                            <div id="morris_bar" class="morris_chart_height" data-url="{{ route('courier7DayIncomeExpense') }}"></div>
                            <ul class="j-card-list j-card-list-dir">
                                <li> <span class="clr-bullet-1"></span> {{___('dashboard.income') }} </li>
                                <li> <span class=""></span> {{___('dashboard.expense') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="j-chart-parent-2a grid-3">
                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title">{{ ___('dashboard.hero_commission') }} </h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>
                    <div class="card-body j-card-flex">
                        <div class="j-card-left">
                            <ul class="j-card-list flex-row flex-md-column">
                                <li> <span class=""></span> {{ ___('dashboard.paid') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('dashboard.unpaid') }} </li>
                                <li> <span class="clr-bullet-1"></span> {{ ___('dashboard.total') }} </li>
                            </ul>
                        </div>
                        <div id="hero_commission_donut" class="morris_chart_height j-crcl" data-paid="{{ @$hero_paid_commission }}" data-unpaid="{{ @$hero_unpaid_commission }}"></div>
                    </div>
                </div>

                <div class="card  mb-0">
                    <div class="card-header">
                        <h4 class="card-title"> {{___('parcel.daily')}} {{ ___('dashboard.parcel_charge') }} </h4>
                        <span>{{___('dashboard.last_7_day')}}</span>
                    </div>
                    <div class="card-body">
                        <div id="line_chart_1" class="morris_chart_height" data-url="{{ route('dailyMerchantCharge') }}"></div>
                        <ul class="j-card-list j-card-list-dir">
                            <li> <span class="clr-bullet-1"></span> {{ ___('dashboard.paid') }} </li>
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
                            <ul class="j-card-list flex-row flex-md-column">
                                <li> <span></span> {{ ___('dashboard.hub') }} </li>
                                <li> <span class="clr-bullet-1"></span> {{ ___('dashboard.admin') }} </li>
                                <li> <span class="clr-red"></span> {{ ___('dashboard.merchant') }} </li>
                            </ul>
                        </div>
                        <div id="cod_donut" class="morris_chart_height j-crcl" data-cod-hub="{{ @$cod_received_hub }}" data-cod-admin="{{ @$cod_received_admin }}" data-cod-merchant="{{ @$cod_received_merchant }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-20 grid-2">

            <div class="card">
                <div class="card-header">
                    <h4 class="title-site">{{ ___('parcel.recent_pending') }}</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table">
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
                        <table class="table">
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
                                @forelse(@$deliveredParcels as $parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', @$parcel->id) }}">{{ @$parcel->tracking_id }}</a></td>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->total_charge }} </td>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->current_payable }}</td>
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
<script type="text/javascript" src="{{ asset('backend/js/custom/dashboard/admin_morris_donut.js') }}"></script>

@endpush
