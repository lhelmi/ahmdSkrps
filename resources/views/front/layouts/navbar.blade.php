<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('front/images/logo.png') }}" alt="logo" height="34px" width="38px">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.index') }}">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.blog.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.product.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.service.index') }}">Jasa</a>
                </li>
                @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.warranty.index') }}">Garansi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.complaint.index') }}">Keluhan</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.order.index') }}">Pemesanan</a>
                </li>
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a href="{{ route('login') }}" type="button" class="btn btn-primary">Login</a>
                        </li>
                    @endif
                @else
                <li class="nav-item dropdown">
                    @php
                        $route = "#";
                        if(Auth::user()->role == 0){
                            $route = route('dashboard.index');
                        }if (Auth::user()->role == 1) {
                            $route = route('warranty.index');
                        }
                    @endphp

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if (Auth::user()->role !== "2")
                            <a class="dropdown-item" href="{{ $route }}">Halaman Admin</a>
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-fw fa-power-off text-red"></i>
                            {{ __('adminlte::adminlte.log_out') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @if(config('adminlte.logout_method'))
                                {{ method_field(config('adminlte.logout_method')) }}
                            @endif
                            {{ csrf_field() }}
                        </form>
                    </div>
                  </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
