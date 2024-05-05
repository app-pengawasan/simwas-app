@extends('layouts.app')

@section('title', 'Edit Pegawai')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Edit Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/admin/master-pegawai">Master Pegawai</a></div>
                <div class="breadcrumb-item">Ubah Data Pegawai</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="javascript(0);" id="btn-back">
                                    <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </div> --}}
                        <form method="POST" action="/admin/master-pegawai/{{ $user->id }}" class="needs-validation"
                            novalidate="">
                            @method('put')
                            @csrf
                            <h1 class="h4 text-dark mb-4 header-card">Data Pribadi Pegawai</h1>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="name" required
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input class="form-control" name="nip" required value="{{ old('nip', $user->nip) }}">
                                @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pangkat">Pangkat</label>
                                <select class="form-control select2" name="pangkat" required>
                                    @foreach ($pangkat as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('pangkat', $user->pangkat) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="unit_kerja">Unit Kerja</label>
                                <select class="form-control select2" name="unit_kerja" required>
                                    @foreach ($unit_kerja as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('unit_kerja', $user->unit_kerja) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select class="form-control select2" name="jabatan" required>
                                    @foreach ($jabatan as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('jabatan', $user->jabatan) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <h1 class="h4 text-dark mb-4 mt-lg-5 header-card">Role/Group Pegawai</h1>
                            @foreach ($role as $key => $value)
                            <div class="form-group">
                                <label> Sebagai {{ $value }} ?</label>
                                <div class="d-flex align-items-center">
                                    {{-- <div class="form-check form-check-inline mr-4">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ $key }}" id="{{ $key }}_true"
                                    value="1"
                                    {{ old($key, $user["$key"]) == '1' ? 'checked="checked"' : '' }}
                                    required>
                                    <label class="form-check-label btn btn-outline-primary"
                                        for="{{ $key }}_true">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $key }}" id="{{ $key }}_false"
                                        value="0" {{ old($key, $user["$key"]) == '0' ? 'checked="checked"' : '' }}>
                                    <label class="form-check-label btn btn-outline-primary"
                                        for="{{ $key }}_false">Tidak</label>
                                </div> --}}
                                <div class="selectgroup w-50">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="{{ $key }}" value="1" class="selectgroup-input"
                                            {{ old($key, $user["$key"]) == '1' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Ya</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="{{ $key }}" value="0" class="selectgroup-input1"
                                            {{ old($key, $user["$key"]) == '0' ? 'checked' : '' }}>
                                        <span class="selectgroup-button1">Tidak</span>
                                    </label>
                                </div>
                                {{-- toggle switch --}}
                            </div>

                    </div>
                    @endforeach
                    <hr class="my-1">
                    <div class="d-flex mt-4" style="gap: 10px">
                        <a class="btn btn-outline-primary" href="javascript(0);" id="btn-back">
                            <i class="fa-solid fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
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
<script src="{{ asset('js/page/admin/master-pegawai.js') }}"></script>
@endpush
