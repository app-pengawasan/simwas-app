@extends('layouts.app')

@section('title', 'Kendali Mutu')

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
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <!-- Modal -->
    @include('pegawai.tugas-tim.km.create');
    {{-- Modal --}}
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kendali Mutu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" id="myeditform" name="myeditform">
                    <input type="hidden" name="km_id" id="km_id">
                    <div class="modal-body">
                        {{-- @csrf --}}
                        <div class="form-group">
                            <label for="edit-link">File Kendali Mutu</label>
                            <input type="url" name="edit-link" id="edit-link" class="form-control link" placeholder="Link File Kendali Mutu" required>
                            <small id="error-edit-link" class="text-danger"></small>

                            <div class="d-flex mt-2 align-items-center">
                                <label for="edit-file" style="color: #34395e; width: 24%" class="mt-2">
                                    <em>atau upload file</em>
                                </label>
                                <input type="file" name="edit-file" id="edit-file" class="form-control file" accept=".rar, .zip" required>
                                <button type="button" class="btn btn-primary ml-2 h-100 clear" id="edit-clear">
                                    Clear
                                </button>
                            </div>
                            <small id="error-edit-file" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="edit-submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="section-header">
            <h1>Kendali Mutu</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Kendali Mutu</div>
            </div>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-end">
                                <button type="button" class="btn btn-primary" id="create-btn" data-toggle="modal"
                                    data-target="#modal-create-tim-km">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display responsive"
                                    id="table-pengelolaan-dokumen-pegawai">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; text-align:center">No</th>
                                            <th style="width: 20%">Tugas</th>
                                            <th>Objek Pengawasan</th>
                                            <th>Bulan Pelaporan</th>
                                            <th>Dokumen</th>
                                            <th>Verifikasi Arsiparis</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dokumen as $km)
                                        <tr>
                                            <td></td>
                                            <td>{{ $km->laporanObjekPengawasan->objekPengawasan->rencanaKerja->tugas }}</td>
                                            <td>{{ $km->laporanObjekPengawasan->objekPengawasan->nama }}</td>
                                            <td>{{ $months[$km->laporanObjekPengawasan->month] }}</td>
                                            
                                            @if ($km->status == 'tidak ada')
                                                <td></td>
                                            @else
                                                <td>
                                                    @if (file_exists($km->path))
                                                        <a class="badge btn-primary"
                                                        href="kendali-mutu/download/{{ $km->id }}" target="_blank">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    @else
                                                        <a class="badge btn-primary"
                                                        href="{{ $km->path }}" target="_blank">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif

                                            <td>
                                                <span class="badge
                                                    {{ $km->status == 'diperiksa' ? 'badge-primary' : '' }}
                                                    {{ $km->status == 'disetujui' ? 'badge-success' : '' }}
                                                    {{ $km->status == 'ditolak' ? 'badge-danger' : '' }}
                                                    {{ $km->status == 'tidak ada' ? 'badge-dark' : '' }}
                                                    text-capitalize"><i class="
                                                        {{ $km->status == 'diperiksa' ? 'fa-regular fa-clock mr-1' : '' }}
                                                        {{ $km->status == 'disetujui' ? 'fa-regular fa-circle-check mr-1' : '' }}
                                                        {{ $km->status == 'ditolak' ? 'fa-solid fa-triangle-exclamation mr-1' : '' }}
                                                        {{ $km->status == 'tidak ada' ? 'fa-regular fa-circle-xmark mr-1' : '' }}
                                                    "></i>{{ $km->status }}
                                                </span>
                                            </td>
                                            <td>{{ $km->catatan }}</td>
                                            <td>
                                                @if ($km->status != 'disetujui')
                                                        <button type="button" class="ml-2 btn btn-warning btn-sm edit-btn" data-toggle="modal"
                                                        data-target="#staticBackdrop" data-id="{{ $km->id }}">
                                                            <i class="fas fa-edit m-0"></i></button>
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
{{-- <script>
        $(document).ready(function() {
            $('#table-pengelolaan-dokumen-pegawai').DataTable( {
            "columnDefs": [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
            });
        });
    </script> --}}

<!-- Page Specific JS File -->
<script src="{{ asset('js') }}/page/pegawai/kendali-mutu-tim.js"></script>

@endpush
