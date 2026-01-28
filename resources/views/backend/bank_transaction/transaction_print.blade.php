<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Bank transaction | print</title>
    <link rel="shortcut icon" href="{{ asset(settings()->favicon_image) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/') }}/css/bulk_print.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

    <style>
        .print {
            text-align: right;
        }

        .officehead .left-col {
            height: 70px;
            border-right: 3px solid;
        }

        .officehead .right-col {
            padding-left: 10px;
            line-height: 1.2;
        }

        .logo {
            max-height: 70px;
        }

        .card {
            border-top: none!important;
        }

        .invoice .row {
            margin-top: 20px;
        }

        .invoice .table th {
            color: black!important;
        }

        .invoice .table td {
            color: black!important;
        }

        .invoice .table thead {
            background: none!important;
        }
    </style>
</head>

<body>
    <div class="print">
        <a href="#" onclick="window.close();" class="btn-danger">Close</a>
    </div>

    <div>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="officehead">
            <tbody>
                <tr>
                    <td class="left-col">
                        <img alt="Logo" src="{{ logo(settings('light_logo'))}}" class="logo">
                    </td>
                    <td class="right-col">
                        <span><b></b> {{ @settings('name') }}</span><br>
                        <span>{{ @settings('email') }}</span><br>
                        <span>{{ @settings('phone') }}</span><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="invoice" id="printablediv">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('label.account_no') }} | {{ ___('label.name')}}</th>
                                <th>{{ ___('label.type') }}</th>
                                <th>{{ ___('label.amount') }}</th>
                                <th>{{ ___('label.date') }}</th>
                                <th>{{ ___('label.note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $n = 0;

                            @endphp

                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{++$n}}</td>
                                <td>
                                    @if ($transaction->fund_transfer_id !== null)
                                        <span>From :</span>
                                        @if ($transaction->fundTransfer->fromAccount->gateway == 1)
                                            {{ @$transaction->fromAccount->user->name }} (Cash)
                                        @else
                                            @if ($transaction->fundTransfer->fromAccount->gateway == 3)
                                                bKash ,
                                            @elseif ($transaction->fundTransfer->fromAccount->gateway == 4)
                                                Rocket ,
                                            @elseif ($transaction->fundTransfer->fromAccount->gateway == 5)
                                                Nagad ,
                                            @endif
                                            {{ $transaction->fundTransfer->fromAccount->account_holder_name }}
                                            ({{ $transaction->fundTransfer->fromAccount->account_no }}
                                            {{ $transaction->fundTransfer->fromAccount->branch_name }}
                                            {{ $transaction->fundTransfer->fromAccount->mobile }})
                                        @endif
                                        <br>
                                        <span>To :</span>
                                        @if ($transaction->fundTransfer->toAccount->gateway == 1)
                                            {{ @$transaction->toAccount->user->name }} (Cash)
                                        @else
                                            @if ($transaction->fundTransfer->toAccount->gateway == 3)
                                                bKash ,
                                            @elseif ($transaction->fundTransfer->toAccount->gateway == 4)
                                                Rocket ,
                                            @elseif ($transaction->fundTransfer->toAccount->gateway == 5)
                                                Nagad ,
                                            @endif
                                            {{ $transaction->fundTransfer->toAccount->account_holder_name }}
                                            ({{ $transaction->fundTransfer->toAccount->account_no }}
                                            {{ $transaction->fundTransfer->toAccount->branch_name }}
                                            {{ $transaction->fundTransfer->toAccount->mobile }})
                                        @endif
                                    @else
                                        @if ($transaction->account->gateway == 1)
                                            {{ @$transaction->account->user->name }} (Cash)
                                        @else
                                            @if ($transaction->account->gateway == 3)
                                                bKash ,
                                            @elseif ($transaction->account->gateway == 4)
                                                Rocket ,
                                            @elseif ($transaction->account->gateway == 5)
                                                Nagad ,
                                            @endif
                                            {{ $transaction->account->account_holder_name }}
                                            ({{ $transaction->account->account_no }}
                                            {{ $transaction->account->branch_name }}
                                            {{ $transaction->account->mobile }})
                                        @endif
                                    @endif
                                </td>
                                <td>{!! $transaction->account_type !!}</td>
                                <td>{{settings('currency')}}{{$transaction->amount}}</td>
                                <td>{{dateFormat($transaction->date)}}</td>
                                <td>{{$transaction->note}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>

</body>

</html>
