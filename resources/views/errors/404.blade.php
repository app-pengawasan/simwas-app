@extends('layouts.error')

@section('title', '404')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="page-error">
    <div class="page-inner">
        <h1>404</h1>
        <div class="page-description">
            Mohon Maaf, Halaman yang Anda cari tidak dapat kami temukan.
        </div>
        <div class="page-search">
            </form>
            <div class="mt-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary d-inline-flex align-items-center">
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
