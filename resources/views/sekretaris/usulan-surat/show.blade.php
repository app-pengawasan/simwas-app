@extends('layouts.app')

@section('title', 'Detail Usulan Surat Pegawai')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    @include('components.sekretaris-header')
    @include('components.sekretaris-sidebar')
    <div class="main-content">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tolak usulan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/sekretaris/usulan-surat/{{ $usulan->id }}" method="post">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')    
                            <input type="hidden" name="status" value="{{ $usulan->status == 0 ? '1' : '4' }}">
                            <input type="hidden" name="id" value="{{ $usulan->id }}">
                            <div class="form-group">
                                <label for="catatan">Beri catatan</label>
                                <input type="text" class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" value="{{ old('catatan') }}">
                                @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tidak Setujui Usulan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Detail Usulan Surat Pegawai</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/sekretaris">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/sekretaris/usulan-surat">Usulan Surat Pegawai</a></div>
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
                                            <table class="table">
                                                <tr>
                                                    <th>Pemohon</th>
                                                    <th>:</th>
                                                    <td>{{ $usulan->user->name }}</td>
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
                                                    <th>Status Surat</th>
                                                    <th>:</th>
                                                    <td>
                                                    @if($usulan->status == 2)
                                                        <div class="badge badge-light">Belum Upload NH TTD</div>
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
                                                <tr>
                                                    <th>Catatan Terakhir</th>
                                                    <th>:</th>
                                                    <th>{{ $usulan->catatan }}</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    @if ($usulan->status == 0)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                    <a href="/sekretaris/usulan-surat/{{ $usulan->id }}/edit" class="btn btn-primary mr-2">
                                                        Edit Usulan
                                                    </a>
                                                    <form action="/sekretaris/usulan-surat/{{ $usulan->id }}" method="post" class="mr-2">
                                                        @csrf
                                                        @method('PUT')    
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                        <button type="submit" class="btn btn-success">Setujui Usulan</button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#staticBackdrop">
                                                        Tidak Setujui Usulan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($usulan->status == 3)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                <form action="/sekretaris/usulan-surat/{{ $usulan->id }}" method="post" class="mr-2">
                                                    @csrf
                                                    @method('PUT')    
                                                    <input type="hidden" name="status" value="5">
                                                    <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                    <button type="submit" class="btn btn-success">Setujui Surat</button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#staticBackdrop">
                                                    Tidak Setujui Surat
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
