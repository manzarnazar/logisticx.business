@extends('backend.partials.master')
@section('title')
{{ ___('reports.title') }} {{ ___('reports.parcel_reports') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('dashboard.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant-panel.parcel.reports') }}" class="breadcrumb-link active">{{ ___('reports.parcel_reports') }}</a></li>
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
                    <form action="{{route('merchant-panel.parcel.filter.reports')}}" method="GET">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12 col-md-4 col-sm-6">
                                <label class="label-style-1" for="parcel_date">{{ ___('parcel.date') }}</label>
                                <input type="date" id="date" name="parcel_date" class="form-control input-style-1 flatpickr-range" value="{{ old('parcel_date',$request->parcel_date) }}" placeholder="{{ ___('label.select_date_range') }}">
                                @error('parcel_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4  col-sm-6 ">
                                <label class="label-style-1" for="parcelStatus">{{ ___('parcel.status') }}</label>
                                <select id="parcelStatus" name="parcel_status[]" class="form-control" multiple>
                                    @foreach (config('site.status.parcel') as $key => $status)
                                    <option value="{{ $key}}" @if($request->parcel_status !== null && in_array($key,$request->parcel_status)) selected @endif>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('parcel_status')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12 col-xl-3 col-lg-4 col-md-6 ">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('merchant-panel.parcel.reports') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($parcels))
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('reports.parcel_reports') }}
                    </h4>

                    @isset($filteredIds)
                    @if($filteredIds != null)
                    <a href="{{ route('download.all.merchant.parcel_status.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn">
                        <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image">
                        <span>{{ ___('label.download_all') }}</span>
                    </a>
                    @endif
                    @endisset

                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('reports.count') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parcels as $key=>$parcel)
                                <tr>
                                    @php $i=1; @endphp
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
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()



<!-- js  -->
@push('scripts')

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
