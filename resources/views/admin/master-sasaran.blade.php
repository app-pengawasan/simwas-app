@extends('layouts.app')

@section('title', 'Master Sasaran Inspektorat Utama')

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
        @include('components.master-sasaran.create');
        @include('components.master-sasaran.edit');
        <section class="section">
            <div class="section-header">
                <h1>Master Sasaran Inspekotrat Utama</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Halaman Mengelola Sasaran Inspektorat Utama.</p>
                            @if (session()->has('success'))
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <p>{{ session('success') }}</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>Gagal menambah data Unit Kerja</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-create-mastersasaran">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <table id="master-sasaran" class="table table-bordered display responsive">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Tujuan</th>
                                            <th>Sasaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($masterSasaran as $sasaran)
                                            <tr id="index_{{ $sasaran->id_sasaran }}">
                                                <td>{{ $sasaran->tujuan->tahun_mulai }} -
                                                    {{ $sasaran->tujuan->tahun_selesai }}</td>
                                                <td>{{ $sasaran->tujuan->tujuan }}</td>
                                                <td>{{ $sasaran->sasaran }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                                                        data-id="{{ $sasaran->id_sasaran }}" style="width: 42px"
                                                        data-toggle="modal" data-target="#modal-edit-mastersasaran">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                                                        data-id="{{ $sasaran->id_sasaran }}" style="width: 42px">
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
    <script src="{{ asset('js') }}/page/master-sasaran.js"></script>
@endpush
