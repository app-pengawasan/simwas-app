@extends('layouts.app')

@section('title', 'Master Pegawai')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="base-url" content="{{ route('master-pegawai.destroy', ':id') }}"> --}}
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
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Import Data Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/admin/master-pegawai/import" enctype="multipart/form-data"
                        class="needs-validation" novalidate="">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" class="form-control" name="file" accept=".xlsx" required>
                                <div class="invalid-feedback">
                                    File belum ditambahkan
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Impor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Master Pegawai
                </h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">
                                Untuk melakukan import pegawai silahkan download format <a
                                    href="{{ asset('document/data-pegawai-inspektorat-utama.xlsx') }}"
                                    class="link-primary fw-bold" download>disini</a>.
                            </p>
                            @include('components.flash')
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
                                    <a type="button" class="btn btn-primary" href="/admin/master-pegawai/create">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#staticBackdrop">
                                        <i class="fas fa-file-upload"></i>
                                        Import
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <table id="table-master-pegawai"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px;">NIP</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Unit Kerja</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->nip }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $jabatan["$user->jabatan"] }}</td>
                                                <td>{{ $unit_kerja["$user->unit_kerja"] }}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                        href="/admin/master-pegawai/{{ $user->id }}"
                                                        style="width: 42px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-warning"
                                                        href="/admin/master-pegawai/{{ $user->id }}/edit"
                                                        style="width: 42px">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if ($user->id != auth()->user()->id)
                                                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                                                            style="width: 42px" data-id="{{ $user->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <form action="/admin/master-pegawai/:id" method="post" id="form-delete">
        @csrf
        @method('delete')
        <button type="submit"></button>
    </form>
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
    <script src="{{ asset('js/page/admin/master-pegawai.js') }}"></script>
@endpush
