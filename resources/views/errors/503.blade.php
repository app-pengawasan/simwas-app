@extends('layouts.error')

@section('title', '503')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="page-error">
    <div class="page-inner">
        <h1>503</h1>
        <div class="page-description">
            Mohon Maaf, Server sedang dalam perbaikan. Silakan coba beberapa saat lagi.
        </div>
        <div class="page-search">
            </form>
            <div class="mt-3">
                <a href="/" class="btn btn-outline-primary d-inline-flex align-items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Kembali Ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
@endpush
