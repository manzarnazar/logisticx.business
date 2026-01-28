<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ___('menus.closing_report') }}</title>
    <link rel="shortcut icon" href="{{ favicon(settings('favicon')) }}" type="image/x-icon">

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

        .print-cancel {
            text-align: right;
        }

        .logo {
            max-height: 70px;
        }

        .border-left {
            border-left: 3px solid;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .mb-1 {
            margin-bottom: 1rem;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        h3 {
            text-align: center;
        }
        .letter-spacing{
            letter-spacing: 3px;
        }

    </style>
</head>
<body>
    <div class="print-cancel">
        <button class="btn btn-sm btn-danger" onclick="window.close()">{{ ___('menus.cancel') }}</button>
    </div>

    <div class="d-flex justify-content-between mb-1">
        <div>
            <img alt="Logo" src="{{ asset(logo(settings('light_logo')))}}" class="logo">
        </div>

        <div class="border-left">
            <span><b class="letter-spacing"></b> {{ settings('name') }}</span><br>
            <span>{{ settings('email') }}</span><br>
            <span class="pt-2">{{ settings('phone') }}</span><br>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div>
                <div>
                    <h3>{{ ___('common.deliveryman') }} {{ ___('reports.title') }}</h3>
                </div>

                <div class="d-flex justify-content-between overflow-hidden">
                    <span>{{ ___('common.deliveryman') }}: {{ @$report->deliveryman->user->name }}</span>
                    <span><b>{{ ___('label.date') }}:</b> {{ dateFormat(date('Y-m-d')) }}</span>
                </div>

                <hr>

                <div>
                    @if(@$report)
                    @include('backend.reports.panel.deliveryman')
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
