@extends('layouts.app')

@section('title', 'Ajukan Usulan Norma Hasil')

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
            <h1>Form Usulan Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/pegawai/norma-hasil">Norma Hasil</a></div>
                <div class="breadcrumb-item">Form Usulan</div>
            </div>
        </div>
        <div class="section-body">
            @include('components.flash')
            {{ session()->forget(['alert-type', 'status']) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="/pegawai/norma-hasil" method="post" enctype="multipart/form-data">
                                @csrf
                                <h1 class="h4 text-dark mb-4 header-card">Data Norma Hasil</h1>
                                <div class="form-group">
                                    <label for="rencana_id">Tugas</label>
                                    <select required id="rencana_id" name="rencana_id"
                                        class="form-control select2 @error('rencana_id') is-invalid @enderror">
                                        <option value="">Pilih tugas</option>
                                        @foreach ($rencanaKerja as $rencana)
                                        <option value="{{ $rencana->id_rencanakerja }}"
                                            {{ old('rencana_id') == $rencana->id_rencanakerja ? 'selected' : '' }}>
                                            {{ $rencana->tugas }}</option>
                                        @endforeach
                                    </select>
                                    @error('rencana_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- Objek Kegiatan --}}
                                <div class="form-group
                                        @if ($errors->has('objek_kegiatan')) is-invalid @endif">
                                    <label for="objek_kegiatan">Objek Kegiatan</label>
                                    <select id="objek_kegiatan" name="objek_kegiatan[]" disabled multiple="multiple"
                                        data-placeholder="Pilih objek kegiatan" class="form-control select2">
                                        <option value="">Pilih objek kegiatan</option>
                                    </select>
                                    @if ($errors->has('objek_kegiatan'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('objek_kegiatan') }}
                                    </div>
                                    @endif
                                </div>

                                {{-- Jenis Norma Hasil --}}
                                <div class="form-group
                                        @if ($errors->has('jenis_norma_hasil')) is-invalid @endif">
                                    <label for="jenis_norma_hasil">Jenis Norma Hasil</label>
                                    <select required id="jenis_norma_hasil" name="jenis_norma_hasil"
                                        class="form-control select2">
                                        <option value="">Pilih jenis norma hasil</option>
                                        @foreach ($hasilPengawasan as $id => $nama)
                                        <option value="{{ $id }}"
                                            {{ old('jenis_norma_hasil') == $id ? 'selected' : '' }}>
                                            {{ $nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('jenis_norma_hasil'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jenis_norma_hasil') }}
                                    </div>
                                    @endif
                                </div>
                                {{-- text nama dokumen --}}
                                <div class="form-group
                                        @if ($errors->has('nama_dokumen')) is-invalid @endif">
                                    <label for="nama_dokumen">Nama Dokumen</label>
                                    <input placeholder="Nama Dokumen" required type="text" id="nama_dokumen"
                                        name="nama_dokumen" class="form-control" value="{{ old('nama_dokumen') }}">
                                    @if ($errors->has('nama_dokumen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nama_dokumen') }}
                                    </div>
                                    @endif
                                </div>
                                {{-- upload word Laporan --}}
                                <div class="form-group
                                        @if ($errors->has('file')) is-invalid @endif">
                                    <label for="url_norma_hasil">Link Dokumen</label>
                                    <input placeholder="Masukkan URL/Link dokumen" type="url" id="file"
                                        name="url_norma_hasil" class="form-control" required>
                                    @if ($errors->has('url_norma_hasil'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('url-norma-hasil') }}
                                    </div>
                                    @endif
                                </div>
                                <hr class="my-1">
                                <div class="d-flex justify-content-between mt-4">
                                    <div>
                                        <a class="btn btn-outline-primary mr-2" href="/pegawai/norma-hasil"
                                            id="btn-back2">
                                            <i class="fa-solid fa-arrow-left mr-1"></i>
                                            Kembali
                                        </a>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i>
                                            Simpan
                                        </button>
                                    </div>
                                    <div>
                                        <input class="btn btn-outline-secondary" type="reset" value="Reset" />
                                    </div>

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
<!-- JS Libraies -->
<script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js') }}/page/pegawai/norma-hasil.js"></script>
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
