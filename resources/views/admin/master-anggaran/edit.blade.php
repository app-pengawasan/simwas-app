@extends('layouts.app')

@section('title', 'Edit Master Anggaran')

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
            <h1>Form Edit Master Anggaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.master-anggaran.index') }}">Master Anggaran</a>
                </div>
                <div class="breadcrumb-item">Edit Master Anggaran</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.master-anggaran.update', $masterAnggaran) }}"
                            class="needs-validation" novalidate="">
                            @csrf
                            @method('put')
                            <h1 class="h4 text-dark mb-4 header-card">Data Anggaran</h1>
                            <div class="form-group">
                                <label for="program">Program</label>
                                <input type="text" class="form-control" name="program" disabled
                                    value="{{ old('program', $masterAnggaran->program) }}">
                            </div>
                            <div class="form-group">
                                <label for="id_kegiatan">ID Kegiatan</label>
                                <input type="text" class="form-control" name="id_kegiatan"
                                    value="{{ old('id_kegiatan', $masterAnggaran->id_kegiatan) }}" required>
                                @error('id_kegiatan')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kegiatan">Kegiatan</label>
                                <input type="text" class="form-control" name="kegiatan"
                                    value="{{ old('kegiatan', $masterAnggaran->kegiatan) }}" required>
                                @error('kegiatan')
                                <small class="text-danger">
                                    {{ $message }}
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
<script src="{{ asset('js/page/admin/master-anggaran.js') }}"></script>
@endpush
