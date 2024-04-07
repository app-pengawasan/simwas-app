@extends('layouts.app')

@section('title', 'Detail Tugas')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')
<!-- Modal -->
{{-- @include('components.rencana-kerja.create'); --}}
@include('components.pelaksana-tugas.anggaran.create');
@include('components.pelaksana-tugas.anggaran.edit');
@include('components.pelaksana-tugas.objek-pengawasan.create');
@include('components.pelaksana-tugas.objek-pengawasan.edit');
@if ($rencanaKerja->kategori_pelaksanatugas == 'gt')
@include('components.pelaksana-tugas.gugus-tugas.create')
@include('components.pelaksana-tugas.gugus-tugas.edit')
@else
@include('components.pelaksana-tugas.bukan-gugus-tugas.create')
@include('components.pelaksana-tugas.bukan-gugus-tugas.edit')
@endif
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Tugas {{ $rencanaKerja->tugas }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/ketua-tim/rencana-kinerja">Kelola Rencana Kinerja</a></div>
                <div class="breadcrumb-item">
                    <a href="/ketua-tim/rencana-kinerja/{{ $timKerja->id_timkerja }}">Tim Kerja</a>
                </div>
                <div class="breadcrumb-item"><a href="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}">Proyek</a></div>
                <div class="breadcrumb-item">Detail Tugas</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <table class="mb-4 table table-striped" id="table-show">
                            <input type="hidden" name="id_rencanakerja" id="id_rencanakerja"
                                value="{{ $rencanaKerja->id_rencanakerja }}">
                            <tr>
                                <th style="min-width: 120pt">Nama Tim</th>
                                <td>{{ $rencanaKerja->proyek->timkerja->nama }}</td>
                            </tr>
                            <tr>
                                <th>Tugas</th>
                                <td>{{ $rencanaKerja->tugas }}</td>
                            </tr>
                            <tr>
                                <th>Hasil Kerja</th>
                                <td>{{ $rencanaKerja->hasilKerja->nama_hasil_kerja }}</td>
                            </tr>
                            {{-- unsur --}}
                            <tr>
                                <th>Unsur</th>
                                <td>{{ $rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur }}</td>
                            </tr>
                            <tr>
                                <th>Subunsur</th>
                                <td>{{ $rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur }}</td>
                            </tr>
                            <tr>
                                <th>Objek</th>
                                <td>
                                    @if (count($rencanaKerja->objekPengawasan))
                                    <ol>
                                        <table>
                                            @foreach ($rencanaKerja->objekPengawasan as $objek)
                                            <tr>
                                                <td class="pr-2">
                                                    <li>{{ $objek->nama }}
                                                    </li>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-edit-objek" type="button"
                                                        data-toggle="modal" data-target="#modal-edit-objek"
                                                        data-kategori="{{ $objek->kategori_objek }}"
                                                        data-id="{{ $objek->id_opengawasan }}"
                                                        data-idobjek="{{ $objek->id_objek }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-delete-objek" type="button"
                                                        data-id="{{ $objek->id_opengawasan }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </ol>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Kategori Pelaksana</th>
                                <td>{{ $pelaksanaTugas[$rencanaKerja->kategori_pelaksanatugas] }}</td>
                            </tr>
                        </table>
                        <div class="row mb-4 pb0">
                            <div class="col-md-12">
                                @if (
                                ($rencanaKerja->kategori_pelaksanatugas == 'gt' && count($rencanaKerja->pelaksana) > 2)
                                ||
                                ($rencanaKerja->kategori_pelaksanatugas == 'ngt' && count($rencanaKerja->pelaksana) >
                                0))
                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                    <button class="btn btn-primary btn-create-pelaksana" type="button"
                                        data-toggle="modal" data-target="#modal-create-pelaksana" data-hasilkerja=2
                                        data-jabatan=4
                                        data-disable={{ $rencanaKerja->kategori_pelaksanatugas == 'gt' ? true : false }}><i
                                            class="fas fa-user"></i>
                                        Tambah Pelaksana
                                    </button>
                                    @endif
                                    @endif
                                    @if ($timKerja->status < 2 || $timKerja->status == 3)
                                        <button id="btn-create-objek" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-create-objek">
                                            <i class="fas fa-building"></i>
                                            Tambah Objek
                                        </button>
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-create-anggaran">
                                            <i class="fas fa-money-bill"></i>
                                            Tambah Anggaran
                                        </button>
                                        @endif
                            </div>
                        </div>
                        <div class="row mb-4 pb-0">
                            <div class="col-md-12">

                                <h5>Pelaksana</h5>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Hasil Kerja</th>
                                        <th>Total Jam Kerja</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @if ($rencanaKerja->kategori_pelaksanatugas == 'gt')
                                    <?php
                                            $jabatanPelaksana = ['Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                                            $hasilKerja = ['Lembar Reviu', 'Kertas Kerja'];
                                            $jumlahPelaksana = count($rencanaKerja->pelaksana) < 3 ? 3 : count($rencanaKerja->pelaksana);
                                            ?>
                                    @for ($i = 0; $i < $jumlahPelaksana; $i++) <tr>
                                        @if (!isset($rencanaKerja->pelaksana[$i]))
                                        <td class="font-italic">
                                            Belum ditentukan
                                        </td>
                                        <td>{{ $i < 2 ? $jabatanPelaksana[$i] : $jabatanPelaksana[$i + 1] }}
                                        </td>
                                        <td>{{ $i == 0 ? 'Lembar Reviu' : 'Kertas Kerja' }}</td>
                                        <td class="font-italic">
                                            Belum tersedia
                                        </td>
                                        <td>
                                            @if ($i > 0 && !isset($rencanaKerja->pelaksana[$i - 1]))
                                            <i>Belum tersedia</i>
                                            @elseif($i == 0 || isset($rencanaKerja->pelaksana[$i - 1]))
                                            @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                <button class="btn btn-primary btn-create-pelaksana" type="button"
                                                    data-toggle="modal" data-disable=true
                                                    data-target="#modal-create-pelaksana"
                                                    data-hasilkerja={{ $i == 0 ? 1 : 2 }} data-jabatan=<?php
                                                                    if ($i == 0) {
                                                                        echo 1;
                                                                    } elseif ($i == 1) {
                                                                        echo 2;
                                                                    } else {
                                                                        echo 4;
                                                                    }
                                                                    ?>>
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>

                                                @endif
                                                @endif
                                        </td>
                                        @else
                                        <td>
                                            {{ $rencanaKerja->pelaksana[$i]->user->name }}
                                        </td>
                                        <td>{{ $jabatanPelaksana[$rencanaKerja->pelaksana[$i]->pt_jabatan - 1] }}
                                        </td>
                                        <td>{{ $hasilKerja[$rencanaKerja->pelaksana[$i]->pt_hasil - 1] }}
                                        </td>
                                        <td>
                                            {{
                                                $rencanaKerja->pelaksana[$i]->jan + $rencanaKerja->pelaksana[$i]->feb + $rencanaKerja->pelaksana[$i]->mar + $rencanaKerja->pelaksana[$i]->apr + $rencanaKerja->pelaksana[$i]->mei + $rencanaKerja->pelaksana[$i]->jun + $rencanaKerja->pelaksana[$i]->jul + $rencanaKerja->pelaksana[$i]->agu + $rencanaKerja->pelaksana[$i]->sep + $rencanaKerja->pelaksana[$i]->okt + $rencanaKerja->pelaksana[$i]->nov + $rencanaKerja->pelaksana[$i]->des
                                                }}
                                        </td>
                                        <td>
                                            @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                <button class="btn btn-warning btn-edit-pelaksana" type="button"
                                                    data-toggle="modal" data-disable=true
                                                    data-target="#modal-edit-pelaksana"
                                                    data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if ($i > 2)
                                                <button class="btn btn-danger btn-delete-pelaksana" type="button"
                                                    data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                                @endif
                                        </td>
                                        @endif
                                        </tr>
                                        @endfor
                                        @else
                                        <?php
                                            $jabatanPelaksana = ['Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                                            $jumlahPelaksana = count($rencanaKerja->pelaksana) < 1 ? 1 : count($rencanaKerja->pelaksana);
                                            ?>
                                        @for ($i = 0; $i < $jumlahPelaksana; $i++) <tr>
                                            @if (!isset($rencanaKerja->pelaksana[$i]))
                                            <td class="font-italic"> Belum ditentukan </td>
                                            <td> PIC </td>
                                            <td class="font-italic"> Belum ditentukan </td>
                                            <td class="font-italic"> Belum ditentukan </td>
                                            <td>
                                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                    <button class="btn btn-primary btn-create-pelaksana" type="button"
                                                        data-toggle="modal" data-disable=false
                                                        data-target="#modal-create-pelaksana" data-hasilkerja=1
                                                        data-jabatan=3>
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                    @endif
                                            </td>
                                            @else
                                            <td>
                                                {{ $rencanaKerja->pelaksana[$i]->user->name }}
                                            </td>
                                            <td>
                                                {{ $jabatanPelaksana[$rencanaKerja->pelaksana[$i]->pt_jabatan - 1] }}
                                            </td>
                                            <td>
                                                {{ $masterHasilKerja[$rencanaKerja->pelaksana[$i]->pt_hasil] }}
                                            </td>
                                            <td>
                                                {{
                                                        $rencanaKerja->pelaksana[$i]->jan + $rencanaKerja->pelaksana[$i]->feb + $rencanaKerja->pelaksana[$i]->mar + $rencanaKerja->pelaksana[$i]->apr + $rencanaKerja->pelaksana[$i]->mei + $rencanaKerja->pelaksana[$i]->jun + $rencanaKerja->pelaksana[$i]->jul + $rencanaKerja->pelaksana[$i]->agt + $rencanaKerja->pelaksana[$i]->sep + $rencanaKerja->pelaksana[$i]->okt + $rencanaKerja->pelaksana[$i]->nov + $rencanaKerja->pelaksana[$i]->des
                                                        }}
                                            </td>
                                            <td>
                                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                    <button class="btn btn-warning btn-edit-pelaksana" type="button"
                                                        data-toggle="modal" data-disable=false
                                                        data-target="#modal-edit-pelaksana"
                                                        data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @endif
                                                    @if ($i >= 1)

                                                    <button class="btn btn-danger btn-delete-pelaksana" type="button"
                                                        data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @endif
                                            </td>
                                            @endif
                                            </tr>
                                            @endfor
                                            @endif
                                </table>
                            </div>
                        </div>
                        <div class="row mb-4 pb-0">
                            <div class="col-md-12">
                                <h5>Anggaran</h5>
                                @if (count($rencanaKerja->anggaran))
                                <table class="table table-striped">
                                    <tr>
                                        <th>Uraian</th>
                                        <th>Volume</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <?php $totalAnggaran = 0; ?>
                                    @foreach ($rencanaKerja->anggaran as $anggaran)
                                    <tr>
                                        <td>{{ $anggaran->uraian }}</td>
                                        <td>{{ $anggaran->volume }}</td>
                                        <td>{{ $satuan[$anggaran->satuan] }}</td>
                                        <td class="rupiah">{{ $anggaran->harga }}</td>
                                        <td class="rupiah">{{ $anggaran->total }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-edit-anggaran" type="button"
                                                data-toggle="modal" data-target="#modal-edit-anggaran"
                                                data-id="{{ $anggaran->id_rkanggaran }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-delete-anggaran" type="button"
                                                data-id="{{ $anggaran->id_rkanggaran }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php $totalAnggaran += $anggaran->total; ?>
                                    @endforeach
                                    <tr>
                                        <th colspan="4">Total Anggaran</th>
                                        <th class="rupiah">{{ $totalAnggaran }}</th>
                                        <th></th>
                                    </tr>
                                </table>
                                @else
                                <p class="font-italic">Tidak ada anggaran yang ditambahkan</p>
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
<script src="{{ asset('js') }}/page/pegawai-tim-pelaksana.js"></script>
<script></script>
@endpush
