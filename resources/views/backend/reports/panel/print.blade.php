<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Reports Print</title>
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
                <h3 class="text-center">

                    @if( request()->input('user_type') == \App\Enums\UserType::MERCHANT && @$report)
                    {{ ___('merchant.merchant') }} {{ ___('reports.title') }}
                    @endif

                    @if( request()->input('user_type') == \App\Enums\UserType::HUB && @$report)
                    {{ ___('hub.title') }} {{ ___('reports.title') }}
                    @endif

                    @if( request()->input('user_type') == \App\Enums\UserType::DELIVERYMAN && @$report)
                    {{ ___('parcel.deliveryman') }} {{ ___('reports.title') }}
                    @endif

                </h3>
            </div>

            <div class="d-flex justify-content-between overflow-hidden mt-3">
                <span>
                    @if( request()->input('user_type') == \App\Enums\UserType::MERCHANT && @$report)
                    <b> {{ ___('merchant.merchant') }} </b> : {{ @$report->business_name }}
                    @endif

                    @if( request()->input('user_type') == \App\Enums\UserType::HUB && @$report)
                    <b>{{ ___('hub.title') }}</b> : {{ @$report->name }}
                    @endif

                    @if( request()->input('user_type') == \App\Enums\UserType::DELIVERYMAN && @$report)
                    <b>{{ ___('parcel.deliveryman') }}</b> : {{ @$report->user->name }}
                    @endif
                </span>

                <span> <b> {{ ___('label.date') }} </b> : {{ dateFormat(date('Y-m-d')) }} </span>
            </div>

            <hr>

            <div class="mt-3">

                @if( request()->input('user_type') == \App\Enums\UserType::MERCHANT && @$report)
                @include('backend.reports.panel.merchant')
                @endif

                @if( request()->input('user_type') == \App\Enums\UserType::HUB && @$report)
                @include('backend.reports.panel.hub')
                @endif

                @if( request()->input('user_type') == \App\Enums\UserType::DELIVERYMAN && @$report)
                @include('backend.reports.panel.deliveryman')
                @endif

            </div>
        </div>
    </div>


    <script type="text/javascript">
        window.print();

    </script>
</body>
</html>
