<?php setlocale(LC_ALL, 'id-ID', 'id_ID'); ?>
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
                <h1>Detail Tugas {{ $rencanaKerja->tugas }}</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="/pegawai/rencana-kinerja">
                                        <i class="fas fa-chevron-circle-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <table class="mb-4">
                                        <tr>
                                            <th style="min-width: 94pt">Tujuan</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->timkerja->iku->sasaran->tujuan->tujuan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sasaran</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->timkerja->iku->sasaran->sasaran }}</td>
                                        </tr>
                                        <tr>
                                            <th>IKU</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->timkerja->iku->iku }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kegiatan</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->timkerja->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Unit Kerja</th>
                                            <td>: </td>
                                            <td>{{ $unitKerja[$rencanaKerja->timkerja->unitkerja] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ketua</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->timkerja->ketua->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tahun</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->timkerja->tahun }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tugas</th>
                                            <td>: </td>
                                            <td>{{ $rencanaKerja->tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Tugas</th>
                                            <td>: </td>
                                            <td>{{ $statusTugas[$rencanaKerja->status_realisasi] }}</td>
                                        </tr>
                                        <tr>
                                            <th valign=top style="min-width: 64px">Objek</th>
                                            <td>:</td>
                                            <td>
                                                @if (count($rencanaKerja->objekPengawasan) > 0)
                                                    @foreach ($rencanaKerja->objekPengawasan as $objek)
                                                        <p>{{ $loop->iteration }}. {{ $objek->nama }}</p>
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td>:</td>
                                            <td class="">
                                                {{ strftime('%A, %d %B %Y', strtotime($rencanaKerja->mulai)) }} -
                                                {{ strftime('%A, %d %B %Y', strtotime($rencanaKerja->selesai)) }}
                                            </td>
                                        </tr>
                                    </table>
                                    <p class="font-weight-bold">Pelaksana</p>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Hasil Kerja</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rencanaKerja->pelaksana as $pelaksana)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pelaksana->user->name }}</td>
                                                    <?php
                                                    $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                                                    $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja'];
                                                    ?>
                                                    <td>{{ $jabatanPelaksana[$pelaksana->pt_jabatan] }}</td>
                                                    <td>
                                                        @if ($rencanaKerja->kategori_pelaksanatugas == 'gt')
                                                            {{ $hasilKerja2[$pelaksana->pt_hasil] }}
                                                        @elseif ($pelaksana->pt_jabatan == 4)
                                                            Kertas Kerja
                                                        @else
                                                            @if ($pelaksana->pt_hasil == 2)
                                                                Kertas Kerja
                                                            @else
                                                                {{ $hasilKerja[$pelaksana->pt_hasil] }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p class="font-weight-bold">Anggaran</p>
                                    @if (count($rencanaKerja->anggaran))
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Uraian</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                            </tr>
                                            <?php $totalAnggaran = 0; ?>
                                            @foreach ($rencanaKerja->anggaran as $anggaran)
                                                <tr>
                                                    <td>{{ $anggaran->uraian }}</td>
                                                    <td>{{ $anggaran->volume }}</td>
                                                    <td>{{ $satuan[$anggaran->satuan] }}</td>
                                                    <td class="rupiah">{{ $anggaran->harga }}</td>
                                                    <td class="rupiah">{{ $anggaran->total }}</td>
                                                </tr>
                                                <?php $totalAnggaran += $anggaran->total; ?>
                                            @endforeach
                                            <tr>
                                                <th colspan="4">Total Anggaran</th>
                                                <th class="rupiah">{{ $totalAnggaran }}</th>
                                            </tr>
                                        </table>
                                    @else
                                        <p class="font-italic">Tidak ada anggaran yang ditambahkan</p>
                                    @endif
                                    <hr>
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
    <script src="{{ asset('js') }}/page/pegawai-rencana-kerja.js"></script>
@endpush
