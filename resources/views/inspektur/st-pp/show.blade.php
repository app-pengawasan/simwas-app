@extends('layouts.app')

@section('title', 'Detail Usulan ST Pengembangan Profesi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tolak {{ $usulan->status == 0 ? 'Usulan' : ( $usulan->status == 3 ? 'Surat' : 'Sertifikat')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/inspektur/st-pp/{{ $usulan->id }}" method="post">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')    
                            <input type="hidden" name="status" value="{{ $usulan->status == 0 ? '1' : ( $usulan->status == 3 ? '4' : '7')}}">
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
                            <button type="submit" class="btn btn-danger">Tidak Setujui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Detail Usulan ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/inspektur/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/inspektur/st-pp">ST Pengembangan Profesi</a></div>
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
                                            <th>Backdate</th>
                                            <th>:</th>
                                            <td>{{ $usulan->is_backdate ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Surat</th>
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
                                            <th>Status</th>
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
                                            <th>Sumber anggaran</th>
                                            <th>:</th>
                                            <td>{{ $usulan->pembebanan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pegawai</th>
                                            <th>:</th>
                                            <td>{{ $pegawai }}</td>
                                        </tr>
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
                                        <tr>
                                            <th>Status Sertifikat</th>
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
                                        <th>Sertifikat</th>
                                        <th>:</th>
                                        @if ($usulan->sertifikat)
                                        <td><a target="blank" href="{{ $usulan->sertifikat }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                        @endif
                                        </tr>
                                        <tr>
                                        <th>Tanggal Upload Sertifikat</th>
                                        <th>:</th>
                                        <td>{{ $usulan->tanggal_sertifikat ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->catatan }}</td>
                                        </tr>
                                    </table>
                                        </div>
                                    </div>
                                    @if ($usulan->status == 0)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                    <a href="/inspektur/st-pp/{{ $usulan->id }}/edit" class="btn btn-primary mr-2">
                                                        Edit Usulan
                                                    </a>
                                                    <form action="/inspektur/st-pp/{{ $usulan->id }}" method="post" class="mr-2">
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
                                                <form action="/inspektur/st-pp/{{ $usulan->id }}" method="post" class="mr-2">
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
                                    @elseif ($usulan->status == 6)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                <form action="/inspektur/st-pp/{{ $usulan->id }}" method="post" class="mr-2">
                                                    @csrf
                                                    @method('PUT')    
                                                    <input type="hidden" name="status" value="8">
                                                    <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                    <button type="submit" class="btn btn-success">Setujui Sertifikat</button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#staticBackdrop">
                                                    Tidak Setujui Sertifikat
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
