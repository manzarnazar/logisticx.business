<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Test Notification</title>
    <style>
        body { background-color: #f5f7fb; color: #555d70; font-family: 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 20px; }
        a { color: #7367f0; text-decoration: none; }
        .container { max-width: 650px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(115,103,240,0.1); }
        .header { background: #7367f0; text-align: center; padding: 25px 15px; }
        .header img { height: 45px; }
        .body { padding: 40px 30px; text-align: center; }
        .body h1 { margin: 0 0 10px; font-size: 22px; color: #333; }
        .footer { text-align: center; font-size: 13px; color: #888; padding: 20px 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <a href="{{ url('/') }}"><img src="{{ $logo }}" alt="Logo"></a>
    </div>

    <div class="body">
        <h1>Mail Test Notification</h1>
        <p>This is a test email sent from your system to verify that email configuration works correctly.</p>
    </div>

    <div class="footer">
        <p>{!! $copyright !!}</p>
    </div>
</div>

</body>
</html>
