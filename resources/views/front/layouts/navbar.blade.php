<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('front/images/logo.png') }}" alt="logo" height="34px" width="38px">
            CV. SUPRI GROUP
        </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample07">
        <ul class="navbar-nav mr-auto">
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

        </ul>
        <ul class="navbar-nav my-2 my-md-0">

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
                        // $route = route('warranty.index');
                        $route = route('dashboard.index');
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
                    @if (Auth::user()->role == "2")
                        <a class="dropdown-item" href="{{ route('auth.profile.index') }}">Profile</a>
                    @endif
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
