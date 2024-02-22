@extends('layouts.app')

@section('title', 'Evaluasi IKU Unit Kerja')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
{{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.perencana-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Evaluasi Unit Kerja</h1>

        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <h1 class="h4 text-dark mb-4 header-card">Informasi Unit Kerja</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Unit Kerja:</th>
                                <td>{{ $targetIkuUnitKerja->unit_kerja }}</td>
                            </tr>
                            <tr>
                                <th>Nama Kegiatan:</th>
                                <td>{{ $targetIkuUnitKerja->nama_kegiatan }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>{{ $targetIkuUnitKerja->status }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Objek:</th>
                                <td>{{ $targetIkuUnitKerja->jumlah_objek }}</td>
                            </tr>
                        </table>
                        <h1 class="h4 text-dark mb-4 header-card">Informasi Evaluasi</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Kendala:</th>
                                <td>{{ $evaluasiIkuUnitKerja->kendala }}</td>
                            </tr>
                            <tr>
                                <th>Solusi</th>
                                <td>{{ $evaluasiIkuUnitKerja->solusi }}</td>
                            </tr>
                            {{-- tindak lanjut --}}
                            <tr>
                                <th>Tindak Lanjut:</th>
                                <td>{{ $evaluasiIkuUnitKerja->tindak_lanjut }}</td>
                            </tr>
                            <tr>
                                <th>PIC Tindak Lanjut:</th>
                                <td>{{ $evaluasiIkuUnitKerja->id_pic }}</td>
                            </tr>
                            <tr>
                                <th>Batas Waktu Tindak Lanjut:</th>
                                <td>{{ \Carbon\Carbon::parse($evaluasiIkuUnitKerja->batas_waktu_tindak_lanjut)->format('d/m/Y') }}</td>
                            </tr>
                            {{-- bukti tindak lanjut --}}
                            <tr>
                                <th>Bukti Tindak Lanjut:</th>
                                <td>
                                    {{ $evaluasiIkuUnitKerja->uraian_tindak_lanjut }}
                                </td>
                            </tr>
                            <tr>
                                <th>Link Bukti Tindak Lanjut:</th>
                                <td>
                                    <a class="badge badge-primary" href="{{ asset('/' . $evaluasiIkuUnitKerja->link_tindak_lanjut) }}"
                                        target="_blank">{{ $evaluasiIkuUnitKerja->link_tindak_lanjut }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Dokumen Undangan:</th>
                                <td>

                                    <a class="badge badge-primary" href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_undangan_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Undangan</a>
                                </td>
                            </tr>
                            {{-- dokumen daftar hadir --}}
                            <tr>
                                <th>Dokumen Daftar Hadir:</th>
                                <td>
                                    <a class="badge badge-primary" href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_daftar_hadir_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Daftar Hadir</a>
                                </td>

                            {{-- dokumen laporan --}}
                            <tr>
                                <th>Dokumen Laporan:</th>
                                <td>
                                    <a class="badge badge-primary" href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_laporan_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Laporan</a>
                                </td>
                            </tr>
                            {{-- dokumen notulen --}}
                            <tr>
                                <th>Dokumen Notulen:</th>
                                <td>
                                    <a class="badge badge-primary" href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_notulen_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Notulen</a>
                                </td>
                            </tr>
                        </table>

            </div>

        </div>
</div>
</section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Bootstrap is required -->
@endpush
