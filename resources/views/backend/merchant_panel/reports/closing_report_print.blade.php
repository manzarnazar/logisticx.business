<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Reports Print</title>
    <link rel="shortcut icon" href="{{ favicon(settings('favicon')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/')}}/css/reports_print.css">
    <link rel="stylesheet" href="{{asset('backend')}}/vendor/bootstrap/4.1.1/css/bootstrap.min.css">

    <style>
        @media print {
            .print-cancel {
                display: none;
            }
        }

        body {
            padding: 10px;
        }

        .logo {
            max-height: 70px;
        }

    </style>
</head>
<body>
    <div class="print-cancel text-right">
        <button class="btn btn-sm btn-danger" onclick="window.close()">{{ ___('menus.cancel') }}</button>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <img alt="Logo" src="{{ asset(logo(settings('light_logo')))}}" class="logo">
        </div>

        <div class="border-left border-3 pl-2">
            <span class="d-block mb-1"> <b>{{ settings('name') }}</b> </span>
            <span class="d-block mb-1">{{ settings('email') }}</span>
            <span class="d-block"> {{ settings('phone') }} </span>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div>
                <div>
                    <h3 class="text-center"> {{ ___('merchant.merchant') }} {{ ___('reports.title') }} </h3>
                </div>

                <div class="d-flex justify-content-between overflow-hidden mt-3">
                    <span> <b> {{ ___('merchant.merchant') }} </b> : {{ @$report->business_name }} </span>
                    <span> <b> {{ ___('label.date') }} </b> : {{ dateFormat(date('Y-m-d')) }} </span>
                </div>

                <hr>

                <div>
                    @if(@$report)
                    @include('backend.reports.panel.merchant')
                    @endif
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.print();

    </script>
</body>
</html>
