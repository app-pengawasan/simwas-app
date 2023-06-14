@extends('layouts.app')

@section('title', 'Satuan Kerja')

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
        @include('components.modal-import-excel');
        @include('components.master-objek.form.create-satuan-kerja');
        @include('components.master-objek.form.edit-satuan-kerja');
        <section class="section">
            <div class="section-header">
                <h1>Master Satuan Kerja</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Halaman kelola daftar Satuan Kerja BPS, untuk melakukan import silahkan
                                download
                                format <a href="{{ asset('document/data-satuan-kerja-bps.xlsx') }}"
                                    class="link-primary font-weight-bold" download="">disini</a>.</p>
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
                                        data-target="#modal-create-satuankerja">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-import-excel">
                                        <i class="fas fa-file-upload"></i>
                                        Import
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <table id="master-satuan-kerja" class="table table-bordered display responsive">
                                    <thead>
                                        <tr>
                                            <th>Kode Wilayah</th>
                                            <th>Kode Satuan Kerja</th>
                                            <th>Nama Satuan Kerja</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($master_satuankerja as $satuankerja)
                                            <tr id="index_{{ $satuankerja->id_objek }}">
                                                <td>{{ $satuankerja->kode_wilayah }}</td>
                                                <td>{{ $satuankerja->kode_satuankerja }}</td>
                                                <td>{{ $satuankerja->nama }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                                                        data-id="{{ $satuankerja->id_objek }}" style="width: 42px"
                                                        data-toggle="modal" data-target="#modal-edit-satuankerja">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                                                        data-id="{{ $satuankerja->id_objek }}" style="width: 42px">
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
    <script src="{{ asset('js') }}/page/master-satuan-kerja.js"></script>
    <script>
        // let table2 = $("#master-satuan-kerja");

        // $(function() {
        //     table2
        //         .DataTable({
        //             dom: "Bfrtip",
        //             responsive: true,
        //             lengthChange: false,
        //             autoWidth: false,
        //             buttons: [{
        //                     extend: "excel",
        //                     className: "btn-success",
        //                     exportOptions: {
        //                         columns: [0, 1],
        //                     },
        //                 },
        //                 {
        //                     extend: "pdf",
        //                     className: "btn-danger",
        //                     exportOptions: {
        //                         columns: [0, 1],
        //                     },
        //                 },
        //             ],
        //         })
        //         .buttons()
        //         .container()
        //         .appendTo("#master-unit-kerja_wrapper .col-md-6:eq(0)");
        // });
    </script>
@endpush
