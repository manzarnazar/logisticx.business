<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    {{-- <meta name="viewport" content="width=device-width, minimum-scale=0.8, maximum-scale = 0.8, user-scalable = no , shrink-to-fit=no"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ favicon(settings('favicon')) }}" sizes="16x16">
     

    <link rel="stylesheet" href="{{ asset('backend/vendor/summernote/summernote-lite.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/css/flag-icons/flag-icons.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/icons/simple-line-icons/css/simple-line-icons.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/icons/font-awesome-old/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/icons/themify-icons/css/themify-icons.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/jqvmap/css/jqvmap.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/css/sass/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css')}}" />



    @stack('styles')

</head>
