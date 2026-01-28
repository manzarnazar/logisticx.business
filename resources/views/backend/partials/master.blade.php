<!DOCTYPE html>
<html lang="{{ defaultLanguage()->code }}">

@include('backend.partials.header')

<body class="with-sidebar {{ session('theme') == 'dark'? "dark-mode":"" }}" dir="{{ strtolower(defaultLanguage()->text_direction) }}"  id="body">


    @if (Auth::user()->user_type == \App\Enums\UserType::MERCHANT)
    @include('backend.merchant_panel.partials.navbar')

    @elseif (Auth::user()->user_type == \App\Enums\UserType::DELIVERYMAN)
    @include('backend.deliveryman_panel.partials.navbar')

    @else
    @include('backend.partials.navbar')
    @endif

    <!-- Overlay for Mobile -->
    <div id="overlay"></div>

    <!-- Layout Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        <div id="sidebar">
            @if (Auth::user()->user_type == \App\Enums\UserType::MERCHANT)
            @include('backend.merchant_panel.partials.sidebar')

            @elseif (Auth::user()->user_type == \App\Enums\UserType::DELIVERYMAN)
            @include('backend.deliveryman_panel.partials.sidebar')

            @else
            @include('backend.partials.sidebar')
            @endif
        </div>

        <!-- Main Content -->
        <div id="main-content" class="with-sidebar">
            @yield('maincontent')

            <div class="footer txt-body-p">
                <div class="copyright">
                    <p>{{settings('copyright')}}</p>
                </div>
            </div>

        </div>
    </div>



    {{-- <div id="main-wrapper">

        @if (Auth::user()->user_type == \App\Enums\UserType::MERCHANT)
        @include('backend.merchant_panel.partials.navbar')
        @include('backend.merchant_panel.partials.sidebar')

        @elseif (Auth::user()->user_type == \App\Enums\UserType::DELIVERYMAN)
        @include('backend.deliveryman_panel.partials.navbar')
        @include('backend.deliveryman_panel.partials.sidebar')

        @else
        @include('backend.partials.navbar')
        @include('backend.partials.sidebar')
        @endif

        <div class="content-body">
            @yield('maincontent')
        </div>

        <div class="footer txt-body-p">
            <div class="copyright">
                <p>{{settings('copyright')}}</p>
            </div>
        </div>
    </div> --}}

    @include('backend.partials.dynamic-modal')

    {{-- Scripts ========================================================================================================================= --}}

    <script src="{{ asset('backend/vendor/global/global.min.js')}}"></script>
    <script src="{{ asset('backend/js/custom.min.js')}}"></script>
    <script src="{{ asset('backend/js/sidebar.js')}}"></script>

    <script src="{{ asset('backend/vendor/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('backend/vendor/summernote/summernote-lite.min.js')}}"></script>
    <script src="{{ asset('backend/vendor/fontawesome/fontawesome.min.js')}}"></script>
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('backend/vendor/flatpickr/flatpickr.min.js')}}"></script>
    {{-- <script src="{{ asset('frontend/assets/js/theme_mode_change.js') }}"></script> --}}

    <script src="{{ asset('backend/js/_developer.js')}}"></script>
     <script defer src="{{ asset('backend/js/dark-light.js')}}"> </script>


    @include('backend.partials.alert-message')

    @stack('scripts')

</body>
</html>
