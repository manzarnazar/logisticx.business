<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ @settings()->title }}</title>
    <style>
        body {
            background-color: aliceblue;
            color: #8094ae;
            margin: 10px;
        }

        a {
            color: #593BDB;
        }

        .table-container {
            width: 100%;
            height: 50px;
            max-width: 650px;
            margin: auto;
        }

        .table-padding {
            padding: 30px;
            line-height: 1.5;
        }

        .uppercase-text {
            text-align: center;
            text-transform: uppercase;
            font-size: 13px;
        }

        .img-container {
            text-align: center;
        }

        .img-container img {
            height: 50px;
        }

        .right-align {
            text-align: right;
        }

        .left-align {
            text-align: left;
        }

        .download-img {
            width: 200px;
        }

        .social-img {
            width: 30px;
        }

        .social-container {
            text-align: center;
        }

        .social-container ul {
            display: inline-block;
            text-align: center;
            overflow: hidden;
            padding-left: 0;
            margin-bottom: 0 !important;
        }

        .social-container ul li {
            float: left;
            list-style: none;
            padding: 5px;
        }

        .social-container ul li a {
            cursor: pointer;
            display: block;
        }

        .white-background {
            background-color: white;
        }

        .italic-text {
            font-style: italic;
        }
    </style>
</head>
<body>

    <table class="table-container">
        <tr>
            <td class="img-container">
                <a href="{{ url('/') }}"><img src="{{ logo(settings('light_logo')) }}" /></a>
            </td>
        </tr>
    </table>
    <table class="table-container white-background">
        <tr>
            <td class="table-padding" colspan="2">
                <p>Hi <b class="italic-text">{{ @$data['merchant_user']->name }}</b>,</p>
                <p>Thank you for your interest in becoming an merchant with {{ @settings('name') }}.</p>
                <p>Your otp is <b class="italic-text">{{ @$data->otp }}</b></p>
                <p>Hope you'll enjoy the experience, we're here if you have any questions, drop us a line at <a href="mailto:{{ @settings('email') }}">{{ @settings('email') }}</a> or {{ @settings('phone') }} anytime.</p>
            </td>
        </tr>
        <tr>
            <td class="uppercase-text" colspan="2">
                Get download our android or i application
            </td>
        </tr>
        <tr>
            <td class="right-align table-padding">
                <a href="#"><img src="{{ asset('backend/images/social-media') }}/play butttom.png" class="download-img" /></a>
            </td>
            <td class="left-align table-padding">
                <a href="#"><img src="{{ asset('backend/images/social-media') }}/istore.png" class="download-img" /></a>
            </td>
        </tr>
    </table>
    <table class="table-container">
        <tr>
            <td class="social-container">
                <ul>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-b.png" class="social-img" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-c.png" class="social-img" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-d.png" class="social-img" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-e.png" class="social-img" /> </a> </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="table-padding">
                <p> {{ @settings('copyright') }} </p>
            </td>
        </tr>
    </table>
</body>
</html>
