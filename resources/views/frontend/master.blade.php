<!doctype html>
<html class="no-js" lang="{{ defaultLanguage()->code }}">

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

    @if (strtoupper(defaultLanguage()->text_direction) == "LTR")
    <link id="bootstrap-ltr" href="{{ asset('frontend/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    @else
    <link id="bootstrap-rtl" rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap-rtl/bootstrap.rtl.min.css')}}">
    @endif

    <!-- Bootstrap RTL version -->
    
    <link href="{{ asset('frontend/assets/css/all.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/themify-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/icofont.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/flaticon.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/bootstrap-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/bsnav.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/preloader.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/magnific-popup.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/swiper-bundle.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('frontend/assets/css/jquery-ui.css')}}" rel="stylesheet" />

    <link href="{{ asset('frontend/assets/sass/style.css')}}" rel="stylesheet">

    <link href="{{ asset('frontend/assets/css/custom.css')}}" rel="stylesheet">
    
    {{-- <!-- <link href="{{ asset('frontend/assets/style.css')}}" rel="stylesheet"> --> --}}
    {{-- <!-- <link href="{{ asset('frontend/assets/css/responsive.css')}}" rel="stylesheet" /> --> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


    {{-- <script src="{{ asset('frontend/js/recaptcha-api.js')}}"></script> --}}
    @if(settings('recaptcha_status'))
    <script src="{{ asset('backend/js/api.js') }}" async defer></script>
    @endif


    @stack('styles')

    <!-- ========== End Stylesheet ========== -->

    <style type="text/css">
        :root {
            --font-1: {!!  themeAppearance('font_family_body') !!}; /* use body font */
	        --font-2: {!!  themeAppearance('font_family_heading') !!}; /* use heading font */
	        --primary-text-color: {!!  themeAppearance('primary_text_color') !!}; /* use heading font */
	        --secondary-text-color: {!!  themeAppearance('secondary_text_color') !!}; /* use heading font */
            --primary-color: {!! primaryColorRgb() !!};   /* primary color (RGB for rgba()) */
            --clr-def-2: {!!  themeAppearance('primary_color') ?: '#FFA500' !!};   /* primary color (hex) */
            /* --rounded-square: 0.375rem;     ===== square =  0.375rem default, rounded = 50rem  ====== */
        }

        @if(themeAppearance('button_input_style') == 'square')
            :root {
                --rounded-square: 0.375rem; /* square */
            }
        @else
            :root {
                --rounded-square: 50rem; /* rounded */
            }
        @endif
    </style>

</head>

<body id="bdy" class="body-2 {{ session('theme') == 'dark'? 'dark-mode':'' }}" dir="{{defaultLanguage()->text_direction == "LTR"? 'ltr':'rtl'}}">

    <!-- Start PreLoader    ============================================= -->
    <div class="preloader">
        <div class="preloader-container">
            <span class="preloader-text"> {{ settings('name') }}</span>
            <div class="preloader-animation"> </div>
        </div>
    </div>
    <!-- Start PreLoader-->

    <!-- Header goes here -->
    <x-frontend.header />
    
    
    <main class="main">

    <!-- theme typography mode-->
        

        @yield('main')
        

    </main>

    <!-- Footer goes here -->
    <x-frontend.footer/>


    {{-- Image Modal --}}
<div id="imgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">
    <span id="closeModal" style="position:absolute; top:20px; right:30px; font-size:35px; color:white; cursor:pointer;">&times;</span>
    <img id="modalImg" src="" style="max-width:90%; max-height:90%; border-radius:10px;">
</div>
    
    <!-- popups -->
    <x-frontend.popups.cookie-consent />

    <!-- Start Scroll top        ============================================= -->
    <a href="#bdy" id="scrtop" class="smooth-menu"><i class="fa-solid fa-arrow-up"></i></a>
    <!-- End Scroll top-->

    <!-- jQuery Frameworks        ============================================= -->
    <script src="{{ asset('frontend/assets/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/bsnav.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/count-to.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/progress-bar.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.easypiechart.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/typed.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/YTPlayer.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.appear.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/active-class.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/dark-mode.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    {{-- sweetalert2 --}}
    <script src="{{ asset('backend/vendor/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('backend/css/flag-icons/flag-icons.min.css')}}" />


    <script src="{{ asset('frontend/js/custom/_developer.js')}}"></script>

    {{-- JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const images = document.querySelectorAll('.gallery-img');
        const modal = document.getElementById('imgModal');
        const modalImg = document.getElementById('modalImg');
        const closeModal = document.getElementById('closeModal');

        images.forEach(img => {
            img.addEventListener('click', function () {
                modal.style.display = 'flex';
                modalImg.src = this.src;
            });
        });

        closeModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Optional: close modal on background click
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

    <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });
            });

            function alertMessage(message, icon = 'error') {

                const Toast = Swal.mixin({
                    toast: true
                    , position: 'bottom-end'
                    , showConfirmButton: false
                    , timer: 3000
                    , timerProgressBar: true
                    , didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: icon
                    , title: message
                })
            }
        


        @if(session('success'))
        alertMessage("{{ session('success') }}", "success");
        @endif

        @if(session('danger'))
        alertMessage("{{ session('danger') }}", "error");
        @endif

    </script>


    @stack('scripts')


</body>

</html>
