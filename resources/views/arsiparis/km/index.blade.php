@extends('layouts.app')

@section('title', 'Kendali Mutu')

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
@include('components.arsiparis-header')
@include('components.arsiparis-sidebar')
<div class="main-content">
    {{-- Modal --}}
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tolak Kendali Mutu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data">
                    <input type="hidden" name="km_id" id="km_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="alasan">Alasan Penolakan</label>
                            <input placeholder="Berikan Alasan Penolakan" required type="text" class="form-control"
                                name="alasan" id="alasan">
                            @error('alasan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="tolak-submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="section-header">
            <h1>Kendali Mutu</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/arsiparis">Dashboard</a></div>
                <div class="breadcrumb-item">Kendali Mutu</div>
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
                            <div class="form-group mb-2">
                                <label for="yearSelect">Tahun Pengajuan</label>
                                <select name="year" id="yearSelect" class="form-control select2 col-md-1">
                                    @php
                                    $currentYear = date('Y');
                                    $lastThreeYears = range($currentYear, $currentYear - 3);
                                    @endphp
                
                                    @foreach ($lastThreeYears as $year)
                                    <option value="{{ $year }}" {{ request()->query('year') == $year ? 'selected' : '' }}>{{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display responsive"
                                    id="table-pengelolaan-dokumen-pegawai">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; text-align:center">No</th>
                                            <th>Tugas</th>
                                            <th style="width: 20%">Dokumen</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                            <th class="never">tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dokumen as $km)
                                        <tr>
                                            <td></td>
                                            <td>{{ $km->laporanObjekPengawasan->objekPengawasan->rencanaKerja->tugas }}</td>
                                            <td>   
                                                @if (file_exists($km->path))
                                                    <a target="blank" href="/pegawai/tim/kendali-mutu/download/{{ $km->id }}"
                                                        class="badge btn-primary"><i
                                                            class="fa fa-download"></i> Download</a> 
                                                @else
                                                    <a target="blank" href="{{ $km->path }}"
                                                        class="badge btn-primary"><i
                                                            class="fa fa-download"></i> Download</a> 
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge
                                                    {{ $km->status == 'diperiksa' ? 'badge-primary' : '' }}
                                                    {{ $km->status == 'disetujui' ? 'badge-success' : '' }}
                                                    {{ $km->status == 'ditolak' ? 'badge-danger' : '' }}
                                                    text-capitalize">{{ $km->status }}
                                                </span>
                                            </td>
                                            <td>{{ $km->catatan }}</td>
                                            <td>
                                                {{-- <a href="/arsiparis/kendali-mutu/{{ $km->id }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye
                                                    "></i>
                                                    Detail
                                                </a> --}}
                                                @if ($km->status == 'diperiksa')
                                                <button type="button" class="btn btn-danger btn-sm mr-2 tolak" data-toggle="modal"
                                                    data-target="#staticBackdrop" data-id="{{ $km->id }}" style="float: left">
                                                    Tolak
                                                </button>
                                                <form action="/arsiparis/kendali-mutu"
                                                    method="post">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="kendali_mutu" value="{{ $km->id }}">
                                                    <button type="submit" class="btn btn-success btn-sm" style="float: left">Setujui</button>
                                                </form>
                                                @endif
                                            </td>
                                            <td>{{ date("Y",strtotime($km->created_at)) }}</td>
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
<script>
    let table = $("#table-pengelolaan-dokumen-pegawai")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [],
            columnDefs: [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
        }).api();

    $('#yearSelect').on("change", function () {
        table.draw();
    });
    
    $.fn.dataTableExt.afnFiltering.push(
        function (setting, data, index) {
            var selectedYear = $('select#yearSelect option:selected').val();
            if (data[6] == selectedYear) return true;
            else return false;
        }
    );

    $('.tolak').on("click", function () {
        $('#km_id').val($(this).attr('data-id'));
    });

    $('#tolak-submit').on("click", function (e) {
        e.preventDefault();
        let token = $("meta[name='csrf-token']").attr("content");
        let id = $('#km_id').val();
        let alasan = $('#alasan').val();

        $.ajax({
            url: `/arsiparis/kendali-mutu/${id}`,
            type: "PUT",
            cache: false,
            data: {
                _token: token,
                alasan: alasan
            },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.log(error);
                let errorResponses = error.responseJSON;
                let errors = Object.entries(errorResponses.errors);

                errors.forEach(([key, value]) => {
                    let errorMessage = document.getElementById(`error-${key}`);
                    errorMessage.innerText = value.join('\n');
                });
            },
        });
    });
</script>
@endpush
