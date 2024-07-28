@extends('layouts.app')

@section('title', 'Master Penyelenggara Diklat')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        @include('analis-sdm.master-penyelenggara.create')
        @include('analis-sdm.master-penyelenggara.edit')
        <section class="section">
            <div class="section-header">
                <h1>Master Penyelenggara Diklat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/analis-sdm">Dashboard</a></div>
                    <div class="breadcrumb-item">Master Penyelenggara Diklat</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @include('components.flash')
                                {{ session()->forget(['alert-type', 'status']) }}
                                <div class="pt-1 pb-1 m-4">
                                    <div class="btn btn-success btn-lg btn-round" data-toggle="modal"
                                    data-target="#staticBackdrop">
                                        + Tambah
                                    </div>
                                </div>
                                <div class="">
                                    <table class="table table-bordered table-striped display responsive" id="table-pengelolaan-dokumen-pegawai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Penyelenggara Diklat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($masters as $master)
                                            <tr>
                                                <td></td>
                                                <td>{{ $master->penyelenggara }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning edit-btn" 
                                                    data-toggle="modal" data-target="#editModal"
                                                    data-id="{{ $master->id }}" data-penyelenggara="{{ $master->penyelenggara }}">
                                                    <i class="fas fa-edit"></i> Edit</button>
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
    
    <!-- Page Specific JS File -->
    <script src="{{ asset('js') }}/page/pegawai-pengelolaan-dokumen.js"></script>

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    @endif

    <script>
        $(".edit-btn").on("click", function () {
            let dataId = $(this).attr("data-id");
            let penyelenggara = $(this).attr("data-penyelenggara");
            $('#data_id').val(dataId);
            $('#edit-penyelenggara').val(penyelenggara);
        });

        $("#edit-submit").on("click", function (e) {
            e.preventDefault();
            
            let id = $('#data_id').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/analis-sdm/master-penyelenggara/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    penyelenggara: $('#edit-penyelenggara').val(),
                },
                success: function (response) {
                    location.reload();
                },
                error: function (error) {
                    $('form').removeClass('was-validated');

                    let errorResponses = error.responseJSON;
                    let errors = Object.entries(errorResponses.errors);

                    errors.forEach(([key, value]) => {
                        console.log(errors);
                        let errorMessage = document.getElementById(`error-edit-${key}`);
                        errorMessage.innerText = `${value}`;
                    });
                },
            });
        });
    </script>
@endpush