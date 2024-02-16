@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
{{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Proyek</h1>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="/ketua-tim/rencana-kinerja">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="card">
                            <div class="card-body shadow-sm border">
                                <h1 class="h4 text-dark mb-4 header-card">Informasi Proyek</h1>
                                <table class="mb-4 table table-striped responsive" id="table-show">
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <td>{{ $proyek->nama_proyek }}</td>
                                    </tr>
                                    {{-- rencana_kinerja_anggota --}}
                                    <tr>
                                        <th>Rencana Kinerja Anggota</th>
                                        <td>{{ $proyek->rencana_kinerja_anggota }}</td>
                                    </tr>
                                    {{-- iki_anggota --}}
                                    <tr>
                                        <th>IKI Anggota</th>
                                        <td>{{ $proyek->iki_anggota }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
{{-- <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script> --}}
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/format-rupiah.js') }}"></script>
<script src="{{ asset('js/page/pegawai/ketua-tim-rencana-kinerja.js') }}"></script>
@endpush
