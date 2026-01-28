<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }

        table{
            width: 100%;
        }

        * {
            font-size: 12px;
        }

        table th {
            padding: 10px;
            text-align: left;
        }

        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid rgba(73, 73, 73, 0.226);
        }
        body table tr td table {
            border: 0;
            text-align: center;
            padding: 0;
            margin: 0;
            border-collapse: collapse;
        }
        .border-bottom-0{
            border-bottom: none!important;
        }
        .f-size-15{
            font-size: 15px;
        }
        body table tr td{
            text-align: center;
            border-bottom:none!important;
            padding:0px;
            padding-bottom:5px
        }
        .custom-style {
            padding: 0px;
            border-bottom: none !important;
        }
        .td-3 {
            border: 1px solid rgba(73, 73, 73, 0.226) !important;
            padding: 0px;
        }
        .td-4 {
            border-right: 1px solid rgba(73, 73, 73, 0.226);
            padding: 5px!important;
        }
        .td-5 {
            border-bottom: none!important;
            border-right: 1px solid rgba(73, 73, 73, 0.226);
            padding: 5px!important;
        }
        .td-6 {
            border-bottom: none!important;
            padding: 5px!important;
        }
        .tr-custom {
            background-color: #593BDB;
            color: white;
        }
        .p-3-10{
            padding: 3px 10px;
        }
        .p-2-10{
            padding: 2px 10px;
        }
        .td-custom{
            background-color: rgb(73 73 73 / 7%); 
            padding: 2px 10px;
        }
        .th-custom{
                text-transform: uppercase; padding: 2px 10px;
            }

    </style>
</head>

<body>
    <table>
        <tr>
            <td >
                <table>
                    <tbody>
                        <tr>
                            <td class="border-bottom-0"> 
                                <div class="text-align-center mb-0">
                                    <h4>{{ settings('name') }}</h4>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <td class="border-bottom-0 p-0">
                                <table>
                                    <tr>
                                        <td class= "custom-style p-0">
                                            <div class= "p-8 lh-1.5">
                                                <span><i class="fa-sharp fa-solid fa-file-invoice f-size-15"></i>{{ ___('merchant.merchant')}} : <br />
                                                    <b>{{ $user->merchant->business_name }}</b> </span><br>
                                                <span> {{$user->mobile}} </span><br>
                                                <span> {{$user->merchant->address}}</span><br>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="custom-style">
                                <table>
                                    <tr>
                                      
                                        <td class = "td-3" >
                                            <table>
                                                <tr>
                                                    <td class="td-4" ><b>{{___('merchant.export_date')}} </b></td>
                                                    <td clas="p-5">{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td-5" ><b>{{___('merchant.total_payable')}}</b></td>
                                                    <td class="td-6">{{ $parcels->sum('current_payable') }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <table cellspacing="0">
     
        <tr class = "tr-custom" >
            <th class = "p-3-10 ">#</th>
            <th class = "p-3-10 ">{{___('invoice_iD')}}</th>
            <th class = "p-3-10 ">{{___('tracking_iD')}}</th>
            <th class = "p-3-10 ">{{___('customer_info')}}</th>
            <th class = "p-3-10 ">{{___('merchant.status')}}</th>
            <th class = "p-3-10 ">{{___('parcel.cash_collection')}} <br />(TK)</th>
            <th class = "p-3-10 ">{{___('parcel.delivery')}}<br />{{___('parcel.charge')}}</th>
            <th class = "p-3-10 ">{{___('parcel.vat')}}</th>
            <th class = "p-3-10 ">{{___('parcel.cod')}}</th>
            <th class = "p-3-10 ">{{___('parcel.total_charge')}}</th>
            <th class = "p-3-10 ">{{___('parcel.Payable')}}</th>
        </tr>
        @foreach ($parcels as $key=>$parcel)
        <tr>
            <td class = "p-2-10 ">{{ ++$key }}</td>
            <td class = "p-2-10 ">{{ @$parcel->invoice_no }}</td>
            <td class = "p-2-10 ">{{ @$parcel->tracking_id }}</td>
            <td class = "p-2-10 ">{{ @$parcel->customer_name }}<br />{{ @$parcel->customer_phone }}<br />{{ @$parcel->customer_address }}</td>
            <td class = "p-2-10 ">{{ @$parcel->status_name }}</td>

            <td>{{ number_format(@$parcel->cash_collection,2) }}</td>
            <td class= "td-custom">{{$parcel->delivery_charge }}</td>
            <td class= "td-custom">{{@$parcel->vat_amount}}</td>
            <td class= "td-custom">{{@$parcel->cod_amount}}</td>
            <td class = "p-2-10 ">({{@$parcel->total_delivery_amount + @$parcel->vat_amount}})</td>
            <td class = "p-2-10 ">{{@$parcel->current_payable}}</td>
        </tr>
        @endforeach
     
        <tr class = "tr-custom">
           
            <th class = "th-custom" colspan="5">{{___('parcel.total')}}</th>
            <th class = "p-2-10 "> {{ number_format($parcels->sum('cash_collection'),2) }} </th>
            <th class = "p-2-10 "> {{ number_format($parcels->sum('delivery_charge'),2) }} </th>
            <th class = "p-2-10 "> {{ number_format($parcels->sum('vat_amount'),2) }} </th>
            <th class = "p-2-10 "> {{ number_format($parcels->sum('cod_amount'),2) }} </th>
            <th class = "p-2-10 "> {{ number_format($parcels->sum('total_delivery_amount') + $parcels->sum('vat_amount'),2) }} </th>
            <th class = "p-2-10 "> {{ number_format($parcels->sum('current_payable'),2) }} </th>
        </tr>
    </table>
</body>
</html>
