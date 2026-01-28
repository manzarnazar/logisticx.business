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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('parcel.label') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('common.print') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">


                    <div id="printablediv" class="d-flex flex-column">

                        <div class="mb-3"> <img src="{{ logo(settings('dark_logo')) }}" alt="Logo" /> </div>

                        <div class="mb-2"><span class="font-weight-bold ">{{ $parcel->tracking_id }}</span></div>

                        <div class="mb-3 qrcode" data-height="200" data-width="200" data-text="{{ route('parcel.track').'?tracking_id='. $parcel->tracking_id }}"></div>


                        <div class="small">
                            <p class="m-0"> {{ ___('label.merchant') . ' : ' .  @$parcel->merchant->business_name }} </p>
                            <p class="m-0"> {{ @$parcel->pickup_phone }} </p>
                            <address> {{ @$parcel->merchant->address }} </span> </address>
                        </div>

                        <div class="small">
                            <p class="m-0"> {{ ___('label.customer') . ' : ' .$parcel->customer_name }} </p>
                            <p class="m-0"> {{ @$parcel->customer_phone }} </p>
                            <address> {{ @$parcel->customer_address }} </address>
                        </div>

                        <div>
                            <p class="m-0 font-weight-bold">{{ ___('label.cod') . ' | ' . $parcel->parcelTransaction->cash_collection }}</p>
                        </div>

                        <div>
                            <p class="m-0"> {{ @$parcel->productCategory->name  . " | " . @$parcel->serviceType->name }} </p>
                        </div>

                        <div>
                            <p class="font-weight-bold m-0"> {{ @$parcel->pickupArea->name  . " | " . @$parcel->destinationArea->name }} </p>
                        </div>

                    </div>

                    <div class="row no-print mt-4">
                        <div class="col-sm-12">
                            <div class="float-sm-right">
                                <button class="j-td-btn" onclick="printDiv('printablediv')"><i class="fa fa-print"></i> {{ ___('common.print') }}</button>
                            </div>
                        </div>
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

<script type="text/javascript">
    // for qr code 
    const containers = document.querySelectorAll(".qrcode");
    containers.forEach(container => {
        new QRCode(container, {
            text: container.getAttribute('data-text')
            , width: container.getAttribute('data-width')
            , height: container.getAttribute('data-height')
        });
    });

</script>

@endpush
