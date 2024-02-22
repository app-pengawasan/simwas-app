@extends('layouts.app')

@section('title', 'Form Evaluasi IKU')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library') }}/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
@include('components.header')
@include('components.perencana-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Evaluasi IKU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Form Evaluasi IKU</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('evaluasi-iku-unit-kerja.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col">
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
                                <div class="form-group col">
                                    <label for="nama-kegiatan">Nama Kegiatan</label>
                                    <div>
                                        <input disabled value="{{ $targetIkuUnitKerja->nama_kegiatan }}"
                                            id="nama-kegiatan" type="text" class="form-control" name="nama-kegiatan"
                                            required placeholder="Isikan Nama Kegiatan IKU">
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label for="jumlah-objek">Jumlah Objek</label>
                                    <div>
                                        <input type="hidden" name="jumlah_objek"
                                            value="{{ $targetIkuUnitKerja->jumlah_objek }}">
                                        <input disabled value="{{ intval($targetIkuUnitKerja->jumlah_objek) }}"
                                            id="jumlah-objek" type="number" class="form-control" name="jumlah-objek"
                                            required placeholder="Isikan Jumlah Objek">
                                    </div>
                                </div>
                                <div class="d-lg-flex flex-lg-row px-3 my-3 overflow-auto">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th colspan="5">
                                                    <h5 class="text-center">Target</h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="text-center align-middle">Y
                                                </th>
                                                <th colspan="4" class="text-center align-middle">X</th>
                                            </tr>
                                            <tr style="font-size: 0.8em;">
                                                <th class="text-center align-middle">Triwulan
                                                    1</th>
                                                <th class="text-center align-middle">Triwulan
                                                    2</th>
                                                <th class="text-center align-middle">Triwulan
                                                    3</th>
                                                <th class="text-center align-middle">Triwulan
                                                    4</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="row-1">
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th colspan="5">
                                                    <h5 class="text-center">Realisasi</h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-center align-middle">X</th>
                                            </tr>
                                            <tr style="font-size: 0.8em;">
                                                <th class="text-center align-middle">Triwulan
                                                    1</th>
                                                <th class="text-center align-middle">Triwulan
                                                    2</th>
                                                <th class="text-center align-middle">Triwulan
                                                    3</th>
                                                <th class="text-center align-middle">Triwulan
                                                    4</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="row-1">
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th colspan="5">
                                                    <h5 class="text-center">Capaian Kinerja</h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-center align-middle">X</th>
                                            </tr>
                                            <tr style="font-size: 0.8em;">
                                                <th class="text-center align-middle">Triwulan
                                                    1</th>
                                                <th class="text-center align-middle">Triwulan
                                                    2</th>
                                                <th class="text-center align-middle">Triwulan
                                                    3</th>
                                                <th class="text-center align-middle">Triwulan
                                                    4</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="row-1">
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                                <td>21</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                {{-- create table with no, Satuan = Select Option, Y=number, Triwulan 1 =number, Triwulan 2 =number , Triwulan 3 =number, Triwulan 4 =number--}}
                                <div class="form-group col">
                                    <label for="kendala">Kendala</label>
                                    <input id="kendala" type="text" class="form-control" name="kendala" required
                                        placeholder="Isikan kendala yang dihadapi">
                                </div>
                                <div class="form-group col">
                                    <label for="solusi">Solusi</label>
                                    <input id="solusi" type="text" class="form-control" name="solusi" required
                                        placeholder="Masukkan solusi">
                                </div>
                                <div class="form-group col">
                                    <label for="tindak_lanjut">Tindak Lanjut</label>
                                    <input id="tindak_lanjut" type="text" class="form-control" name="tindak_lanjut"
                                        required placeholder="Masukkan tindak lanjut">
                                </div>
                                <div class="form-group col">
                                    <label for="pic_tindak_lanjut">PIC Tindak Lanjut</label>
                                    <select name="pic_tindak_lanjut" id="pic_tindak_lanjut" class="form-control">
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="batas_waktu">Batas Waktu Tindak Lanjut</label>
                                    <input type="date" class="form-control" name="batas_waktu" id="batas_waktu"
                                        required>
                                </div>
                                <div class="form-group col">
                                    <label for="bukti_tindak_lanjut">Bukti Tindak Lanjut</label>
                                    <input id="bukti_tindak_lanjut" type="text" class="form-control"
                                        name="bukti_tindak_lanjut" required placeholder="Masukkan bukti tindak lanjut">
                                </div>
                                <div class="form-group col">
                                    <label for="link_bukti_tindak_lanjut">Link Bukti Tindak Lanjut</label>
                                    <input id="link_bukti_tindak_lanjut" type="text" class="form-control"
                                        name="link_bukti_tindak_lanjut" required
                                        placeholder="Masukkan link/tautan bukti tindak lanjut, contoh : https://www.bukti-pendukung.com">
                                </div>
                                {{-- file upload  undangan (pdf) --}}
                                <div class="form-group col">
                                    <label for="undangan">Dokumen Undangan</label>
                                    <input type="file" class="form-control" name="undangan" id="undangan" required
                                        accept="application/pdf">
                                </div>
                                {{-- daftar hadir pdf --}}
                                <div class="form-group col">
                                    <label for="daftar_hadir">Dokumen Daftar Hadir</label>
                                    <input type="file" class="form-control" name="daftar_hadir" id="daftar_hadir"
                                        required accept="application/pdf">
                                </div>
                                {{-- notulen --}}
                                <div class="form-group col">
                                    <label for="notulen">Dokumen Notulen</label>
                                    <input type="file" class="form-control" name="notulen" id="notulen" required
                                        accept="application/pdf">
                                </div>
                                {{-- laporan kinerja --}}
                                <div class="form-group col">
                                    <label for="laporan_kinerja">Dokumen Laporan Kinerja</label>
                                    <input type="file" class="form-control" name="laporan_kinerja" id="laporan_kinerja"
                                        required accept="application/pdf">
                                </div>
                                <button class="btn btn-primary" type="submit">Button</button>
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

<script>
    // add table row if same as jumlah objek

    function toggleBackdateInput(input) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');

            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
            } else {
                tanggalInputContainer.style.display = 'none';
            }
        }
</script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
