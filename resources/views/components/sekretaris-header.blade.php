<div class="navbar-bg"></div>
<form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
    @csrf
</form>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                <a href="#" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="/pegawai/dashboard" class="dropdown-item has-icon">
                    <i class="fas fa-user-shield"></i> Login sebagai Pegawai
                </a>
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin-dashboard') }}" class="dropdown-item has-icon">
                        <i class="fas fa-user-shield"></i> Login sebagai Admin
                    </a>
                @endif
                @if (auth()->user()->is_aktif)
                    <a href="{{ route('inspektur-dashboard') }}" class="dropdown-item has-icon">
                        <i class="fas fa-user-shield"></i> Login sebagai Inspektur
                    </a>
                @endif
                @if (auth()->user()->is_analissdm)
                <a href="{{ route('analis-sdm-dashboard') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-shield"></i> Login sebagai Analis SDM
                </a>
                @endif
            </div>
        </li>
        <li class="dropdown mr-4 ml-2 d-flex justify-content-center align-items-center">
            <a class="has-icon text-white" href="#"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
    <ul class="navbar-nav navbar-right">

    </ul>
</nav>
