@extends('layouts.app')

@section('title', 'Detail Surat Tugas')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Surat Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" name="myform" action="/pegawai/tim/surat-tugas/{{ $surat->nomor }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="file">File Surat Tugas</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
                        <small id="error-file" class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-edit">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Surat Tugas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/pegawai/tim/norma-hasil">Surat Tugas</a></div>
                <div class="breadcrumb-item">Detail</div>
            </div>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="col-md-4 mb-4">
                                            <a class="btn btn-primary" href="/pegawai/tim/surat-tugas">
                                                <i class="fas fa-chevron-circle-left"></i> Kembali
                                            </a>
                                        </div>

                                        @include('components.timeline.timeline-st')

                                        <table class="table">
                                            <tr>
                                                <th>Tugas</th>
                                                <th>:</th>
                                                <td>{{$tugas->implode(', ') }}</td>
                                            <tr>
                                                <th>Nomor Surat</th>
                                                <th>:</th>
                                                <td>
                                                    <span class="badge badge-primary">
                                                        {{ $surat->nomor }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nama Surat</th>
                                                <th>:</th>
                                                <td>{{ $surat->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>File Surat Tugas</th>
                                                <th>:</th>
                                                <td>
                                                    <a target="blank" href="{{ asset($surat->path) }}"
                                                        class="badge btn-primary" download><i
                                                            class="fa fa-download"></i> Download</a>
                                                    @if ($surat->status != 'disetujui')
                                                        <button type="button" class="ml-2 btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#staticBackdrop">
                                                            <i class="fas fa-edit m-0"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Verifikasi Arsiparis</th>
                                                <th>:</th>
                                                <td>
                                                    <span class="badge
                                                        {{ $surat->status == 'diperiksa' ? 'badge-primary' : '' }}
                                                        {{ $surat->status == 'disetujui' ? 'badge-success' : '' }}
                                                        {{ $surat->status == 'ditolak' ? 'badge-danger' : '' }}
                                                            text-capitalize">{{ $surat->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($surat->status == 'ditolak')
                                            <tr>
                                                <th>Alasan Penolakan</th>
                                                <th>:</th>
                                                <td>{{ $surat->catatan }}</td>
                                            </tr>
                                            @endif

                                        </table>
                                    </div>
                                </div>
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
{{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
{{-- <script src="{{ asset() }}"></script> --}}
{{-- <script src="{{ asset() }}"></script> --}}
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<script>
    document.forms['myform'].reset();

    $('.btn-edit').on("click", function (e) {
        if ($('#file').val() != '' && $('#file')[0].files[0].size / 1024 > 1024) {
            $('#error-file').text('Ukuran file maksimal 1MB');
            e.preventDefault();
        }
    });
</script>

@endpush
