<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title') – SIMWAS</title>
        <link rel="shortcut icon" href="{{ asset('img/simwas.png') }}" type="image/x-icon">

        {{-- Open Graph --}}


        <!-- General CSS Files -->
        @stack('clockpicker')
        <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('library') }}/select2/dist/css/select2.css">
        <link rel="stylesheet"
            href="{{ asset('library') }}/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.css">
        @stack('style')

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    </head>

    <body>
        <div class="center-body modal fade show" id="modal-loader">
            <div class="loader-circle-75">
            </div>
        </div>
        <div id="app">
            <div class="main-wrapper">
                <!-- Content -->
                @yield('main')

                <!-- Footer -->
                {{-- @include('components.footer') --}}
            </div>
            @include('components.changelog')

            <!-- General JS Scripts -->
            <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
            <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
            <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
            <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
            <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
            <script src="{{ asset('js/stisla.js') }}"></script>
            <script src="{{ asset('library/select2/dist/js/select2.full.js') }}"></script>
            @stack('scripts')

            <!-- Template JS File -->
            <script src="{{ asset('js/scripts.js') }}"></script>
            <script src="{{ asset('js/custom.js') }}"></script>

            <!-- Script agar search box select2 bekerja dalam modal -->
            <script>
                $(document).ready(function () { 
                    $.fn.modal.Constructor.prototype._enforceFocus = function() {}; 
                });
            </script>
    </body>

</html>
