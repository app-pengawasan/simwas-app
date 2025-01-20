@extends('layouts.auth')

@section('title', 'Log in')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('main')
<div class="d-flex justify-content-center">
    <div class="rowalign-items-center max-w-xl">
        <div class="my-4">
            <h1 class="h3 text-dark text-center selamat-datang my-2">Selamat Datang di SIMWAS</h1>
            <h2 class="auth-login-text">Silakan login terlebih dahulu</h2>
        </div>
        <div>
            <div class="form-group col-lg-12 mx-auto">
                <a href="/auth/sso-bps" class="gsi-material-button" style="width:620; display:block">
                    <div class="gsi-material-button-state"></div>
                    <div class="gsi-material-button-content-wrapper">
                        <div class="gsi-material-button-icon">
                            <img src="/img/bps-logo.png"
                                style="width: 24px; height: 24px; margin-right: 10px;">
                        </div>
                        <span class="gsi-material-button-contents">Sign in with SSO BPS</span>
                    </div>
                </a>
                <br>
                <a href="/auth/google" class="gsi-material-button" style="width:620; display:block">
                    <div class="gsi-material-button-state"></div>
                    <div class="gsi-material-button-content-wrapper">
                        <div class="gsi-material-button-icon">
                            <img src="/img/google-logo.png"
                                style="width: 24px; height: 24px; margin-right: 10px;">
                        </div>
                        <span class="gsi-material-button-contents">Sign in with Google</span>
                    </div>
                </a>
            </div>
        </div>
        @include('components.flash')
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
@endpush
