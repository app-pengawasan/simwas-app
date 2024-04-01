@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
@include('components.rencana-kerja.summary');
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Rencana Kegiatan</h1>
        </div>
        <div class="row">
            <input type="hidden" name="id_timkerja" id="id_timkerja" value="{{ $timKerja->id_timkerja }}">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="/admin/rencana-kinerja">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="prg">
                            <div class="circle done">
                                <span class="label"><i class="fa-solid fa-check"></i></span>
                            </div>
                            <span class="bar done"></span>
                            <div class="circle done">
                                <span class="label">2</span>
                            </div>
                            <span class="bar half"></span>
                            <div class="circle active">
                                <span class="label">3</span>
                            </div>
                            <span class="bar"></span>
                            <div class="circle">
                                <span class="label">4</span>
                            </div>
                            <span class="bar"></span>
                            <div class="circle">
                                <span class="label">5</span>
                            </div>
                        </div>
                        <table class="mb-4">
                            <tr>
                                <th style="min-width: 160pt">Tujuan</th>
                                <td>{{ $timKerja->iku->sasaran->tujuan->tujuan }}</td>
                            </tr>
                            <tr>
                                <th>Sasaran</th>
                                <td>{{ $timKerja->iku->sasaran->sasaran }}</td>
                            </tr>
                            <tr>
                                <th>IKU</th>
                                <td>{{ $timKerja->iku->iku }}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>{{ $timKerja->nama }}</td>
                            </tr>
                            <tr>
                                <th>Unit Kerja</th>
                                <td>{{ $unitKerja[$timKerja->unitkerja] }}</td>
                            </tr>
                            <tr>
                                <th>Ketua</th>
                                <td>{{ $timKerja->ketua->name }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $timKerja->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Total Anggaran</th>
                                <td class="rupiah">
                                    <?php $totalAnggaran = 0; ?>
                                    @foreach ($timKerja->rencanaKerja as $rk)
                                    <?php $totalAnggaran += $rk->anggaran->sum('total'); ?>
                                    @endforeach
                                    {{ $totalAnggaran }}
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $statusTim[$timKerja->status] }}</td>
                            </tr>
                        </table>
                        <div class="row mb-4 pb0">
                            <div class="col-md-12">
                                @if ($timKerja->status > 1)
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modal-summary">
                                    <i class="fas fa-receipt"></i> Ringkasan
                                </button>
                                @endif
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
