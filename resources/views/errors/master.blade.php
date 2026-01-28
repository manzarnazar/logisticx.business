<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', settings('name'))</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{favicon(settings('favicon'))}}">

    <!-- ========== Start Stylesheet ========== -->
    <link href="{{asset('frontend')}}/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('frontend')}}/assets/style.css" rel="stylesheet">

    @stack('styles')
    <!-- ========== End Stylesheet ========== -->

</head>

<body id="bdy" class="body-2">

    <main class="main">
        @yield('main')
    </main>

    <script>
        const language = "{{ app()->getLocale() }}";

        document.documentElement.setAttribute('lang', language);

        var body = document.body;

        // Toggle the dir attribute between "ltr" and "rtl"
        if (language === "ar") {
            body.setAttribute("dir", "rtl");
        } else {
            body.setAttribute("dir", "ltr");
        }

    </script>

    @stack('scripts')

</body>

</html>
