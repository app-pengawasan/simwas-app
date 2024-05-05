@extends('layouts.app')

@section('title', 'Tambah Master Anggaran')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Pagu Anggaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('pagu-anggaran.index') }}">Pagu Anggaran</a></div>
                <div class="breadcrumb-item">Tambah Pagu Anggaran</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('pagu-anggaran.store') }}" class="needs-validation"
                            novalidate="">
                            @csrf
                            <h1 class="h4 text-dark mb-4 header-card">Data Pagu Anggaran</h1>
                            <div class="form-group">
                                <label for="program">Program</label>
                                <input type="text" class="form-control" name="program" readonly
                                    value="{{ old('program', $program_manggaran) }}">
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="form-control select2" name="tahun" required>
                                    <?php $year = date('Y'); ?>
                                    @for ($i = -3; $i < 5; $i++) <option value="{{ $year + $i }}"
                                        {{ $i === old('tahun', 0) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                        @endfor
                                </select>
                                @error('tahun')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kegiatan">Kegiatan</label>
                                <select class="form-control select2" name="kegiatan" required>
                                    @foreach ($kegiatan as $k)
                                    <option value="{{ $k->id_kegiatan }}"
                                        {{ $k->id_kegiatan == old('kegiatan') ? 'selected' : '' }}>
                                        {{ $k->id_kegiatan . ' ' . $k->kegiatan }}</option>
                                    @endforeach
                                </select>
                                @error('kegiatan')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="komponen">Komponen</label>
                                <div>
                                    @foreach ($komponen as $key => $value)
                                    <div class="form-check form-check-inline mr-4">
                                        <input class="form-check-input" type="radio" name="komponen" id="{{ $key }}"
                                            value="{{ $key }}" {{ old('komponen') == $key ? 'checked="checked"' : '' }}
                                            required>
                                        <Label class="form-check-label"
                                            for="{{ $key }}">{{ $key . ' ' . $value }}</Label>
                                    </div>
                                    @endforeach
                                    @error('komponen')
                                    <small class="text-danger">
                                        {{ trans($message) }}
                                    </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="akun">Akun</label>
                                <select type="text" class="form-control select2" name="akun" required>
                                    @foreach ($akun as $key => $value)
                                    <option value="{{ $key }}" {{ old('akun') == $key ? 'selected' : '' }}>
                                        {{ $key . ' ' . $value }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('akun')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="uraian">Uraian</label>
                                <textarea name="uraian" id="uraian" class="form-control" value="{{ old('uraian') }}"
                                    style="min-height: 120px" required></textarea>
                                @error('uraian')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="volume">Volume</label>
                                <input type="text" name="volume" id="volume" class="form-control" {{ old('volume') }}
                                    required>
                                @error('volume')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <select class="form-control select2" name="satuan" required>
                                    @foreach ($satuan as $key => $value)
                                    <option value="{{ $key }}" {{ old('satuan') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('satuan')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <input type="text" name="harga_satuan" id="harga_satuan" class="form-control"
                                    value="{{ old('harga_satuan') }}" required>
                                @error('harga_satuan')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pagu">Pagu Anggaran</label>
                                <input type="text" name="pagu" id="pagu" class="form-control" value="{{ old('pagu') }}"
                                    readonly>
                                @error('pagu')
                                <small class="text-danger">
                                    {{ trans($message) }}
                                </small>
                                @enderror
                            </div>

                            <hr class="my-1">
                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    <a class="btn btn-outline-primary mr-2" href="javascript(0);" id="btn-back">
                                        <i class="fa-solid fa-arrow-left mr-1"></i>
                                        Kembali
                                    </a>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-save"></i>
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
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/format-rupiah.js') }}"></script>
<script src="{{ asset('js/page/admin/form-pagu-anggaran.js') }}"></script>
@endpush
