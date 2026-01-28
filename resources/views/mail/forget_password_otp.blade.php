<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ @settings()->title }}</title>
    <style>
        body { background-color: #f5f7fb; color: #555d70; font-family: 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 20px; }
        a { color: #7367f0; text-decoration: none; }
        .container { max-width: 650px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(115,103,240,0.1); }
        .header { background: #7367f0; text-align: center; padding: 25px 15px; }
        .header img { height: 45px; }
        .body { padding: 30px; line-height: 1.6; font-size: 15px; }
        .body h1 { color: #333; font-size: 22px; margin-top: 0; }
        .body h3 { color: #7367f0; font-size: 20px; margin: 15px 0; }
        .download { text-align: center; border-top: 1px solid #eee; padding: 15px 0; }
        .download img { width: 180px; margin: 5px; }
        .footer { text-align: center; font-size: 13px; color: #888; padding: 20px 10px; }
        .social img { width: 26px; margin: 0 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <a href="{{ url('/') }}"><img src="{{ logo(settings('light_logo')) }}" alt="Logo"></a>
    </div>

    <div class="body">
        <h1>{{ @settings('name') }} Verification Code</h1>
        <p>Dear {{ @settings('name') }} user,</p>
        <p>We received a request to reset your {{ @settings('name') }} account password.</p>
        <p>Your verification code is:</p>
        <h3>{{ @$otp }}</h3>
        <p>If you did not request this code, please ignore this email.</p>
        <p>We’re here if you have any questions — reach us at 
            <a href="mailto:{{ @settings('email') }}">{{ @settings('email') }}</a> or {{ @settings('phone') }} anytime.
        </p>
        <p>Sincerely,<br><b>The {{ @settings('name') }} Team</b></p>
    </div>


    <div class="footer">

        <p>{{ @settings('copyright') }}</p>
    </div>
</div>

</body>
</html>
