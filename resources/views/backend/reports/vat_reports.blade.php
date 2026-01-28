@extends('backend.partials.master')
@section('title')
{{ ___('reports.vat_reports') }}
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
                            <li class="breadcrumb-item"><a href="{{route('leave.reports') }}" class="breadcrumb-link active">{{ ___('reports.vat_reports') }}</a></li>
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
                    <form action="{{route('reports.vat.reports')}}" method="GET">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="date" autocomplete="off" placeholder="{{___('placeholder.enter_date_range')}}" id="date" name="date" class="form-control  input-style-1  flatpickr-range" value="{{ old('date',$request->date) }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="tracking_id">{{ ___('parcel.tracking_id') }}</label>
                                <input id="tracking_id" type="text" name="tracking_id" placeholder="{{ ___('parcel.tracking_id') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('tracking_id', $request->tracking_id) }}">

                                @error('tracking_id') <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class=" label-style-1" for="merchant">{{ ___('label.merchant') }}</label>
                                <select class="form-control input-style-1 select2" id="merchant" name="merchant">
                                    <option></option>
                                    @foreach($merchants as $merchant)
                                    <option {{$request->merchant == $merchant->id ? 'selected':''}} value="{{$merchant->id}}">{{$merchant->business_name}}</option>
                                    @endforeach
                                </select>
                                @error('merchant') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                        <div class="form-row mt-2">
                            <div class="col-md-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('vat.reports') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(isset($vats))
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('reports.vat_reports') }} </h4>
                    <a href="{{ route('download.all.vat.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn">
                        <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image">
                        <span>{{ ___('label.download_all') }}</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table    ">
                            @php $i=1; @endphp

                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('#') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                    <th>{{ ___('parcel.tracking_id') }}</th>
                                    <th>{{ ___('parcel.merchant') }}</th>
                                    <th>{{ ___('parcel.vat') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vats as $vat )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td> {{ dateFormat($vat->created_at) }}</td>
                                    <td><a href="{{ route('parcel.details', $vat->parcel->id) }}"> {{ $vat->parcel->tracking_id }}
                                        </a></td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-user.png" alt="no image">
                                                <span>{{ $vat->parcel->merchant->business_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-phone.png" alt="no image">
                                                <span>{{ $vat->parcel->merchant->user->mobile }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-location.png" alt="no image">
                                                <span>{{ $vat->parcel->merchant->address }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td> {{ settings('currency') }} {{ $vat->vat_amount }} </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
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

<script src="{{ asset('backend/js/custom/reports/print.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/jquery.table2excel.min.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/reports.js') }}"></script>

@endpush
