@extends('layouts.app')

@section('title', 'Analis SDM')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css') }}">

@endpush

@section('main')
@include('components.analis-sdm-header')
@include('components.analis-sdm-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Analis SDM Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-body p-0">
                        <select class="form-control" id="filterPegawai" autocomplete="off">
                            <option value="" selected>Pilih Pegawai</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sertifikasi</h4>
                        </div>
                        <div class="card-body" id="sertifikasi">
                            0
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-ranking-star"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Diklat Penjenjangan</h4>
                        </div>
                        <div class="card-body" id="jenjang">
                            0
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-gears"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Diklat Teknis Subtantif</h4>
                        </div>
                        <div class="card-body" id="teknis">
                            0
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kompetensi</h4>
                    </div>
                    <div class="card-body" style="padding-top: 5px;">
                        <div class="d-flex mb-3 row" style="gap:10px">
                            <div class="form-group col-4" style="margin-bottom: 0;">
                                <label for="filterTahun" style="margin-bottom: 0;">Jenis Kompetensi</label>
                                <select class="form-control" id="filterJenis" name="filterJenis">
                                    <option value="all">Semua</option>
                                    <option value="1">Sertifikasi</option>
                                    <option value="2">Diklat Penjenjangan</option>
                                    <option value="3">Diklat Subtantif</option>
                                    <option value="4">Pelatihan</option>
                                    <option value="5">Workshop</option>
                                    <option value="6">Seminar</option>
                                    <option value="7">Pelatihan di Kantor Sendiri</option>
                                    <option value="999">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped display responsive"
                                id="table-dashboard-analis">
                                <thead>
                                    <tr>
                                        <th>Jenis Pengembangan Kompetensi</th>
                                        <th>Nama Pengembangan Kompetensi</th>
                                        <th>Sertifikat</th>
                                        <th class="never">pegawai</th>
                                        <th class="never">sertifikat_link</th>
                                        <th class="never">kode jenis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kompetensi as $k)
                                        <tr>
                                            @if ($k->pp->id == 999) <td>{{ $k->pp_lain }}</td>
                                            @else <td>{{ $k->pp->jenis }}</td>
                                            @endif

                                            @if ($k->namaPp->id == 999) <td>{{ $k->nama_pp_lain }}</td>
                                            @else <td>{{ $k->namaPp->nama }}</td>
                                            @endif

                                            <td>
                                                <a class="btn btn-primary"
                                                href="{{ asset('document/sertifikat/'.$k->sertifikat) }}" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>

                                            <td>{{ $k->pegawai_id }}</td>

                                            <td>{{ url('/').'/document/sertifikat/'.$k->sertifikat }}</td>
                                            <td>{{ $k->pp->id }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- Page Specific JS File -->
<script>
    var count = @json($count);
</script>
<script src="{{ asset('js') }}/page/kompetensi.js"></script>
@endpush
