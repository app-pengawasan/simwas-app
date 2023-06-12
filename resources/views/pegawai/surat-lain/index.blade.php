@extends('layouts.app')

@section('title', 'Surat Lain')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="base-url" content="{{ route('master-pegawai.destroy', ':id') }}"> --}}
    <!-- CSS Libraries -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Surat Lain</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Surat Lain</div>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="section-body">
                <h2 class="section-title">Format surat</h2>
                <p class="section-lead">Contoh format surat bisa dilihat <a
                    target="blank"
                    href="http://s.bps.go.id/templeteSURAT_ittama"
                    class="link-primary fw-bold">di sini</a>.
                </p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                    <a href="/pegawai/surat-lain/create"
                                        class="btn btn-primary btn-lg btn-round">
                                        + Ajukan Usulan Surat
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped display responsive" id="table-pengelolaan-dokumen-pegawai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Hal</th>
                                                <th>Nomor Surat</th>
                                                <th>Surat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usulan as $un)
                                            <tr>
                                                <td></td>
                                                <td><a href="/pegawai/surat-lain/{{ $un->id }}">{{ $un->tanggal }}</a></td>
                                                <td>{{ $un->jenis_surat }}</a></td>
                                                <td>{{ $un->hal }}</td>
                                                <td>
                                                    @if($un->status == 0)
                                                        Menunggu Persetujuan
                                                    @elseif($un->status == 1)
                                                    <a href="/pegawai/surat-lain/{{ $un->id }}"><div class="badge badge-danger">Tidak Disetujui</div></a>
                                                    @else
                                                        <a href="/pegawai/surat-lain/{{ $un->id }}">{{ $un->no_surat }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($un->status == 2)
                                                    <div class="container">
                                                        <div class="row">
                                                            <a target="blank" class="btn btn-sm btn-primary" href="{{ asset('storage/'.$un->surat) }}" download>Download Surat Belum TTD</a>
                                                        </div>
                                                        <div class="row">
                                                            <a class="btn btn-sm btn-info" href="{{ route('surat-lain.edit', ['surat_lain' => $un->id]) }}">Upload Surat Sudah TTD</a>
                                                        </div>
                                                    </div>
                                                    @elseif($un->status == 3)
                                                        Menunggu Persetujuan
                                                    @elseif($un->status == 4)
                                                        <a href="/pegawai/surat-lain/{{ $un->id }}"><div class="badge badge-danger">Tidak Disetujui</div></a>
                                                    @elseif($un->status == 5)
                                                    <a target="blank" href="{{ asset('storage/'.$un->surat) }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
                                                    @endif
                                                </td>
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
    {{-- <script>
        $(document).ready(function() {
            $('#table-pengelolaan-dokumen-pegawai').DataTable( {
            "columnDefs": [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
            });
        });
    </script> --}}
    
    <!-- Page Specific JS File -->
    <script src="{{ asset('js') }}/page/pegawai-pengelolaan-dokumen.js"></script>
@endpush
