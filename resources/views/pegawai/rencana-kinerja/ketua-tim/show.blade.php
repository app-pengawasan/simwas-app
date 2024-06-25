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
                                    @if ($timKerja->status < 2)
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
                                </div>
                                <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                                    <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                        <div id="filter-search-wrapper">
                                        </div>
                                    </div>
                                </div>
                                <table id="table-proyek" class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 15px;">No</th>
                                            <th>Nama Proyek</th>
                                            <th style="width: 150px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proyeks as $proyek)
                                        <tr>
                                            <td class="text-center" style="width: 15px;">{{ $loop->iteration }}</td>
                                            <td>{{ $proyek->nama_proyek }}</td>
                                            <td>
                                                {{-- <a href="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i>
                                                </a> --}}
                                                {{-- delete form --}}
                                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#modal-edit-proyek" data-id="{{ $proyek->id }}"
                                                        data-nama="{{ $proyek->nama_proyek }}"
                                                        data-iki="{{ $proyek->iki_anggota }}"
                                                        data-rencana="{{ $proyek->rencana_kinerja_anggota }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}"
                                                        method="post" class="d-inline delete-form">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm" type="submit">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                            </td>
                                            @endforeach
                                    </tbody>
                                </table>
                                @if ($timKerja->status < 2)
                                    <div class="d-flex justify-content-end mt-3">
                                        <button class="btn btn-outline-primary mt-2" data-toggle="modal"
                                            data-target="#modal-tambah-proyek">
                                            <i class="fa-solid fa-plus mr-1"></i>
                                            Tambah Proyek
                                        </button>
                                    </div>
                                    @endif
                            </div>
                            <div class="card-body shadow-sm border p-4 table-responsive mt-4">
                                <div class="h5 text-dark mb-4 d-flex align-items-center header-card">
                                    <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px">
                                        <i class="fa-solid fa-list-check fa-xs"></i>
                                    </div>
                                    <h1 class="h5 text-dark mb-0">
                                        Daftar Tugas
                                    </h1>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                                    <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                        <div id="filter-search-wrapper-tugas">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                        <label for="filter-unit-kerja" style="margin-bottom: 0;">
                                            Proyek</label>
                                        <select name="proyek" id="filter-proyek" class="form-control select2">
                                            <option value="">Semua</option>
                                            @foreach ($proyeks as $key => $value)
                                            <option value="{{ $value->nama_proyek }}">
                                                {{ $value->nama_proyek }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped display responsive mt-3"
                                    id="table-tugas">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 15px;">No</th>
                                            <th>Nama Proyek</th>
                                            <th>Nama Tugas</th>
                                            <th>Hasil Kerja</th>
                                            <th style="width: 150px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencanaKerjas as $tugas)
                                        <tr>
                                            <td class="text-center" style="width: 15px;">{{ $loop->iteration }}</td>
                                            <td>{{ $tugas->proyek->nama_proyek }}</td>
                                            <td>
                                                {{
                                                        $tugas->tugas
                                                    }}
                                            </td>
                                            <td>{{ $tugas->hasilKerja->nama_hasil_kerja }}</td>
                                            <td>
                                                <a href="/ketua-tim/tim-pelaksana/{{ $tugas->id_rencanakerja }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if ($timKerja->status < 2)
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
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($timKerja->status < 2)
                                    <div class="d-flex justify-content-end mt-3">
                                        <button id="btn-modal-create-tugas"
                                            class="btn btn-outline-primary float-right mt-2" type="button"
                                            data-toggle="modal" data-target="#modal-create-tugas">
                                            <i class="fa-solid fa-plus mr-1"></i>
                                            Tambah Tugas
                                        </button>
                                    </div>
                                    @endif
                            </div>
                        </div>
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
<script>
    $(document).ready(function() {
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "var(--primary)",
                cancelButtonColor: "var(--danger)",
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
