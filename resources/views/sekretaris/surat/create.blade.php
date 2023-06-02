@extends('layouts.app')

@section('title', 'Form Pembuatan Surat')

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
    @include('components.sekretaris-header')
    @include('components.sekretaris-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Pembuatan Surat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/surat-lain">Surat</a></div>
                    <div class="breadcrumb-item">Form Surat</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="/sekretaris/surat" method="post" enctype="multipart/form-data">
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
                                                    {{ old('is_backdate') == '1' ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_backdate') == '0' ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis">Jenis Surat</label>
                                        <select id="jenis" name="jenis" class="form-control select2 @error('jenis') is-invalid @enderror">
                                            <option value="">Pilih jenis surat</option>
                                            <option value="Surat Dinas" {{ old('jenis') == 'Surat Dinas' ? 'selected' : '' }}>Surat Dinas</option>
                                            <option value="Nota Dinas" {{ old('jenis') == 'Nota Dinas' ? 'selected' : '' }}>Nota Dinas</option>
                                            <option value="Surat Undangan" {{ old('jenis') == 'Surat Undangan' ? 'selected' : '' }}>Surat Undangan</option>
                                        </select>
                                        @error('jenis')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="derajat_klasifikasi">Derajat Klasifikasi</label>
                                        <select id="derajat_klasifikasi" name="derajat_klasifikasi" class="form-control select2 @error('derajat_klasifikasi') is-invalid @enderror">
                                            <option value="">Pilih derajat klasifikasi</option>
                                            <option value="SR" {{ old('derajat_klasifikasi') == 'SR' ? 'selected' : '' }}>SR (Sangat Rahasia)</option>
                                            <option value="R" {{ old('derajat_klasifikasi') == 'R' ? 'selected' : '' }}>R (Rahasia)</option>
                                            <option value="T" {{ old('derajat_klasifikasi') == 'T' ? 'selected' : '' }}>T (Terbatas)</option>
                                            <option value="B" {{ old('derajat_klasifikasi') == 'B' ? 'selected' : '' }}>B (Biasa)</option>
                                        </select>
                                        @error('derajat_klasifikasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_organisasi">Nomor Organisasi</label>
                                        <select id="nomor_organisasi" name="nomor_organisasi" class="form-control select2 @error('nomor_organisasi') is-invalid @enderror">
                                            <option value="">Pilih nomor organisasi</option>
                                            <option value="8000" {{ old('nomor_organisasi') == '8000' ? 'selected' : '' }}>Inspektorat Utama</option>
                                            <option value="8010" {{ old('nomor_organisasi') == '8010' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                            <option value="8100" {{ old('nomor_organisasi') == '8100' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                            <option value="8200" {{ old('nomor_organisasi') == '8200' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                            <option value="8300" {{ old('nomor_organisasi') == '8300' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                        </select>
                                        @error('nomor_organisasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kka">KKA</label>
                                        <select id="kka" name="kka" class="form-control select2 @error('kka') is-invalid @enderror">
                                            <option value="">Pilih KKA</option>
                                                <option value="PW.110" {{ old('kka') == 'PW.110' ? 'selected' : '' }}>PW.110</option>
                                                <option value="PW.120" {{ old('kka') == 'PW.120' ? 'selected' : '' }}>PW.120</option>
                                                <option value="KP.310" {{ old('kka') == 'KP.310' ? 'selected' : '' }}>KP.310</option>
                                        </select>
                                        @error('kka')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                        @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="hal">Hal</label>
                                        <input type="text" class="form-control @error('hal') is-invalid @enderror" id="hal" name="hal" value="{{ old('hal') }}">
                                        @error('hal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="draft">Upload draft</label>
                                        <input type="file" class="form-control @error('draft') is-invalid @enderror" name="draft" accept=".docx, .doc" id="draft" value="{{ old('draft') }}">
                                        @error('draft')
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
