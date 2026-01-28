@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('parcel.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            @if(@$slugText != null)
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ $slugText }}</a></li>
                            @endif
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
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
                    <form action="{{route('merchant-panel.parcel.filter')}}" method="GET">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcel_date">{{ ___('parcel.date') }}</label>
                                <input type="date" id="date" name="parcel_date" class="form-control input-style-1 flatpickr-range" value="{{ old('parcel_date', request()->parcel_date) }}" placeholder="{{ ___('merchant.date') }}">
                                @error('parcel_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcelStatus">{{ ___('parcel.status') }}</label>
                                <select id="parcelStatus" name="parcel_status" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach ( config('site.status.parcel') as $key => $status)
                                    <option value="{{ $key}}" @selected(old('parcel_status', request()->parcel_status) == $key) >{{ ___('parcel.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('parcel_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcel_customer">{{ ___('parcel.customer_name') }}</label>
                                <input id="parcel_customer" type="text" name="parcel_customer" placeholder="{{ ___('parcel.customer_name') }}" class="form-control input-style-1" value="{{old('parcel_customer', request()->parcel_customer)}}">
                                @error('parcel_customer') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcel_customer_phone">{{ ___('parcel.customer_phone') }}</label>
                                <input id="parcel_customer_phone" type="text" name="parcel_customer_phone" placeholder="{{ ___('parcel.customer_phone') }}" class="form-control input-style-1" value="{{old('parcel_customer_phone', request()->parcel_customer_phone)}}">
                                @error('parcel_customer_phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="invoice_id">{{ ___('parcel.invoice_id') }}</label>
                                <input id="invoice_id" type="text" name="invoice_id" placeholder="{{ ___('parcel.invoice_id') }}" class="form-control input-style-1" value="{{old('invoice_id', request()->invoice_id)}}">
                                @error('parcel_customer_phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4 j-create-btns">
                                <div class="drp-btns ">
                                    <button type="submit" class="j-td-btn"><i class="fa fa-filter"></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('parcel.index') }}" class="j-td-btn btn-red"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">

                <div class="card-header">
                    <h4 class="title-site">{{ ___('parcel.parcel') }}</h4>
                    <div class="card-table d-flex align-items-center">
                        <form class="j-search-form mr-10" action="{{ route('parcel.specific.search') }}" method="get">
                            @csrf
                            <input type="text" onkeyup="searchOnTable(this.value)" name="search" id="Psearch" class="j-form-control" placeholder="{{ ___('label.search') }}..." value="{{ request()->search }}">
                            <button type="submit" class="j-form-btn"> <i class="icon-magnifier"> </i> </button>
                        </form>

                        <a href="{{ route('parcel.importView') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('parcel.import_parcel') }} </span> </a>

                        <a href="{{ route('parcel.create') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('parcel.add_parcel') }} </span> </a>

                    </div>
                </div>

                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table id="table" class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                    <th>{{ ___('parcel.tracking_id') }}</th>
                                    <th>{{ ___('parcel.recipient_info') }}</th>
                                    <th>{{ ___('parcel.amount')}}</th>
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('label.action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($parcels as $key => $parcel)
                                <tr id="row_{{ $parcel->id }}">

                                    <td> {{ ++$key }}</td>
                                    <td> {{ dateTimeFormat( $parcel->created_at) }} </td>
                                    <td><a href="{{ route('parcel.details', $parcel->id) }}"> {{ $parcel->tracking_id }} </a></td>

                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-user.png" alt="no image">
                                                <span>{{ $parcel->customer_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-phone.png" alt="no image">
                                                <span>{{ $parcel->customer_phone }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-location.png" alt="no image">
                                                <span> {{ $parcel->customer_address }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td>
                                        <ul class="parcel-total">
                                            <li class="d-flex justify-content-between gap-2">
                                                <span> {{ ___('label.cod') }}: </span>
                                                <span class="whitespace-nowrap">{{ settings('currency') . " " . $parcel->parcelTransaction->cash_collection }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span>{{ ___('label.charge') }}:</span>
                                                <span class="whitespace-nowrap">{{ settings('currency') . " " . $parcel->parcelTransaction->total_charge }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span>{{ ___('label.payable') }}:</span>
                                                <span class="whitespace-nowrap">{{ settings('currency') . " " . $parcel->parcelTransaction->current_payable }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td title="{{ ___('parcel.updated_on') }}: {{ dateTimeFormat($parcel->updated_at) }}"> {!! $parcel->parcel_status !!} </td>

                                    <td>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend be-addon">
                                                <div class="d-flex" data-toggle="dropdown">
                                                    <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                                </div>
                                                <div class="dropdown-menu">

                                                    <a href="{{ route('parcel.details', $parcel->id) }}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view')}}</a>
                                                    <a href="{{ route('parcel.clone',$parcel->id) }}" class="dropdown-item"><i class="fa fa-clone" aria-hidden="true"></i> {{ ___('label.clone')}}</a>

                                                    @if ($parcel->status == App\Enums\ParcelStatus::PENDING)
                                                    <a href="{{route('parcel.edit',$parcel->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit')}}</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('parcel/delete', {{$parcel->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- pagination --}}
                    @if(count($parcels))
                    <x-paginate-show :items="$parcels" />
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
<!-- end wrapper  -->


<!-- js  -->
@push('scripts')

@include('backend.partials.delete-ajax')

@endpush
