@extends('layouts.app')

@section('title', 'Edit Pagu Anggaran')

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
            <h1>Form Edit Pagu Anggaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('pagu-anggaran.index') }}">Pagu Anggaran</a></div>
                <div class="breadcrumb-item">Edit Pagu Anggaran</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('pagu-anggaran.update', $paguAnggaran) }}"
                            class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <h1 class="h4 text-dark mb-4 header-card">Data Pagu Anggaran</h1>
                            <div class="form-group">
                                <label for="program">Program</label>
                                <input type="text" class="form-control" name="program" readonly
                                    value="{{ old('program', $paguAnggaran->masterAnggaran->program) }}">
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="form-control" name="tahun" required>
                                    <?php $year = date('Y'); ?>
                                    @for ($i = -3; $i < 5; $i++) <option value="{{ $year + $i }}"
                                        {{ $year + $i == old('tahun', $paguAnggaran->tahun) ? 'selected' : '' }}>
                                        {{ $year + $i }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kegiatan">Kegiatan</label>
                                <select class="form-control" name="kegiatan" required>
                                    <?php $id_kegiatan = $paguAnggaran->masterAnggaran->id_kegiatan; ?>
                                    @foreach ($kegiatan as $k)
                                    <option value="{{ $k->id_kegiatan }}"
                                        {{ $k->id_kegiatan == old('kegiatan', $id_kegiatan) ? 'selected' : '' }}>
                                        {{ $k->id_kegiatan . ' ' . $k->kegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="komponen">Komponen</label>
                                <div>
                                    @foreach ($komponen as $key => $value)
                                    <div class="form-check form-check-inline mr-4">
                                        <input class="form-check-input" type="radio" name="komponen" id="{{ $key }}"
                                            value="{{ $key }}"
                                            {{ old('komponen', $paguAnggaran->komponen) == $key ? 'checked="checked"' : '' }}
                                            required>
                                        <Label class="form-check-label"
                                            for="{{ $key }}">{{ $key . ' ' . $value }}</Label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="akun">Akun</label>
                                <select type="text" class="form-control" name="akun" required>
                                    @foreach ($akun as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('akun', $paguAnggaran->akun) == $key ? 'selected' : '' }}>
                                        {{ $key . ' ' . $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="uraian">Uraian</label>
                                <textarea name="uraian" id="uraian" class="form-control form-control-md"
                                    style="min-height: 120px">{{ old('uraian', $paguAnggaran->uraian) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="volume">Volume</label>
                                <input type="text" name="volume" id="volume" class="form-control"
                                    value="{{ old('volume', $paguAnggaran->volume) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <select class="form-control" name="satuan" required>
                                    @foreach ($satuan as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('satuan', $paguAnggaran->satuan) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <input type="text" name="harga_satuan" id="harga_satuan" class="form-control rupiah"
                                    value="{{ old('harga_satuan', $paguAnggaran->harga) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pagu">Pagu Anggaran</label>
                                <input type="text" name="pagu" id="pagu" class="form-control rupiah"
                                    value="{{ old('pagu', $paguAnggaran->pagu) }}" readonly>
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
