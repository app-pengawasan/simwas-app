@extends('layouts.app')

@section('title', 'Surat Tugas')

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
    @include('pegawai.tugas-tim.st.create');
    <section class="section">
        <div class="section-header">
            <h1>Surat Tugas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Surat Tugas</div>
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
                                    data-target="#modal-create-tim-st">
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
                                            <th>Nomor Dokumen</th>
                                            <th>Nama Dokumen</th>
                                            <th>Verifikasi Arsiparis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($surat as $nomor => $st)
                                        <tr>
                                            <td></td>
                                            <td><span class="badge badge-primary">{{ $nomor }}</span></td>
                                            <td>{{ $st[0]->nama }}</td>
                                            <td>
                                                <span class="badge
                                                    {{ $st[0]->status == 'diperiksa' ? 'badge-primary' : '' }}
                                                    {{ $st[0]->status == 'disetujui' ? 'badge-success' : '' }}
                                                    {{ $st[0]->status == 'ditolak' ? 'badge-danger' : '' }}
                                                    text-capitalize"><i class="
                                                        {{ $st[0]->status == 'diperiksa' ? 'fa-regular fa-clock mr-1' : '' }}
                                                        {{ $st[0]->status == 'disetujui' ? 'fa-regular fa-circle-check mr-1' : '' }}
                                                        {{ $st[0]->status == 'ditolak' ? 'fa-solid fa-triangle-exclamation' : '' }}
                                                    "></i>{{ $st[0]->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/pegawai/tim/surat-tugas/{{ $nomor }}"
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

        $("#error-tugas").text("");
        $("#error-nomor_st").text("");
        $("#error-nama").text("");
        $("#error-file").text("");
        
        let data = new FormData($('#formNHtim')[0]);
        let token = $("meta[name='csrf-token']").attr("content");
        data.append('_token', token);

        $.ajax({
            url: `/pegawai/tim/surat-tugas`,
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
