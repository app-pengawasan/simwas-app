@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

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
{{-- @include('components.rencana-kerja.summary'); --}}
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Tim kerja</h1>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="/pimpinan/rencana-kinerja">
                                    <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <input type="hidden" name="id_timkerja" id="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        @include('components.rencana-kerja.timeline-steps')
                        <div class="d-flex flex-row flex-wrap justify-content-between">
                            <div class="card col-md-6 p-0 pr-2">
                                <div class="card-body shadow-sm border p-4">
                                    <h1 class="h4 text-dark mb-4 header-card">Informasi Tim</h1>
                                    <table class="mb-4 table table-striped responsive">
                                        <tr>
                                            <th>Nama Tim:</th>
                                            <td>{{ $timKerja->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ketua Tim:</th>
                                            <td>{{ $timKerja->ketua->name }}</td>
                                        </tr>
                                        @if ($timKerja->operator != null)

                                        <tr>
                                            <th>Operator:</th>
                                            <td>{{ $timKerja->operator->name}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Unit Kerja:</th>
                                            <td>{{ $unitKerja[$timKerja->unitkerja] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tahun:</th>
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
                                            <td>
                                                <span
                                                    class="badge {{ "badge-" . $colorText[$timKerja->status] }}">{{ $statusTim[$timKerja->status] }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card col-md-6 p-0 pl-2">
                                <div class="card-body shadow-sm border p-4">
                                    <h1 class="h4 text-dark mb-4 header-card">Indikator Tim</h1>
                                    <table class="mb-4 table table-striped responsive">
                                        <tr>
                                            <th>Tujuan:</th>
                                            <td>{{ $timKerja->iku->sasaran->tujuan->tujuan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sasaran</th>
                                            <td>{{ $timKerja->iku->sasaran->sasaran }}</td>
                                        </tr>
                                        <tr>
                                            <th>IKU (Indikator Kinerja Utama)</th>
                                            <td>{{ $timKerja->iku->iku }}</td>
                                        </tr>

                                        <tr>
                                            <th>Uraian Tugas</th>
                                            <td>{{ $timKerja->uraian_tugas ?? 'Belum Diisi' }}</td>
                                        </tr>
                                        {{-- rencana_kerja_ketua --}}
                                        <tr>
                                            <th>Rencana Kerja Ketua</th>
                                            <td>{{ $timKerja->renca_kerja_ketua ?? 'Belum Diisi' }}</td>
                                        </tr>
                                        <tr>
                                            <th>IKI Ketua</th>
                                            <td>{{ $timKerja->iki_ketua ?? 'Belum Diisi' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="main">
                            <h1 class="h4 text-dark mb-4 header-card">Daftar Proyek</h1>
                            <div class="accordion" id="faq">
                                @foreach ($proyeks as $proyek)
                                <div class="card">
                                    <div class="card-header" id="faqhead1">
                                        <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse"
                                            data-target="#faq{{ $loop->iteration }}" aria-expanded="true"
                                            aria-controls="faq{{ $loop->iteration }}" style="width: 100%;">

                                            {{ $proyek->nama_proyek }} </a>
                                    </div>
                                    <div id="faq{{ $loop->iteration }}" class="collapse"
                                        aria-labelledby="faqhead{{ $loop->iteration }}" data-parent="#faq">

                                        <div class="card-body"
                                            style="border: 1px solid #cccccc;box-shadow:0 .125rem .25rem rgba(0,0,0,.075)!important">
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
                                                    <td>{{ $proyek->rencanaKerja->count() }}</td>
                                                </tr>
                                            </table>
                                            <h1 class="h4 text-dark mb-4 mt-2 header-card">Daftar Tugas</h1>
                                            <ol>
                                                @foreach ($proyek->rencanaKerja as $tugas)
                                                <li class="font-weight-bold mt-4 h5">
                                                    <p class="font-weight-bold mt-4 h5">{{ $tugas->tugas }}</p>
                                                </li>
                                                <table class="">
                                                    <tr>
                                                        <th valign=top style="min-width: 64px">Objek</th>
                                                        <td>:</td>
                                                        <td>
                                                            @if (count($tugas->objekPengawasan) > 0)
                                                            @foreach ($tugas->objekPengawasan as $objek)
                                                            <p>{{ $loop->iteration }}. {{ $objek->nama }}</p>
                                                            @endforeach
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Waktu</th>
                                                        <td>:</td>
                                                        <td class="">
                                                            {{ strftime('%A, %d %B %Y', strtotime($tugas->mulai)) }} -
                                                            {{ strftime('%A, %d %B %Y', strtotime($tugas->selesai)) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                                <p class="font-weight-bold">
                                                    Pelaksana
                                                </p>
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama</th>
                                                        <th>Jabatan</th>
                                                        <th>Hasil Kerja</th>
                                                    </tr>
                                                    @if (count($tugas->pelaksana) > 0)
                                                    @foreach ($tugas->pelaksana as $pelaksana)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}.</td>
                                                        <td>{{ $pelaksana->user->name }}</td>
                                                        <?php
                                                                                                                        $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                                                                                                                        $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja'];
                                                                                                                        ?>
                                                        <td>{{ $jabatanPelaksana[$pelaksana->pt_jabatan] }}</td>
                                                        <td>
                                                            @if ($tugas->kategori_pelaksanatugas == 'gt')
                                                            {{ $hasilKerja2[$pelaksana->pt_hasil] }}
                                                            @elseif ($pelaksana->pt_jabatan == 4)
                                                            Kertas Kerja
                                                            @else
                                                            @if ($pelaksana->pt_hasil == 2)
                                                            Kertas kerja
                                                            @else
                                                            {{ $hasilKerja[$pelaksana->pt_hasil] }}
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td class="font-italic text-center" colspan="4">Tidak terdapat
                                                            data
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                                <p class="font-weight-bold">Anggaran</p>
                                                @if (count($tugas->anggaran))
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Uraian</th>
                                                        <th>Volume</th>
                                                        <th>Satuan</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    <?php $totalAnggaran = 0; ?>
                                                    @foreach ($tugas->anggaran as $anggaran)
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
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mb-4 pb0">
                            <div class="col-md-12">
                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                    <button class="btn btn-primary" type="button" data-toggle="modal"
                                        data-target="#modal-create-tugas">
                                        <i class="fas fa-plus-circle"></i>
                                        Tugas
                                    </button>
                                    @endif
                                    @if ($timKerja->status != 0)
                                    @if ($timKerja->status == 5)
                                    <button class="btn btn-danger" id="btn-pimpinan-send-back">
                                        <i class="fas fa-undo"></i>
                                        Kembalikan
                                    </button>
                                    <button class="btn btn-success" id="btn-pimpinan-submit-rk">
                                        <i class="far fa-check-circle"></i>
                                        Setujui
                                    </button>
                                    @endif

                                    {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#modal-summary">
                                        <i class="fas fa-receipt"></i> Ringkasan
                                    </button> --}}
                                    @if ($timKerja->status < 2 || $timKerja->status == 3)
                                        <button class="btn btn-success" id="btn-send-rencana-kerja">
                                            <i class="fas fa-paper-plane"></i> Kirim
                                        </button>
                                        @endif
                                        @endif
                            </div>
                        </div>
                        {{-- <div class="row mb-4 pb-0">
                                <div class="col-md-12">
                                    <h4>Tugas</h4>
                                    <ol>
                                        @foreach ($rencanaKerja as $tugas)
                                            <li class="my-2">
                                                {{ $tugas->tugas }}
                        @if ($timKerja->status < 2 || $timKerja->status == 3)
                            <a href="/pegawai/tim-pelaksana/{{ $tugas->id_rencanakerja }}"
                                class="btn btn-warning edit-btn">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript(0)" class="btn btn-danger delete-btn"
                                data-id="{{ $tugas->id_rencanakerja }}">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endif
                            </li>
                            @endforeach
                            </ol>
                    </div>
                </div> --}}
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
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js') }}/page/pimpinan-rencana-kerja.js"></script>
@endpush
