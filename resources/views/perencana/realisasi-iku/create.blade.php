@extends('layouts.app')

@section('title', 'Ajukan Usulan Surat Lain')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Pembuatan Target IKU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Form Pembuatan Target IKU</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="/" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col">
                                    <label for="nama-kegiatan">Nama Kegiatan</label>
                                    <div>
                                        <input disabled value="Kegiatan Nomor 1" id="nama-kegiatan" type="text"
                                            class="form-control" name="nama-kegiatan" required
                                            placeholder="Isikan Nama Kegiatan IKU">
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label for="jumlah-objek">Jumlah Objek</label>
                                    <div>
                                        <input disabled value="21" id="jumlah-objek" type="number" class="form-control"
                                            name="jumlah-objek" required placeholder="Isikan Jumlah Objek">
                                    </div>
                                </div>
                                <div class="form-group">

                                    {{-- create table with no, Satuan = Select Option, Y=number, Triwulan 1 =number, Triwulan 2 =number , Triwulan 3 =number, Triwulan 4 =number--}}
                                    <div class="form-group col">
                                        <table class="table table-responsive-md table-bordered">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center align-middle"
                                                        style="width: 50px;">No</th>
                                                    <th rowspan="2" class="text-center align-middle"
                                                        style="min-width: 200px;">Satuan</th>
                                                    <th rowspan="2" class="text-center align-middle"
                                                        style="width: 120px;">Y</th>
                                                    <th colspan="4" class="text-center align-middle">X</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center align-middle" style="width: 120px;">Triwulan
                                                        1</th>
                                                    <th class="text-center align-middle" style="width: 120px;">Triwulan
                                                        2</th>
                                                    <th class="text-center align-middle" style="width: 120px;">Triwulan
                                                        3</th>
                                                    <th class="text-center align-middle" style="width: 120px;">Triwulan
                                                        4</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= 10; $i++) <tr id="row-{{ $i }}">
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td>
                                                        <select name="satuan" id="satuan" class="form-control">
                                                            @foreach ($kabupaten as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="nilai-y-row{{ $i }}"
                                                            id="nilai-y-row{{ $i }}" class="form-control"></td>
                                                    <td><input type="number" name="triwulan1" id="triwulan1-row{{ $i }}"
                                                            class="form-control"></td>
                                                    <td><input type="number" name="triwulan2" id="triwulan2-row{{ $i }}"
                                                            class="form-control"></td>
                                                    <td><input type="number" name="triwulan3" id="triwulan3-row{{ $i }}"
                                                            class="form-control"></td>
                                                    <td><input type="number" name="triwulan4" id="triwulan4-row{{ $i }}"
                                                            class="form-control"></td>
                                                    </tr>
                                                    @endfor
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
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <div class="form-group col">
                                        <label for="catatan">Catatan</label>
                                        <div>
                                            <textarea class="form-control" id="catatan" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col table table-borderless">
                                        <label for="catatan">Dokumen AKIP</label>
                                        <table>
                                            <tr>
                                                <td class="text-center align-middle"> 1 </td>
                                                <td class="align-middle"> Undangan </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile">
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center align-middle"> 2 </td>
                                                <td class="align-middle"> Daftar Hadir </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile">
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center align-middle"> 3 </td>
                                                <td class="align-middle"> Notulen </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile">
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center align-middle"> 4 </td>
                                                <td class="align-middle"> Laporan Kinerja </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile">
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
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
