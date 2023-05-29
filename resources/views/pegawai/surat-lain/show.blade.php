@extends('layouts.app')

@section('title', 'Detail Usulan Surat Lain')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('header-app')
@endsection
@section('sidebar')
@endsection

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Usulan Surat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/surat-lain">Surat Lain</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                    <article>
                                        <h2>Detail Usulan</h2>
                                        @if ($usulan->status == 1 || $usulan->status == 4)
                                            <div class="pt-1 pb-1 m-4">
                                                <a href="/pegawai/surat-lain/{{ $usulan->id }}/edit"
                                                    class="btn btn-primary btn-lg btn-round">
                                                    Edit Usulan
                                                </a>
                                            </div>
                                            <h5>Catatan : {{ $usulan->catatan }}</h5>
                                        @endif
                                        <h5>Nomor Surat : @if($usulan->status == 0)
                                            Menunggu Persetujuan
                                        @elseif($usulan->status == 1)
                                        <div class="badge badge-danger">Tidak Disetujui</div>
                                        @else
                                            {{ $usulan->no_surat }}
                                        @endif</h5>
                                        <h5>Tanggal : {{ $usulan->tanggal }}</h5>
                                        <h5>Kegiatan : {{ $usulan->kegiatan }}</h5>
                                        <h5>Subkegiatan : {{ $usulan->subkegiatan }}</h5>
                                        <h5>Jenis : {{ $usulan->jenisSurat->nama }}</h5>
                                        <h5>KKA : {{ $usulan->kka }}</h5>
                                        <h5>Surat : @if($usulan->status == 2)
                                            <a target="blank" class="btn btn-sm btn-warning" href="{{ $usulan->jenisSurat->file }}" download>Unduh Form</a><a class="btn btn-sm btn-info" href="{{ route('surat-lain.edit', ['surat_lain' => $usulan->id]) }}">Upload Surat</a>
                                        @elseif($usulan->status == 3)
                                            Menunggu Persetujuan
                                        @elseif($usulan->status == 4)
                                            <div class="badge badge-danger">Tidak Disetujui</div>
                                        @elseif($usulan->status == 5)
                                        <a target="blank" href="{{ asset('storage/'.$usulan->surat) }}" download><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                                        @endif</h5>    
                                    </article>
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
@endpush
