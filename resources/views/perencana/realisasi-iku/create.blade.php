@extends('layouts.app')

@section('title', 'Realisasi IKU Unit Kerja')

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
    <section class="section">
        <div class="section-header">
            <h1>Realisasi IKU Unit Kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Realisasi IKU Unit Kerja</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <form action="{{ route('perencana.target-iku-unit-kerja.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group col">
                                        <label for="nama-kegiatan">Unit Kerja</label>
                                        <div>
                                            <select disabled name="unit-kerja" class="form-control">
                                                @foreach ($unitKerja as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="nama-kegiatan">Nama Kegiatan</label>
                                        <div>
                                            <input disabled id="nama-kegiatan" type="text" class="form-control"
                                                name="nama-kegiatan" required placeholder="Isikan Nama Kegiatan IKU">
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="jumlah-objek">Jumlah Objek</label>
                                        <div>
                                            <input disabled id="jumlah-objek" type="number" class="form-control"
                                                name="jumlah-objek" required placeholder="Isikan Jumlah Objek">
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="catatan">Catatan</label>
                                        <div>
                                            <input id="catatan" type="text" class="form-control" name="catatan" required
                                                placeholder="Isikan Dengan catatan">
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="catatan">Dokumen Sumber</label>
                                        <div>
                                            <input id="catatan" type="file" class="form-control" name="catatan"
                                                required>
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
                                                    <th colspan="4" class="text-center align-middle">Realisasi Kinerja
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
                                                    <td>
                                                        <select name="satuan-row1" class="form-control satuan">
                                                            @foreach ($kabupaten as $key => $value)
                                                            <option value="{{ $value }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="nilai-y-row1" id="nilai-y-row1"
                                                            class="form-control nilai-y">
                                                    </td>
                                                    <td><input type="number" name="triwulan1-row1" id="triwulan1-row1"
                                                            class="form-control triwulan1"></td>
                                                    <td><input type="number" name="triwulan2-row1" id="triwulan2-row1"
                                                            class="form-control triwulan2"></td>
                                                    <td><input type="number" name="triwulan3-row1" id="triwulan3-row1"
                                                            class="form-control triwulan3"></td>
                                                    <td><input type="number" name="triwulan4-row1" id="triwulan4-row1"
                                                            class="form-control triwulan4"></td>

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
                                                            value="0" class="form-control">
                                                    </td>
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
                                        <div class="form-group
                                                                        d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" id="add-objek">Tambah
                                                Objek</button>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-success">Submit</button>
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
