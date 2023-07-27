@extends('layouts.app')

@section('title', 'Edit Usulan ST Perjalanan Dinas')

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
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Usulan ST Perjalanan Dinas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/inspektur/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/inspektur/st-pd">ST Perjalanan Dinas</a></div>
                    <div class="breadcrumb-item">Edit Usulan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $selectedPelaksana = old('pelaksana', explode(', ', $usulan->pelaksana));
                                @endphp
                                <form action="/inspektur/st-pd/{{ $usulan->id }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="status" value="2">
                                    <input type="hidden" name="edit" value="1">
                                    <input type="hidden" name="id" value="{{ $usulan->id }}">
                                    <div class="form-group">
                                        <label class="d-block">Backdate</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                name="is_backdate"
                                                value="1"
                                                {{ old('is_backdate', $usulan->is_backdate) == '1' ? 'checked' : '' }}
                                                onchange="toggleBackdateInput(this)"
                                                id="is_backdate_ya"
                                                class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="is_backdate_ya">Ya</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                name="is_backdate"
                                                value="0"
                                                {{ old('is_backdate', $usulan->is_backdate) == '0' ? 'checked' : '' }}
                                                onchange="toggleBackdateInput(this)"
                                                id="is_backdate_tidak"
                                                class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="is_backdate_tidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div id="tanggalInputContainer" style="display: none;">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', $usulan->tanggal) }}">
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
                                            <option value="8000" {{ old('unit_kerja', $usulan->unit_kerja) == '8000' ? 'selected' : '' }}>Inspektorat Utama</option>
                                            <option value="8010" {{ old('unit_kerja', $usulan->unit_kerja) == '8010' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                            <option value="8100" {{ old('unit_kerja', $usulan->unit_kerja) == '8100' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                            <option value="8200" {{ old('unit_kerja', $usulan->unit_kerja) == '8200' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                            <option value="8300" {{ old('unit_kerja', $usulan->unit_kerja) == '8300' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                        </select>
                                        @error('unit_kerja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="control-label">Bagian dari ST Kinerja</div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                name="is_st_kinerja"
                                                value="1"
                                                {{ old('is_st_kinerja', $usulan->is_st_kinerja) == '1' ? 'checked' : '' }}
                                                onchange="toggleStKinerjaInput(this)"
                                                id="is_st_kinerja_ya"
                                                class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="is_st_kinerja_ya">Ya</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                name="is_st_kinerja"
                                                value="0"
                                                {{ old('is_st_kinerja', $usulan->is_st_kinerja) == '0' ? 'checked' : '' }}
                                                onchange="toggleStKinerjaInput(this)"
                                                id="is_st_kinerja_tidak"
                                                class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="is_st_kinerja_tidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="form-group" id="stKinerjaContainer" style="display: none;">
                                        <label for="st_kinerja_id">ST Kinerja</label>
                                        <select class="form-control select2 @error('st_kinerja_id') is-invalid @enderror" id="st_kinerja_id" name="st_kinerja_id">
                                            <option value="">Pilih st kinerja</option>
                                            @foreach ($stks as $stk)
                                                <option value="{{ $stk->id }}" {{ old('st_kinerja_id', $usulan->st_kinerja_id) == $stk->id ? 'selected' : '' }}>{{ $stk->no_surat }}</option>
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
                                        <input type="text" class="form-control @error('melaksanakan') is-invalid @enderror" id="melaksanakan" name="melaksanakan" value="{{ old('melaksanakan', $usulan->melaksanakan) }}">
                                        @error('melaksanakan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kota">Kota tujuan</label>
                                        <input type="text" class="form-control @error('kota') is-invalid @enderror" id="kota" name="kota" value="{{ old('kota', $usulan->kota) }}">
                                        @error('kota')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Mulai</label>
                                        <input type="date" class="form-control @error('mulai') is-invalid @enderror" name="mulai" value="{{ old('mulai', $usulan->mulai) }}">
                                        @error('mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Selesai</label>
                                        <input type="date" class="form-control @error('selesai') is-invalid @enderror" name="selesai" value="{{ old('selesai', $usulan->selesai) }}">
                                        @error('selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pelaksana">Pelaksana</label>
                                        <select id="pelaksana" name="pelaksana[]" class="form-control select2 @error('pelaksana') is-invalid @enderror" multiple="multiple">
                                            <option value="">Pilih pelaksana</option>
                                            @foreach ($user as $pelaksana)
                                                <option value="{{ $pelaksana->id }}" {{ in_array($pelaksana->id, $selectedPelaksana) ? 'selected' : '' }}>{{ $pelaksana->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('pelaksana')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pembebanan_id">Sumber Anggaran</label>
                                        <select class="form-control select2 @error('pembebanan_id') is-invalid @enderror" id="pembebanan_id" name="pembebanan_id">
                                            <option value="">Pilih sumber anggaran</option>
                                            @foreach ($pembebanans as $pembebanan)
                                                <option value="{{ $pembebanan->id }}" {{ old('pembebanan_id', $usulan->pembebanan_id) == $pembebanan->id ? 'selected' : '' }}>{{ $pembebanan->nama }}</option>
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
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                name="is_esign"
                                                value="1"
                                                {{ old('is_esign', $usulan->is_esign) == '1' ? 'checked' : '' }}
                                                onchange="toggleEsignInput(this)"
                                                id="is_esign_ya"
                                                class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="is_esign_ya">Ya</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                name="is_esign"
                                                value="0"
                                                {{ old('is_esign', $usulan->is_esign) == '0' ? 'checked' : '' }}
                                                onchange="toggleEsignInput(this)"
                                                id="is_esign_tidak"
                                                class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="is_esign_tidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div id="penandatanganContainer" class="form-group">
                                        <label for="penandatangan">Penanda tangan</label>
                                        <select class="form-control select2 @error('penandatangan') is-invalid @enderror" id="penandatangan" name="penandatangan">
                                            <option value="">Pilih penanda tangan</option>
                                            @foreach ($pimpinanAktif as $pimpinan)
                                                <option value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan', $usulan->penandatangan) == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $jabatan_pimpinan[$pimpinan->jabatan] }}] {{ $pimpinan->user->name }}</option>
                                            @endforeach
                                            
                                            @foreach ($pimpinanNonaktif as $pimpinan)
                                                <option class="pimpinanNonaktif" value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan', $usulan->penandatangan) == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $jabatan_pimpinan[$pimpinan->jabatan] }}] {{ $pimpinan->user->name }}</option>
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
        document.addEventListener('DOMContentLoaded', function() {
                var tanggalInputContainer = document.getElementById('tanggalInputContainer');
                var pimpinanNonaktif = document.getElementsByClassName("pimpinanNonaktif");
                var isBackdateInput = document.querySelector('input[name="is_backdate"]:checked');
                toggleBackdateInput(isBackdateInput, tanggalInputContainer, pimpinanNonaktif);

                // var penandatanganContainer = document.getElementById('penandatanganContainer');
                // var isEsignInput = document.querySelector('input[name="is_esign"]:checked');
                // toggleEsignInput(isEsignInput, penandatanganContainer);
        
                var stKinerjaContainer = document.getElementById('stKinerjaContainer');
                var isStKinerjaInput = document.querySelector('input[name="is_st_kinerja"]:checked');
                toggleStKinerjaInput(isStKinerjaInput, stKinerjaContainer);
        });

        function toggleBackdateInput(input, tanggalInputContainer, pimpinanNonaktif) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
            var pimpinanNonaktif = document.getElementsByClassName("pimpinanNonaktif");
    
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
                for (var i = 0; i < pimpinanNonaktif.length; i++) {
                    pimpinanNonaktif[i].removeAttribute("disabled");
                }
            } else {
                tanggalInputContainer.style.display = 'none';
                for (var i = 0; i < pimpinanNonaktif.length; i++) {
                    pimpinanNonaktif[i].setAttribute("disabled", "disabled");
                }
            }
        }

        // function toggleEsignInput(input, penandatanganContainer) {
        //     var penandatanganContainer = document.getElementById('penandatanganContainer');
    
        //     if (input.value === '1') {
        //         penandatanganContainer.style.display = 'block';
        //     } else {
        //         penandatanganContainer.style.display = 'none';
        //     }
        // }

        function toggleStKinerjaInput(input, stKinerjaContainer) {
            var stKinerjaContainer = document.getElementById('stKinerjaContainer');
    
            if (input.value === '1') {
                stKinerjaContainer.style.display = 'block';
            } else {
                stKinerjaContainer.style.display = 'none';
            }
        }
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
