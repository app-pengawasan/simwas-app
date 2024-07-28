@extends('layouts.app')

@section('title', 'Kelola Kompetensi Pegawai')

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
        @include('components.kelola-kompetensi.create')
        @include('components.kelola-kompetensi.edit')
        <section class="section">
            <div class="section-header">
                <h1>Kelola Kompetensi</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
                                    <button type="button" id="create-btn" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-create-kompetensi">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <table id="table-kompetensi"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Pengembangan Kompetensi</th>
                                            <th>Pengembangan Kompetensi</th>
                                            <th>Sertifikat</th>
                                            <th>Catatan</th>
                                            <th>Status</th>
                                            <th style="width: 15%">Aksi</th>
                                            <th class="never">Link Sertifikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($kompetensi as $k)
                                            <tr>
                                                <td>{{ ++$i }}</td>

                                                @if ($k->pp->id == 999) <td>{{ $k->pp_lain }}</td>
                                                @else <td>{{ $k->pp->jenis }}</td>
                                                @endif

                                                @if ($k->namaPp->id == 999) <td>{{ $k->nama_pp_lain }}</td>
                                                @else <td>{{ $k->namaPp->nama }}</td>
                                                @endif
                                                
                                                <td>
                                                    {{-- @if (file_exists(public_path().'/document/sertifikat/'.$k->sertifikat)) --}}
                                                    <a class="btn btn-sm btn-primary"
                                                    href="{{ asset('document/sertifikat/'.$k->sertifikat) }}" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- @else
                                                        <a class="btn btn-primary"
                                                        href="{{ $k->sertifikat }}" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif --}}
                                                </td>
                                                <td>{{ $k->catatan }}</td>
                                                @if ($k->status == 1)
                                                    <td>
                                                        <span class="badge badge-{{ $colorText[$k->status] }}">{{ $status[$k->status] }} oleh {{ $k->analis->name }}</span>
                                                    </td>
                                                @else 
                                                    <td>
                                                        <span class="badge badge-{{ $colorText[$k->status] }}">{{ $status[$k->status] }}</span>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="/pegawai/kompetensi/{{ $k->id }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-sm edit-btn btn-warning"
                                                        data-id="{{ $k->id }}"
                                                        data-toggle="modal" data-target="#modal-edit-kompetensi">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-sm delete-btn btn-danger"
                                                    data-id="{{ $k->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{ url('/').'/document/sertifikat/'.$k->sertifikat }}</td>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/kompetensi.js') }}"></script>
@endpush
