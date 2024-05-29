@extends('layouts.app')

@section('title', 'Kelola Data Kepegawaian')

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
    @include('components.analis-sdm-header')
    @include('components.analis-sdm-sidebar')

    <div class="main-content">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Import Data Kepegawaian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/analis-sdm/data-kepegawaian/import" enctype="multipart/form-data"
                        class="needs-validation" novalidate="">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" class="form-control" name="file" accept=".xlsx" required>
                                <div class="invalid-feedback">
                                    File belum ditambahkan
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Impor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Nilai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" name="myeditform" id="myeditform">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" id="data_id" name="data_id">
                                <label for="nilai" class="mt-3">Nilai</label>
                                <input type="number" min="0" max="100" step=".01" class="form-control" id="nilai" name="nilai" required>
                                <small id="error-nilai" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success edit-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Data Kepegawaian
                </h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            <p class="mt-3">
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Untuk melakukan import data kepegawaian silahkan download format
                                <a href="/analis-sdm/data-kepegawaian/export"
                                    class="link-primary font-weight-bold" download>
                                    <i class="fas fa-download"></i> disini
                                </a>.
                            </p>
                            <div class="d-flex align-items-center">
                                <div id="download-button">
                                </div>
                                <div class="buttons ml-auto my-2">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#staticBackdrop">
                                        <i class="fas fa-file-upload"></i>
                                        Import
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap: 10px;">
                                <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                    <div id="filter-search-wrapper">
                                    </div>
                                </div>    
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label for="filter-unit-kerja" style="margin-bottom: 0;">Unit Kerja</label>
                                    <select name="unit_kerja" id="filter-unit-kerja" class="form-control select2">
                                        <option value="all">Semua</option>
                                        <option value="8000">Inspektorat Utama</option>
                                        <option value="8010">Bagian Umum Inspektorat Utama</option>
                                        <option value="8100">Inspektorat Wilayah I</option>
                                        <option value="8200">Inspektorat Wilayah II</option>
                                        <option value="8300">Inspektorat Wilayah III</option>
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <table id="table-master-pegawai"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px;">NIP</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jenis Data Kepegawaian</th>
                                            <th>Nilai</th>
                                            <th>Aksi</th>
                                            <th class="never">unit_kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td>{{ $data->user->nip }}</td>
                                                <td>{{ $data->user->name }}</td>
                                                <td>{{ $data->masterdk->jenis }}</td>
                                                <td>{{ $data->nilai }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning edit-btn" 
                                                    data-toggle="modal" data-target="#editModal"
                                                    data-id="{{ $data->id }}" data-nilai="{{ $data->nilai }}">
                                                    <i class="fas fa-edit"></i> Edit</button>
                                                </td>
                                                <td>{{ $data->user->unit_kerja }}</td>
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
    {{-- <form action="/admin/master-pegawai/:id" method="post" id="form-delete">
        @csrf
        @method('delete')
        <button type="submit"></button>
    </form> --}}
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
        let table = $("#table-master-pegawai")
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
                            columns: [0, 1, 2, 3, 4],
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        },
                    },
                ],
                oLanguage: {
                    sSearch: "Cari:",
                    sZeroRecords: "Data tidak ditemukan",
                    sEmptyTable: "Data tidak ditemukan",
                    sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
                    sInfoFiltered: "(disaring dari _MAX_ data)",
                    sLengthMenu: "Tampilkan _MENU_ data",
                    oPaginate: {
                        sPrevious: "Sebelumnya",
                        sNext: "Selanjutnya",
                    },
                },
            })
            .api();
        
        $(".dataTables_filter input").attr(
            "placeholder",
            "Cari berdasarkan NIP, Nama, atau Jenis"
        );

        $(".dataTables_filter").appendTo("#filter-search-wrapper");
        $(".dataTables_filter").find("input").addClass("form-control");
        // .dataTables_filter width 100%
        $(".dataTables_filter").css("width", "100%");
        // .dataTables_filter label width 100%
        $(".dataTables_filter label").css("width", "100%");
        // input height 35px
        $(".dataTables_filter input").css("height", "35px");
        // make label text bold and black
        $(".dataTables_filter label").css("font-weight", "bold");
        // remove bottom margin from .dataTables_filter
        $(".dataTables_filter label").css("margin-bottom", "0");
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");

        $('#filter-unit-kerja').on("change", function () {
            table.draw();
        });
        
        $.fn.dataTableExt.afnFiltering.push(
            function (setting, data, index) {
                var selectedUnit = $('select#filter-unit-kerja option:selected').val();
                if ((data[5] == selectedUnit || selectedUnit == 'all')) return true;
                else return false;
            }
        );

        $(".edit-btn").on("click", function () {
            let dataId = $(this).attr("data-id");
            let nilai = $(this).attr("data-nilai");
            $('#data_id').val(dataId);
            $('#nilai').val(nilai);
        });

        $(".edit-submit").on("click", function (e) {
            e.preventDefault();
            
            let id = $('#data_id').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/analis-sdm/data-kepegawaian/editNilai/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    nilai: $('#nilai').val(),
                    // _method: 'PUT'
                },
                success: function (response) {
                    location.reload();
                },
                error: function (error) {
                    $('form').removeClass('was-validated');
                    $('.form-group').addClass('was-validated');

                    let errorResponses = error.responseJSON;
                    let errors = Object.entries(errorResponses.errors);

                    errors.forEach(([key, value]) => {
                        console.log(errors);
                        let errorMessage = document.getElementById(`error-${key}`);
                        errorMessage.innerText = `${value}`;
                    });
                },
            });
        });
    </script>
@endpush
