@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
<style>

</style>
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
@include('components.tim-kerja.edit');
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
                                <a class="btn btn-outline-primary" href="/admin/rencana-kinerja">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        @include('components.rencana-kerja.timeline-steps')
                        <div class="row pb0">
                            <div class="col-md-12">
                                @if ($timKerja->status == 1)
                                <form class="mb-4" action="/admin/tim-kerja/lock/{{ $timKerja->id_timkerja }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" id="btn-lock-timkerja">
                                        <i class="fas fa-lock mr-1"></i>
                                        Kunci Tim Kerja
                                    </button>
                                </form>
                                @elseif ($timKerja->status == 2)
                                <form class="mb-4" action="/admin/tim-kerja/unlock/{{ $timKerja->id_timkerja }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" id="btn-unlock-timkerja">
                                        <i class="fas fa-lock-open mr-1"></i>
                                        Buka Kunci Tim Kerja
                                    </button>
                                </form>
                                @endif

                            </div>
                        </div>
                        <div class="d-flex flex-row flex-wrap justify-content-between">
                            <div class="card col-md-6 p-0 pr-2">
                                <div class="card-body shadow-sm border p-4">
                                    <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                        <div class="badge alert-primary mr-2" style="width: 30px; height: 30px">
                                            <i class="fa-solid fa-info fa-xs"></i>
                                        </div>
                                        <h1 class="h5 text-dark mb-0">
                                            Informasi Tim
                                        </h1>
                                    </div>
                                    <table class="mb-4 table table-striped responsive">
                                        <tr>
                                            <th>Nama Tim:</th>
                                            <td>{{ $timKerja->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>PJ Kegiatan:</th>
                                            <td>{{ $timKerja->ketua->name }}</td>
                                        </tr>
                                        @if (count($operator) > 0)
                                        <tr>
                                            <th>Operator:</th>
                                            <td class="py-1">
                                                @foreach ($operator as $op)
                                                <li>{{ $op->user->name }}</li>
                                                @endforeach
                                            </td>
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
                                    @if ($timKerja->status != 2)
                                    <div class="text-right">
                                        <button class="btn btn-outline-primary btn-edit-timkerja"
                                            data-id="{{ $timKerja->id_timkerja }}" data-toggle="modal"
                                            data-target="#modal-edit-timkerja">
                                            <i class="fa-solid fa-pen mr-1"></i>
                                            Edit Tim Kerja
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card col-md-6 p-0 pl-2">
                                <div class="card-body shadow-sm border p-4">
                                    <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                        <div class="badge alert-primary mr-2" style="width: 30px; height: 30px">
                                            <i class="fa-solid fa-scale-balanced fa-xs"></i>
                                        </div>
                                        <h1 class="h5 text-dark mb-0">
                                            Indikator Tim
                                        </h1>
                                    </div>
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
                            <div class="card-body shadow-sm border p-4">
                                <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                    <div class="badge alert-primary mr-2" style="width: 30px; height: 30px">
                                        <i class="fa-solid fa-list-check fa-xs"></i>
                                    </div>
                                    <h1 class="h5 text-dark mb-0">
                                        Daftar Proyek dan Tugas
                                    </h1>
                                </div>
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
                                                <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                                    <div class="badge alert-success mr-2 d-flex justify-content-center align-items-center"
                                                        style="width: 30px; height: 30px">
                                                        <i class="fa-solid fa-bars-progress fa-xs"></i>
                                                    </div>
                                                    <h1 class="h5 text-dark mb-0">
                                                        Informasi Proyek
                                                    </h1>
                                                </div>
                                                <table class="mb-4 table table-striped responsive" id="table-show">
                                                    <tr>
                                                        <th>Nama Proyek</th>
                                                        <td>{{ $proyek->nama_proyek }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jumlah Tugas</th>
                                                        <td>{{ $proyek->rencanaKerja->count() }}</td>
                                                    </tr>
                                                </table>
                                                <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                                    <div class="badge alert-success mr-2 d-flex justify-content-center align-items-center"
                                                        style="width: 30px; height: 30px">
                                                        <i class="fa-solid fa-list-check fa-xs"></i>
                                                    </div>
                                                    <h1 class="h5 text-dark mb-0">
                                                        Informasi Tugas
                                                    </h1>
                                                </div>
                                                <ol>
                                                    @foreach ($proyek->rencanaKerja as $tugas)
                                                    <li class="font-weight-bold mt-4 h5">
                                                        <p class="font-weight-bold mt-4 h5">{{ $tugas->tugas }}</p>
                                                    </li>
                                                    <table class="">
                                                        <tr>
                                                            <th valign=top style="min-width: 64px">Hasil Kerja Tim</th>
                                                            <td>:</td>
                                                            <td>{{ $tugas->hasilKerja->nama_hasil_kerja }}</td>
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
                                                                $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'Penanggung Jawab Kegiatan'];
                                                                ?>
                                                            <td>{{ $jabatanPelaksana[$pelaksana->pt_jabatan] }}</td>
                                                            <td>
                                                                {{ count($tugas->hasilKerja->masterKinerja) != 0 ? $tugas->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )
                                                                ->first()
                                                                ->hasil_kerja : 'Belum Ditentukan' }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td class="font-italic text-center" colspan="4">Tidak
                                                                terdapat
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
                                                    <p class="font-weight-bold">Laporan</p>
                                                    @if(count($tugas->objekPengawasan) > 0)
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th>Nama Objek</th>
                                                            <th>Nama Laporan</th>
                                                            <th>Jumlah Laporan</th>
                                                        </tr>
                                                        @foreach ($tugas->objekPengawasan as $op)
                                                        <tr>
                                                            <td>{{ $op->nama }}</td>
                                                            <td>{{ $op->nama_laporan }}</td>
                                                            <td>{{ $op->laporanObjekPengawasan->where('status', 1)->count() }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                    @else
                                                    <p class="font-italic">Tidak ada laporan yang ditambahkan</p>
                                                    @endif
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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

<script src="{{ asset('js/page/format-rupiah.js') }}"></script>
{{-- <script src="{{ asset('js/page/admin/tim-rencana-kinerja.js') }}"></script> --}}
<script src="{{ asset('js/page/admin/rencana-kerja.js') }}"></script>
<script src="{{ asset('js/page/pegawai/ketua-tim-rencana-kinerja.js') }}"></script>
@endpush