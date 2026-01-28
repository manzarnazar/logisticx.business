<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{___('reports.report')}}</title>
    <style>
        main {
            page-break-inside: avoid;
        }

        footer {
            position: sticky;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ecf9fa;
        }

        th {
            color: black;
            background-color: #f0f8fc;
            font-weight: bold;  
        }

        tr:nth-child(even) {
            background-color: #fcffff;
        }

        tr:hover {
            background-color: #ddd;
        }

        .bg {
            background-color: #4CAF50;
            color: white;
        }

        .bg th {
            font-weight: bold;
        }

        . {
            overflow-x: auto;
        }

    </style>
</head>
<body>
    <main>
        <h1>{{ ___('reports.parcel_wise_profit') }}</h1>
    </main>
    <section>
        <table class="table    ">
            @php $i=1; @endphp

            <thead class="bg">
                <tr>
                    <th>{{ ___('label.id') }}</th>
                    <th>{{ ___('reports.details') }}</th>
                    <th>{{ ___('reports.income') }}</th>
                    <th>{{ ___('reports.expense') }}</th>
                    <th>{{ ___('reports.profit') }}</th>
            </thead>
            <tbody>
                @foreach($parcels as $key=>$parcel)
                <tr>
                    <td>
                        {{ $i++ }}
                    </td>
                    <td>
                        <div class="width300px">
                            <b>Tracking Id :</b> <a class="active" href="{{ route('parcel.details',$parcel->id) }}" target="_blank">{{ $parcel->tracking_id }}</a><br />
                            <span><b>Merchant :</b> {{$parcel->merchant->business_name}}</span><br>
                            <span><b>Customer :</b> {{$parcel->customer_name}}</span><br>
                        </div>
                    </td>
                    <td> {{ $parcel->parcelTransaction->total_charge }}</td>
                    @if ($parcel->deliveryHeroCommission->sum('amount'))
                    <td> {{ $parcel->deliveryHeroCommission->sum('amount') }}</td>
                    @else
                    <td> not paid yet </td>
                    @endif
                    <td>{{ ($parcel->parcelTransaction->total_charge - $parcel->deliveryHeroCommission->sum('amount'))}} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="totalCalculationHead bg text-dark">
                    <td></td>
                    <td>{{ ___('reports.total') }} : </td>
                    <td>{{ $parcels->load('parcelTransaction')->sum(function ($parcel) {
                        return optional($parcel->parcelTransaction)->total_charge ?? 0;
                    }) }}</td>
                    <td>{{ $parcels->load('deliveryHeroCommission')->sum(function ($parcel) {
                        return optional($parcel->deliveryHeroCommission)->sum('amount') ?? 0;
                    }) }}</td>

                    <td>
                        @php
                        $total = $parcels->load('parcelTransaction')->sum(function ($parcel) {
                        return optional($parcel->parcelTransaction)->total_charge ?? 0;
                        });
                        $total -= $parcels->load('deliveryHeroCommission')->sum(function ($parcel) {
                        return optional($parcel->deliveryHeroCommission)->sum('amount') ?? 0;
                        });
                        echo $total;
                        @endphp
                    </td>
                </tr>
            </tfoot>
        </table>
    </section>
    <footer>
        <p>{{ settings('copyright') }}</p>
    </footer>
</body>
</html>
