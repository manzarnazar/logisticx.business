@extends('backend.partials.master')
@section('title')
{{ ___('reports.parcel_reports') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('dashboard.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.reports') }}" class="breadcrumb-link active">{{ ___('reports.parcel_reports') }}</a></li>
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
            <div class="card">
                <div class="card-body">
                    {{-- <form action="{{route('parcel.filter.reports')}}" method="GET"> --}}
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="form-row">
                            <div class="form-group  col-sm-6 col-md-3">
                                <label class="label-style-1" for="parcel_date">{{ ___('parcel.date') }}</label>
                                <input type="date" placeholder="{{___('placeholder.enter_date_range')}}" id="date" name="parcel_date" class="form-control  input-style-1 flatpickr-range" value="{{ old('parcel_date',$request->parcel_date) }}">
                                @error('parcel_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group  col-sm-6 col-md-3">
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
                                    <option value=""> {{ ___('menus.select') }} {{ ___('hub.title') }}</option>
                                    @foreach ($hubs as $hub)
                                    <option value="{{ $hub->id }}" @if(old('hub_id',$hub->id) == $request->hub_id) selected @endif>{{ $hub->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-sm-6 col-md-3">
                                <label class="label-style-1" for="parcelStatus">{{ ___('parcel.status') }}</label>
                                <select id="parcelStatus" name="parcel_status[]" class="form-control select2" multiple>
                                    <option value="" disabled>{{ ___('merchant.parcelStatus') }}</option>
                                    @foreach (config('site.status.parcel') as $key => $status)
                                    <option value="{{ $key}}" @if($request->parcel_status !== null && in_array($key,$request->parcel_status)) selected @endif>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('parcel_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 col-md-6">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ url()->current() }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>

            @if(isset($parcels))

            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('reports.parcel_reports') }}</h4>

                    <a href="{{ route('download.all.parcel_status.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn">
                        <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image">
                        <span>{{ ___('label.download_all') }}</span>
                    </a>



                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table    ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('reports.count') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($parcels as $key=>$parcel)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{!! StatusParcel($key) !!}</td>
                                    <td>{{ $parcel->count() }}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="3" />
                                @endforelse
                            </tbody>
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

<script type="text/javascript">
    var merchantUrl = "{{ route('parcel.merchant.get') }}";
    var merchantID = '{{ $request->parcel_merchant_id }}';
    var deliveryManID = '{{ $request->parcel_deliveryman_id }}';
    var pickupManID = '{{ $request->parcel_pickupman_id }}';
    var dateParcel = '{{ $request->parcel_date }}';

</script>

<script src="{{ asset('backend/js/custom/parcel/filter.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/print.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/jquery.table2excel.min.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/reports.js') }}"></script>


@endpush
