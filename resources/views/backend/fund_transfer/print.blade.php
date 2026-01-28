<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset(settings()->favicon_image)}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/')}}/css/bulk_print.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

    <style>
        .print {
            text-align: right;
        }

        .left-col {
            height: 70px;
            border-right: 3px solid;
        }

        .logo {
            max-height: 70px;
        }

        .right-col {
            padding-left: 10px;
            line-height: 1.2;
        }

        .table th, .table td {
            color: black !important;
        }

        .row-margin-top {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="print">
        <a href="#" onclick="window.close();" class="btn-danger">Close</a>
    </div>
    <div>
        <table cellpadding="0" cellspacing="0" class="officehead">
            <tbody>
                <tr>
                    <td class="left-col">
                        <img alt="Logo" src="{{ asset(logo(settings('light_logo')))}}" class="logo">
                    </td>
                    <td class="right-col">
                        <span> <b></b> {{ settings('name') }}</span><br>
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
                <div class="row row-margin-top">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.from_account') }}</th>
                                    <th>{{ ___('label.to_account') }}</th>
                                    <th>{{ ___('label.date') }}</th>
                                    <th>{{ ___('label.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($fund_transfers as $fund_transfer)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <!-- Remaining HTML content -->
                                </tr>
                                @endforeach
                            </tbody>
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
