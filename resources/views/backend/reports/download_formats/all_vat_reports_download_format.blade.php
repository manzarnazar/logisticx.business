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
            position: fixed;
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
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #000000;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
         <h1>{{___('reports.percelfly-Reports')}} </h1>
    </main>
    <section>
        <table class="table">
            @php $i=1; @endphp

            <thead class="bg">
                <tr>
                    <th>{{ ___('#') }}</th>
                    <th>{{ ___('parcel.date') }}</th>
                    <th>{{ ___('parcel.tracking_id') }}</th>
                    <th>{{ ___('parcel.merchant') }}</th>
                    <th>{{ ___('parcel.vat') }}</th>
            </thead>
            <tbody>
                @foreach ($vats as $vat)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td> {{ dateFormat($vat->created_at) }}</td>
                    <td><a href="{{ route('parcel.details', $vat->parcel->id) }}"> {{ $vat->parcel->tracking_id }}
                        </a></td>
                    <td>
                        <ul class="parcel-list">
                            <li>
                                <span>{{ $vat->parcel->merchant->business_name }}</span>
                            </li>
                            <li>
                                <span>{{ $vat->parcel->merchant->user->mobile }}</span>
                            </li>
                            <li>
                                <span>{{ $vat->parcel->merchant->address }}</span>
                            </li>
                        </ul>
                    </td>
                    <td> {{ settings('currency') }} {{ $vat->vat_amount }} </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </section>
    <footer>
        <p>{{ settings('copyright') }}</p>
    </footer>
</body>
</html>
