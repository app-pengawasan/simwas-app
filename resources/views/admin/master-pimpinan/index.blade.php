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
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mbt-3">
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Halaman untuk mengelola Pimpinan Inspektorat
                            </p>
                            @include('components.flash')
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
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
                                                <td>{{ $p->user->nip }}</td>
                                                <td>{{ $p->user->name }}</td>
                                                <td>{{ $jabatan_pimpinan["$p->jabatan"] }}</td>
                                                <td>{{ date('d-m-Y', strtotime($p->mulai)) }} s.d.
                                                    {{ date('d-m-Y', strtotime($p->selesai)) }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-primary"
                                                        href="/admin/master-pimpinan/{{ $p->id_pimpinan }}"
                                                        style="width: 42px">
                                                        <i class="fas fa-info"></i>
                                                    </a> --}}
                                                    <a class="btn btn-warning"
                                                        href="/admin/master-pimpinan/{{ $p->id_pimpinan }}/edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger delete-btn"
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
