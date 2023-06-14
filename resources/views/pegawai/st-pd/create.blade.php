@extends('layouts.app')

@section('title', 'Ajukan Usulan ST Perjalanan Dinas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Usulan ST Perjalanan Dinas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-pd">ST Perjalanan Dinas</a></div>
                    <div class="breadcrumb-item">Form Usulan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="/pegawai/st-pd" method="post">
                                    @csrf
                                    <input type="hidden" name="status" value="0">
                                    <div class="form-group">
                                        <div class="control-label">Backdate</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="1"
                                                    class="custom-switch-input"
                                                    {{ old('is_backdate') == '1' ? 'checked' : '' }}
                                                    onchange="toggleBackdateInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_backdate') == '0' ? 'checked' : '' }}
                                                    onchange="toggleBackdateInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="tanggalInputContainer" style="display: none;">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                            @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit_kerja">Unit Kerja</label>
                                        <select id="unit_kerja" name="unit_kerja" class="form-control select2 @error('unit_kerja') is-invalid @enderror">
                                            <option value="">Pilih unit kerja</option>
                                            <option value="8000" {{ old('unit_kerja') == '8000' ? 'selected' : '' }}>Inspektorat Utama</option>
                                            <option value="8010" {{ old('unit_kerja') == '8010' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                            <option value="8100" {{ old('unit_kerja') == '8100' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                            <option value="8200" {{ old('unit_kerja') == '8200' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                            <option value="8300" {{ old('unit_kerja') == '8300' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                        </select>
                                        @error('unit_kerja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="control-label">Bagian dari ST Kinerja</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_st_kinerja"
                                                    value="1"
                                                    class="custom-switch-input"
                                                    {{ old('is_st_kinerja') == '1' ? 'checked' : '' }}
                                                    onchange="toggleStKinerjaInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_st_kinerja"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_st_kinerja') == '0' ? 'checked' : '' }}
                                                    onchange="toggleStKinerjaInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" id="stKinerjaContainer" style="display: none;">
                                        <label for="st_kinerja_id">ST Kinerja</label>
                                        <select class="form-control select2 @error('st_kinerja_id') is-invalid @enderror" id="st_kinerja_id" name="st_kinerja_id">
                                            <option value="">Pilih st kinerja</option>
                                            @foreach ($stks as $stk)
                                                <option value="{{ $stk->id }}" {{ old('st_kinerja_id') == $stk->id ? 'selected' : '' }}>{{ $stk->no_surat }}</option>
                                            @endforeach
                                        </select>
                                        @error('st_kinerja_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="melaksanakan">Untuk melaksanakan</label>
                                        <input type="text" class="form-control @error('melaksanakan') is-invalid @enderror" id="melaksanakan" name="melaksanakan" value="{{ old('melaksanakan') }}">
                                        @error('melaksanakan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kota">Kota Tujuan</label>
                                        <input type="text" class="form-control @error('kota') is-invalid @enderror" id="kota" name="kota" value="{{ old('kota') }}">
                                        @error('kota')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Mulai</label>
                                        <input type="date" class="form-control @error('mulai') is-invalid @enderror" name="mulai" value="{{ old('mulai') }}">
                                        @error('mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Selesai</label>
                                        <input type="date" class="form-control @error('selesai') is-invalid @enderror" name="selesai" value="{{ old('selesai') }}">
                                        @error('selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pelaksana">Pelaksana</label>
                                        <select id="pelaksana" name="pelaksana[]" class="form-control select2 @error('pelaksana') is-invalid @enderror" multiple="multiple">
                                            <option value="">Pilih Pelaksana</option>
                                            @foreach ($user as $pelaksana)
                                                <option value="{{ $pelaksana->id }}" {{ old('pelaksana') == $pelaksana->id ? 'selected' : '' }}>{{ $pelaksana->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('pelaksana')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pembebanan_id">Pembebanan</label>
                                        <select class="form-control select2 @error('pembebanan_id') is-invalid @enderror" id="pembebanan_id" name="pembebanan_id">
                                            <option value="">Pilih pembebanan</option>
                                            @foreach ($pembebanans as $pembebanan)
                                                <option value="{{ $pembebanan->id }}" {{ old('pembebanan_id') == $pembebanan->id ? 'selected' : '' }}>{{ $pembebanan->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('pembebanan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="control-label">E-Sign</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="1"
                                                    class="custom-switch-input"
                                                    {{ old('is_esign') == '1' ? 'checked' : '' }}
                                                    onchange="toggleEsignInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_esign') == '0' ? 'checked' : '' }}
                                                    onchange="toggleEsignInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="penandatanganContainer" style="display: none;" class="form-group">
                                        <label for="penandatangan">Penanda tangan</label>
                                        <select class="form-control select2 @error('penandatangan') is-invalid @enderror" id="penandatangan" name="penandatangan">
                                            <option value="">Pilih penanda tangan</option>
                                            @foreach ($pimpinanAktif as $pimpinan)
                                                <option value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan') == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $pimpinan->jabatan }}] {{ $pimpinan->user->name }}</option>
                                            @endforeach
                                            
                                            @foreach ($pimpinanNonaktif as $pimpinan)
                                                <option class="pimpinanNonaktif" value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan') == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $pimpinan->jabatan }}] {{ $pimpinan->user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('penandatangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        function toggleBackdateInput(input) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
            var pimpinanNonaktif = document.getElementsByClassName("pimpinanNonaktif");
    
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
                for (var i = 0; i < pimpinanNonaktif.length; i++) {
                    pimpinanNonaktif[i].setAttribute("disabled", "disabled");
                }
            } else {
                tanggalInputContainer.style.display = 'none';
                for (var i = 0; i < pimpinanNonaktif.length; i++) {
                    pimpinanNonaktif[i].removeAttribute("disabled");
                }
            }
        }

        function toggleEsignInput(input) {
            var penandatanganContainer = document.getElementById('penandatanganContainer');
    
            if (input.value === '1') {
                penandatanganContainer.style.display = 'block';
            } else {
                penandatanganContainer.style.display = 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#pp_id").on("change", function() {
                const ppId = $(this).val();
                if(ppId == 1 || ppId == 2 || ppId == 3){
                    $.ajax({
                    url: `/get-nama-pp-by-pp`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        pp_id: ppId
                    },
                    dataType: "json",
                    success: (data) => {
                        $("#div_nama_pp").empty();
                        $("#div_nama_pp").append(`<label for="nama_pp">Nama Pengembangan Profesi</label>
                                        <select id="nama_pp" required class="form-control select2" name="nama_pp">
                                            <option value="">Pilih nama pengembangan profesi</option>
                                        </select>`);

                        data.namaPp.forEach(element => {
                            $("#nama_pp").append(
                                `<option value="${element.nama}">${element.nama}</option>`
                            );
                        });
                        // console.log(data);
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                    }
                });
                } else {
                    $("#div_nama_pp").empty();
                    $("#div_nama_pp").append(`<label for="nama_pp">Nama Pengembangan Profesi</label><input type="text" class="form-control" id="nama_pp_text" name="nama_pp">`);
                }
            });
        });
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush