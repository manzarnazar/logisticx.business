<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports Print</title>
    <link rel="shortcut icon" href="{{ favicon(settings('favicon')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/')}}/css/reports_print.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <style>
        @media print {
            .print-btn {
                display: none;
            }
        }

        body {
            padding: 10px;
        }

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
            width: 100%;
            text-align: center;
        }

        .date-container {
            width: 100%;
            overflow: hidden;
            margin-top: 20px;
        }

        .date-container span {
            float: right;
            font-weight: bold;
        }

        .table-responsive {
            margin-top: 20px;
        }
        .bold-font {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div>
        <table class="officehead">
            <tbody>
                <tr>
                    <td class="left-col">
                        <img alt="Logo" src="{{ asset(logo(settings('light_logo'))) }}" class="logo">
                    </td>
                    <td class="right-col">
                        <span><b></b>{{ settings('name') }}</span><br>
                        <span>{{ settings('email') }}</span><br>
                        <span>{{ settings('phone') }}</span><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="invoice-header">
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <h3>{{ ___('reports.closig_report') }}</h3>
                    </div>
                </div>
                <div class="row mt-3 date-container">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <span>{{ settings('name') }}</span>
                        <span class="bold-font">{{ ___('label.date') }} :</span> {{ dateFormat(date('Y-m-d')) }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        @if(@$report)
                        @include('backend.reports.closing.report')
                        @endif
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
