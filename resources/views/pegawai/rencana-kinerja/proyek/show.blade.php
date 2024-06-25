@extends('layouts.app')

@section('title', 'Detail Proyek')

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
@include('components.rencana-kerja.create');


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Proyek
                {{ $proyek->nama_proyek }}
            </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/ketua-tim/rencana-kinerja">Kelola Rencana Kinerja</a></div>
                <div class="breadcrumb-item">
                    <a href="/ketua-tim/rencana-kinerja/{{ $timKerja->id_timkerja }}">Tim Kerja</a>
                </div>
                <div class="breadcrumb-item">Detail Proyek</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-outline-primary mr-1" href="/ketua-tim/rencana-kinerja/{{ $timKerja->id_timkerja }}">
                                    <i class="fas fa-arrow-left"></i> Kembali
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
                                    <tr>
                                        <th>Jumlah Tugas</th>
                                        <td>{{ $rencanaKerjas->count() }} Tugas</td>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body shadow-sm border">
                                <h1 class="h4 text-dark mb-4 header-card">Informasi Tugas</h1>
                                <table class="table table-bordered table-striped responsive" id="table-proyek">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Proyek</th>
                                            <th>Pelaksana Tugas</th>
                                            <th>Melaksanakan</th>
                                            <th>Capaian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencanaKerjas as $tugas)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tugas->tugas }}</td>
                                            <td>
                                                {{
                                                    $tugas->kategori_pelaksanatugas == 'gt' ? "Gugus Tugas" :  "Non Gugus Tugas"
                                                }}
                                                </td>
                                            <td>{{ $tugas->melaksanakan }}</td>
                                            <td>{{ $tugas->capaian }}</td>
                                            <td>
                                                <a href="/ketua-tim/tim-pelaksana/{{ $tugas->id_rencanakerja }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye mr-1"></i>Lihat
                                                </a>
                                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                    <a href="javascript(0)" class="btn btn-danger btn-sm delete-btn"
                                                        data-id="{{ $tugas->id_rencanakerja }}">
                                                        <i class="fa fa-trash mr-1"></i> Hapus
                                                    </a>
                                                    @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                    <button id="btn-modal-create-tugas" class="btn btn-outline-primary float-right mt-2"
                                        type="button" data-toggle="modal" data-target="#modal-create-tugas">
                                        <i class="fa-solid fa-plus mr-1"></i>
                                        Tambah Tugas
                                    </button>
                                    @endif
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
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/format-rupiah.js') }}"></script>
<script src="{{ asset('js/page/pegawai/ketua-tim-rencana-kinerja.js') }}"></script>
@endpush
