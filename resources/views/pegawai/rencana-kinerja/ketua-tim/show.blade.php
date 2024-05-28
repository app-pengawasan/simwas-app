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
<!-- Modal -->
{{-- @include('components.rencana-kerja.create'); --}}
@include('components.rencana-kerja.summary');
@include('components.rencana-kerja.edit')
@include('components.rencana-kerja.create-proyek')
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
                                    @if ($timKerja->status < 2 || $timKerja->status == 3)
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
                            <div class="card-body shadow-sm border p-4">
                                <h1 class="h4 text-dark mb-4 header-card">Daftar Proyek</h1>
                                <table class="table table-bordered table-striped display responsive" id="table-proyek">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Proyek</th>
                                            <th>Rencana Kinerja Anggota</th>
                                            <th>IKI Ketua</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proyeks as $proyek)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $proyek->nama_proyek }}</td>
                                            <td>{{ $proyek->rencana_kinerja_anggota }}</td>
                                            <td>{{ $proyek->iki_anggota }}</td>
                                            <td>
                                                <a href="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye mr-1"></i>Lihat
                                                </a>
                                                {{-- delete form --}}
                                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                    <form action="/ketua-tim/rencana-kinerja/proyek/{{ $proyek->id }}"
                                                        method="post" class="d-inline delete-form">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm" type="submit">
                                                            <i class="fa fa-trash mr-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                    @endif
                                            </td>
                                            @endforeach
                                    </tbody>
                                </table>
                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                    <button class="btn btn-outline-primary float-right mt-2" data-toggle="modal"
                                        data-target="#modal-tambah-proyek">
                                        <i class="fa-solid fa-plus mr-1"></i>
                                        Tambah Proyek
                                    </button>
                                    @endif

                            </div>
                        </div>
                        <div class="row mb-4 pb0">
                            <div class="col-md-12">
                                {{-- @if ($timKerja->status <div 2 || $timKerja->status == 3)
                                    <button id="btn-modal-create-tugas" class="btn btn-primary" type="button"
                                        data-toggle="modal" data-target="#modal-create-tugas">
                                        <i class="fas fa-plus-circle"></i>
                                        Tugas
                                    </button>
                                    @endif --}}
                                {{-- @if ($timKerja->status != 0)
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modal-summary">
                                    <i class="fas fa-receipt"></i> Ringkasan
                                </button>
                                @endif --}}
                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                    <button class="btn btn-success float-right btn-xl mt-4 text-bold"
                                        id="btn-send-rencana-kerja">
                                        <i class="fa-regular fa-paper-plane mr-1"></i> Kirim
                                    </button>
                                    @endif
                            </div>
                            {{-- <div class="row mb-4 pb-0">
                                <div class="col-md-12">
                                    <h5>Tugas</h5>
                                    <ol>
                                        @foreach ($rencanaKerja as $tugas)
                                        <li class="my-2">
                                            {{ $tugas->tugas }}
                            @if ($timKerja->status < 2 || $timKerja->status == 3)
                                <a href="/ketua-tim/tim-pelaksana/{{ $tugas->id_rencanakerja }}"
                                    class="btn btn-warning edit-btn">
                                    <i class="fa fa-edit"></i>
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
{{-- <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script> --}}
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

<!-- Page Specific JS File -->
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
