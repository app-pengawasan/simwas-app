@extends('layouts.app')

@section('title', 'Evaluasi IKU Unit Kerja')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.perencana-header')
@include('components.perencana-sidebar')
<div class="main-content">
    <!-- Modal -->

    <section class="section">
        <div class="section-header">
            <h1>Evaluasi Realisasi IKU Unit Kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item">Evaluasi IKU Unit Kerja</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash')
                        <p class="mt-3">
                            <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                            Halaman Mengelola Evaluasi Indikator Kinerja Utama Unit Kerja.
                        </p>
                        {{ session()->forget(['alert-type', 'status']) }}
                        {{-- <div class="d-flex">
                            <div class="buttons ml-auto my-2">
                                <a type="button" class="btn btn-primary"
                                    href="{{ route('realisasi-iku-unit-kerja.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        Tambah
                        </a>
                    </div>
                </div> --}}
                <div class="">
                    <table class="table table-bordered table-striped display responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Unit Kerja</th>
                                <th>Nama Kegiatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targetIkuUnitKerja as $ti)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ti->unit_kerja }}</td>
                                <td>{{ $ti->nama_kegiatan }}</td>
                                <td>
                                    {{ $ti->status }}
                                </td>
                                <td>
                                    @if ($ti->status == '4')
                                    <a href="{{ route('evaluasi-iku-unit-kerja.show', $ti->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                    @if ($ti->status == '3')
                                    <a href="{{ route('evaluasi-iku-unit-kerja.edit', $ti->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    {{-- <form action="{{ route('target-iku-unit-kerja.destroy', $ti->id) }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </form> --}}
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
@endpush
