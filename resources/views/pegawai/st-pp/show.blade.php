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
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Upload Sertifikat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/pegawai/st-pp/{{ $usulan->id }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="draft">Upload Sertifikat</label>
                                <input type="file" class="form-control @error('sertifikat') is-invalid @enderror" name="sertifikat" accept=".docx, .doc" id="sertifikat" value="{{ old('sertifikat') }}">
                                @error('sertifikat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h2>Detail Usulan</h2>
                                    @if ($usulan->status == 1 || $usulan->status == 4)
                                    <div class="pt-1 pb-1 m-4">
                                        <a href="/pegawai/st-pp/{{ $usulan->id }}/edit"
                                            class="btn btn-primary btn-lg btn-round">
                                            Edit Usulan
                                        </a>
                                    </div>
                                    @elseif ($usulan->status == 2)
                                    <div data-toggle="modal" data-target="#staticBackdrop" class="pt-1 pb-1 m-4 btn btn-primary btn-lg btn-round">
                                            Edit Usulan
                                    </div>
                                    @endif

                                    <table class="table">
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
                                        <th>Jenis PP</th>
                                        <th>:</th>
                                        <td>{{ $usulan->pp->jenis }}</td>
                                        </tr>
                                        <tr>
                                        <th>Nama PP</th>
                                        <th>:</th>
                                        <td>{{ $usulan->nama_pp }}</td>
                                        </tr>
                                        <tr>
                                        <th>Untuk Melaksanakan</th>
                                        <th>:</th>
                                        <td>{{ $usulan->melaksanakan }}</td>
                                        </tr>
                                        <tr>
                                        <th>Mulai-Selesai</th>
                                        <th>:</th>
                                        <td>{{ $usulan->mulai." - ".$usulan->selesai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pegawai</th>
                                            <th>:</th>
                                            <td>{{ $pegawai }}</td>
                                        </tr>
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
                                        <th>File</th>
                                        <th>:</th>
                                        <td><a target="blank" href="{{ $usulan->file }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                        </tr>
                                        <tr>
                                        <th>Sertifikat</th>
                                        <th>:</th>
                                        <td>
                                            @if ($usulan->status == 2)
                                                <div class="badge badge-light">Proses Tugas</div>
                                            @elseif ($usulan->status == 3)
                                                Menunggu Persetujuan
                                            @elseif ($usulan->status == 4)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @elseif ($usulan->status == 5)
                                                <a target="blank" href="{{ $usulan->sertifikat }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
                                            @endif
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>Tanggal Upload Sertifikat</th>
                                        <th>:</th>
                                        <td>{{ ($usulan->status == 3 || $usulan->status == 4 || $usulan->status == 5) ? $usulan->tanggal_sertifikat : '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->catatan }}</td>
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
