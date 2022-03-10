<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{url('dashboard')}}">
                <img src="{{ asset('argon/img/logo.png') }}" class="navbar-brand-img" alt="...">
                {{-- Administrator --}}
            </a>

        </div>

        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index')}}">
                            <i class="ni ni-building text-orange"></i>
                            <span class="nav-link-text">Products</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index')}}">
                            <i class="ni ni-atom text-green"></i>
                            <span class="nav-link-text">Categories</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index')}}">
                            <i class="ni ni-archive-2 text-info"></i>
                            <span class="nav-link-text">Orders</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="ni ni-badge text-primary"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
