@extends('layouts.app')

@section('title', 'Ajukan Usulan ST Pengembangan Profesi')

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

@section('header-app')
@endsection
@section('sidebar')
@endsection

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Usulan ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-pp">ST Pengembangan Profesi</a></div>
                    <div class="breadcrumb-item">Form Usulan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="/pegawai/st-pp" method="post">
                                    @csrf
                                    <input type="hidden" name="tanggal" value="{{ date("Y-m-d") }}">
                                    <input type="hidden" name="status" value="0">
                                    <input type="hidden" name="no_st" value="{{ random_bytes(10) }}">
                                    <div class="form-group">
                                        <label for="unit-kerja">Unit Kerja</label>
                                        <select id="unit-kerja" name="unit-kerja" class="form-control select2 @error('unit-kerja') is-invalid @enderror">
                                            <option value="">Pilih unit kerja</option>
                                            <option value="1" {{ old('unit-kerja') == '1' ? 'selected' : '' }}>Inspektorat Utama</option>
                                            <option value="2" {{ old('unit-kerja') == '2' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                            <option value="3" {{ old('unit-kerja') == '3' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                            <option value="4" {{ old('unit-kerja') == '4' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                            <option value="5" {{ old('unit-kerja') == '5' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                        </select>
                                        @error('unit-kerja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pp_id">Jenis Pengembangan Profesi</label>
                                        <select class="form-control select2 @error('pp_id') is-invalid @enderror" id="pp_id" name="pp_id">
                                            <option value="">Pilih jenis pengembangan profesi</option>
                                            <option value="1" {{ old('pp_id') == '1' ? 'selected' : '' }}>Sertifikasi</option>
                                            <option value="2" {{ old('pp_id') == '2' ? 'selected' : '' }}>Diklat</option>
                                            <option value="3" {{ old('pp_id') == '3' ? 'selected' : '' }}>Diklat Subtantif</option>
                                            <option value="4" {{ old('pp_id') == '4' ? 'selected' : '' }}>Pelatihan</option>
                                            <option value="5" {{ old('pp_id') == '5' ? 'selected' : '' }}>Workshop</option>
                                            <option value="6" {{ old('pp_id') == '6' ? 'selected' : '' }}>Seminar</option>
                                            <option value="7" {{ old('pp_id') == '7' ? 'selected' : '' }}>Pelatihan di Kantor Sendiri</option>
                                        </select>
                                        @error('pp_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pp">Nama Pengembangan Profesi</label>
                                        <select class="form-control select2 @error('nama_pp') is-invalid @enderror" id="nama_pp" name="nama_pp">
                                            <option value="">Pilih nama pengembangan profesi</option>
                                            <option value="1" {{ old('nama_pp') == '1' ? 'selected' : '' }}>CISA</option>
                                            <option value="2" {{ old('nama_pp') == '2' ? 'selected' : '' }}>CRMP</option>
                                            <option value="3" {{ old('nama_pp') == '3' ? 'selected' : '' }}>QIA</option>
                                            <option value="4" {{ old('nama_pp') == '4' ? 'selected' : '' }}>Diklat Auditor Ahli Pertama</option>
                                            <option value="5" {{ old('nama_pp') == '5' ? 'selected' : '' }}>Audit Investigasi</option>
                                        </select>
                                        @error('nama_pp')
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
                                        <label>Waktu Mulai</label>
                                        <input type="date" class="form-control datepicker @error('mulai') is-invalid @enderror" name="mulai" value="{{ old('mulai') }}">
                                        @error('mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Selesai</label>
                                        <input type="date" class="form-control datepicker @error('selesai') is-invalid @enderror" name="selesai" value="{{ old('selesai') }}">
                                        @error('selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pegawai">Pegawai</label>
                                        <input type="text" class="form-control @error('pegawai') is-invalid @enderror" id="pegawai" name="pegawai" value="{{ old('pegawai') }}">
                                        @error('pegawai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="penandatangan">Penanda tangan</label>
                                        <select class="form-control select2 @error('penandatangan') is-invalid @enderror" id="penandatangan" name="penandatangan">
                                            <option value="">Pilih penanda tangan</option>
                                            <option value="0" {{ old('penandatangan') == '0' ? 'selected' : '' }}>Inspektur Utama</option>
                                            <option value="1" {{ old('penandatangan') == '1' ? 'selected' : '' }}>Inspektur Wilayah I</option>
                                            <option value="2" {{ old('penandatangan') == '2' ? 'selected' : '' }}>Inspektur Wilayah II</option>
                                            <option value="3" {{ old('penandatangan') == '3' ? 'selected' : '' }}>Inspektur Wilayah III</option>
                                            <option value="4" {{ old('penandatangan') == '4' ? 'selected' : '' }}>Kepala Bagian Umum Inspektorat Utama</option>
                                        </select>
                                        @error('penandatangan')
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
                                                    {{ old('is_esign') == '1' ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_esign') == '0' ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
