@extends('layouts.app')

@section('title', 'Master Kompetensi Pegawai')

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
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Kategori Kompetensi Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/analis-sdm/kategori" method="post">
                        <div class="modal-body">
                            @csrf  
                            <div class="form-group">
                                <label for="nama">Jenis Kompetensi Pegawai</label>
                                <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="nama" value="{{ old('jenis') }}">
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Submit</button>
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
                        <h5 class="modal-title" id="editModalLabel">Edit Kategori Kompetensi Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" name="myeditform" id="myeditform">
                        <div class="modal-body">
                            <input type="hidden" name="is_aktif" value="1">
                            <div class="form-group">
                                <input type="hidden" id="kategori_id" name="kategori_id">
                                <label for="nama" class="mt-3">Kategori Kompetensi Pegawai</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="namaEdit" name="namaEdit" required>
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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
                <h1>Master Kategori Kompetensi Pegawai</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/analis-sdm">Dashboard</a></div>
                    <div class="breadcrumb-item">Kategori Kompetensi</div>
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
                                <div class="d-flex">
                                    <div class="buttons ml-auto my-2">
                                        <button type="button" id="create-btn" class="btn btn-primary" data-toggle="modal"
                                            data-target="#staticBackdrop">
                                            <i class="fas fa-plus-circle"></i>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                <div class="">
                                    <table class="table table-bordered table-striped display responsive" id="table-pengelolaan-dokumen-pegawai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori Kompetensi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($kategori as $k)
                                                 <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>
                                                        <a href="/analis-sdm/kategori/{{ $k->id }}">{{ $k->nama }}</a>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning edit-btn" 
                                                        data-toggle="modal" data-target="#editModal"
                                                        data-id="{{ $k->id }}" data-nama="{{ $k->nama }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>

                                                        <form action="/analis-sdm/kategori/{{ $k->id }}"
                                                            method="post" class="d-inline delete-form">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm ml-1" type="submit">
                                                                <i class="fa fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
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
    {{-- <script src="{{ asset('js') }}/page/pegawai-pengelolaan-dokumen.js"></script> --}}
    <script>
        let table = $("#table-pengelolaan-dokumen-pegawai");

        table
            .DataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                pageLength: 20,
                buttons: [
                    {
                        className: "btn-success unduh",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                    },
                ],
            })
            .buttons()
            .container()
            .appendTo("#table-pengelolaan-dokumen-pegawai_wrapper .col-md-6:eq(0)");

        $('.unduh').on('click', function() {
            window.location.href = `/analis-sdm/kategori/export`;
        })

        $(".edit-btn").on("click", function () {
            let dataId = $(this).attr("data-id");
            let nama = $(this).attr("data-nama");
            $('#kategori_id').val(dataId);
            $('#namaEdit').val(nama);
        });

        $(".edit-submit").on("click", function (e) {
            e.preventDefault();
            
            let id = $('#kategori_id').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/analis-sdm/kategori/${id}`,
                type: "POST",
                cache: false,
                data: {
                    _token: token,
                    nama: $('#namaEdit').val(),
                    _method: 'PUT'
                },
                success: function (response) {
                    location.reload();
                },
            });
        });

        
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "var(--primary)",
                cancelButtonColor: "var(--danger)",
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    @endif
@endpush