@extends('layouts.app')

@section('title', 'Detail Usulan ST Kinerja dan Norma Hasil')

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
                <h1>Detail Usulan ST Kinerja dan Norma Hasil</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-kinerja">ST Kinerja dan Norma Hasil</a></div>
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
                                    @if ($usulan->status == 1 || $usulan->status == 4 || $usulan->status == 7)
                                    <div class="pt-1 pb-1 m-4">
                                        <a href="/pegawai/st-kinerja/{{ $usulan->id }}/edit"
                                            class="btn btn-primary btn-lg btn-round">
                                            Edit Usulan
                                        </a>
                                    </div>
                                    @elseif ($usulan->status == 2)
                                    <form action="/inspektur/st-kinerja/{{ $usulan->id }}" method="post" class="mr-2">
                                        @csrf
                                        @method('PUT')    
                                        <input type="hidden" name="status" value="3">
                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                        <div class="pt-1 pb-1 m-4">
                                            <a type="submit" class="btn btn-primary btn-lg btn-round">
                                                Minta Nomor Norma Hasil
                                            </a>
                                        </div>
                                    </form>
                                    
                                    @endif

                                    <table class="table">
                                        @if ($usulan->status == 1 || $usulan->status == 4 || $usulan->status == 7)
                                        <tr class="text-danger">
                                            <th>Catatan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->catatan }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Backdate</th>
                                            <th>:</th>
                                            <td>{{ $usulan->is_backdate ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor ST</th>
                                            <th>:</th>
                                            <td>
                                            @if ($usulan->status == 0)
                                            <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status == 1)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @else
                                                {{ $usulan->no_surat }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status ST</th>
                                            <th>:</th>
                                            <td>
                                            @if ($usulan->status === 0)
                                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status === 1)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @else
                                                <div class="badge badge-success">Disetujui</div>
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <td>{{ $usulan->tanggal }}</td>
                                        </tr>
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
                                        <tr>
                                        <tr>
                                            <th>Tim Kerja</th>
                                            <th>:</th>
                                            <td>{{ $usulan->tim_kerja }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>:</th>
                                            <td>{{ $usulan->tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Untuk Melaksanakan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->melaksanakan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Objek Pengawasan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->objek }}</td>
                                        </tr>
                                        <tr>
                                        <th>Mulai-Selesai</th>
                                        <th>:</th>
                                        <td>{{ $usulan->mulai." - ".$usulan->selesai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gugus Tugas</th>
                                            <th>:</th>
                                            <td>{{ ($usulan->is_gugus_tugas) ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        @if (!($usulan->is_gugus_tugas))
                                        <tr>
                                            <th>Jenis</th>
                                            <th>:</th>
                                            <td>{{ ($usulan->is_perseorangan) ? '1 orang' : 'Kolektif' }}</td>
                                        </tr>
                                        @endif
                                        @if (!($usulan->is_perseorangan))
                                        @if ($usulan->is_gugus_tugas)
                                        <tr>
                                            <th>Pengendali Teknis</th>
                                            <th>:</th>
                                            <td>{{ $usulan->dalnis->name }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>{{ $usulan->is_gugus_tugas ? 'Ketua Tim' : 'Koordinator' }}</th>
                                            <th>:</th>
                                            <td>{{ $usulan->ketuaKoor->name }}</td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <th>Anggota</th>
                                            <th>:</th>
                                            <td>{{ $anggota }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                        <th>Penandatangan</th>
                                        <th>:</th>
                                        <td><?php if ($usulan->penandatangan === 0) {
                                            echo "Inspektur Utama";
                                        } elseif ($usulan->penandatangan === 1) {
                                            echo "Inspektur Wilayah I";
                                        } elseif ($usulan->penandatangan === 2) {
                                            echo "Inspektur Wilayah II";
                                        } elseif ($usulan->penandatangan === 3) {
                                            echo "Inspektur Wilayah III";
                                        } else {
                                            echo "Kepala Bagian Umum";
                                        }?>
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>E-Sign</th>
                                        <th>:</th>
                                        <td>@if($usulan->is_esign)
                                            {{ "Ya" }}
                                        @else
                                            {{ "Tidak" }}
                                        @endif
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>File ST</th>
                                        <th>:</th>
                                        @if ($usulan->file)
                                            <td><a target="blank" href="{{ $usulan->file }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <th>Status Nomor Norma Hasil</th>
                                            <th>:</th>
                                            <td>
                                                @if ($usulan->status == 2)
                                                    <div class="badge badge-light">Proses Tugas</div>
                                                @elseif ($usulan->status == 3)
                                                    <div class="badge badge-warning">Menunggu Persetujuan</div>
                                                @elseif ($usulan->status == 4)
                                                    <div class="badge badge-danger">Tidak Disetujui</div>
                                                @elseif ($usulan->status >= 5)
                                                    <div class="badge badge-success">Disetujui</div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Norma Hasil</th>
                                            <th>:</th>
                                            <td>{{ $usulan->no_nh }}</td>
                                        </tr>
                                        <tr>
                                        <th>Status Norma Hasil</th>
                                        <th>:</th>
                                        <td>
                                            @if ($usulan->status == 5)
                                                <div class="badge badge-light">Belum Upload</div>
                                            @elseif ($usulan->status == 6)
                                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status == 7)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @elseif ($usulan->status == 8)
                                                <div class="badge badge-success">Disetujui</div>
                                            @endif
                                        </td>
                                        </tr>
                                        <tr>
                                            <th>File Norma Hasil</th>
                                            <th>:</th>
                                            @if ($usulan->norma_hasil)
                                                <td><a target="blank" href="{{ $usulan->norma_hasil }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Tanggal Upload Norma Hasil</th>
                                            <th>:</th>
                                            <td>{{ $usulan->tanggal_nh }}</td>
                                        </tr>
                                    </table>
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
