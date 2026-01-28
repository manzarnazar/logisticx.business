@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('parcel.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('common.print') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">


            <div id="printablediv">
                <table class="table table-sm table-bordered">

                    <tbody>

                        <tr>
                            <td colspan="2" class="text-center font-weight-bold">{{ ___('invoice.invoice') }} : <small>{{ $parcel->invoice_no }}</small></td>
                        </tr>

                        <tr>
                            <td>
                                Sent By
                                <address class="font-weight-light">
                                    {{ @$parcel->merchant->business_name }} <br>
                                    {{ @$parcel->merchant->user->mobile }} <br>
                                    {{ @$parcel->merchant->address }}
                                </address>
                            </td>
                            <td>
                                Sent To
                                <address class="font-weight-light">
                                    {{ $parcel->customer_name}} <br>
                                    {{ $parcel->customer_phone }}<br>
                                    {{ $parcel->customer_address }}
                                </address>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center">
                                <img src="{{ $parcel->barcodeprint }}" alt="BarCode" width="200"><br>
                                <span class="font-weight-bold ">{{ $parcel->tracking_id }}</span>
                            </td>
                            <td class="text-center">
                                <img src="{{ $parcel->QrcodePrint }}" alt="QR" height="50">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center font-weight-bold">{{ @$parcel->productCategory->name }} | {{ @$parcel->serviceType->name }} </td>
                            <td class="text-center font-weight-bold"> COD | {{ $parcel->cash_collection }} </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-weight-light">
                                <span class="float-sm-left">Date: {{ dateFormat($parcel->created_at)}}</span>
                                <span class="float-sm-right"> Powered by: {{ settings('application_name') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-right">
                        <button class="j-td-btn" onclick="printDiv('printablediv')"><i class="fa fa-print"></i> {{ ___('common.print') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/parcel/print.js') }}"></script>
@endpush
