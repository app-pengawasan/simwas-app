@extends('layouts.app')

@section('title', 'Buat Evaluasi IKU Unit Kerja')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library') }}/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
{{-- <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
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

    #jumlah-objek {
        text-align: left;
        padding: 15px !important;
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
            <h1>Form Evaluasi IKU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                        href="{{ route('perencana.evaluasi-iku-unit-kerja.index') }}">Evaluasi
                        IKU Unit Kerja</a></div>
                <div class="breadcrumb-item">Buat Evaluasi IKU Unit Kerja</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h4 text-dark mb-4 header-card">Data Evaluasi IKU Unit Kerja</h1>
                            <form action="{{ route('perencana.evaluasi-iku-unit-kerja.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $targetIkuUnitKerja->id }}">
                                    <label for="nama-kegiatan">Unit Kerja</label>
                                    <div>
                                        <select disabled class="form-control" name="unit-kerja"
                                            data-placeholder="Pilih Unit kerja" data-allow-clear="1">
                                            @foreach ($unitKerja as $key => $value)
                                            <option {{ $targetIkuUnitKerja->unit_kerja == $key ? 'selected' : '' }}
                                                value="{{ $key }}">{{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama-kegiatan">Nama Kegiatan</label>
                                    <div>
                                        <input disabled value="{{ $targetIkuUnitKerja->nama_kegiatan }}"
                                            id="nama-kegiatan" type="text" class="form-control" name="nama-kegiatan"
                                            required placeholder="Isikan Nama Kegiatan IKU">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah-objek">Jumlah Objek</label>
                                    <div>
                                        <input type="hidden" name="jumlah_objek"
                                            value="{{ $targetIkuUnitKerja->jumlah_objek }}">
                                        <input disabled value="{{ intval($targetIkuUnitKerja->jumlah_objek) }}"
                                            id="jumlah-objek" type="number" class="form-control" name="jumlah-objek"
                                            required placeholder="Isikan Jumlah Objek">
                                    </div>
                                </div>
                                <div class="form-group overflow-auto table-wrapper">
                                    <table class="table table-responsive-md table-bordered " id="table-iku">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center align-middle" style="width: 30px;">No
                                                </th>
                                                <th rowspan="2" class="text-center align-middle"
                                                    style="min-width: 250px;">
                                                    Satuan Kerja</th>
                                                <th rowspan="2" class="text-center align-middle"
                                                    style="width: 75px; min-width:90px">Y</th>
                                                <th colspan="4" class="text-center align-middle">Target Kinerja
                                                    (Triwulan)</th>
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
                                                    <select disabled class="form-control" name="satuan-row1"
                                                        class="satuan">
                                                        <option value="{{ $value->id_objek }}">
                                                            {{ $value->master_objeks->nama}}
                                                        </option>
                                                    </select>
                                                </td>
                                                <td><input value="{{ $value->nilai_y_target }}" disabled type="number"
                                                        name="{{ 'nilai-y-row'.$loop->iteration }}"
                                                        id="{{ 'nilai-y-row'.$loop->iteration }}"
                                                        class="form-control nilai-y"></td>
                                                <td><input value="{{ $value->target_triwulan_1 }}" disabled
                                                        type="number" name="triwulan1-row1"
                                                        id="{{ 'triwulan1-row'.$loop->iteration }}"
                                                        class="form-control triwulan1"></td>
                                                <td><input
                                                        value="{{ $value->target_triwulan_1 + $value->target_triwulan_2 }}"
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

                                                @php
                                                $realisasi1 = $value->nilai_y_realisasi != 0 ?
                                                number_format($value->realisasi_triwulan_1 /
                                                $value->nilai_y_realisasi, 2) : 0;
                                                $realisasi2 = $value->nilai_y_realisasi != 0 ?
                                                number_format($value->realisasi_triwulan_2 /
                                                $value->nilai_y_realisasi, 2) : 0;
                                                $realisasi3 = $value->nilai_y_realisasi != 0 ?
                                                number_format($value->realisasi_triwulan_3 /
                                                $value->nilai_y_realisasi, 2) : 0;
                                                $realisasi4 = $value->nilai_y_realisasi != 0 ?
                                                number_format($value->realisasi_triwulan_4 /
                                                $value->nilai_y_realisasi, 2) : 0;
                                                @endphp

                                                <td><input type="number" disabled value="{{ $realisasi1 + 0}}"
                                                        name="{{ 'triwulan1-row'.$loop->iteration }}"
                                                        id="{{ 'real-triwulan1-row'.$loop->iteration }}"
                                                        class="form-control triwulan1"></td>
                                                <td><input type="number" disabled
                                                        value="{{ $realisasi2 + $realisasi1 }}"
                                                        name="{{ 'triwulan2-row'.$loop->iteration }}"
                                                        id="{{ 'real-triwulan2-row'.$loop->iteration }}"
                                                        class="form-control triwulan2"></td>
                                                <td><input type="number" disabled
                                                        value="{{ $realisasi3 + $realisasi2 + $realisasi1 }}"
                                                        name="{{ 'triwulan3-row'.$loop->iteration }}"
                                                        id="{{ 'real-triwulan3-row'.$loop->iteration }}"
                                                        class="form-control triwulan3"></td>
                                                <td><input type="number" disabled
                                                        value="{{ $realisasi4 + $realisasi3 + $realisasi2 + $realisasi1 }}"
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
                                        <tfoot class="font-weight-bold">
                                            <tr>
                                                <td class="text-center align-middle font-weight-bold" colspan="2"
                                                    style="text-align: center; font-weight: bold;">
                                                    Total:</td>
                                                <td><input disabled type="number" name="total-y" id="total-y" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="total-target-triwulan1"
                                                        id="total-target-triwulan1" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="total-target-triwulan2"
                                                        id="total-target-triwulan2" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="total-target-triwulan3"
                                                        id="total-target-triwulan3" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="total-target-triwulan4"
                                                        id="total-target-triwulan4" value="0"
                                                        class="form-control font-weight-bold"></td>

                                                <td><input disabled type="number" name="total-realisasi-triwulan1"
                                                        id="total-realisasi-triwulan1" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="total-realisasi-triwulan2"
                                                        id="total-realisasi-triwulan2" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="total-realisasi-triwulan3"
                                                        id="total-realisasi-triwulan3" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="total-realisasi-triwulan4"
                                                        id="total-realisasi-triwulan4" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>

                                                <td><input disabled type="number" name="total-capaian-triwulan1"
                                                        id="total-capaian-triwulan1" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="total-capaian-triwulan2"
                                                        id="total-capaian-triwulan2" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="total-capaian-triwulan3"
                                                        id="total-capaian-triwulan3" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="total-capaian-triwulan4"
                                                        id="total-capaian-triwulan4" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center align-middle font-weight-bold" colspan="2"
                                                    style="text-align: center; font-weight: bold;">
                                                    Persentase:</td>
                                                <td>
                                                </td>
                                                <td><input disabled type="number" name="persentase-target-triwulan1"
                                                        id="persentase-target-triwulan1" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="persentase-target-triwulan2"
                                                        id="persentase-target-triwulan2" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="persentase-target-triwulan3"
                                                        id="persentase-target-triwulan3" value="0"
                                                        class="form-control font-weight-bold"></td>
                                                <td><input disabled type="number" name="persentase-target-triwulan4"
                                                        id="persentase-target-triwulan4" value="0"
                                                        class="form-control font-weight-bold"></td>

                                                <td><input disabled type="number" name="persentase-realisasi-triwulan1"
                                                        id="persentase-realisasi-triwulan1" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="persentase-realisasi-triwulan2"
                                                        id="persentase-realisasi-triwulan2" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="persentase-realisasi-triwulan3"
                                                        id="persentase-realisasi-triwulan3" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="persentase-realisasi-triwulan4"
                                                        id="persentase-realisasi-triwulan4" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>

                                                <td><input disabled type="number" name="persentase-capaian-triwulan1"
                                                        id="persentase-capaian-triwulan1" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="persentase-capaian-triwulan2"
                                                        id="persentase-capaian-triwulan2" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="persentase-capaian-triwulan3"
                                                        id="persentase-capaian-triwulan3" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                                <td><input disabled type="number" name="persentase-capaian-triwulan4"
                                                        id="persentase-capaian-triwulan4" value="0"
                                                        class="form-control font-weight-bold">
                                                </td>
                                            </tr>

                                        </tfoot>

                                    </table>
                                </div>
                                {{-- create table with no, Satuan = Select Option, Y=number, Triwulan 1 =number, Triwulan 2 =number , Triwulan 3 =number, Triwulan 4 =number--}}
                                <div class="form-group">
                                    <label for="kendala">Kendala</label>
                                    <input id="kendala" type="text" class="form-control" name="kendala" required
                                        placeholder="Isikan kendala yang dihadapi">
                                </div>
                                <div class="form-group">
                                    <label for="solusi">Solusi</label>
                                    <input id="solusi" type="text" class="form-control" name="solusi" required
                                        placeholder="Masukkan solusi">
                                </div>
                                <div class="form-group">
                                    <label for="tindak_lanjut">Tindak Lanjut</label>
                                    <input id="tindak_lanjut" type="text" class="form-control" name="tindak_lanjut"
                                        required placeholder="Masukkan tindak lanjut">
                                </div>
                                <div class="form-group">
                                    <label for="pic_tindak_lanjut">PIC Tindak Lanjut</label>
                                    <select name="pic_tindak_lanjut" id="pic_tindak_lanjut" class="form-control select2"
                                        data-placeholder="Pilih PIC Tindak Lanjut" required>
                                        <option value=""></option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="batas_waktu">Batas Waktu Tindak Lanjut</label>
                                    <input type="date" class="form-control" name="batas_waktu" id="batas_waktu"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="bukti_tindak_lanjut">Bukti Tindak Lanjut</label>
                                    <input id="bukti_tindak_lanjut" type="text" class="form-control"
                                        name="bukti_tindak_lanjut" required placeholder="Masukkan bukti tindak lanjut">
                                </div>
                                <div class="form-group">
                                    <label for="link_bukti_tindak_lanjut">Link Bukti Tindak Lanjut</label>
                                    <input id="link_bukti_tindak_lanjut" type="url" class="form-control"
                                        name="link_bukti_tindak_lanjut" required
                                        placeholder="Masukkan link/tautan bukti tindak lanjut, contoh : https://www.bukti-pendukung.com">
                                </div>
                                {{-- file upload  undangan (pdf) --}}
                                <div class="form-group">
                                    <label for="undangan">Dokumen Undangan</label>
                                    <input type="file" class="form-control" name="undangan" id="undangan" required
                                        accept="application/pdf">
                                </div>
                                {{-- daftar hadir pdf --}}
                                <div class="form-group">
                                    <label for="daftar_hadir">Dokumen Daftar Hadir</label>
                                    <input type="file" class="form-control" name="daftar_hadir" id="daftar_hadir"
                                        required accept="application/pdf">
                                </div>
                                {{-- notulen --}}
                                <div class="form-group">
                                    <label for="notulen">Dokumen Notulen</label>
                                    <input type="file" class="form-control" name="notulen" id="notulen" required
                                        accept="application/pdf">
                                </div>
                                {{-- laporan kinerja --}}
                                <div class="form-group">
                                    <label for="laporan_kinerja">Dokumen Laporan Kinerja</label>
                                    <input type="file" class="form-control" name="laporan_kinerja" id="laporan_kinerja"
                                        required accept="application/pdf">
                                </div>
                                <hr class="my-1">
                                <div class="d-flex justify-content-start align-content-end mb-0 mt-4 pb-0"
                                    style="gap: 10px">
                                    <a class="btn btn-outline-primary" href="/perencana/evaluasi-iku-unit-kerja/">
                                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                                    </a>
                                    <button class="btn btn-primary float-right" type="submit">
                                        <i class="fas fa-save"></i>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js') }}/page/perencana/evaluasi-iku.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
