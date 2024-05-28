@extends('layouts.app')

@section('title', 'Edit Target IKU Unit Kerja')

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
            <h1>Form Ubah Target IKU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('target-iku-unit-kerja.index') }}">Target IKU Unit
                        Kerja</a></div>
                <div class="breadcrumb-item">Ubah Target IKU Unit Kerja</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h4 text-dark mb-4 header-card">Data Target IKU</h1>
                            <form action="{{ route('target-iku-unit-kerja.update', $targetIkuUnitKerja->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="form-group col">
                                        <label for="unit-kerja">Unit Kerja</label>
                                        <div>
                                            <select class="form-control" name="unit-kerja"
                                                data-placeholder="Pilih Unit kerja" data-allow-clear="1">
                                                @foreach ($unitKerja as $key => $value)
                                                <option {{ $targetIkuUnitKerja->unit_kerja == $key ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="nama-kegiatan">Nama Kegiatan</label>
                                        <div>
                                            <input value="{{ $targetIkuUnitKerja->nama_kegiatan }}" id="nama-kegiatan"
                                                type="text" class="form-control" name="nama-kegiatan" required
                                                placeholder="Isikan Nama Kegiatan IKU">
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="jumlah-objek">Jumlah Objek</label>
                                        <div>
                                            <input value="{{ intval($targetIkuUnitKerja->jumlah_objek) }}"
                                                id="jumlah-objek" type="number" class="form-control" name="jumlah-objek"
                                                required placeholder="Isikan Jumlah Objek">
                                        </div>
                                    </div>
                                    <div class="form-group col">
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
                                                @foreach ($objekIkuUnitKerja as $key => $value)
                                                <tr id="row-1">
                                                    <td class="text-center align-middle">{{ $key+1 }}</td>
                                                    <td class="text-left">
                                                        <select required class="select2 satuan"
                                                            name="satuan-row{{ $loop->iteration }}"
                                                            id="satuan-row{{ $loop->iteration }}"
                                                            data-placeholder="Pilih Satuan">
                                                            <option></option>
                                                            @foreach ($masterUnitKerja as $unitKerja)
                                                            <option
                                                                {{ $value->id_objek == $unitKerja->id_objek ? 'selected' : '' }}
                                                                value="{{ $unitKerja->id_objek }}">
                                                                {{ $unitKerja->nama }}
                                                                @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input value="{{ $value->nilai_y_target }}" type="number"
                                                            name="nilai-y-row{{ $loop->iteration }}" id="nilai-y-row1"
                                                            class="form-control nilai-y"></td>
                                                    <td><input value="{{ $value->target_triwulan_1 }}" type="number"
                                                            name="triwulan1-row{{ $loop->iteration }}"
                                                            id="{{ 'triwulan1-row'.$loop->iteration }}"
                                                            class="form-control triwulan{{ $loop->iteration }}"></td>
                                                    <td><input value="{{ $value->target_triwulan_2 }}" type="number"
                                                            name="triwulan2-row{{ $loop->iteration }}"
                                                            id="{{ 'triwulan2-row'.$loop->iteration }}"
                                                            class="form-control triwulan2"></td>
                                                    <td><input value="{{ $value->target_triwulan_3 }}" type="number"
                                                            name="triwulan3-row{{ $loop->iteration }}"
                                                            id="{{ 'triwulan3-row'.$loop->iteration }}"
                                                            class="form-control triwulan3"></td>
                                                    <td><input value="{{ $value->target_triwulan_4 }}" type="number"
                                                            name="triwulan4-row{{ $loop->iteration }}"
                                                            id="{{ 'triwulan4-row'.$loop->iteration }}"
                                                            class="form-control triwulan4"></td>

                                                    <td><input disabled type="number" name="target-triwulan1-row1"
                                                            id="{{ 'target-triwulan1-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan1"></td>
                                                    <td><input disabled type="number" name="target-triwulan2-row1"
                                                            id="{{ 'target-triwulan2-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan2"></td>
                                                    <td><input disabled type="number" name="target-triwulan3-row1"
                                                            id="{{ 'target-triwulan3-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan3"></td>
                                                    <td><input disabled type="number" name="target-triwulan4-row1"
                                                            id="{{ 'target-triwulan4-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan4"></td>
                                                </tr>
                                                @endforeach
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
                                                            id="total-triwulan1" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="total-triwulan2"
                                                            id="total-triwulan2" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="total-triwulan3"
                                                            id="total-triwulan3" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="total-triwulan4"
                                                            id="total-triwulan4" value="0" class="form-control">
                                                    </td>

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
                                                    <td><input disabled type="text" name="presentase-target-triwulan2"
                                                            id="presentase-target-triwulan2" value="0"
                                                            class="form-control text-center"></td>
                                                    <td><input disabled type="text" name="presentase-target-triwulan3"
                                                            id="presentase-target-triwulan3" value="0"
                                                            class="form-control text-center"></td>
                                                    <td><input disabled type="text" name="presentase-target-triwulan4"
                                                            id="presentase-target-triwulan4" value="0"
                                                            class="form-control text-center"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" id="add-objek">Tambah
                                            Objek</button>
                                    </div>
                                    <hr class="my-1">

                                    <div class="d-flex justify-content-between mt-4">
                                        <div>
                                            <a class="btn btn-outline-primary mr-2"
                                                href="/perencana/target-iku-unit-kerja/{{ $targetIkuUnitKerja->id }}"
                                                id="btn-back2">
                                                <i class="fa-solid fa-arrow-left mr-1"></i>
                                                Kembali
                                            </a>
                                            <button class="btn btn-primary">
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
{{-- <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>d --}}

<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/page/perencana/create-target-iku.js') }}"></script>
<script>
    // when submit form remove disabled attribute
    $('form').submit(function() {
        $('select').prop('disabled', false);
        $('input').prop('disabled', false);
    });
</script>
<!-- Latest compiled and minified CSS -->
@endpush