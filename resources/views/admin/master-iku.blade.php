@extends('layouts.app')

@section('title', 'Master IKU Inspektorat Utama')

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
        @include('components.master-iku.create');
        @include('components.master-iku.edit');
        <section class="section">
            <div class="section-header">
                <h1>Master IKU Inspekotrat Utama</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            <p class="mt-3">
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Halaman Mengelola IKU Inspektorat Utama.
                            </p>
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
                                    <button type="button" id="create-btn" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-create-masteriku">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <table id="master-iku" class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 84px">Tahun</th>
                                            <th>Tujuan</th>
                                            <th>Sasaran</th>
                                            <th>Indikator Kinerja Utama</th>
                                            <th style="min-width: 98px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($masterIku as $iku)
                                            <tr id="index_{{ $iku->id_iku }}">
                                                <td>
                                                    {{ $iku->sasaran->tujuan->tahun_mulai }} -
                                                    {{ $iku->sasaran->tujuan->tahun_selesai }}
                                                </td>
                                                <td>{{ $iku->sasaran->tujuan->tujuan }}</td>
                                                <td>{{ $iku->sasaran->sasaran }}</td>
                                                <td>{{ $iku->iku }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                                                        data-id="{{ $iku->id_iku }}" style="width: 42px"
                                                        data-toggle="modal" data-target="#modal-edit-masteriku">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                                                        data-id="{{ $iku->id_iku }}" style="width: 42px">
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
    <script src="{{ asset('js/page/admin/master-iku.js') }}"></script>
@endpush
