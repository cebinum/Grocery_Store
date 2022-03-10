<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>dministrator | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ asset('argon/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('argon/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('argon/css/argon.css')}}?v=1.1.0" type="text/css">
    <link rel="stylesheet" href="{{ asset('argon/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('argon/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('argon/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    @yield('styles')
</head>
<body>
    <!--===========================-->
    <!--====     SIDEBAR      =====-->
    <!--===========================-->
    @include('layouts.admin.partials._sidebar')

    <div class="main-content" id="panel">
        <!--===========================-->
        <!--=====     NAVBAR      =====-->
        <!--===========================-->
        @include('layouts.admin.partials._navbar')

        <div class="header bg-gradient-pink pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <!--====================================-->
                    <!--=====     HEADER   BREADCRUM   =====-->
                    <!--====================================-->
                    @yield('headerbreadcrum')
                </div>
            </div>
        </div>

        <div class="container-fluid mt--6">
            <!--===========================-->
            <!--=====  PAGE CONTENT   =====-->
            <!--===========================-->
            @yield('content')
        </div>
    </div>

    <!--===========================-->
    <!--=====    FOOTER       =====-->
    <!--===========================-->
    @include('layouts.admin.partials._footer')

    <script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/js-cookie/js.cookie.js')}}"></script>
    <script src="{{ asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/chart.js/dist/Chart.extension.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('argon/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{ asset('argon/js/argon.js?v=1.1.0')}}"></script>
    @yield('scripts')
</body>
</html>
