<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary pay slip | print</title>
    <link rel="shortcut icon" href="{{ favicon(settings('favicon')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/') }}/css/payslip.css">
    <style>
        .officehead {
            width: 100%;
            border-collapse: collapse;
        }

        .officehead td {
            padding: 10px;
            border-right: 3px solid;
            vertical-align: top;
        }

        .officehead .left-col {
            height: 70px;
        }

        .officehead .logo {
            max-height: 70px;
        }

        .userInfo {
            width: 100%;
            border-collapse: collapse;
        }

        .userInfo td {
            padding: 10px;
            vertical-align: top;
        }

        .userInfo .row {
            margin-bottom: 10px;
            display: flex !important;
        }

        .userInfo .row .col-4 {
            width: 30%;
            font-weight: bold;
        }

        .userInfo .row .col-8 {
            width: 70%;
        }


        .font-bold {
            font-weight: bold;
        }

        .ls-3 {
            letter-spacing: 3px;
        }

        .custom-div {
            overflow: hidden;
            padding: 0px 20px;
        }

        .custom-span {
            float: right;
            font-size: 12px;
        }
        .float-center{
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="print text-align-right">
        <button type="button" class="btn-danger" onclick="window.close()">{{ ___('menus.cancel') }}</button>
    </div>
    <div>
        <table class="officehead">
            <tbody>
                <tr>
                    <td class="left-col">
                        <img alt="Logo" src="{{ logo(settings('light_logo')) }}" class="logo">
                    </td>
                    <td class="float-center">
                        <span><b class="ls-3"></b> {{ settings('name') }}</span><br>
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
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <h3 class="text-align-center">{{ ___('common.pay_slip') }}</h3>
                    </div>
                </div>

                <div class="custom-div">
                    <span class="custom-span">
                        <font class="bold-font">{{ ___('label.date') }} :</font>
                        {{ dateFormat($salary->date) }}
                    </span>
                </div>
                <hr>


                {{-- old format --}}
                <div class="row mt-20">
                    <div class="col-12 table-responsive">
                        <table class="userInfo">
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-4">{{ ___('common.employee_name') }}</div>
                                        <div class="col-6">: {{ $salary->user->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">{{ ___('common.joining_date') }}</div>
                                        <div class="col-8">: {{ dateFormat($salary->user->joining_date) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.email') }}</div>
                                            <div class="col-8">: {{ $salary->user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.hub') }}</div>
                                            <div class="col-8">: {{ @$salary->user->hub->name }}</div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.designation') }}</div>
                                            <div class="col-8">: {{ @$salary->user->designation->title }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.pay_period') }}</div>

                                            <div class="col-8">:
                                                {{ \Carbon\Carbon::parse($salary->month)->format('F Y') }}</div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.department') }}</div>
                                            <div class="col-8">: {{ @$salary->user->department->title }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.salary') }}</div>
                                            <div class="col-8">:
                                                {{ @settings('currency') }}{{ @$salary->net_salary }}</div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">{{ ___('common.salary_paid') }}</div>
                                            <div class="col-8">: {{ @settings('currency') }}{{ @$salary->net_salary }}</div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
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
