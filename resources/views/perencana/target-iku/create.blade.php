@extends('layouts.app')

@section('title', 'Buat Target IKU Unit Kerja')

@push('style')
<link rel="stylesheet" href="{{ asset('library') }}/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('library') }}/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
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

    #jumlah-objek {
        text-align: left;
        padding: 15px !important;
    }
</style>
@endpush

@section('main')
@include('components.perencana-header')
@include('components.perencana-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Pembuatan Target IKU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('perencana.target-iku-unit-kerja.index') }}">Target IKU Unit
                        Kerja</a></div>
                <div class="breadcrumb-item">Buat Target IKU Unit Kerja</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-target" action="{{ route('perencana.target-iku-unit-kerja.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <h1 class="h4 text-dark mb-4 header-card">Data Target IKU</h1>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="nama-kegiatan">Unit Kerja</label>
                                        <div>
                                            <select required style="width:100%" class="select2 unitkerja"
                                                name="unit-kerja" data-placeholder="Pilih Unit kerja"
                                                data-allow-clear="1">
                                                <option></option>
                                                @foreach ($unitKerja as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama-kegiatan">Nama Kegiatan</label>
                                        <div>
                                            <input id="nama-kegiatan" type="text" class="form-control"
                                                name="nama-kegiatan" required placeholder="Isikan Nama Kegiatan IKU">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah-objek">Jumlah Objek</label>
                                        <div>
                                            <input value="1" id="jumlah-objek" type="number" class="form-control"
                                                name="jumlah-objek" required placeholder="Isikan Jumlah Objek" min="1"
                                                max="50">
                                        </div>
                                    </div>
                                    {{-- info --}}
                                    <div class="alert alert-info">
                                        <strong>Info!</strong> Silahkan isi data target IKU sesuai dengan jumlah objek
                                        yang
                                        diinginkan. Jika nilai tidak diisi, maka akan dianggap 0.
                                    </div>
                                    <div class="form-group">
                                        <table class="table table-responsive-md table-bordered" id="table-iku">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center align-middle"
                                                        style="width: 30px;">No</th>
                                                    <th rowspan="2" class="text-center align-middle"
                                                        style="min-width: 250px;">Satuan</th>
                                                    <th rowspan="2" class="text-center align-middle"
                                                        style="width: 75px; min-width:90px">Y</th>
                                                    <th colspan="4" class="text-center align-middle">X (Triwulan)</th>
                                                    <th colspan="4" class="text-center align-middle">Target Kinerja
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
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr id="row-1">
                                                    <td class="text-center align-middle">1</td>
                                                    <td class="text-left">
                                                        <select required class="select2 satuan" name="satuan-row1"
                                                            id="satuan-row1" data-placeholder="Pilih Satuan">
                                                            <option></option>
                                                            @foreach ($masterUnitKerja as $unitKerja)
                                                            <option value="{{ $unitKerja->id_objek }}">
                                                                {{ $unitKerja->nama }}
                                                                @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" min="0" max="20" name="nilai-y-row1"
                                                            id="nilai-y-row1" class="form-control nilai-y"></td>
                                                    <td><input type="number" min="0" max="20" name="triwulan1-row1"
                                                            id="triwulan1-row1" class="form-control triwulan1"></td>
                                                    <td><input type="number" min="0" max="20" name="triwulan2-row1"
                                                            id="triwulan2-row1" class="form-control triwulan2"></td>
                                                    <td><input type="number" min="0" max="20" name="triwulan3-row1"
                                                            id="triwulan3-row1" class="form-control triwulan3"></td>
                                                    <td><input type="number" min="0" max="20" name="triwulan4-row1"
                                                            id="triwulan4-row1" class="form-control triwulan4"></td>

                                                    <td><input disabled type="number" name="target-triwulan1-row1"
                                                            id="target-triwulan1-row1"
                                                            class="form-control target-triwulan1"></td>
                                                    <td><input disabled type="number" name="target-triwulan2-row1"
                                                            id="target-triwulan2-row1"
                                                            class="form-control target-triwulan2"></td>
                                                    <td><input disabled type="number" name="target-triwulan3-row1"
                                                            id="target-triwulan3-row1"
                                                            class="form-control target-triwulan3"></td>
                                                    <td><input disabled type="number" name="target-triwulan4-row1"
                                                            id="target-triwulan4-row1"
                                                            class="form-control target-triwulan4"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    {{-- total --}}
                                                    <td class="text-center align-middle" colspan="2"
                                                        style="text-align: center; font-weight: bold;">
                                                        Total:</td>
                                                    <td><input disabled type="number" name="total-y" id="total-y"
                                                            value="0" class="form-control"></td>
                                                    <td><input disabled type="number" name="total-triwulan1"
                                                            id="total-triwulan1" value="0" class="form-control"></td>
                                                    <td><input disabled type="number" name="total-triwulan2"
                                                            id="total-triwulan2" value="0" class="form-control"></td>
                                                    <td><input disabled type="number" name="total-triwulan3"
                                                            id="total-triwulan3" value="0" class="form-control"></td>
                                                    <td><input disabled type="number" name="total-triwulan4"
                                                            id="total-triwulan4" value="0" class="form-control"></td>

                                                    <td><input disabled type="number" name="target-total-triwulan1"
                                                            id="target-total-triwulan1" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="target-total-triwulan2"
                                                            id="target-total-triwulan2" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="target-total-triwulan3"
                                                            id="target-total-triwulan3" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="target-total-triwulan4"
                                                            id="target-total-triwulan4" value="0" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-weight: bold;" colspan="7">
                                                        Target Kinerja (Persen)</td>
                                                    <td><input disabled type="text" name="presentase-target-triwulan1"
                                                            id="presentase-target-triwulan1" value="0"
                                                            class="form-control text-center"></td>
                                                    <td><input disabled type="text name=" presentase-target-triwulan2"
                                                            id="presentase-target-triwulan2" value="0"
                                                            class="form-control text-center"></td>
                                                    <td><input disabled type="text name=" presentase-target-triwulan3"
                                                            id="presentase-target-triwulan3" value="0"
                                                            class="form-control text-center"></td>
                                                    <td><input disabled type="text name=" presentase-target-triwulan4"
                                                            id="presentase-target-triwulan4" value="0"
                                                            class="form-control text-center"></td>
                                            </tfoot>

                                        </table>
                                        {{-- add button tambah objeck --}}
                                        <div class="form-group
                                            d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" id="add-objek"><i
                                                    class="fa-solid fa-plus mr-1"></i>Tambah
                                                Objek</button>
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="d-flex justify-content-between mt-4">
                                        <div>
                                            <a class="btn btn-outline-primary mr-2"
                                                href="/perencana/target-iku-unit-kerja" id="btn-back2">
                                                <i class="fa-solid fa-arrow-left mr-1"></i>
                                                Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary submit-btn">
                                                <i class="fas fa-save mr-1"></i>
                                                Simpan
                                            </button>
                                        </div>

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
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/page/perencana/create-target-iku.js') }}"></script>
<!-- Latest compiled and minified CSS -->
@endpush
