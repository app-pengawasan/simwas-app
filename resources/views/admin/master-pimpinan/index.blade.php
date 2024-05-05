@extends('layouts.app')

@section('title', 'Master Pimpinan')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="base-url" content="{{ route('master-pegawai.destroy', ':id') }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelola Pimpinan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item">Kelola Pimpinan</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <p class="mbt-3">
                            <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                            Halaman untuk mengelola Pimpinan Inspektorat
                        </p>
                        <div id="download-button">
                        </div>
                        </div>
                        @include('components.flash')

                        <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                            <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                <div id="filter-search-wrapper">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                <label for="filter-jabatan" style="margin-bottom: 0;">
                                    Jabatan</label>
                                <select name="jabatan" id="filter-jabatan" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($jabatan_pimpinan as $key => $value)
                                    <option value="{{ $value }}" {{ request()->jabatan == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex align-items-end">
                                <a type="button" class="btn btn-primary" href="/admin/master-pimpinan/create">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>

                        <div class="">
                            <table id="table-master-pimpinan"
                                class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">No</th>
                                        <th style="width: 100px;">NIP</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Masa Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pimpinan as $p)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $p->user->nip }}</td>
                                        <td>{{ $p->user->name }}</td>
                                        <td>{{ $jabatan_pimpinan["$p->jabatan"] }}</td>
                                        <td>
                                            {{ date('d M Y', strtotime($p->mulai)) }} -
                                            {{ date('d M Y', strtotime($p->selesai)) }}</td>
                                        <td>
                                            {{-- <a class="btn btn-primary"
                                                        href="/admin/master-pimpinan/{{ $p->id_pimpinan }}"
                                            style="width: 42px">
                                            <i class="fas fa-info"></i>
                                            </a> --}}
                                            <a class="btn btn-warning btn-sm"
                                                href="/admin/master-pimpinan/{{ $p->id_pimpinan }}/edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-danger delete-btn btn-sm"
                                                data-id="{{ $p->id_pimpinan }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/admin/master-pimpinan.js') }}"></script>
@endpush
