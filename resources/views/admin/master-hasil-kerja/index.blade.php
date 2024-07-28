@extends('layouts.app')

@section('title', 'Master Hasil Kerja Inspektorat Utama')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Modal -->
    @include('admin.master-hasil-kerja.create');
    @include('admin.master-hasil-kerja.edit');
    <section class="section">
        <div class="section-header">
            <h1>Master Hasil Kerja Inspektorat Utama</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item">Master Hasil Kerja</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash')
                        @include('components.flash-error')
                        <div class="d-flex justify-content-between">
                            <p>
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Halaman Mengelola Hasil Kerja Inspektorat Utama
                            </p>
                            <div id="download-button">
                            </div>
                        </div>
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                            <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                <div id="filter-search-wrapper">
                                </div>
                            </div>
                            <div style="gap:10px" class="d-flex align-items-end">
                                <button type="button" id="create-btn" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-create-master-subunsur">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </button>
                            </div>
                        </div>
                        <div class="">
                            <table id="master-hasil-kerja"
                                class="table table-bordered table-striped table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 15px;">No</th>
                                        <th>Nama Hasil Kerja</th>
                                        <th>Status</th>
                                        <th>Nama Subunsur</th>
                                        <th>Master Kinerja</th>
                                        <th style="min-width: 98px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masterHasilKerjas as $hasilKerja)
                                    <tr id="index_{{ $hasilKerja->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $hasilKerja->nama_hasil_kerja }}</td>
                                        <td>{{
                                        $hasilKerja->kategori_pelaksana == 'gt' ? 'Gugus Tugas' : 'Non Gugus Tugas'

                                        }}</td>
                                        <td>{{ $hasilKerja->masterSubUnsur->nama_sub_unsur}}</td>
                                        <td>
                                            @if (count($hasilKerja->masterKinerja) > 0)
                                            <span class="badge badge-success">Sudah Diisi</span>
                                            @else
                                            <span class="badge badge-danger">
                                                <a href="{{ route('admin.master-kinerja.index', $hasilKerja->id) }}"
                                                    class="text-white">Belum Diisi</a>
                                            </span>
                                            @endif
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-warning btn-sm edit-button"
                                                    data-toggle="modal" data-target="#modal-edit-master-subunsur"
                                                    data-id="{{ $hasilKerja->id }}">
                                                    <i class=" fas fa-edit"></i>
                                                </button>
                                                <form
                                                    action="{{ route('admin.master-hasil-kerja.destroy', $hasilKerja->id) }}"
                                                    id="form-{{ $hasilKerja->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <input type="hidden" name="id" value="{{ hasilKerja->id }}">
                                                    --}}
                                                    <button type="button" data-id="{{ $hasilKerja->id }}"
                                                        class="btn btn-danger btn-sm ml-2 hapus-button">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
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
<script src="{{ asset('js') }}/page/admin/master-hasil-kerja.js"></script>
@endpush