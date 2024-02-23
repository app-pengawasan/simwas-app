@extends('layouts.app')

@section('title', 'Detail Evaluasi IKU Unit Kerja')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
{{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type="number"] {
        text-align: center;
        padding: 2px !important;
    }
    .table-wrapper {
        overflow-x: auto;
    }
</style>
@endpush

@section('main')
@include('components.perencana-header')
@include('components.perencana-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Evaluasi Unit Kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('evaluasi-iku-unit-kerja.index') }}">Evaluasi
                        IKU Unit Kerja</a></div>
                <div class="breadcrumb-item">Detail Evaluasi IKU Unit Kerja</div>
            </div>
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
                                <td id="jumlah-objek">{{ $targetIkuUnitKerja->jumlah_objek }}</td>
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
                                <td>{{ \Carbon\Carbon::parse($evaluasiIkuUnitKerja->batas_waktu_tindak_lanjut)->format('d/m/Y') }}
                                </td>
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
                                    <a class="badge badge-primary"
                                        href="{{ asset('/' . $evaluasiIkuUnitKerja->link_tindak_lanjut) }}"
                                        target="_blank">{{ $evaluasiIkuUnitKerja->link_tindak_lanjut }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Dokumen Undangan:</th>
                                <td>

                                    <a class="badge badge-primary"
                                        href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_undangan_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Undangan</a>
                                </td>
                            </tr>
                            {{-- dokumen daftar hadir --}}
                            <tr>
                                <th>Dokumen Daftar Hadir:</th>
                                <td>
                                    <a class="badge badge-primary"
                                        href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_daftar_hadir_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Daftar Hadir</a>
                                </td>

                                {{-- dokumen laporan --}}
                            <tr>
                                <th>Dokumen Laporan:</th>
                                <td>
                                    <a class="badge badge-primary"
                                        href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_laporan_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Laporan</a>
                                </td>
                            </tr>
                            {{-- dokumen notulen --}}
                            <tr>
                                <th>Dokumen Notulen:</th>
                                <td>
                                    <a class="badge badge-primary"
                                        href="{{ asset('/' . $evaluasiIkuUnitKerja->dokumen_notulen_path) }}"
                                        target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                        Dokument Notulen</a>
                                </td>
                            </tr>
                        </table>
                        <div class="form-group col overflow-scroll table-wrapper">
                            <table class="table table-responsive-md table-bordered " id="table-iku">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle" style="width: 30px;">No</th>
                                        <th rowspan="2" class="text-center align-middle" style="min-width: 250px;">
                                            Satuan</th>
                                        <th rowspan="2" class="text-center align-middle"
                                            style="width: 75px; min-width:90px">Y</th>
                                        <th colspan="4" class="text-center align-middle">Target Kinerja (Triwulan)</th>
                                        <th colspan="4" class="text-center align-middle">Realisasi Kinerja
                                            (Triwulan)</th>
                                        <th colspan="4" class="text-center align-middle">Capaian Kinerja
                                            (Triwulan)</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle" style="min-width: 80px;">1</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">2</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">3</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">4</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">1</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">2</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">3</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">4</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">1</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">2</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">3</th>
                                        <th class="text-center align-middle" style="min-width: 80px;">4</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($objekIkuUnitKerja as $key => $value)
                                    <tr id="row-1">
                                        <td class="text-center align-middle">{{ $key+1 }}</td>
                                        <td class="text-left">
                                            <select disabled class="form-control" name="satuan-row1" class="satuan">
                                                @foreach ($kabupaten as $key => $value1)
                                                <option {{ $value->satuan == $value1 ? 'selected' : '' }}
                                                    value="{{ $value }}">
                                                    {{ $value->satuan }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input value="{{ $value->nilai_y_target }}" disabled type="number"
                                                name="nilai-y-row1" id="nilai-y-row1" class="form-control nilai-y"></td>
                                        <td><input value="{{ $value->target_triwulan_1 }}" disabled type="number"
                                                name="triwulan1-row1" id="{{ 'triwulan1-row'.$loop->iteration }}"
                                                class="form-control triwulan1"></td>
                                        <td><input value="{{ $value->target_triwulan_1 + $value->target_triwulan_2  }}"
                                                disabled type="number" name="triwulan2-row1"
                                                id="{{ 'triwulan2-row'.$loop->iteration }}"
                                                class="form-control triwulan2"></td>
                                        <td><input
                                                value="{{ $value->target_triwulan_1 + $value->target_triwulan_2 + $value->target_triwulan_3 }}"
                                                disabled type="number" name="triwulan3-row1"
                                                id="{{ 'triwulan3-row'.$loop->iteration }}"
                                                class="form-control triwulan3"></td>
                                        <td><input
                                                value="{{ $value->target_triwulan_1 + $value->target_triwulan_2 + $value->target_triwulan_3 + $value->target_triwulan_4 }}"
                                                disabled type="number" name="triwulan4-row1"
                                                id="{{ 'triwulan4-row'.$loop->iteration }}"
                                                class="form-control triwulan4"></td>


                                        <td><input type="number" disabled
                                                value="{{ number_format($value->realisasi_triwulan_1/$value->nilai_y_realisasi, 2) }}"
                                                name="{{ 'triwulan1-row'.$loop->iteration }}"
                                                id="{{ 'real-triwulan1-row'.$loop->iteration }}"
                                                class="form-control triwulan1"></td>
                                        <td><input type="number" disabled
                                                value="{{ number_format($value->realisasi_triwulan_2/$value->nilai_y_realisasi, 2) }}"
                                                name="{{ 'triwulan2-row'.$loop->iteration }}"
                                                id="{{ 'real-triwulan2-row'.$loop->iteration }}"
                                                class="form-control triwulan2"></td>
                                        <td><input type="number" disabled
                                                value="{{ number_format($value->realisasi_triwulan_3/$value->nilai_y_realisasi, 2) }}"
                                                name="{{ 'triwulan3-row'.$loop->iteration }}"
                                                id="{{ 'real-triwulan3-row'.$loop->iteration }}"
                                                class="form-control triwulan3"></td>
                                        <td><input type="number" disabled
                                                value="{{ number_format($value->realisasi_triwulan_4/$value->nilai_y_realisasi, 2) }}"
                                                name="{{ 'triwulan4-row'.$loop->iteration }}"
                                                id="{{ 'real-triwulan4-row'.$loop->iteration }}"
                                                class="form-control triwulan4"></td>


                                        <td><input type="number" disabled
                                                name="{{ 'capaian1-row'.$loop->iteration }}"
                                                id="{{ 'capaian1-row'.$loop->iteration }}"
                                                class="form-control triwulan1"></td>
                                        <td><input type="number" disabled
                                                name="{{ 'capaian2-row'.$loop->iteration }}"
                                                id="{{ 'capaian2-row'.$loop->iteration }}"
                                                class="form-control triwulan2"></td>
                                        <td><input type="number" disabled
                                                name="{{ 'capaian3-row'.$loop->iteration }}"
                                                id="{{ 'capaian3-row'.$loop->iteration }}"
                                                class="form-control triwulan3"></td>
                                        <td><input type="number" disabled
                                                name="{{ 'capaian4-row'.$loop->iteration }}"
                                                id="{{ 'capaian4-row'.$loop->iteration }}"
                                                class="form-control triwulan4"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{-- <tr>
                                        <td class="text-center align-middle" colspan="2"
                                            style="text-align: center; font-weight: bold;">
                                            Total:</td>
                                        <td><input disabled type="number" name="total-y" id="total-y" value="0"
                                                class="form-control"></td>
                                        <td><input disabled type="number" name="total-triwulan1" id="total-triwulan1"
                                                value="0" class="form-control"></td>
                                        <td><input disabled type="number" name="total-triwulan2" id="total-triwulan2"
                                                value="0" class="form-control"></td>
                                        <td><input disabled type="number" name="total-triwulan3" id="total-triwulan3"
                                                value="0" class="form-control"></td>
                                        <td><input disabled type="number" name="total-triwulan4" id="total-triwulan4"
                                                value="0" class="form-control"></td>
                                    </tr> --}}
                                </tfoot>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</div>
@endsection

@push('scripts')
{{-- <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> --}}
<script src="{{ asset('js') }}/page/perencana/evaluasi-iku.js"></script>

<!-- Bootstrap is required -->
@endpush
