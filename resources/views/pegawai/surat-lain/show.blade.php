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
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <h2>Detail Usulan</h2>
                                        @if ($usulan->status == 1 || $usulan->status == 4)
                                            <div class="pt-1 pb-1 m-4">
                                                <a href="/pegawai/surat-lain/{{ $usulan->id }}/edit"
                                                    class="btn btn-primary btn-lg btn-round">
                                                    Edit Usulan
                                                </a>
                                            </div>
                                        @endif     
                                            <table class="table">
                                                @if ($usulan->status == 1 || $usulan->status == 4)
                                                    <tr>
                                                        <th>Catatan</th>
                                                        <th>:</th>
                                                        <td>{{ $usulan->catatan }}</td>
                                                    </tr>
                                                @endif  
                                                <tr>
                                                    <th>Nomor Surat</th>
                                                    <th>:</th>
                                                    <td>
                                                        @if($usulan->status == 0)
                                                            Menunggu Persetujuan
                                                        @elseif($usulan->status == 1)
                                                            <div class="badge badge-danger">Tidak Disetujui</div>
                                                        @else
                                                            {{ $usulan->no_surat }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->tanggal }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Surat</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->jenis_surat }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Derajat Klasifikasi</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->derajat_klasifikasi }}</td>
                                                </tr>
                                                <tr>
                                                    <th>KKA</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->kka->kode }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Unit Kerja</th>
                                                    <th>:</th>
                                                    <td>
                                                        {{
                                                            ($usulan->unit_kerja == "8000") ? "Inspektorat Utama" :
                                                            (($usulan->unit_kerja == "8010") ? "Bagian Umum Inspektorat Utama" :
                                                            (($usulan->unit_kerja == "8100") ? "Inspektorat Wilayah I" :
                                                            (($usulan->unit_kerja == "8200") ? "Inspektorat Wilayah II" :
                                                            "Inspektorat Wilayah III")))
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Hal</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->hal }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Draft</th>
                                                    <th>:</th>
                                                    <td>
                                                        <a target="blank" href="{{ asset('storage/'.$usulan->draft) }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Surat</th>
                                                    <th>:</th>
                                                    <td>
                                                        @if($usulan->status == 2)
                                                            <a target="blank" class="btn btn-sm btn-primary" href="{{ asset('storage/'.$usulan->surat) }}" download>Download Surat Belum TTD</a>
                                                            <a class="btn btn-sm btn-info" href="{{ route('surat-lain.edit', ['surat_lain' => $usulan->id]) }}">Upload Surat Sudah TTD</a>
                                                        @elseif($usulan->status == 3)
                                                            Menunggu Persetujuan
                                                        @elseif($usulan->status == 4)
                                                            <div class="badge badge-danger">Tidak Disetujui</div>
                                                        @elseif($usulan->status == 5)
                                                            <a target="blank" href="{{ asset('storage/'.$usulan->surat) }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
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
@endpush
