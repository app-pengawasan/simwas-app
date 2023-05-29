@extends('layouts.app')

@section('title', 'Tambah Pimpinan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Tambah Pimpinan</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('master-pimpinan.store') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="id_user">Nama</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="id_user" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="jabatan" required>
                                                @foreach ($jabatan_pimpinan as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('jabatan') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="mulai">Mulai</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="mulai"
                                                value="{{ old('mulai') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="selesai">Selesai</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="selesai"
                                                value="{{ old('selesai') }}" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Submit</button>
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

    <!-- Page Specific JS File -->
@endpush
