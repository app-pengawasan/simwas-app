@extends('layouts.app')

@section('title', 'Detail Usulan ST Kinerja')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
        {{-- Modal --}}
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Upload Surat Sudah TTD</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/pegawai/st-kinerja/{{ $usulan->id }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="status" value="3">
                            <input type="hidden" name="id" value="{{ $usulan->id }}">
                            <div class="form-group">
                                <label for="draft">Upload Surat Sudah TTD</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" accept=".pdf" id="file" value="{{ old('file') }}">
                                @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Upload</button>
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
                <h1>Detail Usulan ST Kinerja</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-kinerja">ST Kinerja</a></div>
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
                                    @if ($usulan->status == 1)
                                    <div class="pt-1 pb-1 m-4">
                                        <a href="/pegawai/st-kinerja/{{ $usulan->id }}/edit"
                                            class="btn btn-primary btn-lg btn-round">
                                            Edit Usulan
                                        </a>
                                    </div>
                                    @elseif ($usulan->status == 2 || $usulan->status == 4)
                                        <a target="blank" href="{{ $usulan->draft }}"
                                            class="pt-1 pb-1 m-4 btn btn-primary btn-lg btn-round" download>
                                            Download ST Belum TTD
                                        </a>
                                    <div data-toggle="modal" data-target="#staticBackdrop" class="pt-1 pb-1 m-4 btn btn-primary btn-lg btn-round">
                                        Upload ST Sudah TTD
                                    </div>
                                    @endif

                                    <table class="table">
                                        @if ($usulan->status == 1 || $usulan->status == 4)
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
                                            @if ($usulan->status == 0 || $usulan->status == 3)
                                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status == 1 || $usulan->status == 4)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @elseif ($usulan->status == 2)
                                                <div class="badge badge-light">Belum Upload ST TTD</div>
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
                                                    ($usulan->rencanaKerja->timkerja->unitkerja == "8000") ? "Inspektorat Utama" :
                                                    (($usulan->rencanaKerja->timkerja->unitkerja == "8010") ? "Bagian Umum Inspektorat Utama" :
                                                    (($usulan->rencanaKerja->timkerja->unitkerja == "8100") ? "Inspektorat Wilayah I" :
                                                    (($usulan->rencanaKerja->timkerja->unitkerja == "8200") ? "Inspektorat Wilayah II" :
                                                    "Inspektorat Wilayah III")))
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tim Kerja</th>
                                            <th>:</th>
                                            <td>{{ $usulan->rencanaKerja->timkerja->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>:</th>
                                            <td>{{ $usulan->rencanaKerja->tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Untuk Melaksanakan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->melaksanakan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Objek Pengawasan</th>
                                            <th>:</th>
                                            <td>
                                                <?php
                                                    $objek = $usulan->rencanaKerja->objekPengawasan;
                                                    $objekArray = [];
                                                    foreach ($objek as $obj) {
                                                        $objekArray[] = $obj->nama; 
                                                    }
                                                    echo implode(", ", $objekArray);
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        <th>Mulai-Selesai</th>
                                        <th>:</th>
                                        <td>{{ $usulan->mulai." - ".$usulan->selesai }}</td>
                                        </tr>
                                        @foreach ($usulan->rencanaKerja->pelaksana as $pelaksana)
                                        <tr>
                                            <th>{{ $pelaksana->pt_jabatan == 1 ? 'Pengendali Teknis' : ($pelaksana->pt_jabatan == 2 ? 'Ketua Tim' : ($pelaksana->pt_jabatan == 3 ? 'PIC' : 'Anggota')) }}</th>
                                            <th>:</th>
                                            <td>[{{ $pelaksana->user->nip }}] {{ $pelaksana->user->name }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                        @if ($usulan->is_esign)
                                        <th>Penandatangan</th>
                                        <th>:</th>
                                        <td>[{{ $jabatan_pimpinan[$usulan->pimpinan->jabatan] }}] {{ $usulan->pimpinan->user->name }}</td>
                                        @endif
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
                                            <th>Draft</th>
                                            <th>:</th>
                                            @if ($usulan->draft)
                                                <td><a target="blank" href="{{ $usulan->draft }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                            @endif
                                        </tr>
                                        <tr>
                                        <th>File ST</th>
                                        <th>:</th>
                                        @if ($usulan->file)
                                            <td><a target="blank" href="{{ $usulan->file }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                        @endif
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

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    @endif
@endpush