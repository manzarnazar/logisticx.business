<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ @settings()->title }}</title>
    <style>
        body {
            background-color: #f5f7fb;
            color: #555d70;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        a { color: #7367f0; text-decoration: none; }
        .container { max-width: 650px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(115,103,240,0.1); }
        .header { background: #7367f0; text-align: center; padding: 25px 15px; }
        .header img { height: 45px; }
        .body { padding: 30px; line-height: 1.6; font-size: 15px; }
        .body h3 { color: #7367f0; font-size: 20px; margin: 15px 0; }
        .footer { text-align: center; font-size: 13px; color: #888; padding: 20px 10px; }
        .download { text-align: center; border-top: 1px solid #eee; padding: 15px 0; }
        .download img { width: 180px; margin: 5px; }
        .social img { width: 26px; margin: 0 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <a href="{{ url('/') }}"><img src="{{ logo(settings('light_logo')) }}" alt="Logo"></a>
    </div>

    <div class="body">
        <p>{{ ___('merchant.hi') }} <b>{{ @$data['merchant_user']->name }}</b>,</p>
        <p>{{ ___('merchant.thank_you_for_your_interest_in_becoming_a_merchant_with') }} {{ @settings('name') }}.</p>
        <p>Your verification code is:</p>
        <h3>{{ @$data->otp }}</h3>
        <p>{{ ___('merchant.hope_youll_enjoy_the_experience,_we_are_here_if_you_have_any_questions,_drop_us_a_line_at') }}
            <a href="mailto:{{ @settings('email') }}">{{ @settings('email') }}</a> or {{ @settings('phone') }} {{ ___('merchant.anytime') }}.
        </p>
    </div>

    <div class="footer">
        
        <p>{{ @settings('copyright') }}</p>
    </div>
</div>

</body>
</html>
