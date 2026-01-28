<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: aliceblue;
            color: #8094ae;
            margin: 10;
        }
        table{
            width:100%;
            height:50px;
            max-width:650px;
            margin: auto;
        }
        table .bg-color{
            width:100%;
            height:50px;
            max-width:650px;
            margin: auto;
        }

        td:first-child {
            text-align: center;
            padding: 30px 10px;
        }

        td:nth-child(2) {
            padding: 30px;
        }

        td:last-child {
            text-align: center;
            padding: 0px 30px;
        }

        a {
            color: #593BDB;
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

        .w-30{
            width: 30px;
        }
        .f-size-13{
            .font-size: 13px;
        }

    </style>
</head>
<body >
    <table>
        <tr>
            <td>
                <a href="{{ url('/') }}"><img src="{{ asset(@settings()->rxlogo->original) }}" class="h-15" /></a>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <tds colspan="2">
                <p>{{ ___('label.name')}} : <b class="italic-font">{{ @$data['name'] }}</b></p>
                <p>{{ ___('label.email ')}}: <b class="italic-font">{{ @$data['email'] }}</b></p>
                <p>{{ ___('label.subject')}} : <b class="italic-font">{{ @$data['subject'] }}</b></p>
                <span> <b>{{ ___('label.message')}}:</b></span>
                <p class="lh-1.5">{!! @$data['message'] !!}</p>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <ul>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-b.png" class="w-30" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-c.png" class="w-30" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-d.png" class="w-30" /> </a> </li>
                    <li> <a> <img src="{{ asset('backend/images/social-media') }}/brand-e.png" class="w-30" /> </a> </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <p class="f-size-13">
                    {{ @settings('copyright') }}
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
