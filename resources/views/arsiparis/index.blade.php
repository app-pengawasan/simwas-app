@extends('layouts.app')

@section('title', 'Dashboard Arsiparis')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.arsiparis-header')
@include('components.arsiparis-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Arsiparis Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Monitoring Kelengkapan Tugas Tim</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped display responsive"
                                id="table-dashboard-arsiparis">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tugas</th>
                                        <th>Nomor Surat Tugas</th>
                                        <th>File Surat Tugas</th>
                                        <th>Nomor Norma Hasil</th>
                                        <th>File Norma Hasil</th>
                                        <th>Status Norma Hasil</th>
                                        <th>Kendali Mutu</th>
                                        <th>Verifikasi Arsiparis</th>
                                        <th class="never">Nomor Surat Tugas</th>
                                        <th class="never">File Surat Tugas</th>
                                        <th class="never">Nomor Norma Hasil</th>
                                        <th class="never">File Norma Hasil</th>
                                        <th class="never">Status Norma Hasil</th>
                                        <th class="never">Kendali Mutu</th>
                                        <th class="never">Verifikasi Arsiparis</th>
                                    </tr>
                                </thead>
                                @php $i = 0; @endphp
                                <tbody>
                                    @foreach ($tugas as $t) 
                                        @php $i++; @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $t->tugas }}</td> 
                                            @if (isset($t->suratTugas) && $t->suratTugas->status == 'disetujui')
                                                <td>
                                                    <span class="badge badge-primary">
                                                        {{ $t->suratTugas->nomor }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a target="blank" href="{{ asset($t->suratTugas->path) }}"
                                                        class="badge btn-primary" download><i
                                                            class="fa fa-download"></i></a>
                                                </td>
                                            @else <td></td><td></td>
                                            @endif
                                            
                                            @if (isset($t->normaHasil[0]->normaHasilAccepted))
                                                <td>
                                                    <span class="badge badge-primary">
                                                        R-{{ $t->normaHasil[0]->normaHasilAccepted->nomor_norma_hasil}}/{{ $t->normaHasil[0]->normaHasilAccepted->unit_kerja}}/{{ 
                                                        $t->normaHasil[0]->normaHasilAccepted->kode_klasifikasi_arsip}}/{{
                                                            $kodeHasilPengawasan[$t->normaHasil[0]->normaHasilAccepted->kode_norma_hasil]}}/{{ date('Y', strtotime($t->normaHasil[0]->normaHasilAccepted->tanggal_norma_hasil)) }}
                                                    </span>
                                                </td>
                                            @else <td></td>
                                            @endif

                                            @if (isset($t->normaHasil[0]->normaHasilAccepted->laporan_path))
                                                <td>
                                                    <a target="blank" href="{{ asset($t->normaHasil[0]->normaHasilAccepted->laporan_path) }}"
                                                        class="badge btn-primary" download><i
                                                            class="fa fa-download"></i></a>
                                                </td>
                                            @else <td></td>
                                            @endif

                                            @if (isset($t->normaHasil[0]))
                                                @if ($t->normaHasil[0]->status_norma_hasil != 'disetujui')
                                                    <td>
                                                        <span class="badge
                                                            {{ $t->normaHasil[0]->status_norma_hasil == 'diperiksa' ? 'badge-primary' : '' }}
                                                            {{ $t->normaHasil[0]->status_norma_hasil == 'ditolak' ? 'badge-danger' : '' }}
                                                            text-capitalize">{{ $t->normaHasil[0]->status_norma_hasil }} oleh Ketua Tim
                                                        </span>
                                                    </td>
                                                @else
                                                <td>
                                                    <span class="badge
                                                        {{ $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis == 'diperiksa' ? 'badge-primary' : '' }}
                                                        {{ $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis == 'ditolak' ? 'badge-danger' : '' }}
                                                        {{ $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis == 'disetujui' ? 'badge-success' : '' }}
                                                        {{ $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis == 'belum unggah' ? 'badge-dark' : '' }}
                                                        text-capitalize">{{ $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis }}
                                                    </span>
                                                </td>
                                                @endif
                                            @else <td></td>
                                            @endif

                                            @if (isset($t->kendaliMutu->path) && $t->kendaliMutu->status == 'disetujui')
                                                <td>
                                                    <a target="blank" href="{{ asset($t->kendaliMutu->path) }}"
                                                        class="badge btn-primary" download><i
                                                            class="fa fa-download"></i></a>
                                                </td>
                                            @else <td></td>
                                            @endif

                                            @if (isset($t->suratTugas) && $t->suratTugas->status == 'disetujui' && 
                                                 isset($t->kendaliMutu) && $t->kendaliMutu->status == 'disetujui' &&
                                                 isset($t->normaHasil[0]->normaHasilAccepted) && $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis == 'disetujui')
                                                <td>
                                                    <span class="badge badge-success">Berkas Lengkap</span>
                                                </td>
                                            @else   
                                                <td>
                                                    <span class="badge badge-danger">Belum Lengkap</span>
                                                </td>
                                            @endif

                                            <td>{{ $t->suratTugas->nomor ?? 'Belum Ada' }}</td>
                                            <td>{{ isset($t->suratTugas->path) ? url('/').'/'.$t->suratTugas->path : 'Belum Ada' }}</td>

                                            @if (isset($t->normaHasil[0]->normaHasilAccepted))
                                                <td>
                                                    R-{{ $t->normaHasil[0]->normaHasilAccepted->nomor_norma_hasil}}/{{ $t->normaHasil[0]->normaHasilAccepted->unit_kerja}}/{{ 
                                                    $t->normaHasil[0]->normaHasilAccepted->kode_klasifikasi_arsip}}/{{
                                                    $kodeHasilPengawasan[$t->normaHasil[0]->normaHasilAccepted->kode_norma_hasil]}}/{{ date('Y', strtotime($t->normaHasil[0]->normaHasilAccepted->tanggal_norma_hasil)) }}
                                                </td>
                                            @else <td>Belum Ada</td>
                                            @endif

                                            <td>{{ isset($t->normaHasil[0]->normaHasilAccepted->laporan_path) ? 
                                                    url('/').'/'.$t->normaHasil[0]->normaHasilAccepted->laporan_path : 'Belum Ada' }}</td>
                                            
                                            @if (isset($t->normaHasil[0]))
                                                @if ($t->normaHasil[0]->status_norma_hasil != 'disetujui')
                                                    <td>{{ $t->normaHasil[0]->status_norma_hasil }} oleh Ketua Tim</td>
                                                @else
                                                <td>{{ $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis }}</td>
                                                @endif
                                            @else <td>Belum Ada</td>
                                            @endif

                                            <td>{{ isset($t->kendaliMutu->path) ? url('/').'/'.$t->kendaliMutu->path : 'Belum Ada' }}</td>

                                            @if (isset($t->suratTugas) && $t->suratTugas->status == 'disetujui' && 
                                                 isset($t->kendaliMutu) && $t->kendaliMutu->status == 'disetujui' &&
                                                 isset($t->normaHasil[0]->normaHasilAccepted) && $t->normaHasil[0]->normaHasilAccepted->status_verifikasi_arsiparis == 'disetujui')
                                                <td>Berkas Lengkap</td>
                                            @else   
                                                <td>Belum Lengkap</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

<script>
    let table = $("#table-dashboard-arsiparis")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 9, 10, 11, 12, 13, 14, 15],
                    },
                    messageTop: function () {
                        return $(":selected", '#filterBulan').text() + ' ' + $(":selected", '#filterTahun').text();
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 9, 10, 11, 12, 13, 14, 15],
                    },
                    messageTop: function () {
                        return $(":selected", '#filterBulan').text() + ' ' + $(":selected", '#filterTahun').text();
                    },
                },
            ],
        }).api();
</script>
@endpush
