@extends('layouts.app')

@section('title', 'Buat Realisasi IKU Unit Kerja')

@push('style')
<!-- CSS Libraries -->
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
    {{-- Modal --}}
    <div class="modal fade" id="targetIKU" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="targetIKULabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="targetIKULabel">Target IKU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-scroll">
                    <div class="form-group overflow-scroll">
                        <table class="table table-responsive-md table-bordered overflow-scroll" id="table-iku">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle" style="width: 30px;">No</th>
                                    <th rowspan="2" class="text-center align-middle" style="min-width: 250px;">Satuan
                                    </th>
                                    <th rowspan="2" class="text-center align-middle"
                                        style="width: 75px; min-width:90px">Y
                                    </th>
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
                                        <select disabled class="form-control" name="{{ 'satuan-row'.$loop->iteration }}"
                                            class="satuan">
                                            <option value="{{ $value->id_objek }}">{{ $value->master_objeks->nama
                                                                                                            }}</option>
                                        </select>
                                    </td>
                                    <td><input disabled value="{{ $value->nilai_y_target }}" type="number"
                                            name="{{ 'nilai-y-row'.$loop->iteration }}"
                                            id="{{ 'tgt-nilai-y-row'.$loop->iteration }}"
                                            class="form-control tgt-nilai-y">
                                    </td>
                                    <td><input disabled value="{{ $value->target_triwulan_1 }}" type="number"
                                            name="{{ 'triwulan1-row'.$loop->iteration }}"
                                            id="{{ 'tgt-triwulan1-row'.$loop->iteration }}"
                                            class="form-control tgt-triwulan1">
                                    </td>
                                    <td><input disabled value="{{ $value->target_triwulan_2 }}" type="number"
                                            name="{{ 'triwulan2-row'.$loop->iteration }}"
                                            id="{{ 'tgt-triwulan2-row'.$loop->iteration }}"
                                            class="form-control tgt-triwulan2">
                                    </td>
                                    <td><input disabled value="{{ $value->target_triwulan_3 }}" type="number"
                                            name="{{ 'triwulan3-row'.$loop->iteration }}"
                                            id="{{ 'tgt-triwulan3-row'.$loop->iteration }}"
                                            class="form-control tgt-triwulan3">
                                    </td>
                                    <td><input disabled value="{{ $value->target_triwulan_4 }}" type="number"
                                            name="{{ 'triwulan4-row'.$loop->iteration }}"
                                            id="{{ 'tgt-triwulan4-row'.$loop->iteration }}"
                                            class="form-control tgt-triwulan4">
                                    </td>

                                    <td><input disabled type="number" name="target-triwulan1-row1"
                                            id="{{ 'tgt-target-triwulan1-row'.$loop->iteration }}"
                                            class="form-control tgt-target-triwulan1"></td>
                                    <td><input disabled type="number" name="target-triwulan2-row1"
                                            id="{{ 'tgt-target-triwulan2-row'.$loop->iteration }}"
                                            class="form-control tgt-target-triwulan2"></td>
                                    <td><input disabled type="number" name="target-triwulan3-row1"
                                            id="{{ 'tgt-target-triwulan3-row'.$loop->iteration }}"
                                            class="form-control tgt-target-triwulan3"></td>
                                    <td><input disabled type="number" name="target-triwulan4-row1"
                                            id="{{ 'tgt-target-triwulan4-row'.$loop->iteration }}"
                                            class="form-control tgt-target-triwulan4"></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    {{-- total --}}
                                    <td class="text-center align-middle" colspan="2"
                                        style="text-align: center; font-weight: bold;">
                                        Total:</td>
                                    <td><input disabled type="number" name="total-y" id="tgt-total-y"
                                            class="form-control">
                                    </td>
                                    <td><input disabled type="number" name="total-triwulan1" id="tgt-total-triwulan1"
                                            value="0" class="form-control"></td>
                                    <td><input disabled type="number" name="total-triwulan2" id="tgt-total-triwulan2"
                                            value="0" class="form-control"></td>
                                    <td><input disabled type="number" name="total-triwulan3" id="tgt-total-triwulan3"
                                            value="0" class="form-control"></td>
                                    <td><input disabled type="number" name="total-triwulan4" id="tgt-total-triwulan4"
                                            value="0" class="form-control"></td>

                                    <td><input disabled type="number" name="target-total-triwulan1"
                                            id="tgt-target-total-triwulan1" value="0" class="form-control">
                                    </td>
                                    <td><input disabled type="number" name="target-total-triwulan2"
                                            id="tgt-target-total-triwulan2" value="0" class="form-control">
                                    </td>
                                    <td><input disabled type="number" name="target-total-triwulan3"
                                            id="tgt-target-total-triwulan3" value="0" class="form-control">
                                    </td>
                                    <td><input disabled type="number" name="target-total-triwulan4"
                                            id="tgt-target-total-triwulan4" value="0" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold;" colspan="7">
                                        Target Kinerja (Persen)</td>
                                    <td><input disabled type="number" name="presentase-target-triwulan1"
                                            id="tgt-presentase-target-triwulan1" value="0" class="form-control"></td>
                                    <td><input disabled type="number" name="presentase-target-triwulan2"
                                            id="tgt-presentase-target-triwulan2" value="0" class="form-control"></td>
                                    <td><input disabled type="number" name="presentase-target-triwulan3"
                                            id="tgt-presentase-target-triwulan3" value="0" class="form-control"></td>
                                    <td><input disabled type="number" name="presentase-target-triwulan4"
                                            id="tgt-presentase-target-triwulan4" value="0" class="form-control"></td>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
    <section class="section">
        <div class="section-header">
            <h1>Buat Realisasi IKU Unit Kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('realisasi-iku-unit-kerja.index') }}">Realisasi
                        IKU Unit Kerja</a></div>
                <div class="breadcrumb-item">Buat Realisasi IKU Unit Kerja</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <h1 class="h4 text-dark mb-4 header-card">Data Realisasi IKU Unit Kerja</h1>
                            <form action="{{ route('realisasi-iku-unit-kerja.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
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
                                    <div class="form-group">
                                        <label for="catatan">Catatan</label>
                                        <div>
                                            <input value="{{ $realisasiIkuUnitKerja->catatan ?? '' }}" id="catatan"
                                                type="text" class="form-control" name="catatan" required
                                                placeholder="Isikan Dengan catatan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="catatan">Dokumen Sumber</label>
                                        <div>
                                            <input id="dokumen_sumber" type="file" class="form-control"
                                                name="dokumen_sumber" required accept="application/pdf">
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#targetIKU"><i class="fa-solid fa-circle-info mr-1"></i>
                                            Lihat Target
                                            IKU</button>
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
                                                    <th colspan="4" class="text-center align-middle">X (Triwulan)
                                                    </th>
                                                    <th colspan="4" class="text-center align-middle">Realisasi
                                                        Kinerja
                                                        (Triwulan)</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center align-middle" style="min-width: 80px;">1
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">2
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">3
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">4
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">1
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">2
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">3
                                                    </th>
                                                    <th class="text-center align-middle" style="min-width: 80px;">4
                                                    </th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                @foreach ($objekIkuUnitKerja as $key => $value)
                                                <tr id="row-1">
                                                    <td class="text-center align-middle">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="text-left">
                                                        <input type="hidden" name="{{ 'id_objek'.$loop->iteration }}"
                                                            value="{{ $value->id }}">
                                                        <select disabled class="form-control" name="satuan-row1"
                                                            class="satuan">
                                                            <option value="{{ $value->id_objek }}">
                                                                {{ $value->master_objeks->nama
                                                                                                                            }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td><input min="0" max="20" value="{{ $value->nilai_y_realisasi }}"
                                                            type="number" name="{{ 'nilai-y-row'.$loop->iteration }}"
                                                            id="{{ 'nilai-y-row'.$loop->iteration }}"
                                                            class="form-control nilai-y">
                                                    </td>
                                                    <td><input min="0" max="20" type="number"
                                                            value="{{ $value->realisasi_triwulan_1 }}"
                                                            name="{{ 'triwulan1-row'.$loop->iteration }}"
                                                            id="{{ 'triwulan1-row'.$loop->iteration }}"
                                                            class="form-control triwulan1"></td>
                                                    <td><input min="0" max="20" type="number"
                                                            value="{{ $value->realisasi_triwulan_2 }}"
                                                            name="{{ 'triwulan2-row'.$loop->iteration }}"
                                                            id="{{ 'triwulan2-row'.$loop->iteration }}"
                                                            class="form-control triwulan2"></td>
                                                    <td><input min="0" max="20" type="number"
                                                            value="{{ $value->realisasi_triwulan_3 }}"
                                                            name="{{ 'triwulan3-row'.$loop->iteration }}"
                                                            id="{{ 'triwulan3-row'.$loop->iteration }}"
                                                            class="form-control triwulan3"></td>
                                                    <td><input min="0" max="20" type="number"
                                                            value="{{ $value->realisasi_triwulan_4 }}"
                                                            name="{{ 'triwulan4-row'.$loop->iteration }}"
                                                            id="{{ 'triwulan4-row'.$loop->iteration }}"
                                                            class="form-control triwulan4"></td>

                                                    <td><input disabled type="number"
                                                            name="{{ 'target-triwulan1-row'.$loop->iteration }}"
                                                            id="{{ 'target-triwulan1-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan1"></td>
                                                    <td><input disabled type="number"
                                                            name="{{ 'target-triwulan2-row'.$loop->iteration }}"
                                                            id="{{ 'target-triwulan2-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan2"></td>
                                                    <td><input disabled type="number"
                                                            name="{{ 'target-triwulan3-row'.$loop->iteration }}"
                                                            id="{{ 'target-triwulan3-row'.$loop->iteration }}"
                                                            class="form-control target-triwulan3"></td>
                                                    <td><input disabled type="number"
                                                            name="{{ 'target-triwulan4-row'.$loop->iteration }}"
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
                                                            value="0" class="form-control">
                                                    </td>
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
                                                    <td style="text-align: center; font-weight: bold;" colspan="7"
                                                        rowspan="2">
                                                        Realisasi Kinerja</td>
                                                    <td><input disabled type="number" name="satuan-target-triwulan1"
                                                            id="satuan-target-triwulan1" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="satuan-target-triwulan2"
                                                            id="satuan-target-triwulan2" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="satuan-target-triwulan3"
                                                            id="satuan-target-triwulan3" value="0" class="form-control">
                                                    </td>
                                                    <td><input disabled type="number" name="satuan-target-triwulan4"
                                                            id="satuan-target-triwulan4" value="0" class="form-control">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><input disabled type="number" name="presentase-target-triwulan1"
                                                            id="presentase-target-triwulan1" value="0"
                                                            class="form-control"></td>
                                                    <td><input disabled type="number" name="presentase-target-triwulan2"
                                                            id="presentase-target-triwulan2" value="0"
                                                            class="form-control"></td>
                                                    <td><input disabled type="number" name="presentase-target-triwulan3"
                                                            id="presentase-target-triwulan3" value="0"
                                                            class="form-control"></td>
                                                    <td><input disabled type="number" name="presentase-target-triwulan4"
                                                            id="presentase-target-triwulan4" value="0"
                                                            class="form-control"></td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                        {{-- add button tambah objeck --}}
                                        {{-- <div class="form-group
                                                                        d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" id="add-objek">Tambah
                                                Objek</button>
                                        </div> --}}

                                    </div>
                                    <div class="d-flex justify-content-start align-content-end mb-0 mt-4 pb-0"
                                        style="gap: 10px">
                                        <a class="btn btn-outline-primary" href="/perencana/realisasi-iku-unit-kerja/">
                                            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                                        </a>

                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i>
                                            Simpan</button>
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
<script src="{{ asset('js/page/perencana/create-realisasi-iku.js') }}"></script>
@endpush
