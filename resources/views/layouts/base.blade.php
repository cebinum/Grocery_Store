<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Grocery Store | @yield('title')</title>
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
    <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-gradient-white border-bottom">
            <div class="container">
                <a class="navbar-b" href="{{ url('/') }}">
                    <img src="{{ asset('argon/img/logo.png') }}" class="navbar-brand-img" height="40" alt="logo">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav align-items-center ml-md-auto">
                        <li class="nav-item d-xl-none">
                        </li>

                        <li class="nav-item d-sm-none">
                            <a class="nav-link text-dark" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav align-items-center ml-auto ml-md-0 text-dark">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item text-dark">
                                    <a class="nav-link text-dark" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item text-dark">
                                    <a class="nav-link text-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endguest
                            <li class="nav-item dropdown mr-2">
                                <a class="btn btn-secondary btn-sm position-relative" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                        {{ count(\Cart::getContent()) }}
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                                    <!-- Dropdown header -->
                                    <div class="px-3 py-3">
                                        <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">{{ count(\Cart::getContent()) }}</strong> items in your cart.</h6>
                                    </div>
                                    <!-- List group -->
                                    @if(count(\Cart::getContent()) > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach(\Cart::getContent() as $product)
                                        @php
                                        $item = App\Models\Product::where('id', $product->id)->first();
                                        @endphp
                                        <a href="#!" class="list-group-item list-group-item-action">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <!-- Avatar -->
                                                    <img alt="{{ $product->name }}" src="{{ asset('product/'. $item->photo) }}" class="avatar rounded-circle">
                                                </div>
                                                <div class="col ml--2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="mb-0 text-sm">{{ $product->name }}</h4>
                                                        </div>
                                                        <div class="text-right text-muted">
                                                            {{-- <small>{{ $product->p }}</small> --}}
                                                        </div>
                                                    </div>
                                                    <p class="text-sm mb-0">
                                                        <strong>{{ $product->quantity }}</strong> x <span class="text-danger">${{ number_format(\Cart::get($product->id)->getPriceSum(),2) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                        <a href="{{ route('checkout') }}" class="dropdown-item text-center text-primary font-weight-bold py-3">Checkout</a>
                                    @endif
                                </div>
                            </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link text-dark pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media align-items-center">
                                        <span class="avatar avatar-sm rounded-circle">
                                            <img alt="Image placeholder" src="{{ asset('argon/img/user-male-icon.png')}}">
                                        </span>
                                        <div class="media-body ml-2 d-none d-lg-block">
                                            <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                                        </div>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome!</h6>
                                    </div>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ni ni-single-02"></i>
                                        <span>My profile</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ni ni-user-run"></i>
                                        <span>Logout</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container-fluid mt-6">
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
