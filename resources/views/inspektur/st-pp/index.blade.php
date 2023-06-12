@extends('layouts.app')

@section('title', 'Usulan ST Pengembangan Profesi')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Usulan ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/sekretaris">Dashboard</a></div>
                    <div class="breadcrumb-item">Usulan ST Pengembangan Profesi</div>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <table class="table table-bordered table-striped display responsive"
                                        id="table-pengelolaan-dokumen-inspektur">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Usulan</th>
                                                <th>Pemohon</th>
                                                <th>Tanggal Surat</th>
                                                <th>Jenis PP</th>
                                                <th>Nama PP</th>
                                                <th>Status ST</th>
                                                <th>Surat Tugas</th>
                                                <th>Status Sertifikat</th>
                                                <th>Sertifikat</th>
                                                <th>Tanggal Upload Sertifikat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usulan as $un)
                                            <tr>
                                                <td></td>
                                                <td><a href="/inspektur/st-pp/{{ $un->id }}">{{ $un->created_at->format('Y-m-d') }}</a></td>
                                                <td>{{ $un->user->name }}</td>
                                                <td>{{ $un->tanggal }}</td>
                                                <td>{{ $un->pp->jenis }}</td>
                                                <td>{{ $un->nama_pp }}</td>
                                                <td>
                                                    @if ($un->status == 0)
                                                        <a href="/inspektur/st-pp/{{ $un->id }}" class="badge badge-warning">Menunggu Persetujuan</a>
                                                    @elseif ($un->status == 1)
                                                        <a href="/pegawai/st-pp/{{ $un->id }}" class="badge badge-danger">Tidak Disetujui</a>
                                                    @else
                                                        <div class="badge badge-success">Disetujui</div>
                                                    @endif
                                                    </td>
                                                <td>
                                                @if ($un->status != 0 && $un->status != 1)
                                                    <a target="blank" href="{{ $un->file }}" download>{{ $un->no_surat }}</a>
                                                @endif
                                                </td>
                                                <td>
                                                    @if ($un->status == 2)
                                                        <div class="badge badge-light">Belum Upload</div>
                                                    @elseif ($un->status == 3)
                                                        <div class="badge badge-warning">Menunggu Persetujuan</div>
                                                    @elseif ($un->status == 4)
                                                        <a href="/pegawai/st-pp/{{ $un->id }}" class="badge badge-danger">Tidak Disetujui</a>
                                                    @elseif ($un->status == 5)
                                                        <div class="badge badge-success">Disetujui</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($un->status == 5)
                                                        <a target="blank" href="{{ $un->sertifikat }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
                                                    @endif
                                                </td>
                                                <td>{{ ($un->status == 3 || $un->status == 4 || $un->status == 5) ? $un->tanggal_sertifikat : '' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    <script src="{{ asset('js') }}/page/inspektur-pengelolaan-dokumen.js"></script>
@endpush
