@extends('layouts.app')

@section('title', 'Changelogs')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
<div class="main-content">
    <!-- Modal -->
    @include('components.master-objek.form.create-isi-changelogs');
    @include('components.master-objek.form.edit-isi-changelogs');
    <section class="section">
        <div class="section-header">
            <h1>Changelogs</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item">Changelogs</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash')
                        <div class="d-flex justify-content-between">                            
                        </div>
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                            <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                <div id="filter-search-wrapper">
                                </div>
                            </div>
                            <div style="gap:10px" class="d-flex align-items-end">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-create-isi-changelogs">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </button>
                            </div>
                        </div>
                        <div class="">
                            <table id="changelogs"
                                class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 15px;">No</th>
                                        <th class="text-center">Judul Perubahan</th>
                                        <th class="text-center">Perubahan</th>
                                        <th class="text-center">Versi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($changelog as $cl)
                                    <tr id="index_{{ $cl->id_isichangelog }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $cl->judul }}</td>
                                        <td>{{ $cl->isi }}</td>
                                        <td>{{ $cl->versi }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-warning edit-btn btn-sm"
                                                data-id="{{ $cl->id_isichangelog }}"
                                                data-toggle="modal" data-target="#modal-edit-isi-changelogs">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-danger delete-btn btn-sm"
                                                data-id="{{ $cl->id_isichangelog }}">
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
<script src="{{ asset('js/page/admin/changelogisi.js') }}"></script>
@endpush
