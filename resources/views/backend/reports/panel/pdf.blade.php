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
        th,
        td {
            padding: 10px;
        }

        .officehead td.left-col {
            height: 70px;
            border-right: 3px solid;
            text-align: right;
            width: 50%;
        }

        .officehead td.right-col {
            padding-left: 10px;
            line-height: 1.2;
        }

        .officehead .logo {
            max-height: 70px;
        }

        .merchant-details th,
        .merchant-details td {
            text-align: left;
        }

        .statistics th,
        .statistics td {
            width: 50%;
            text-align: left;
        }

        .statistics th:first-child,
        .statistics td:first-child {
            text-align: left;
        }

        .statistics th:last-child,
        .statistics td:last-child {
            text-align: right;
        }

        .statistics tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .statistics tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .custom-tr{
            background-color: #5969ff;
            color:"white";
        }
        .ls-3{
            letter-spacing: 3px;
        }
    </style>
</head>
<body>
    <div>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="officehead">
            <tbody>
                <tr>
                    <td class="left-col">
                    </td>
                    <td class="right-col">
                        <span><b class="ls-3" ></b> {{ settings('name') }}</span><br>
                        <span>{{ settings('email') }}</span><br>
                        <span>{{ settings('phone') }}</span><br>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="w-100p">
            <thead>
                <tr>
                    <th  colspan="5" class="text-align-center">
                        <h3>{{___('merchant.merchant_details')}}</h3>
                    </th>
                </tr>
                <tr class="custom-tr" class="merchant-details">
                    <th>{{___('label.name')}}</th>
                    <th>{{___('label.mobile')}}</th>
                    <th>{{___('label.address')}}</th>
                    <th>{{___('label.total_Shops')}}</th>
                    <th>{{___('parcel.total_Parcel')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['merchant']->business_name }}</td>
                    <td>{{ $data['merchant']->user->mobile }}</td>
                    <td>{{ $data['merchant']->address }}</td>
                    <td> {{ $data['merchant']->activeShops->count() }}</td>
                    <td> {{ $data['total_parcel'] }}</td>
                </tr>
            </tbody>
        </table>
        <table class="test statistics w-100p">
            <thead>
                <tr>
                    <th colspan="5" class="text-align-center">
                        <h3>{{___('label.total_statistics')}}</h3>
                    </th>
                </tr>
                <tr class="custom-tr">
                    <th class= "text-align-left"> {{___('label.title')}}</th>
                    <th class= "text-align-left"> {{___('label.count')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::PENDING) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::PENDING)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::PICKUP_ASSIGN) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::PICKUP_ASSIGN)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::PICKUP_RE_SCHEDULE) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::PICKUP_RE_SCHEDULE)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::RECEIVED_WAREHOUSE) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::RECEIVED_WAREHOUSE)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::TRANSFER_TO_HUB) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::TRANSFER_TO_HUB)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::DELIVERY_RE_SCHEDULE) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::DELIVERY_RE_SCHEDULE)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::RETURN_TO_COURIER) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::RETURN_TO_COURIER)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::RETURN_ASSIGN_TO_MERCHANT) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::RETURN_ASSIGN_TO_MERCHANT)->count() }}</td>
                </tr>
                <tr>
                    <td>{{ ___('parcelStatus.'.\App\Enums\ParcelStatus::DELIVERED) }}</td>
                    <td>{{ $data['parcels']->where('status',\App\Enums\ParcelStatus::DELIVERED)->count() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
