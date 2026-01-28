@extends('backend.partials.master')
@section('title')
{{ ___('reports.parcel_wise_profit') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.reports') }}" class="breadcrumb-link active">{{ ___('reports.parcel_wise_profit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('parcel.wise.profit.reports')}}" method="GET">
                        {{-- @csrf --}}
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-md-3">
                                <label class="label-style-1" for="parcel_date">{{ ___('parcel.date') }}</label>
                                <input type="date" placeholder="{{___('placeholder.enter_date_range')}}" id="date" name="parcel_date" class="form-control input-style-1  flatpickr-range" value="{{ old('parcel_date',$request->parcel_date) }}">
                                @error('parcel_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- <div class="form-group col-12 col-md-3">
                                <label class=" label-style-1" for="tracking_id">{{ ___('parcel.tracking_id') }}</label>
                            <input id="tracking_id" type="text" name="tracking_id" placeholder="{{ ___('parcel.tracking_id') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('tracking_id', $request->tracking_id) }}">

                            @error('tracking_id') <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div> --}}

                        <div class="form-group col-sm-6 col-md-3">
                            <label class="label-style-1" for="merchant">{{ ___('parcel.merchant') }}</label>
                            <select id="merchant" name="merchant" class="form-control input-style-1 select2">
                                <option value=""> {{ ___('menus.select') }} {{ ___('parcel.merchant') }}</option>
                                @foreach ($merchants as $merchant)
                                <option value="{{ $merchant->id }}" @if(old('merchant',$merchant->id) == $request->merchant) selected @endif>{{ $merchant->business_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6 col-md-3">
                            <label class="label-style-1" for="parcelhub">{{ ___('parcel.hub') }}</label>
                            <select id="parcelhub" name="hub_id" class="form-control input-style-1 select2">
                                <option value="" selected> {{ ___('menus.select') }} {{ ___('hub.title') }}</option>
                                @foreach ($hubs as $hub)
                                <option value="{{ $hub->id }}" @if(old('hub_id',$hub->id) == $request->hub_id) selected @endif>{{ $hub->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- id="parcel_profit" --}}
                        <div class="form-group col-sm-6 col-md-3">
                            <label class="label-style-1" for="parcel_profit">{{ ___('reports.parcel_tracking_id') }}</label>
                            <select name="parcel_tracking_id[]" id="parcel_profit" class="form-control input-style-1 select2" multiple>
                            </select>
                            @error('parcel_tracking_id')
                            <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                </div>
                <div class="form-row mt-2">
                    <div class="col-12 col-xl-8 col-lg-3 col-md-6">
                        <div class="d-flex gap-2">
                            <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                            <a href="{{ route('parcel.wise.profit.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        @if(isset($print))
        <div class="card">


            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('reports.parcel_wise_profit') }} </h4>

                <a href="{{ route('download.all.profit.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn">
                    <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image">
                    <span>{{ ___('label.download_all') }}</span>
                </a>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  ">
                        <thead class="bg">
                            <tr>
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('reports.details') }}</th>
                                <th>{{ ___('reports.income') }}</th>
                                <th>{{ ___('reports.expense') }}</th>
                                <th>{{ ___('reports.profit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @forelse($parcels as $key=>$parcel)
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <div class="width300px">
                                        <b>Tracking Id :</b> <a class="active" href="{{ route('parcel.details',$parcel->id) }}" target="_blank">{{ $parcel->tracking_id }}</a><br />
                                        <span><b>Merchant :</b> {{$parcel->merchant->business_name}}</span><br>
                                        <span><b>Customer :</b> {{$parcel->customer_name}}</span><br>
                                    </div>
                                </td>
                                <td> {{ @settings('currency') }} {{ $parcel->parcelTransaction->total_charge }}</td>

                                @if ($parcel->deliveryHeroCommission != null)
                                <td> {{ @settings('currency') }} {{ $parcel->deliveryHeroCommission->sum('amount') }}</td>
                                <td>{{ @settings('currency') }} {{ ($parcel->parcelTransaction->total_charge - $parcel->deliveryHeroCommission->sum('amount'))}} </td>
                                @else
                                <td> Not Generated Yet </td>
                                <td> Not Calculated Yet </td>
                                @endif
                                {{-- <td>{{ @settings('currency') }} {{ ($parcel->parcelTransaction->total_charge - $parcel->deliveryHeroCommission->amount)}} </td> --}}
                            </tr>
                            @empty
                            <x-nodata-found :colspan="5" />
                            @endforelse


                        </tbody>
                        <tfoot>
                            <tr class="totalCalculationHead bg text-dark">
                                <td></td>
                                <td>{{ ___('reports.total') }} : </td>

                                <td>{{ @settings('currency') }} {{ $parcels->load('parcelTransaction')->sum(function ($parcel) {
                                        if($parcel->deliveryHeroCommission->sum('amount') != null){
                                            return optional($parcel->parcelTransaction)->total_charge ?? 0;
                                        }
                                        return 0;
                                    }) }}</td>
                                <td>{{ @settings('currency') }} {{ $parcels->load('deliveryHeroCommission')->sum(function ($parcel) {
                                        return optional($parcel->deliveryHeroCommission)->sum('amount') ?? 0;
                                    }) }}</td>

                                <td>
                                    {{ @settings('currency') }}
                                    @php
                                    $total = $parcels->load('parcelTransaction')->sum(function ($parcel) {
                                    return optional($parcel->parcelTransaction)->total_charge ?? 0;
                                    });
                                    $total -= $parcels->load('deliveryHeroCommission')->sum(function ($parcel) {
                                    return optional($parcel->deliveryHeroCommission)->sum('amount') ?? 0;
                                    });
                                    echo $total;
                                    @endphp
                                </td>



                                {{-- <td> {{ @settings('currency') }} {{ parcelExpenseTotal($parcels->pluck('id')) }} </td>
                                <td> {{ @settings('currency') }} {{ ($parcels->sum('total_delivery_amount') - parcelExpenseTotal($parcels->pluck('id')) ) }}</td> --}}
                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</div>

@endsection()


<!-- js  -->
@push('scripts')

{{-- need to check use of this js codes  --}}

<script type="text/javascript">
    var merchantUrl = "{{ route('parcel.merchant.get') }}";
    var merchantID = "{{ $request->parcel_merchant_id }}";
    var deliveryManID = "{{ $request->parcel_deliveryman_id }}";
    var pickupManID = "{{ $request->parcel_pickupman_id }}";
    var dateParcel = "{{ $request->parcel_date }}";

</script>

<script src="{{ asset('backend/js/custom/parcel/filter.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/print.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/jquery.table2excel.min.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/reports.js') }}"></script>

@endpush
