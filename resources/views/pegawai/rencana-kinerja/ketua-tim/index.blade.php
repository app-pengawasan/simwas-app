@extends('layouts.app')

@section('title', 'Kelola Rencana Kinerja')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <!-- Modal -->
        <section class="section">
            <div class="section-header">
                <h1>Kelola Rencana Kinerja</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex my-3">
                                <p class="">
                                    <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                    Halaman untuk mengelola rencana kinerja yang didelegasikan.
                                </p>
                            </div>
                            <div class="mt-3">
                                <table id="tim-kerja" class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Unit Kerja</th>
                                            <th>IKU</th>
                                            <th>Kegiatan</th>
                                            <th>Ketua Tim</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timKerja as $tim)
                                            <tr id="index_{{ $tim->id_timkerja }}">
                                                <td>{{ $tim->tahun }}</td>
                                                <td>{{ $unitKerja[$tim->unitkerja] }}</td>
                                                <td>{{ $tim->iku->iku }}</td>
                                                <td>{{ $tim->nama }}</td>
                                                <td>{{ $tim->ketua->name }}</td>
                                                <td class="text-{{ $colorText[$tim->status] }}">
                                                    {{ $statusTim[$tim->status] }}
                                                </td>
                                                <td>
                                                    <a href="/ketua-tim/rencana-kinerja/{{ $tim->id_timkerja }}"
                                                        class="btn btn-primary" style="width: 42px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
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
    <script src="{{ asset('js/page/pegawai/ketua-tim-rencana-kinerja.js') }}"></script>
@endpush
