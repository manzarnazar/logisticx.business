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


            <div class="table-responsive" id="printablediv">
                <table class="table table-bordered">

                    <tbody>

                        <tr>
                            <td colspan="2" class="text-center font-weight-bold">{{ ___('label.invoice') }} : <small>{{ $parcel->invoice_no }}</small></td>
                        </tr>

                        <tr>
                            <td>
                                <span>{{ ___('label.sent_by') }}</span>
                                <address class="font-weight-light">
                                    {{ @$parcel->merchant->business_name }} <br>
                                    {{ @$parcel->merchant->user->mobile }} <br>
                                    {{ @$parcel->merchant->address }}
                                </address>
                            </td>
                            <td>
                                <span>{{ ___('label.sent_to') }}</span>
                                <address class="font-weight-light">
                                    {{ $parcel->customer_name}} <br>
                                    {{ $parcel->customer_phone }}<br>
                                    {{ $parcel->customer_address }}
                                </address>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center w-50">
                                <svg id="barcode" jsbarcode-value="{{ $parcel->tracking_id }}" jsbarcode-height="20" jsbarcode-width="2" jsbarcode-margin="5" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold"> </svg>
                            </td>
                            <td class="d-flex justify-content-center">
                                <div id="qrcode" data-height="60" data-width="60" data-text="{{ route('parcel.track').'?tracking_id='. $parcel->tracking_id }}"></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center font-weight-bold">{{ @$parcel->productCategory->name   . " | " . @$parcel->serviceType->name }} </td>
                            <td class="text-center font-weight-bold">{{ ___('label.cod') . ' | ' . $parcel->parcelTransaction->cash_collection }} </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="d-flex justify-content-between font-weight-light">
                                    <span> {{ ___('label.date')." : ". dateFormat($parcel->created_at)}}</span>
                                    <span> {{ ___('label.powered_by') .' : '. settings('name') }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-right mt-4">
                        <button class="j-td-btn" onclick="printDiv('printablediv')"><i class="fa fa-print"></i> {{ ___('common.print') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/parcel/print.js') }}"></script>
<script src="{{ asset('backend/vendor/qrcodejs/qrcode.min.js') }}"></script>
<script src="{{ asset('backend/vendor/jsbarcode/jsbarcode.all.min.js') }}"></script>

<script type="text/javascript">
    // for qr code 
    const container = document.getElementById("qrcode");
    new QRCode(container, {
        text: container.getAttribute('data-text')
        , width: container.getAttribute('data-width')
        , height: container.getAttribute('data-height')
    });

    // for barcode 
    JsBarcode("#barcode").init();

</script>
@endpush
