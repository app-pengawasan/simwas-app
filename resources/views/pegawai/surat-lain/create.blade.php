@extends('layouts.app')

@section('title', 'Ajukan Usulan Surat Lain')

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
                <h1>Form Usulan Surat Lain</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/surat-lain">Surat Lain</a></div>
                    <div class="breadcrumb-item">Form Usulan</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="/pegawai/surat-lain" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="status" value="0">
                                    <div class="form-group">
                                        <label for="kegiatan">Kegiatan</label>
                                        <select id="kegiatan" name="kegiatan" class="form-control select2 @error('kegiatan') is-invalid @enderror">
                                            <option value="">Pilih kegiatan</option>
                                            <option value="1" {{ old('kegiatan') == '1' ? 'selected' : '' }}>Option 1</option>
                                            <option value="2" {{ old('kegiatan') == '2' ? 'selected' : '' }}>Option 2</option>
                                            <option value="3" {{ old('kegiatan') == '3' ? 'selected' : '' }}>Option 3</option>
                                            <option value="4" {{ old('kegiatan') == '4' ? 'selected' : '' }}>Option 4</option>
                                            <option value="5" {{ old('kegiatan') == '5' ? 'selected' : '' }}>Option 5</option>
                                        </select>
                                        @error('kegiatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subkegiatan">Subkegiatan</label>
                                        <select id="subkegiatan" name="subkegiatan" class="form-control select2 @error('subkegiatan') is-invalid @enderror">
                                            <option value="">Pilih subkegiatan</option>
                                            <option value="1" {{ old('subkegiatan') == '1' ? 'selected' : '' }}>Option 1</option>
                                            <option value="2" {{ old('subkegiatan') == '2' ? 'selected' : '' }}>Option 2</option>
                                            <option value="3" {{ old('subkegiatan') == '3' ? 'selected' : '' }}>Option 3</option>
                                            <option value="4" {{ old('subkegiatan') == '4' ? 'selected' : '' }}>Option 4</option>
                                            <option value="5" {{ old('subkegiatan') == '5' ? 'selected' : '' }}>Option 5</option>
                                        </select>
                                        @error('subkegiatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_surat_id">Jenis Surat</label>
                                        <select id="jenis_surat_id" name="jenis_surat_id" class="form-control select2 @error('jenis_surat_id') is-invalid @enderror">
                                            <option value="">Pilih jenis surat</option>
                                            <option value="1" {{ old('jenis_surat_id') == '1' ? 'selected' : '' }}>Surat Undangan</option>
                                            <option value="2" {{ old('jenis_surat_id') == '2' ? 'selected' : '' }}>Surat A</option>
                                            <option value="3" {{ old('jenis_surat_id') == '3' ? 'selected' : '' }}>Surat B</option>
                                            <option value="4" {{ old('jenis_surat_id') == '4' ? 'selected' : '' }}>Surat C</option>
                                            <option value="5" {{ old('jenis_surat_id') == '5' ? 'selected' : '' }}>Surat D</option>
                                        </select>
                                        @error('jenis_surat_id')
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
                                        <label for="kka">KKA</label>
                                        <select id="kka" name="kka" class="form-control select2 @error('kka') is-invalid @enderror">
                                            <option value="">Pilih KKA</option>
                                            <option value="1" {{ old('kka') == '1' ? 'selected' : '' }}>KKA 1</option>
                                            <option value="2" {{ old('kka') == '2' ? 'selected' : '' }}>KKA 2</option>
                                            <option value="3" {{ old('kka') == '3' ? 'selected' : '' }}>KKA 3</option>
                                            <option value="4" {{ old('kka') == '4' ? 'selected' : '' }}>KKA 4</option>
                                            <option value="5" {{ old('kka') == '5' ? 'selected' : '' }}>KKA 5</option>
                                        </select>
                                        @error('kka')
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
