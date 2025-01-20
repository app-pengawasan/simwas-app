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
            <h1>Detail Tugas {{ str_ireplace('tugas ', '', $rencanaKerja->tugas) }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/ketua-tim/rencana-kinerja">Kelola Rencana Kinerja</a></div>
                <div class="breadcrumb-item">
                    <a href="/ketua-tim/rencana-kinerja/{{ $timKerja->id_timkerja }}">Tim Kerja</a>
                </div>
                <div class="breadcrumb-item">Detail Tugas</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-outline-primary mr-1"
                                    href="/ketua-tim/rencana-kinerja/{{ $timKerja->id_timkerja }}">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="card-body shadow-sm border p-4 mb-4">
                            <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px">
                                    <i class="fa-solid fa-info fa-xs"></i>
                                </div>
                                <h1 class="h5 text-dark mb-0">
                                    Informasi Tim
                                </h1>
                            </div>
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
                                    <th>Kategori Pelaksana</th>
                                    <td>{{ $pelaksanaTugas[$rencanaKerja->kategori_pelaksanatugas] }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="row mb-4 pb-0">
                            <div class="col-md-12">
                                <div class="card-body shadow-sm border p-4">

                                    <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                        <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center"
                                            style="width: 30px; height: 30px">
                                            <i class="fa-solid fa-user-check fa-2xs"></i>
                                        </div>
                                        <h1 class="h5 text-dark mb-0">
                                            Pelaksana Tugas
                                        </h1>
                                    </div>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th>Hasil Kerja</th>
                                            <th>Total Jam Kerja</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @if ($rencanaKerja->kategori_pelaksanatugas == 'gt')
                                        <?php
                                            $jabatanPelaksana = ['Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                                            $kodePelaksana = [1, 2, 3, 4];
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
                                            <td>
                                                {{
                                            $rencanaKerja->hasilKerja->masterKinerja[0]
                                            ->masterKinerjaPegawai
                                            ->where('pt_jabatan', $i < 2 ? $i + 1 : $i + 2 )
                                            ->first()
                                            ->hasil_kerja ?? 'Belum tersedia'
                                        }}
                                            </td>
                                            <td class="font-italic">
                                                Belum tersedia
                                            </td>
                                            <td>
                                                @if ($i > 0 && !isset($rencanaKerja->pelaksana[$i - 1]))
                                                <i>Belum tersedia</i>
                                                @elseif($i == 0 || isset($rencanaKerja->pelaksana[$i - 1]))
                                                @if ($timKerja->status < 2 ) <button
                                                    class="btn btn-primary btn-sm btn-create-pelaksana" type="button"
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
                                                    <i class="fa-solid fa-plus mr-1"></i>
                                                    Tambah Pelaksana
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
                                            <td>{{ $rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $rencanaKerja->pelaksana[$i]->pt_jabatan )->first()->hasil_kerja }}
                                            </td>
                                            </td>
                                            <td class="total-jam">
                                                {{
                                                $rencanaKerja->pelaksana[$i]->jan + $rencanaKerja->pelaksana[$i]->feb + $rencanaKerja->pelaksana[$i]->mar + $rencanaKerja->pelaksana[$i]->apr + $rencanaKerja->pelaksana[$i]->mei + $rencanaKerja->pelaksana[$i]->jun + $rencanaKerja->pelaksana[$i]->jul + $rencanaKerja->pelaksana[$i]->agu + $rencanaKerja->pelaksana[$i]->sep + $rencanaKerja->pelaksana[$i]->okt + $rencanaKerja->pelaksana[$i]->nov + $rencanaKerja->pelaksana[$i]->des
                                                }}
                                            </td>
                                            <td>
                                                @if ($timKerja->status < 2) <button
                                                    class="btn btn-warning btn-edit-pelaksana btn-sm" type="button"
                                                    data-toggle="modal" data-disable=true
                                                    data-target="#modal-edit-pelaksana"
                                                    data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-delete-pelaksana btn-sm"
                                                        type="button"
                                                        data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                        <i class="fas fa-trash mr-1"></i>Hapus
                                                    </button>
                                                    @endif
                                            </td>
                                            @endif
                                            </tr>
                                            @endfor
                                            @else
                                            <?php
                                            $jabatanPelaksana = ['Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJK'];
                                            $jumlahPelaksana = count($rencanaKerja->pelaksana) < 2 ? 2 : count($rencanaKerja->pelaksana);
                                            ?>
                                            @for ($i = 0; $i < $jumlahPelaksana; $i++) <tr>
                                                @if (!isset($rencanaKerja->pelaksana[$i]))
                                                <td class="font-italic"> Belum ditentukan </td>
                                                @if ($i == 0)
                                                <td> PJK </td>
                                                @elseif ($i == 1)
                                                <td> PIC</td>
                                                @endif
                                                @if (count($rencanaKerja->hasilKerja->masterKinerja) < 1) <td>Belum
                                                    tersedia</td>
                                                    @else
                                                    <td class="font-italic"> {{
                                                        $rencanaKerja->hasilKerja->masterKinerja[0]
                                                        ->masterKinerjaPegawai
                                                        ->where('pt_jabatan',
                                                        $i == 0 ? 5 : 3
                                                        )
                                                        ->first()
                                                        ->hasil_kerja ?? 'Belum tersedia'

                                                        }} </td>
                                                    @endif
                                                    <td class="font-italic"> Belum ditentukan </td>
                                                    <td>
                                                        @if ($timKerja->status < 2) <button
                                                            class="btn btn-sm btn-primary btn-create-pelaksana"
                                                            type="button" data-toggle="modal" data-disable=false
                                                            data-target="#modal-create-pelaksana" data-hasilkerja=1
                                                            data-jabatan={{ $i == 0 ? 5 : 3 }}>
                                                            <i class="fa-solid fa-plus mr-1"></i>
                                                            Tambah Pelaksana
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
                                                    @if ($rencanaKerja->kategori_pelaksanatugas == 'ngt')
                                                    @if (count($rencanaKerja->hasilKerja->masterKinerja) < 1) <td>Belum
                                                        tersedia</td>
                                                        @else
                                                        <td>{{ $rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $rencanaKerja->pelaksana[$i]->pt_jabatan )->first()->hasil_kerja }}
                                                        </td>
                                                        @endif
                                                        @else
                                                        <td>
                                                            {{ $rencanaKerja->pelaksana[$i]->hasil->id }}
                                                        </td>
                                                        @endif
                                                        <td>
                                                            {{
                                                        $rencanaKerja->pelaksana[$i]->jan + $rencanaKerja->pelaksana[$i]->feb + $rencanaKerja->pelaksana[$i]->mar + $rencanaKerja->pelaksana[$i]->apr + $rencanaKerja->pelaksana[$i]->mei + $rencanaKerja->pelaksana[$i]->jun + $rencanaKerja->pelaksana[$i]->jul + $rencanaKerja->pelaksana[$i]->agu + $rencanaKerja->pelaksana[$i]->sep + $rencanaKerja->pelaksana[$i]->okt + $rencanaKerja->pelaksana[$i]->nov + $rencanaKerja->pelaksana[$i]->des
                                                        }}
                                                        </td>
                                                        <td>
                                                            @if ($timKerja->status < 2) <button
                                                                class="btn btn-warning btn-edit-pelaksana btn-sm"
                                                                type="button" data-toggle="modal" data-disable=false
                                                                data-target="#modal-edit-pelaksana"
                                                                data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                                <i class="fas fa-edit"></i>
                                                                </button>
                                                                @endif
                                                                <button
                                                                    class="btn btn-danger btn-delete-pelaksana btn-sm"
                                                                    type="button"
                                                                    data-id="{{ $rencanaKerja->pelaksana[$i]->id_pelaksana }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                        </td>
                                                        @endif
                                                        </tr>
                                                        @endfor
                                                        @endif
                                    </table>
                                    @if (
                                    ($rencanaKerja->kategori_pelaksanatugas == 'gt' && count($rencanaKerja->pelaksana) >
                                    2)
                                    ||
                                    ($rencanaKerja->kategori_pelaksanatugas == 'ngt' && count($rencanaKerja->pelaksana)
                                    >
                                    0))
                                    @if ($timKerja->status < 2) <div class="d-flex justify-content-end mt-4">
                                        <button class="btn btn-outline-primary btn-create-pelaksana" type="button"
                                            data-toggle="modal" data-target="#modal-create-pelaksana" data-hasilkerja=2
                                            data-jabatan=4
                                            data-disable={{ $rencanaKerja->kategori_pelaksanatugas == 'gt' ? true : false }}><i
                                                class="fa-solid fa-plus mr-1"></i>
                                            Tambah Pelaksana
                                        </button>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 pb-0">
                        <div class="col-md-12">
                            <div class="card-body shadow-sm border p-4">

                                <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                    <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center"
                                        style="width: 30px; height: 30px">
                                        <i class="fa-solid fa-sack-dollar fa-xs"></i>
                                    </div>
                                    <h1 class="h5 text-dark mb-0">
                                        Anggaran
                                    </h1>
                                </div>
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
                                            @if ($timKerja->status < 2) <button
                                                class="btn btn-warning btn-edit-anggaran btn-sm" type="button"
                                                data-toggle="modal" data-target="#modal-edit-anggaran"
                                                data-id="{{ $anggaran->id_rkanggaran }}">
                                                <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-delete-anggaran btn-sm" type="button"
                                                    data-id="{{ $anggaran->id_rkanggaran }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
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
                                @if (
                                ($rencanaKerja->kategori_pelaksanatugas == 'gt' && count($rencanaKerja->pelaksana) > 2)
                                ||
                                ($rencanaKerja->kategori_pelaksanatugas == 'ngt' && count($rencanaKerja->pelaksana) >
                                0))
                                @if ($timKerja->status < 2) @endif @endif @if ($timKerja->status < 2 ) <div
                                        class="d-flex justify-content-end mt-4">
                                        <button class="btn btn-outline-primary" data-toggle="modal"
                                            data-target="#modal-create-anggaran">
                                            <i class="fa-solid fa-plus mr-1"></i>
                                            Tambah Anggaran
                                        </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-4 pb-0">
                    <div class="col-md-12">
                        <div class="card-body shadow-sm border p-4">

                            <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px">
                                    <i class="fa-solid fa-file-circle-check fa-xs"></i>
                                </div>
                                <h1 class="h5 text-dark mb-0">
                                    Laporan
                                </h1>
                            </div>
                            <table class="table table-striped">
                                <tr>
                                    <th>Nama Objek</th>
                                    <th>Nama Laporan</th>
                                    <th>Jumlah Laporan</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($rencanaKerja->objekPengawasan as $objek)
                                <tr>
                                    <td>{{ $objek->nama }}</td>
                                    <td>{{ $objek->nama_laporan }}</td>
                                    <td>{{ $objek->laporanObjekPengawasan->where('status', 1)->count() }}</td>
                                    <td>
                                        @if ($timKerja->status < 2) <button
                                            class="btn btn-warning btn-edit-objek btn-sm" type="button"
                                            data-toggle="modal" data-target="#modal-edit-objek"
                                            data-id="{{ $objek->id_opengawasan }}">
                                            <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-delete-objek btn-sm" type="button"
                                                data-id="{{ $objek->id_opengawasan }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            @if (
                            ($rencanaKerja->kategori_pelaksanatugas == 'gt' && count($rencanaKerja->pelaksana) > 2)
                            ||
                            ($rencanaKerja->kategori_pelaksanatugas == 'ngt' && count($rencanaKerja->pelaksana) >
                            0))
                            @if ($timKerja->status < 2) @endif @endif @if ($timKerja->status < 2 ) <div
                                    class="d-flex justify-content-end mt-4">
                                    <button id="btn-create-objek" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#modal-create-objek">
                                        <i class="fa-solid fa-plus mr-1"></i>
                                        Tambah Objek
                                    </button>
                        </div>
                        @endif
                    </div>
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
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/page/pegawai-tim-pelaksana.js"></script>
<script></script>
@endpush
