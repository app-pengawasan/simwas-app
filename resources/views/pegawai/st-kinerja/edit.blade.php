@extends('layouts.app')

@section('title', 'Edit Usulan ST Kinerja')

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
                @if ($usulan->status == 1)
                <h1>Edit ST Kinerja</h1>
                @elseif ($usulan->status == 5)
                <h1>Ajukan Nomor Norma Hasil</h1>
                @endif
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-kinerja">ST Kinerja</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                    <form action="/pegawai/st-kinerja/{{ $usulan->id }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        @php
                                            $selectedAnggota = old('anggota', explode(', ', $usulan->anggota));
                                        @endphp
                                        <input type="hidden" name="status" value="0">
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
                                                <option value="8000" {{ old('unit_kerja', $usulan->unit_kerja) == '8000'  ? 'selected' : '' }}>Inspektorat Utama</option>
                                                <option value="8010" {{ old('unit_kerja', $usulan->unit_kerja) == '8010'  ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                                <option value="8100" {{ old('unit_kerja', $usulan->unit_kerja) == '8100'  ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                                <option value="8200" {{ old('unit_kerja', $usulan->unit_kerja) == '8200'  ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                                <option value="8300" {{ old('unit_kerja', $usulan->unit_kerja) == '8300'  ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                            </select>
                                            @error('unit_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="tim_kerja">Tim Kerja</label>
                                            <input type="text" class="form-control @error('tim_kerja') is-invalid @enderror" id="tim_kerja" name="tim_kerja" value="{{ old('tim_kerja', $usulan->tim_kerja) }}">
                                            @error('tim_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="tugas">Tugas</label>
                                            <input type="text" class="form-control @error('tugas') is-invalid @enderror" id="tugas" name="tugas" value="{{ old('tugas', $usulan->tugas) }}">
                                            @error('tugas')
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
                                            <label for="objek">Objek</label>
                                            <input type="text" class="form-control @error('objek') is-invalid @enderror" id="objek" name="objek" value="{{ old('objek', $usulan->objek) }}">
                                            @error('objek')
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
                                            <label class="d-block">Gugus Tugas</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_gugus_tugas"
                                                    value="1"
                                                    {{ old('is_gugus_tugas', $usulan->is_gugus_tugas) == '1' ? 'checked' : '' }}
                                                    onchange="toggleGugusTugasInput(this)"
                                                    id="is_gugus_tugas_ya"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_gugus_tugas_ya">Ya</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_gugus_tugas"
                                                    value="0"
                                                    {{ old('is_gugus_tugas', $usulan->is_gugus_tugas) == '0' ? 'checked' : '' }}
                                                    onchange="toggleGugusTugasInput(this)"
                                                    id="is_gugus_tugas_tidak"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_gugus_tugas_tidak">Tidak</label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="perseoranganContainer" style="display: none;">
                                            <div class="control-label">Jenis</div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_perseorangan"
                                                    value="1"
                                                    {{ old('is_perseorangan', $usulan->is_perseorangan) == '1' ? 'checked' : '' }}
                                                    onchange="togglePerseoranganInput(this)"
                                                    id="is_perseorangan_ya"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_perseorangan_ya">1 orang</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_perseorangan"
                                                    value="0"
                                                    {{ old('is_perseorangan', $usulan->is_perseorangan) == '0' ? 'checked' : '' }}
                                                    onchange="togglePerseoranganInput(this)"
                                                    id="is_perseorangan_tidak"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_perseorangan_tidak">Kolektif</label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dalnisContainer" style="display: none;">
                                            <label for="dalnis_id">Pengendali Teknis</label>
                                            <select id="dalnis_id" name="dalnis_id" class="form-control select2 @error('dalnis_id') is-invalid @enderror">
                                                <option value="">Pilih pengendali teknis</option>
                                                @foreach ($user as $dalnis)
                                                    <option value="{{ $dalnis->id }}" {{ old('dalnis_id', $usulan->dalnis_id ) == $dalnis->id ? 'selected' : '' }}>{{ $dalnis->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('dalnis_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group" id ="ketuaKoorContainer" style="display: none;">
                                            <label for="ketua_koor_id"><div id="koordinator" style="display: none;">Koordinator</div><div id="ketua" style="display: block;">Ketua Tim</div></label>
                                            <select id="ketua_koor_id" name="ketua_koor_id" class="form-control select2 @error('ketua_koor_id') is-invalid @enderror">
                                                <option value="">Pilih</option>
                                                @foreach ($user as $ketuaKoor)
                                                    <option value="{{ $ketuaKoor->id }}" {{ old('ketua_koor_id', $usulan->ketua_koor_id) == $ketuaKoor->id ? 'selected' : '' }}>{{ $ketuaKoor->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('ketua_koor_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group" id="anggotaContainer" style="display: none;">
                                            <label for="anggota">Anggota</label>
                                            <select id="anggota" name="anggota[]" class="form-control select2 @error('anggota') is-invalid @enderror" multiple="multiple">
                                                <option value="">Pilih anggota</option>
                                                @foreach ($user as $anggota)
                                                    <option value="{{ $anggota->id }}" {{ in_array($anggota->id, $selectedAnggota) ? 'selected' : '' }}>{{ $anggota->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('anggota')
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
                                        <div class="form-group"  id="penandatanganContainer" style="display: none;">
                                            <label for="penandatangan">Penanda tangan</label>
                                            <select class="form-control select2 @error('penandatangan') is-invalid @enderror" id="penandatangan" name="penandatangan">
                                                <option value="">Pilih penanda tangan</option>
                                                @foreach ($pimpinanAktif as $pimpinan)
                                                    <option value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan', $usulan->penandatangan) == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $pimpinan->jabatan }}] {{ $pimpinan->user->name }}</option>
                                                @endforeach
                                                
                                                @foreach ($pimpinanNonaktif as $pimpinan)
                                                    <option class="pimpinanNonaktif" value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan', $usulan->penandatangan) == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $pimpinan->jabatan }}] {{ $pimpinan->user->name }}</option>
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
                console.log("Baris 1");
                var tanggalInputContainer = document.getElementById('tanggalInputContainer');
                var pimpinanNonaktif = document.getElementsByClassName("pimpinanNonaktif");
                var isBackdateInput = document.querySelector('input[name="is_backdate"]:checked');
                toggleBackdateInput(isBackdateInput, tanggalInputContainer, pimpinanNonaktif);
                
                var penandatanganContainer = document.getElementById('penandatanganContainer');
                var isEsignInput = document.querySelector('input[name="is_esign"]:checked');
                toggleEsignInput(isEsignInput, penandatanganContainer);
                console.log(isEsignInput)

                console.log("Baris 2");

                var perseoranganContainer = document.getElementById('perseoranganContainer');
                var dalnisContainer = document.getElementById('dalnisContainer');
                var ketuaKoorContainer = document.getElementById('ketuaKoorContainer');
                var anggotaContainer = document.getElementById('anggotaContainer');
                var koordinator = document.getElementById('koordinator');
                var ketua = document.getElementById('ketua');
                var isGugusTugasInput = document.querySelector('input[name="is_gugus_tugas"]:checked')
                console.log("Gugus Tugas", isGugusTugasInput);
                toggleGugusTugasInput(isGugusTugasInput, perseoranganContainer, dalnisContainer, ketuaKoorContainer, anggotaContainer, koordinator, ketua);
                
                

                console.log("Baris 3");

                
                var dalnisContainer = document.getElementById('dalnisContainer');
                var ketuaKoorContainer = document.getElementById('ketuaKoorContainer');
                var anggotaContainer = document.getElementById('anggotaContainer');
                var koordinator = document.getElementById('koordinator');
                var ketua = document.getElementById('ketua');
                var isPerseoranganInput = document.querySelector('input[name="is_perseorangan"]:checked');
                togglePerseoranganInput(isPerseoranganInput, dalnisContainer, ketuaKoorContainer, anggotaContainer, koordinator, ketua);
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

        function toggleEsignInput(input, penandatanganContainer) {
            var penandatanganContainer = document.getElementById('penandatanganContainer');
    
            if (input.value === '1') {
                penandatanganContainer.style.display = 'block';
            } else {
                penandatanganContainer.style.display = 'none';
            }
        }
    
        function toggleGugusTugasInput(input, perseoranganContainer, dalnisContainer, ketuaKoorContainer, anggotaContainer, koordinator, ketua) {
            var perseoranganContainer = document.getElementById('perseoranganContainer');
            var dalnisContainer = document.getElementById('dalnisContainer');
            var ketuaKoorContainer = document.getElementById('ketuaKoorContainer');
            var anggotaContainer = document.getElementById('anggotaContainer');
            var koordinator = document.getElementById('koordinator');
            var ketua = document.getElementById('ketua');
    
            if (input.value === '1') {
                perseoranganContainer.style.display = 'none';
                dalnisContainer.style.display = 'block';
                ketuaKoorContainer.style.display = 'block';
                anggotaContainer.style.display = 'block';
                koordinator.style.display = 'none';
                ketua.style.display = 'block';
            } else {
                perseoranganContainer.style.display = 'block';
                dalnisContainer.style.display = 'none';
                ketuaKoorContainer.style.display = 'none';
                anggotaContainer.style.display = 'none';
                koordinator.style.display = 'block';
                ketua.style.display = 'none';
            }
        }
    
        function togglePerseoranganInput(input, dalnisContainer, ketuaKoorContainer, anggotaContainer, koordinator, ketua) {
            var dalnisContainer = document.getElementById('dalnisContainer');
            var ketuaKoorContainer = document.getElementById('ketuaKoorContainer');
            var anggotaContainer = document.getElementById('anggotaContainer');
            var koordinator = document.getElementById('koordinator');
            var ketua = document.getElementById('ketua');
    
            if (input) {
                if (input.value === '1') {
                    dalnisContainer.style.display = 'none';
                    ketuaKoorContainer.style.display = 'none';
                    anggotaContainer.style.display = 'none';
                } else {
                    dalnisContainer.style.display = 'none';
                    ketuaKoorContainer.style.display = 'block';
                    anggotaContainer.style.display = 'block';
                    koordinator.style.display = 'block';
                    ketua.style.display = 'none';
                }
            }
        }
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush