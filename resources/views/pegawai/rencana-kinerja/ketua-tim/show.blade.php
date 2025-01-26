@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')
<!-- Modal -->
{{-- @include('components.rencana-kerja.create'); --}}
{{-- @include('components.rencana-kerja.summary'); --}}
@include('components.rencana-kerja.edit')
@include('components.rencana-kerja.create-proyek')
@include('components.rencana-kerja.edit-proyek')
@include('components.rencana-kerja.create');
@include('components.rencana-kerja.edit-rk');
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Tim kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/ketua-tim/rencana-kinerja">Kelola Rencana Kinerja</a></div>
                <div class="breadcrumb-item">Detail Tim Kerja</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-outline-primary" href="/ketua-tim/rencana-kinerja">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <input type="hidden" name="id_timkerja" id="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                        @include('components.rencana-kerja.timeline-steps')
                        <div class="row pb0">
                            <div class="col-md-12">
                                @if ($timKerja->status < 2)
                                    <button class="btn btn-success mb-3"
                                        id="btn-send-rencana-kerja">
                                        <i class="fa-regular fa-paper-plane mr-1"></i> Kirim
                                    </button>
                                @elseif ($timKerja->status == 5)
                                    <button class="btn btn-success mb-3"
                                        id="btn-send-selesai-pkpt">
                                        <i class="fa-regular fa-paper-plane mr-1"></i> Kirim Selesai PKPT
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex flex-row flex-wrap justify-content-between">
                            <div class="card col-md-6 p-0 pr-2">
                                <div class="card-body shadow-sm border p-4">

                                    <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                        <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center"
                                            style="width: 30px; height: 30px">
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
                                            <th>Ketua Tim:</th>
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
                                </div>
                            </div>
                            <div class="card col-md-6 p-0 pl-2">
                                <div class="card-body shadow-sm border p-4">
                                    <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                        <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px">
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
                                    @if ($timKerja->status < 2 || $timKerja->status == 5)
                                        <div class="text-right">
                                            <button class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#modal-edit-timkerja">
                                                <i class="fa-solid fa-pen mr-1"></i>
                                                Edit Tim Kerja
                                            </button>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row flex-wrap justify-content-between">
                            <div class="card-body shadow-sm border p-4 table-responsive">
                                <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                    <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px">
                                        <i class="fa-solid fa-bars-progress fa-xs"></i>
                                    </div>
                                    <h1 class="h5 text-dark mb-0">
                                        Daftar Proyek
                                    </h1>
                                    @if ($timKerja->status < 2 || $timKerja->status == 5)
                                        <div class="d-flex">
                                            <button class="btn btn-outline-primary btn-sm ml-2" data-toggle="modal"
                                                data-target="#modal-tambah-proyek">
                                                <i class="fa-solid fa-plus mr-1"></i>
                                                Tambah Proyek
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="accordion" id="faq">
                                    @foreach ($proyeks as $proyek)
                                    <div class="card">
                                        <div class="card-header" id="faqhead{{ $loop->iteration }}"
                                            style="border-bottom: 1px solid #cccccc;">
                                            <a href="#" class="btn btn-header-link collapsed align-middle" data-toggle="collapse"
                                                data-target="#faq{{ $loop->iteration }}" aria-expanded="true"
                                                aria-controls="faq{{ $loop->iteration }}" style="width: 100%; display: grid; grid-template-columns: 1fr max-content max-content;">
                                                <span>{{ $proyek->nama_proyek }}</span>
                                                @if ($timKerja->status < 2 || $timKerja->status == 5)
                                                    <span class="mr-3">
                                                        <button class="btn btn-warning btn-sm edit-btn-proyek mt-0" data-toggle="modal"
                                                            data-target="#modal-edit-proyek" data-id="{{ $proyek->id }}"
                                                            data-nama="{{ $proyek->nama_proyek }}"
                                                            data-iki="{{ $proyek->iki_anggota }}"
                                                            data-rencana="{{ $proyek->rencana_kinerja_anggota }}" style="padding: 0.1rem 0.4rem; border-radius: 0.2rem;">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <form action="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}"
                                                            method="post" class="d-inline delete-form">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm mt-0" type="submit" style="padding: 0.1rem 0.4rem; border-radius: 0.2rem;">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                @endif
                                            </a>
                                        
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
                                                        Daftar Tugas
                                                    </h1>
                                                    @if ($timKerja->status < 2 || $timKerja->status == 5)
                                                        <span class="d-flex justify-content-end mt-1 ml-2">
                                                            <button

                                                                class="btn btn-outline-primary float-right btn-sm btn-modal-create-tugas" type="button"
                                                                data-toggle="modal" data-target="#modal-create-tugas" data-proyek="{{ $proyek->id }}">
                                                                <i class="fa-solid fa-plus mr-1"></i>
                                                                Tambah Tugas
                                                            </button>
                                                        </span>
                                                    @endif
                                                </div> 
                                                <ol>
                                                    @if ($proyek->rencanaKerja->count() > 0)
                                                        @foreach ($proyek->rencanaKerja as $tugas)
                                                            <li class="font-weight-bold mt-4 h5">
                                                                <span class="font-weight-bold mt-4 h5">{{ $tugas->tugas }}</span>
                                                                @if ($timKerja->status < 2 || $timKerja->status == 5)
                                                                    <a href="/ketua-tim/tim-pelaksana/{{ $tugas->id_rencanakerja }}"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-eye" style="font-size: 11.8px;"></i>
                                                                    </a>
                                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                                        data-proyek="{{ $tugas->id_proyek }}"
                                                                        data-target="#modal-edit-tugas"
                                                                        data-id="{{ $tugas->id_rencanakerja }}"
                                                                        data-tugas="{{ $tugas->tugas }}"
                                                                        data-melaksanakan="{{ $tugas->melaksanakan }}"
                                                                        data-capaian="{{ $tugas->capaian }}"
                                                                        data-hasil="{{ $tugas->hasilKerja->id }}"
                                                                        data-subunsur="{{ $tugas->hasilKerja->masterSubUnsur->nama_sub_unsur }}"
                                                                        data-unsur="{{ $tugas->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur }}"
                                                                        data-pelaksana="{{ $tugas->kategori_pelaksanatugas }}">
                                                                        <i class="fa fa-edit
                                                                            "></i>
                                                                    </button>
                                                                    <a href="javascript(0)" class="btn btn-danger btn-sm delete-btn"
                                                                        data-id="{{ $tugas->id_rencanakerja }}">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                @endif
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
                                                        @endforeach
                                                    @else
                                                        <p class="font-italic">Tidak terdapat data</p>
                                                    @endif
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mb-4 pb0">
                            <div class="col-md-12">
                            </div>
                        </div> --}}
                    </div>

                </div>
            </div>
    </section>
</div>
@endsection

@push('scripts')
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
<script src="{{ asset('js/page/format-rupiah.js') }}"></script>
<script src="{{ asset('js/page/pegawai/ketua-tim-rencana-kinerja.js') }}"></script>
@endpush
