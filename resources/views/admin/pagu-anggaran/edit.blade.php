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
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="javascript(0);" id="btn-back">
                                        <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('pagu-anggaran.update', $paguAnggaran) }}"
                                class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="program">Program</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="program" readonly
                                                value="{{ old('program', $paguAnggaran->masterAnggaran->program) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tahun">Tahun</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tahun" required>
                                                <?php $year = date('Y'); ?>
                                                @for ($i = -3; $i < 5; $i++)
                                                    <option value="{{ $year + $i }}"
                                                        {{ $year + $i == old('tahun', $paguAnggaran->tahun) ? 'selected' : '' }}>
                                                        {{ $year + $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="kegiatan">Kegiatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="kegiatan" required>
                                                <?php $id_kegiatan = $paguAnggaran->masterAnggaran->id_kegiatan; ?>
                                                @foreach ($kegiatan as $k)
                                                    <option value="{{ $k->id_kegiatan }}"
                                                        {{ $k->id_kegiatan == old('kegiatan', $id_kegiatan) ? 'selected' : '' }}>
                                                        {{ $k->id_kegiatan . ' ' . $k->kegiatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Komponen</label>
                                        <div class="col-sm-10 d-flex align-items-center">
                                            @foreach ($komponen as $key => $value)
                                                <div class="form-check form-check-inline mr-4">
                                                    <input class="form-check-input" type="radio" name="komponen"
                                                        id="{{ $key }}" value="{{ $key }}"
                                                        {{ old('komponen', $paguAnggaran->komponen) == $key ? 'checked="checked"' : '' }}
                                                        required>
                                                    <Label class="form-check-label"
                                                        for="{{ $key }}">{{ $key . ' ' . $value }}</Label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="akun">Akun</label>
                                        <div class="col-sm-10">
                                            <select type="text" class="form-control" name="akun" required>
                                                @foreach ($akun as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('akun', $paguAnggaran->akun) == $key ? 'selected' : '' }}>
                                                        {{ $key . ' ' . $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="uraian">Uraian</label>
                                        <div class="col-sm-10">
                                            <textarea name="uraian" id="uraian" class="form-control form-control-md" style="min-height: 120px">{{ old('uraian', $paguAnggaran->uraian) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="volume">Volume</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="volume" id="volume" class="form-control"
                                                value="{{ old('volume', $paguAnggaran->volume) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="satuan">Satuan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="satuan" required>
                                                @foreach ($satuan as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('satuan', $paguAnggaran->satuan) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="harga_satuan">Harga Satuan</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="harga_satuan" id="harga_satuan"
                                                class="form-control rupiah"
                                                value="{{ old('harga_satuan', $paguAnggaran->harga) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="pagu">Pagu Anggaran</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="pagu" id="pagu"
                                                class="form-control rupiah"
                                                value="{{ old('pagu', $paguAnggaran->pagu) }}" readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            Simpan
                                        </button>
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
