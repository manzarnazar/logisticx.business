@extends('errors.master')

@section('title',___('alert.authentication_timeout'))

@section('main')

<main class="main d-flex align-items-center justify-content-center h-100vh">
    <!-- Start Faq  ============================================= -->
    <div class="page-not-found de-padding">
        <div class="container">
            <div class="d-flex">
                <!--  
                <div>
                    <img src="{{asset('frontend')}}/assets/img/vector/404.webp" class="d-block text-center" alt="thumb">
                </div>
                -->
                <div class="d-flex align-items-center">
                    <div class="page-not-righ-ele">
                        <h2 class="headin-1">419</h2>
                        <h4 class="heading-4">{{___('alert.authentication_timeout')}}</h4>
                        <p class="mb-40">{{___('alert.message_419')}}</p>

                        @if ( url()->current() != url()->previous() )
                        <a href="{{ url()->previous() }}" class="btn-3">{{___('alert.go_back')}}</a>
                        @else
                        <a href="/" class="btn-3">{{___('alert.go_home')}}</a>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Faq -->
</main>

@endsection
