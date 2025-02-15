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
@include('components.admin-header')
@include('components.admin-sidebar')
@include('components.pelaksana-tugas.bukan-gugus-tugas.edit')
@include('components.pelaksana-tugas.objek-pengawasan.bulan')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Tugas {{ str_ireplace('tugas ', '', $rencanaKerja->tugas) }}</h1>

        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary"
                                    href="/admin/realisasi-jam-kerja/pool/{{ $tugas->user->id }}/{{ $tugas->rencanaKerja->timKerja->tahun }}">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <table class="mb-4 table table-striped responsive">
                                    <tr>
                                        <th>IKU</th>
                                        <td>: </td>
                                        <td>{{ $rencanaKerja->proyek->timkerja->iku->iku }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <td>: </td>
                                        <td>{{ $rencanaKerja->proyek->timkerja->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit Kerja</th>
                                        <td>: </td>
                                        <td>{{ $unitKerja[$rencanaKerja->proyek->timkerja->unitkerja] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ketua</th>
                                        <td>: </td>
                                        <td>{{ $rencanaKerja->proyek->timkerja->ketua->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun</th>
                                        <td>: </td>
                                        <td>{{ $rencanaKerja->proyek->timkerja->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tugas</th>
                                        <td>: </td>
                                        <td>{{ $rencanaKerja->tugas }}</td>
                                    </tr>
                                    {{-- <tr>
                                            <th>Status Tugas</th>
                                            <td>: </td>
                                            <td>{{ $statusTugas[$rencanaKerja->status_realisasi] }}</td>
                                    </tr> --}}
                                    {{-- <tr>
                                            <th>Tanggal</th>
                                            <td>:</td>
                                            <td class="">
                                                {{ strftime('%A, %d %B %Y', strtotime($rencanaKerja->mulai)) }} -
                                    {{ strftime('%A, %d %B %Y', strtotime($rencanaKerja->selesai)) }}
                                    </td>
                                    </tr> --}}
                                </table>
                                <hr>
                                <p class="font-weight-bold">Pelaksana</p>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th>Hasil Kerja</th>
                                            <th>Jam Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencanaKerja->pelaksana as $pelaksana)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pelaksana->user->name }}</td>
                                            <?php
                                                    $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'Penanggung Jawab Kegiatan'];
                                                    ?>
                                            <td>{{ $jabatanPelaksana[$pelaksana->pt_jabatan] }}</td>
                                            <td>
                                                {{ $rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan)->first()->hasil_kerja }}
                                            </td>
                                            <td>
                                                {{ 
                                                    $pelaksana->jan + $pelaksana->feb + $pelaksana->mar + $pelaksana->apr +
                                                    $pelaksana->mei + $pelaksana->jun + $pelaksana->jul + $pelaksana->agu +
                                                    $pelaksana->sep + $pelaksana->okt + $pelaksana->nov + $pelaksana->des
                                                }}
                                                <button class="btn btn-primary btn-sm btn-edit-pelaksana" 
                                                    data-toggle="modal" data-target="#modal-edit-pelaksana"
                                                    data-id_peg="{{ $pelaksana->id_pegawai }}" data-nama_peg="{{ $pelaksana->user->name }}"
                                                    data-jan="{{ $pelaksana->jan }}" data-feb="{{ $pelaksana->feb }}"
                                                    data-mar="{{ $pelaksana->mar }}" data-apr="{{ $pelaksana->apr }}"
                                                    data-mei="{{ $pelaksana->mei }}" data-jun="{{ $pelaksana->jun }}"
                                                    data-jul="{{ $pelaksana->jul }}" data-agu="{{ $pelaksana->agu }}"
                                                    data-sep="{{ $pelaksana->sep }}" data-okt="{{ $pelaksana->okt }}"
                                                    data-nov="{{ $pelaksana->nov }}" data-des="{{ $pelaksana->des }}"
                                                    data-jabatan="{{ $pelaksana->pt_jabatan }}">
                                                        <i class="fas fa-eye" style="font-size: 11.8px;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
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
                                <p class="font-weight-bold">Laporan</p>
                                @if(count($rencanaKerja->objekPengawasan) > 0)
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Nama Objek</th>
                                            <th>Nama Laporan</th>
                                            <th>Jumlah Laporan/Dokumen</th>
                                            <th>Laporan/Dokumen Masuk</th>
                                            <th>Persentase Laporan/Dokumen Masuk</th>
                                        </tr>
                                        @foreach ($rencanaKerja->objekPengawasan as $op)
                                        <tr>
                                            <td>{{ $op->nama }}</td>
                                            <td>{{ $op->nama_laporan }}</td>
                                            <td>
                                                {{ $op->laporanObjekPengawasan->where('status', 1)->count() }}
                                                <button class="btn btn-primary btn-sm btn-show-bulan" data-toggle="modal" data-target="#modal-bulan-objek"
                                                data-id="{{ $op->id_opengawasan }}">
                                                        <i class="fas fa-eye" style="font-size: 11.8px;"></i>
                                                </button>
                                            </td>
                                            @php 
                                                $laporan_masuk = 0;
                                                foreach ($op->laporanObjekPengawasan->where('status', 1) as $laporanop) {
                                                    if ($laporanop->normaHasil->count() > 0) {
                                                        foreach ($laporanop->normaHasil->where('status_norma_hasil', 'disetujui') as $nh) {
                                                            if ($nh->normaHasilAccepted) $laporan_masuk += 1;
                                                        }
                                                    }
                                                    $laporan_masuk +=  $laporanop->normaHasilDokumen->count();
                                                }
                                            @endphp
                                            <td>{{ $laporan_masuk }}</td>
                                            <td>{{ round($laporan_masuk / $op->laporanObjekPengawasan->where('status', 1)->count(), 2) * 100 }}%</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <p class="font-italic">Tidak ada laporan yang ditambahkan</p>
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
<script src="{{ asset('js') }}/page/pegawai-rencana-kerja.js"></script>
@endpush
