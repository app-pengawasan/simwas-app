@extends('layouts.app')

@section('title', 'Detail Usulan ST Pengembangan Profesi')

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
                <h1>Detail Usulan ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-pp">ST Pengembangan Profesi</a></div>
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
                                    <div class="pt-1 pb-1 m-4">
                                        <a href="/pegawai/st-pp/edit"
                                            class="btn btn-primary btn-lg btn-round">
                                            Edit Usulan
                                        </a>
                                    </div>
                                    <h5>Nomor Surat : 
                                        @if ($usulan->status == 0)
                                            Menunggu Persetujuan
                                        @elseif ($usulan->status == 1)
                                            <div class="badge badge-danger">Tidak Disetujui</div>
                                        @else
                                            {{ $usulan->no_st }}
                                        @endif
                                    </h5>
                                    <h5>Status : <?php if ($usulan->status === 0) {
                                        echo "Belum Upload";
                                    } elseif ($usulan->status === 1) {
                                        echo "Menunggu Persetujuan";
                                    } elseif ($usulan->status === 2) {
                                        echo "Disetujui";
                                    } else {
                                        echo "Tidak Disetujui";
                                    }?></h5>
                                    <h5>Tanggal : {{ $usulan->tanggal }}</h5>
                                    <h5>Jenis PP : {{ $usulan->pp->jenis }}</h5>
                                    <h5>Nama PP : {{ $usulan->nama_pp }}</h5>
                                    <h5>Untuk Melaksanakan : {{ $usulan->melaksanakan }}</h5>
                                    <h5>Mulai-Selesai : {{ $usulan->mulai." - ".$usulan->selesai }}</h5>
                                    <h5>Penandatangan : <?php if ($usulan->penandatangan === 0) {
                                        echo "Inspektur Utama";
                                    } elseif ($usulan->penandatangan === 1) {
                                        echo "Inspektur Wilayah I";
                                    } elseif ($usulan->penandatangan === 2) {
                                        echo "Inspektur Wilayah II";
                                    } elseif ($usulan->penandatangan === 3) {
                                        echo "Inspektur Wilayah III";
                                    } else {
                                        echo "Kepala Bagian Umum";
                                    }?></h5>
                                    <h5>E-Sign : @if($usulan->is_esign)
                                        {{ "Ya" }}
                                    @else
                                        {{ "Tidak" }}
                                    @endif</h5>
                                    <h5>File : <a href="{{ $usulan->file }}" target="_blank"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a></h5>
                                    <h5>Sertifikat : 
                                        @if ($usulan->status == 2)
                                            <a href="#" class="btn btn-icon btn-warning"><i class="fa fa-upload"></i></a>
                                        @elseif ($usulan->status == 3)
                                            Menunggu Persetujuan
                                        @elseif ($usulan->status == 4)
                                            <div class="badge badge-danger">Tidak Disetujui</div>
                                        @elseif ($usulan->status == 5)
                                            <a href="{{ $usulan->file }}" class="btn btn-icon btn-primary"><i class="fa fa-download"></i></a>
                                        @endif
                                    </h5>
                                    <h5>Tanggal Upload Sertifikat : {{ ($usulan->status == 3 || $usulan->status == 4 || $usulan->status == 5) ? $usulan->tanggal_sertifikat : '' }}</h5>
                                    <h5>Catatan : {{ $usulan->catatan }}</h5> 
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
