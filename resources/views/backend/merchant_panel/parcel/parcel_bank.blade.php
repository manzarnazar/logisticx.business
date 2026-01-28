@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel_bank') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant-panel.parcel-bank.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel_bank') }}</a></li>
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
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('parcel.parcel_bank') }} {{ ___('label.list') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table   parcelTable">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.customer') }}</th>
                                    <th>{{ ___('label.shop') }}</th>
                                    <th>{{ ___('label.delivery_info') }}</th>
                                    <th>{{ ___('label.amount') }}</th>
                                    <th>{{ ___('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parcels as $key => $parcel)
                                <tr id="row_{{ $parcel->id }}">

                                    <td> {{ ++$key }}</td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-user.png" alt="no image">
                                                <span>{{ $parcel->customer_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-location.png" alt="no image">
                                                <span> {{ $parcel->destinationArea->name }}</span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-user.png" alt="no image">
                                                <span>{{ $parcel->shop->name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-location.png" alt="no image">
                                                <span> {{ $parcel->pickupArea->name }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td>
                                        <ul class="parcel-total">
                                            <li class="d-flex justify-content-between gap-2">
                                                <span> {{ ___('label.product') }}: </span>
                                                <span> {{ $parcel->productCategory->name }} </span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span>{{ ___('label.service') }}:</span>
                                                <span> {{ $parcel->serviceType->name }} </span>
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
                                        </ul>
                                    </td>

                                    <td>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend be-addon">
                                                <div class="d-flex" data-toggle="dropdown">
                                                    <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                                </div>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('parcel.clone', $parcel->id) }}" class="dropdown-item"><i class="fa fa-clone"></i> {{ ___('label.clone') }}</a>
                                                    <a href="{{ route('parcelBankToggle', $parcel->id ) }}" class="dropdown-item" onclick="pleaseConfirm(event)" data-question="{{ ___('alert.no_reverse_message') }}"> <i class="fa fa-trash"></i> {{ ___('label.delete') }} </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="6" />
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
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

<!-- js  -->
@push('scripts')

<script src="{{ asset('backend/js/custom/merchant/parcel_bank.js') }}"></script>

@endpush
