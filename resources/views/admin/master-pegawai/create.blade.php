@extends('layouts.app')

@section('title', 'Tambah Pegawai')

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
            <h1>Form Tambah Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/admin/master-pegawai">Master Pegawai</a></div>
                <div class="breadcrumb-item">Tambah Pegawai</div>
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
                        <form method="POST" action="/admin/master-pegawai" class="needs-validation" novalidate="" name="addPegawai">
                            @csrf
                            <h1 class="h4 text-dark mb-4 header-card">Data Pribadi Pegawai</h1>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                {{-- <input placeholder="Nama Pegawai" type="text" class="form-control" name="name" required
                                    value="{{ old('name') }}"> --}}
                                {{-- error bootstrap message --}}
                                <select class="form-control select2" name="name" id="name" required
                                    data-placeholder="Pilih Nama">
                                    <option value=""></option>
                                    @foreach ($allPegawai as $key => $value)
                                    <option value="{{ $value["firstName"] }}{{ empty($value['lastName']) || $value['lastName'] === '-' ? '' : ' '.$value['lastName'] }}" data-nip="{{ $value["attributes"]["attribute-nip"][0] }}">
                                        {{ $value['firstName'] }}{{ empty($value['lastName']) || $value['lastName'] === '-' ? '' : ' '.$value['lastName'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input placeholder="Email Pegawai" type="email" class="form-control" name="email" id="email"
                                    required value="{{ old('email') }}">
                                <div class="invalid-feedback">
                                    Email belum diisi
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nip">Nomor Induk Pegawai (NIP)</label>
                                <input placeholder="Nomor Induk Pegawai" class="form-control" name="nip" required id="nip"
                                    value="{{ old('nip') }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                <div class="invalid-feedback">
                                    NIP belum diisi
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pangkat">Pangkat</label>
                                <input placeholder="Pangkat" type="text" class="form-control" name="pangkat" id="pangkat"
                                    required value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="unit_kerja">Unit Kerja</label>
                                <input placeholder="Unit Kerja" type="text" class="form-control" name="unit_kerja" id="unit_kerja"
                                    required value="{{ old('unit_kerja') }}">
                                <div class="invalid-feedback">
                                    Unit Kerja belum diisi
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <label for="jabatan">Jabatan</label>
                                <input placeholder="Jabatan" type="text" class="form-control" name="jabatan" id="jabatan"
                                    required value="{{ old('jabatan') }}">
                                <div class="invalid-feedback">
                                    Jabatan belum diisi
                                </div>
                            </div>
                            <h1 class="h4 text-dark mb-4 mt-lg-5 header-card">Role/Group Pegawai</h1>
                            @foreach ($role as $key => $value)
                            <div class="form-group">
                                <label>Sebagai {{ $value }} ?</label>
                                <div class="d-flex align-items-center">
                                    {{-- <div class="form-check form-check-inline mr-4">
                                        <input class="form-check-input" type="radio" name="{{ $key }}"
                                    id="{{ $key }}_true" value="1"
                                    {{ old($key) === '1' ? 'checked="checked"' : '' }} required>
                                    <Label class="form-check-label" for="{{ $key }}_true">Ya</Label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $key }}" id="{{ $key }}_false"
                                        value="0" {{ old($key) === '0' ? 'checked="checked"' : '' }}>
                                    <Label class="form-check-label" for="{{ $key }}_false">Tidak</Label>
                                </div> --}}


                                <div class="selectgroup w-50">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="{{ $key }}" value="1" class="selectgroup-input"
                                            {{ old($key) === '1' ? 'checked="checked"' : '' }}>
                                        <span class="selectgroup-button">Ya</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="{{ $key }}" value="0" class="selectgroup-input1"
                                            {{ old($key) === '0' ? 'checked="checked"' : '' }}>
                                        <span class="selectgroup-button1">Tidak</span>
                                    </label>
                                </div>

                            </div>
                    </div>
                    @endforeach
                    {{-- draw line --}}
                    <hr class="my-1">
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a class="btn btn-outline-primary mr-2" href="javascript(0);" id="btn-back2">
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
</section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/admin/master-pegawai.js') }}"></script>
@endpush
