@extends('layouts.app')

@section('title', 'Usulan Surat Srikandi')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')

<div class="main-content">
    <!-- Modal -->
    {{-- @include('components.kelola-kompetensi.create');
    @include('components.kelola-kompetensi.edit'); --}}
    <section class="section">
        <div class="section-header">
            <h1>Usulan Surat Srikandi</h1>
        </div>
        @include('components.flash')
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="d-flex">
                            <div class="buttons ml-auto my-2">
                                <a href="{{ route('usulan-surat-srikandi.create') }}" id="create-btn"
                                    class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>
                        <div class="">
                            <table id="table-usulan-surat-srikandi"
                                class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Nomor Surat</th>
                                        <th>Jenis Surat</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usulanSuratSrikandi as $usulan)
                                    <tr>
                                        <td>{{ $usulan->tanggal }}</td>
                                        <td>{{ $usulan->nomor_surat }}</td>
                                        <td>{{ $usulan->jenis_naskah_dinas }}</td>
                                        <td>
                                            <span class="badge badge-light">{{ $usulan->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('usulan-surat-srikandi.edit', $usulan->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>
                                            <a href="{{ route('usulan-surat-srikandi.show', $usulan->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye
                                                "></i>
                                                Detail
                                            </a>

                                        </td>
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

<script src="{{ asset('js/page/pegawai/usulan-surat-srikandi/index.js') }}"></script>
@endpush