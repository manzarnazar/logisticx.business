<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ settings('name') }}</title>
    <style>
        body {
            background-color: aliceblue;
            color: #8094ae;
        }

        a {
            color: #593BDB;
            text-decoration: none;
        }

        ul {
            display: inline-block;
            text-align: center;
            overflow: hidden;
            padding-left: 0px;
            margin-bottom: 0px !important;
        }

        ul li {
            float: left;
            list-style: none;
            padding: 5px;
        }

        ul li a {
            cursor: pointer;
            display: block;
        }

        .table-wrapper {
            width: 100%;
            height: 50px;
            max-width: 650px;
            margin: auto;
        }
        .table-wrapper .bgColor {
            width: 100%;
            height: 50px;
            max-width: 650px;
            margin: auto;
            background-color: white;
        }

        .content-cell {
            padding: 30px;
            line-height: 1.5;
        }

        .business-info {
            display: flex;
        }

        .business-info div:first-child {
            width: 20%;
            display: inline-block;
        }

        .login-button {
            background-color: #593BDB;
            color: white;
            margin-left: 10px;
            padding: 7px 15px;
            border: none;
            text-decoration: none;
            border-radius: 3px;
        }

        .get-apps {
            text-align: center;
            text-transform: uppercase;
        }

        .download-buttons {
            width: 50%;
            text-align: center;
            padding: 10px;
        }

        .footer-social {
            text-align: center;
        }

        .footer-social ul {
            display: inline-block;
        }

        .footer-social ul li {
            display: inline;
            padding: 0 5px;
        }

        .footer-social ul li a {
            display: inline-block;
        }
        .align_td {
            text-align: center;
            padding:30px 10px;
        }
        .h15{
            height: 50px;
        }
        .font-italic{
            font-style: italic;
        }
        .business-info-text{
            color: #593BDB;
            font-weight: bold;
        }
        .w200{
            width: 200px;
        }
        .w300{
            width: 300px;
        }
            
    </style>
</head>
<body class="m-8">
    <table class="table-wrapper">
        <tr>
            <td class = "align_td">
                <a href="{{ url('/') }}"><img class="h15" src="{{ logo(@settings('logo')) }}" /></a>
            </td>
        </tr>
    </table>
    <table class="table-wrapper .bgColor">
        <tr>
            <td class="content-cell" colspan="2">
                <p>{{___('merchant.Hi')}} <b class="font-italic" >{{ @$data['merchant_user']->name }}</b>,</p>
                <p>{{ ___('merchant.thank_you_for_your_interest_in_becoming_an_merchant_with')}} {{ @settings('name') }}.</p>
                <p>{{___('merchant.your_login_is')}} <b class="font-italic">{{ @$data['merchant_user']->email }}</b></p>
                <p class = "business-info-text" >{{ ___('merchant.your_business_info') }}</p>
                <div class="business-info">
                    <div><b>{{ ___('merchant.business_name')}}</b></div>
                    <div>: {{ @$data['merchant']->business_name }}</div>
                </div>
                <div class="business-info">
                    <div><b>{{___('label.Email')}}</b></div>
                    <div>: {{ @$data['merchant_user']->email }}</div>
                </div>
                <div class="business-info">
                    <div><b>{{___('label.Phone')}}</b></div>
                    <div>: {{ @$data['merchant_user']->mobile }}</div>
                </div>
                <div class="business-info">
                    <div><b>{{___('label.Address')}}</b></div>
                    <div>: {{ @$data['merchant']->address }}</div>
                </div>
                <p>{{ ___('merchant.please_login_your_panel') }}
                    <a class="login-button" target="_blank" href="{{ url('login') }}">Login</a>
                </p>
                <p>{{___('merchant.hope_youll_enjoy_the_experience_were_here_if_you_have_any_questions_drop_us_a_line_at')}} <a href="mailto:{{ @settings('email') }}">{{ @settings('email') }}</a> or {{ @settings('phone') }} anytime.</p>
            </td>
        </tr>
        <tr>
            <td class="content-cell" colspan="2">
                <p class="get-apps">
                    {{___('merchant.get_download_our_android_or_i_application')}}
                </p>
            </td>
        </tr>
        <tr>
            <td class="download-buttons">
                <a href="#"> <img src="{{ asset('backend/images/social-media') }}/play butttom.png" class= "w200" /></a>
            </td>
            <td class="download-buttons">
                <a href="#"><img src="{{ asset('backend/images/social-media') }}/istore.png" class= "w200" /></a>
            </td>
        </tr>
    </table>
    <table class="table-wrapper">
        <tr>
            <td class="footer-social">
                <ul>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-b.png" clas="w300" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-c.png" clas="w300" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-d.png" clas="w300" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-e.png" clas="w300" /> </a> </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="content-cell">
                <p>
                    {{ @settings('copyright') }}
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
