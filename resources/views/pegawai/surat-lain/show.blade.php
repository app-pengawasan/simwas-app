@extends('layouts.app')

@section('title', 'Detail Usulan Surat Lain')

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
        <form method="post" action="/pegawai/surat-lain/{{ $usulan->id }}" enctype="multipart/form-data">
            <div class="modal-body">
                @method('PUT')
                @csrf
                <input type="hidden" name="status" value="3">
                <input type="hidden" name="id" value="{{ $usulan->id }}">
                <div class="form-group">
                    <label for="draft">Upload Surat TTD</label>
                    <input type="file" class="form-control @error('surat') is-invalid @enderror" name="surat" accept=".pdf" id="surat" value="{{ old('surat') }}">
                    @error('surat')
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
                                        @if ($usulan->status == 1)
                                            <div class="pt-1 pb-1 m-4">
                                                <a href="/pegawai/surat-lain/{{ $usulan->id }}/edit"
                                                    class="btn btn-primary btn-lg btn-round">
                                                    Edit Usulan
                                                </a>
                                            </div>
                                        @elseif ($usulan->status == 2 || $usulan->status == 4)
                                                <a target="blank" href="{{ asset('storage/'.$usulan->draft) }}"
                                                    class="pt-1 pb-1 m-4 btn btn-primary btn-lg btn-round" download>
                                                    Download Surat Belum TTD
                                                </a>
                                            <div data-toggle="modal" data-target="#staticBackdrop" class="pt-1 pb-1 m-4 btn btn-primary btn-lg btn-round">
                                                Upload Surat Sudah TTD
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
                                                            <div class="badge badge-warning">Menunggu Persetujuan</div>
                                                        @elseif($usulan->status == 1)
                                                            <div class="badge badge-danger">Tidak Disetujui</div>
                                                        @else
                                                            {{ $usulan->no_surat }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Backdate</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->is_backdate ? 'Ya' : 'Tidak' }}</td>
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
                                                    <th>Status Surat</th>
                                                    <th>:</th>
                                                    <td>
                                                    @if($usulan->status == 2)
                                                        <div class="badge badge-light">Belum Upload Surat TTD</div>
                                                    @elseif($usulan->status == 3)
                                                        <div class="badge badge-warning">Menunggu Persetujuan</div>
                                                    @elseif($usulan->status == 4)
                                                        <div class="badge badge-danger">Tidak Disetujui</div>
                                                    @elseif($usulan->status == 5)
                                                        <div class="badge badge-success">Disetujui</div>
                                                    @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Surat</th>
                                                    <th>:</th>
                                                    <td>
                                                        @if($usulan->status >= 3)
                                                            <a target="blank" href="{{ asset($usulan->surat) }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
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
