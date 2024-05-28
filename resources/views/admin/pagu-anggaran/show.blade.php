@extends('layouts.app')

@section('title', 'Pagu Anggaran')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pagu Anggaran</h1>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h4 text-dark mb-4 header-card">Data Pagu Anggaran</h1>
                        <table class="table table-striped responsive" id="table-show">
                            <tr>
                                <th style="min-width: 160pt">Program</th>
                                <td>{{ $pagu_anggaran->masterAnggaran->program }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $pagu_anggaran->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>{{ $pagu_anggaran->masterAnggaran->kegiatan }}</td>
                            </tr>
                            <tr>
                                <th>Komponen</th>
                                <td>{{ $pagu_anggaran->komponen . $komponen[$pagu_anggaran->komponen] }}</td>
                            </tr>
                            <tr>
                                <th>Akun</th>
                                <td>{{ $akun[$pagu_anggaran->akun] }}</td>
                            </tr>
                            <tr>
                                <th>Uraian</th>
                                <td>{{ $pagu_anggaran->uraian }}</td>
                            </tr>
                            <tr>
                                <th>Volume</th>
                                <td>{{ $pagu_anggaran->volume }}</td>
                            </tr>
                            <tr>
                                <th>Satuan</th>
                                <td>{{ $satuan[$pagu_anggaran->satuan] }}</td>
                            </tr>
                            <tr>
                                <th>Harga Satuan</th>
                                <td class="rupiah">{{ $pagu_anggaran->harga }}</td>
                            </tr>
                            <tr>
                                <th>Pagu</th>
                                <td class="rupiah">{{ $pagu_anggaran->pagu }}</td>
                            </tr>
                        </table>
                        <hr class="my-1">
                        <div class="d-flex justify-content-start align-content-end mb-0 mt-4 pb-0" style="gap: 10px">
                            <a class="btn btn-outline-primary" href="/admin/pagu-anggaran/">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                            <a class="btn btn-warning" href="/admin/pagu-anggaran/{{ $pagu_anggaran->id_panggaran }}">
                                <i class="fas fa-edit mr-1"></i>Ubah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js') }}/page/pagu-anggaran.js"></script>
@endpush