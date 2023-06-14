@extends('layouts.app')

@section('title', 'Pagu Anggaran')

@push('style')
    <!-- CSS Libraries -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pagu Anggaran</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Halaman untuk mengelola Pagu Anggaran Inspektorat Utama</p>
                            @if (session()->has('success'))
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <p>{{ session('success') }}</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
                                    <a type="button" class="btn btn-primary" href="{{ route('pagu-anggaran.create') }}">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </a>
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#staticBackdrop">
                                        <i class="fas fa-file-upload"></i>
                                        Import
                                    </button> --}}
                                </div>
                            </div>
                            <div class="">
                                <table id="table-pagu-anggaran"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Komponen</th>
                                            <th>Akun</th>
                                            <th>Uraian</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Pagu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paguAnggaran as $pa)
                                            <tr>
                                                <td>{{ $pa->tahun }}</td>
                                                <td>{{ $pa->komponen }}</td>
                                                <td>{{ $pa->akun }}</td>
                                                <td>{{ $pa->uraian }}</td>
                                                <td>{{ $pa->volume }}</td>
                                                <td>{{ $satuan["$pa->satuan"] }}</td>
                                                <td class="rupiah">{{ $pa->harga }}</td>
                                                <td class="rupiah">{{ $pa->pagu }}</td>
                                                <td>
                                                    <a class="btn btn-primary mb-2 mr-2"
                                                        href="{{ route('pagu-anggaran.show', $pa) }}" style="width: 42px">
                                                        <i class="fas fa-info"></i>
                                                    </a>
                                                    <a class="btn btn-warning mb-2 mr-2"
                                                        href="{{ route('pagu-anggaran.edit', $pa) }}" style="width: 42px">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    {{-- <a class="btn btn-danger"
                                                            onclick="deleteData('{{ $user->id }}')"
                                                            style="width: 42px">
                                                            <i class="fas fa-trash"></i>
                                                        </a> --}}
                                                    <form class="d-inline mb-2"
                                                        action="{{ route('pagu-anggaran.destroy', $pa) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="deleteData('{{ $pa->id_panggaran }}')"
                                                            style="width: 42px">
                                                            <i class="fas fa-trash"></i>
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
    {{-- <script src="{{ asset('js') }}/page/master-anggaran.js"></script> --}}
    <script src="{{ asset('js') }}/page/pagu-anggaran.js"></script>
@endpush
