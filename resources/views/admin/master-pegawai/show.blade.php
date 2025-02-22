@extends('layouts.app')

@section('title', 'Master Pegawai')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/admin/master-pegawai">Master Pegawai</a></div>
                <div class="breadcrumb-item">Detail Pegawai</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="/admin/master-pegawai/">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div> --}}
                        <h1 class="h4 text-dark mb-4 header-card">Data Pribadi Pegawai</h1>
                        <table class="table table-striped responsive" id="table-show">
                            <tr>
                                <th>Nama:</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th style="min-width: 160pt">Nomor Induk Pegawai (NIP):</th>
                                <td>{{ $user->nip }}</td>
                            </tr>
                            <tr>
                                <th>Pangkat/Jabatan:</th>
                                <td>{{ $pangkat["$user->pangkat"] }} / {{ $jabatan["$user->jabatan"] }}</td>
                            </tr>
                            <tr>
                                <th>Unit Kerja:</th>
                                <td>{{ $unit_kerja["$user->unit_kerja"] }}</td>
                            </tr>
                            <tr>
                                <th>Role/Group:</th>
                                <td class="py-2">
                                    @if (
                                    !(
                                    $user->is_admin ||
                                    $user->is_sekma ||
                                    $user->is_sekwil ||
                                    $user->is_perencana ||
                                    $user->is_apkapbn ||
                                    $user->is_opwil ||
                                    $user->is_analissdm ||
                                    $user->is_aktif ||
                                    $user->is_arsiparis
                                    ))
                                    -
                                    @else
                                    @foreach ($role as $key => $value)
                                    @if ($user["$key"])
                                    <span class="badge badge-success my-1">{{ $value }}</span>
                                    @endif
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <hr class="my-1">
                        <div class="d-flex justify-content-start align-content-end mb-0 mt-4 pb-0" style="gap: 10px">
                            <a class="btn btn-outline-primary" href="/admin/master-pegawai/">
                                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <a class="btn btn-warning" href="/admin/master-pegawai/{{ $user->id }}/edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if ($user->id != auth()->user()->id)
                                @if ($user->status == 1)
                                    <a href="javascript:void(0)" class="btn btn-danger delete-btn" data-id="{{ $user->id }}">
                                        <i class="fas fa-ban"></i> Nonaktifkan
                                    </a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-success activate-btn" data-id="{{ $user->id }}">
                                        <i class="fas fa-check-circle"></i> Aktifkan
                                    </a>
                                @endif
                            @endif
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
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/admin/master-pegawai.js') }}"></script>
@endpush
