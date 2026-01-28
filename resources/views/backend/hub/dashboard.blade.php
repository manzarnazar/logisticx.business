@extends('backend.partials.master')
@section('title')
{{ request()->is('dashboard') ? ___('menus.dashboard') : ___('hub.hub_view') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row {{ request()->is('dashboard') ? 'd-none' : '' }}">
        <div class="col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}" class="breadcrumb-link">{{ ___('label.dashboard')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('hubs.index') }}" class="breadcrumb-link">{{ ___('hub.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.view')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->



    <div class="j-container">
        <div class="j-data-recv mb-20 grid-4">

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/box-primary.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_parcel') }}</h6>
                            <span>{{ @$report->totalParcels }}</span>
                        </div>
                    </div>
                </div>

                <div class="j-box-right">
                    <span>
                        {{-- <i> <img src="{{ asset('backend') }}/icons/icon/arrow-up-green.png" alt="no image"> </i> 15% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{ asset('backend') }}/images/shape/wave-primary.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/user-primary-2.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_delivery_man') }}</h6>
                            <span>{{ @$report->total_delivery_man  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span>
                        {{-- <i> <img src="{{ asset('backend') }}/icons/icon/arrow-up-green.png" alt="no image"> </i> 12% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{ asset('backend') }}/images/shape/wave-primary-2.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/dollar-primary-2.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_accounts') }}</h6>
                            <span>{{ @$report->total_accounts  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    {{-- <span> <i> <img src="{{ asset('backend') }}/icons/icon/arrow-up-green.png" alt="no image"> </i> 12% </span> --}}
                    <p class="mb-0">
                        <img src="{{ asset('backend') }}/images/shape/wave-primary-2.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/box-ylw.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_delivered') }}</h6>
                            <span>{{ @$report->total_parcels_delivered  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{ asset('backend') }}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{ asset('backend') }}/images/shape/wave-ylw.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/cart-green.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_partial_delivered') }}</h6>
                            <span>{{ @$report->total_parcels_partial_delivered  }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span>
                        {{-- <i> <img src="{{ asset('backend') }}/icons/icon/arrow-up-green.png" alt="no image"> </i> 07% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{ asset('backend') }}/images/shape/wave-green.png" alt="no image">
                    </p>
                </div>
            </div>

            <div class="j-data-box">
                <div class="j-box-left">
                    <div class="j-box-icon">
                        <i> <img src="{{ asset('backend') }}/icons/icon/box-ylw.png" alt="no image"> </i>
                        <div class="j-box-txt">
                            <h6 class="heading-6">{{ ___('dashboard.total_hero_assigned') }}</h6>
                            <span>{{ @$report->total_parcels_delivery_assigned }}</span>
                        </div>
                    </div>
                </div>
                <div class="j-box-right">
                    <span class="j-clr-red">
                        {{-- <i> <img src="{{ asset('backend') }}/icons/icon/arrow-down-red.png" alt="no image"> </i> 0.4% --}}
                    </span>
                    <p class="mb-0">
                        <img src="{{ asset('backend') }}/images/shape/wave-ylw.png" alt="no image">
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
                            <div id="line_chart_2" class="morris_chart_height" data-url="{{ route('parcel30DayStatus') }}" data-hub="{{ @$report->id }}"></div>
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
                            <h4 class="card-title">{{ ___('dashboard.cash_collection') }}</h4>
                            <span>{{___('dashboard.last_7_day')}}</span>
                        </div>
                        <div class="card-body">
                            <div id="morris_bar" class="morris_chart_height" data-url="{{ route('cod7day') }}" data-hub="{{ @$report->id }}"></div>
                            <ul class="j-card-list j-card-list-dir">
                                <li> <span></span> {{___('dashboard.hub') }} </li>
                                <li> <span class="clr-green"></span> {{___('dashboard.admin') }} </li>
                                <li> <span class="clr-red"></span> {{___('dashboard.pending') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mb-20 grid-2">

            <div class="card">
                <div class="card-header">
                    <h4 class="title-site">{{ ___('Recent pending') }}</h4>
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

                                @if(@$report->recentPendingParcels)
                                @forelse(@$report->recentPendingParcels as $parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', $parcel->id) }}">{{ $parcel->tracking_id }}</a></td>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->total_charge }} </td>
                                    <td> {{ settings('currency') }}{{ $parcel->parcelTransaction->current_payable }}</td>
                                    <td> {{ $parcel->created_at}}</td>
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
                    <h4 class="title-site">{{ ___('Recent delivered') }}</h4>
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

                                @if(@$report->recentDeliveredParcels)
                                @forelse(@$report->recentDeliveredParcels as $parcel)
                                <tr>
                                    <td> <a class="active" href="{{ route('parcel.details', @$parcel->id) }}">{{ @$parcel->tracking_id }}</a></td>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->cash_collection }}</li>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->total_charge }} </td>
                                    <td> {{ settings('currency') }}{{ @$parcel->parcelTransaction->current_payable }}</td>
                                    <td> {{ $parcel->created_at}}</td>
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
<script type="text/javascript" src="{{ asset('backend/js/custom/dashboard/hub_morris_donut.js') }}"></script>

@endpush
