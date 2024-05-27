@extends('layouts.app')

@section('title', 'Norma Hasil')

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
    <!-- Modal -->
    @include('pegawai.tugas-tim.norma-hasil.create');
    <section class="section">
        <div class="section-header">
            <h1>Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Norma Hasil</div>
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
                            <div class="d-flex align-items-end">
                                <button type="button" class="btn btn-primary" id="create-btn" data-toggle="modal"
                                    data-target="#modal-create-tim-norma-hasil">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display responsive"
                                    id="table-pengelolaan-dokumen-pegawai">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; text-align:center">No</th>
                                            <th>Tugas</th>
                                            <th>Nomor Dokumen</th>
                                            <th>Verifikasi Arsiparis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $lnm)
                                        <tr>
                                            <td></td>
                                            <td>{{ $lnm->normaHasil->rencanaKerja->tugas }}</td>
                                            <td>
                                                <span class="badge badge-primary">
                                                    R-{{ $lnm->nomor_norma_hasil}}/{{ $lnm->unit_kerja}}/{{ $lnm->kode_klasifikasi_arsip}}/{{
                                                    $kodeHasilPengawasan[$lnm->kode_norma_hasil]}}/{{ date('Y', strtotime($lnm->tanggal_norma_hasil)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge
                                                    {{ $lnm->status_verifikasi_arsiparis == 'diperiksa' ? 'badge-primary' : '' }}
                                                    {{ $lnm->status_verifikasi_arsiparis == 'disetujui' ? 'badge-success' : '' }}
                                                    {{ $lnm->status_verifikasi_arsiparis == 'ditolak' ? 'badge-danger' : '' }}
                                                    text-capitalize"><i class="
                                                        {{ $lnm->status_verifikasi_arsiparis == 'diperiksa' ? 'fa-regular fa-clock mr-1' : '' }}
                                                        {{ $lnm->status_verifikasi_arsiparis == 'disetujui' ? 'fa-regular fa-circle-check mr-1' : '' }}
                                                        {{ $lnm->status_verifikasi_arsiparis == 'ditolak' ? 'fa-solid fa-triangle-exclamation' : '' }}
                                                    "></i>{{ $lnm->status_verifikasi_arsiparis }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/pegawai/tim/norma-hasil/{{ $lnm->id_norma_hasil }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye
                                                    "></i>
                                                    Detail
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

<script>
    document.forms['formNHtim'].reset();
    
    $(".submit-btn").on("click", function (e) {
        e.preventDefault();

        $("#error-nomor").text("");
        $("#error-file").text("");
        
        let data = new FormData($('#formNHtim')[0]);
        let token = $("meta[name='csrf-token']").attr("content");
        data.append('_token', token);

        $.ajax({
            url: `/pegawai/tim/norma-hasil`,
            contentType: false,
            processData: false,
            type: "POST",
            cache: false,
            data: data,
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                let errorResponses = error.responseJSON;
                let errors = Object.entries(errorResponses.errors);

                errors.forEach(([key, value]) => {
                    let errorMessage = document.getElementById(`error-${key}`);
                    errorMessage.innerText = `${value}`;
                });
                console.log(errors);
            },
        });
    });
</script>
@endpush
