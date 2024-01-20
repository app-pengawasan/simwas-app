<!DOCTYPE html>
<html lang="en" class="m-0">

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title') &mdash; SIMWAS</title>

        <link rel="shortcut icon" href="{{ asset('img/simwas.png') }}" type="image/x-icon">
        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        @stack('style')

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    </head>

    <body>
        <div id="app" class="vh-100 d-flex flex-column">

            <div class="hero-wrapper">
                <div class="auth-hero d-flex flex-column">
                    <header class="header-auth">
                        <nav class="my-3">
                            <div class="container container-header-hero">
                                <!-- Navbar Brand -->
                                <a href="#" class="navbar-brand">
                                    <img src="{{ asset('img/simwas-text-nobg.svg') }}" alt="logo" width="150">
                                </a>
                            </div>
                        </nav>
                    </header>
                    <section
                        class="section section-hero d-flex flex-column justify-content-center align-items-center flex-grow-1">
                        <div class="container mt-5">
                            <div class="column">
                                <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                                    @csrf
                                </form>
                                <!-- Content -->
                                @yield('main')
                            </div>
                        </div>
                        <!-- Footer -->
                    </section>
                    @include('components.auth-footer')
                </div>
                <div class="hero-main">
                    <div class="card-hero">
                        <div>
                            <h6>Sistem Informasi <br> Manajemen Pengawasan</h6>
                            <span>
                                Digitalkan proses pengawasan<br>
                                Inspektorat Utama Badan Pusat Statistik
                            </span>
                        </div>
                        <div>
                            <img src="{{ asset('img/bps-logo.png') }}" alt="hero" width="125">
                        </div>
                    </div>
                </div>

            </div>

            <!-- General JS Scripts -->
            <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
            <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
            <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
            <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
            <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
            <script src="{{ asset('js/stisla.js') }}"></script>

            @stack('scripts')

            <!-- Template JS File -->
            <script src="{{ asset('js/scripts.js') }}"></script>
            <script src="{{ asset('js/custom.js') }}"></script>
    </body>

</html>
