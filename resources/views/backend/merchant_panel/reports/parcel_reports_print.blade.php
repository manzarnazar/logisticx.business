<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ___('reports.parcel_reports') }}</title>
    <link rel="shortcut icon" href="{{ asset(settings()->favicon_image) }}" type="image/x-icon">
    <style>
        .text-right {
            text-align: right;
        }

        .btn-danger {
            /* Add your button styles here */
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

        .invoice-date {
            overflow: hidden;
        }

        .invoice-date span {
            float: right;
            font-weight: bold;
        }

        .table-container {
            margin-top: 20px;
        }

        .totalCalculationHead {
            background-color: #5969ff;
        }
        .ls-3{
            letter-spacing: 3px;
        }

        /* Add any additional styles as needed */
    </style>
</head>

<body>
    <div class="print text-right">
        <a href="#" class="btn-danger" id="close" onclick="window.close()">{{ ___('menus.cancel') }}</a>
    </div>
    <div>
        <table class="officehead">
            <tbody>
                <tr>
                    <td class="left-col">
                        <img alt="Logo" src="{{ asset(logo(settings('light_logo'))) }}" class="logo">
                    </td>
                    <td class="right-col">

                        <span><b class= "ls-3"></b>{{ settings('name') }}</span><br>
                        <span>{{ settings('email') }}</span><br>
                        <span>{{ settings('phone') }}</span><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="invoice" id="printablediv">
                <div class="row mt-3 invoice-header">
                    <div class="col-sm-12">
                        <h3>{{ ___('reports.parcel_reports') }}</h3>
                    </div>
                </div>
                <div class="row mt-3 invoice-date">
                    <div class="col-sm-12">
                        <span>{{ ___('menus.date') }}:</span>{{ dateFormat(date('Y-m-d')) }}
                    </div>
                </div>
                <hr>
                <div class="row table-container">
                    <div class="col-sm-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('reports.count') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($parcels as $key=>$parcel)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{!! StatusParcel($key) !!}</td>
                                    <td>{{ $parcel->count() }}</td>
                                </tr>
                                @endforeach
                                <tr class="totalCalculationHead bg-primary">
                                    <td></td>
                                    <td><span class="text-dark">{{ ___('reports.total_cash_collection') }}</span></td>
                                    <td>{{ settings('currency') }}{{ totalParcelsCashcollection($parcels) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
