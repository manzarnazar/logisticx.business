<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ___('parcelStatus.'.$bulk_type) }} | print</title>
    <link rel="shortcut icon" href="{{ favicon(settings('favicon')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/')}}/css/bulk_print.css">
    <style>
        .print {
            text-align: right;
        }

        .officehead {
            width: 100%;
            border-collapse: collapse;
        }

        .left-col {
            height: 70px;
            border-right: 3px solid;
        }

        .right-col {
            padding-left: 10px;
            line-height: 1.2;
        }

        .logo {
            max-height: 70px;
        }

        .invoice-header {
            text-align: center;
        }

        .date-container {
            overflow: hidden;
        }

        .date-container span {
            float: right;
            font-weight: bold;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .ls-3 {
            letter-spacing: 3px;
        }

        .w-100p {
            width: 100%;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .bold-font {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="print">
        @if(isset($reprint))
        <a href="#" onclick="window.close();" class="btn-danger"><i class="fa-solid fa-floppy-disk"></i>{{ ___('label.save') }}<i class="fa-solid fa-rectangle-xmark"></i>{{ ___('label.cancel') }}</a>
        @else
        <a href="{{ route('parcel.index') }}" class="btn-danger"><i class="fa-solid fa-rectangle-xmark"></i>{{ ___('label.cancel') }}</a>
        @endif
    </div>
    <div>
        <table class="officehead" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td class="left-col">
                        <img alt="Logo" src="{{ logo(settings('light_logo')) }}" class="logo">
                    </td>
                    <td class="right-col">

                        <span><b class="ls-3"></b> {{ settings('name') }}</span><br>
                        <span>{{ settings('email') }}</span><br>
                        <span class="pt-3">{{ settings('phone') }}</span><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="invoice" id="printablediv">
                <div class="row mt-3 invoice-header w-100p">
                    <div class="col-sm-12">
                        <h3 class="text-align-center">{{ ___('parcelStatus.'.$bulk_type) }}</h3>
                    </div>
                </div>
                <div class="row mt-3 date-container w-100p">
                    <div class="col-sm-12 w-100p overflow-hidden">
                        <span class="bold-font">
                            {{ ___('parcel.delivery_man') }} : <small>{{ @$deliveryman->user->name }}</small>
                        </span>
                        <span>
                            <font class="bold-font">{{ ___('label.date') }} :</font> {{ dateFormat(date('Y-m-d')) }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row mt-20">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-striped w-100p">
                            <thead class="tablehead">
                                <tr class="text-align-left">
                                    <th>#</th>
                                    <th>{{ ___('merchant.track_id') }}</th>
                                    <th>{{ ___('parcel.merchant_details') }}</th>
                                    <th>{{ ___('parcel.customer_details') }}</th>
                                    @if(@$transferred_hub)
                                    <th>{{ ___('parcel.hub') }}</th>
                                    @endif
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('parcel.cash_collection') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @foreach($parcels as $key => $parcel)
                                <tr @if($i%2==0) class="odd" @endif>
                                    <td data-label="#">{{ ++$i }}</td>
                                    <td data-label="tracking_id">#{{ $parcel->tracking_id }}</td>
                                    <td data-label="merchant_details">
                                        {{ @$parcel->merchant->business_name }}<br />
                                        {{ @$parcel->shop->contact_no }}
                                    </td>
                                    <td data-label="customer_details">
                                        {{ $parcel->customer_name }}<br />
                                        {{ $parcel->customer_phone }}<br />
                                        {{ $parcel->customer_address }}
                                    </td>
                                    @if(@$transferred_hub)
                                    <td data-label="hub">{{ $parcel->hub->name }} To {{ $parcel->transferhub->name }}</td>
                                    @endif
                                    <td data-label="status">{!! StatusParcel($parcel->status) !!}</td>
                                    <td data-label="cash_collection">{{ settings('currency') }}{{ $parcel->cash_collection }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="@if(@$transferred_hub) 6 @else 5 @endif">
                                        <span class="pull-right"><b>{{ ___('parcel.total_cash_collection') }}</b></span>
                                    </td>
                                    <td><b>{{ settings('currency') }}{{ $parcels->sum('cash_collection')}}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();

    </script>
</body>
</html>
