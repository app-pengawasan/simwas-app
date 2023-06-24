@extends('layouts.app')

@section('title', 'Surat Lain')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
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
                <h1>Surat Lain</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/surat-lain">Surat Lain</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                                <div class="card-body">
                                    <div class="pt-1 pb-1 m-4">
                                        <form action="/pegawai/surat-lain/{{ $usulan->id }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="0">
                                            <div class="form-group">
                                                <div class="control-label">Backdate</div>
                                                <div class="custom-switches-stacked mt-2">
                                                    <label class="custom-switch">
                                                        <input type="radio"
                                                            name="is_backdate"
                                                            value="1"
                                                            class="custom-switch-input"
                                                            {{ old('is_backdate', $usulan->is_backdate) == '1' ? 'checked' : '' }}
                                                            onchange="toggleBackdateInput(this)">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Ya</span>
                                                    </label>
                                                    <label class="custom-switch">
                                                        <input type="radio"
                                                            name="is_backdate"
                                                            value="0"
                                                            class="custom-switch-input"
                                                            {{ old('is_backdate', $usulan->is_backdate) == '0' ? 'checked' : '' }}
                                                            onchange="toggleBackdateInput(this)">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Tidak</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="tanggalInputContainer" style="display: none;" class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', $usulan->tanggal) }}">
                                                @error('tanggal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_surat">Jenis Surat</label>
                                                <select id="jenis_surat" name="jenis_surat" class="form-control select2 @error('jenis_surat') is-invalid @enderror">
                                                    <option value="">Pilih jenis surat</option>
                                                    <option value="Surat Dinas" {{ old('jenis_surat', $usulan->jenis_surat) == 'Surat Dinas' ? 'selected' : '' }}>Surat Dinas</option>
                                                    <option value="Nota Dinas" {{ old('jenis_surat', $usulan->jenis_surat) == 'Nota Dinas' ? 'selected' : '' }}>Nota Dinas</option>
                                                    <option value="Surat Undangan" {{ old('jenis_surat', $usulan->jenis_surat) == 'Surat Undangan' ? 'selected' : '' }}>Surat Undangan</option>
                                                </select>
                                                @error('jenis_surat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="derajat_klasifikasi">Derajat Klasifikasi</label>
                                                <select id="derajat_klasifikasi" name="derajat_klasifikasi" class="form-control select2 @error('derajat_klasifikasi') is-invalid @enderror">
                                                    <option value="">Pilih derajat klasifikasi</option>
                                                    <option value="SR" {{ old('derajat_klasifikasi', $usulan->derajat_klasifikasi) == 'SR' ? 'selected' : '' }}>SR (Sangat Rahasia)</option>
                                                    <option value="R" {{ old('derajat_klasifikasi', $usulan->derajat_klasifikasi) == 'R' ? 'selected' : '' }}>R (Rahasia)</option>
                                                    <option value="T" {{ old('derajat_klasifikasi', $usulan->derajat_klasifikasi) == 'T' ? 'selected' : '' }}>T (Terbatas)</option>
                                                    <option value="B" {{ old('derajat_klasifikasi', $usulan->derajat_klasifikasi) == 'B' ? 'selected' : '' }}>B (Biasa)</option>
                                                </select>
                                                @error('derajat_klasifikasi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
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
                                                <label for="kka_id">KKA</label>
                                                <select id="kka_id" name="kka_id" class="form-control select2 @error('kka_id') is-invalid @enderror">
                                                    <option value="">Pilih KKA</option>
                                                    @foreach ($kka as $kode)
                                                        <option value="{{ $kode->id }}" {{ old('kka_id', $usulan->kka_id) == $kode->id ? 'selected' : '' }}>{{ $kode->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kka_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="hal">Hal</label>
                                                <input type="text" class="form-control @error('hal') is-invalid @enderror" id="hal" name="hal" value="{{ old('hal', $usulan->hal) }}">
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
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                var tanggalInputContainer = document.getElementById('tanggalInputContainer');
                var isBackdateInput = document.querySelector('input[name="is_backdate"]:checked');
                toggleBackdateInput(isBackdateInput, tanggalInputContainer);
        });

        function toggleBackdateInput(input, tanggalInputContainer) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
        
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
            } else {
                tanggalInputContainer.style.display = 'none';
            }
        }        
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
