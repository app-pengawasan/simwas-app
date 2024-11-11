@extends('layouts.app')

@section('title', 'Usulan Surat Srikandi')

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
    <section class="section">
        <div class="section-header">
            <h1>Usulan Surat Korespondensi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Usulan Surat Korespondensi</div>
            </div>
        </div>
        @include('components.flash')
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="d-flex justify-content-between">
                            <p class="mb-4">
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Menampilkan usulan surat korespondensi yang perlu persetujuan sekretaris.
                            </p>
                            <div id="download-button">
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                                <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                    <label for="filter-search" style="margin-bottom: 0;">
                                        Cari</label>
                                    <input style="height: 35px" type="text" name="search" id="filter-search"
                                        class="form-control" placeholder="Cari berdasarkan nomor surat"
                                        value="{{ request()->search }}">
                                </div>
                                <form id="yearForm" action="" method="GET">
                                    @csrf
                                    <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                        <label for="filter-tahun" style="margin-bottom: 0;">
                                            Tahun</label>
                                        @php
                                        $currentYear = date('Y');
                                        $selectedYear = request()->query('year', $currentYear);
                                        @endphp

                                        <select name="year" id="yearSelect" class="form-control select2">
                                            @foreach ($year as $key => $value)
                                            <option value="{{ $value->year }}"
                                                {{ $selectedYear == $value->year ? 'selected' : '' }}>
                                                {{ $value->year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label for="filter-month" style="margin-bottom: 0;">Jenis Surat</label>
                                    <select name="filter-surat" id="filter-surat" class="form-control select2">
                                        <option value="Semua">Semua</option>
                                        @foreach ( $jenisNaskahDinasPenugasan as $key => $jenis)
                                        <option value="{{ $jenis }}">
                                            {{ $jenis }}
                                        </option>
                                        @endforeach
                                        @foreach ( $jenisNaskahDinasKorespondensi as $key => $jenis)
                                        <option value="{{ $jenis }}">
                                            {{ $jenis }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    {{-- select year --}}
                                    <label for="filter-status" style="margin-bottom: 0;">Status</label>
                                    <select name="filter-status" id="filter-status" class="form-control select2">
                                        <option value="Semua">Semua</option>
                                        @foreach ( $allStatus as $status)
                                        <option value="{{ $status->status }}" @if (!request()->status &&
                                            $status->status
                                            == 'all')
                                            selected
                                            @elseif (request()->status == $status->status)
                                            selected
                                            @endif
                                            >
                                            {{ ucwords($status->status) }}
                                        </option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-end">
                                    <a href="{{ route('pegawai.usulan-surat-korespondensi.create') }}" id="create-btn"
                                        class="btn btn-primary">
                                        <i class=" fas fa-plus-circle"></i>
                                        Tambah
                                    </a>
                                </div>
                            </div>
                        </div>

                        <table id="table-usulan-surat-srikandi"
                            class="table table-bordered table-striped display responsive roundedCorners">
                            <thead>
                                <tr>
                                    <th style="width: 10px; text-align:center">No</th>
                                    <th style="width: 180px;">Tanggal Pengajuan</th>
                                    <th>Nomor Surat</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usulanSuratSrikandi as $usulan)
                                <tr>
                                    <td style="text-align:center">{{ $loop->iteration }}</td>
                                    <td>{{ $usulan->created_at->format('d F Y') }}</td>
                                    <td>
                                        @if ($usulan->nomor_surat)
                                        <span class="badge badge-success">
                                            {{ $usulan->nomor_surat }}
                                        </span>
                                        @endif

                                    </td>
                                    <td>{{ $usulan->jenis_naskah_dinas_penugasan ? $jenisNaskahDinasPenugasan[$usulan->jenis_naskah_dinas_penugasan] : $jenisNaskahDinasKorespondensi[$usulan->jenis_naskah_dinas_korespondensi] }}
                                    <td>
                                        @if ($usulan->status == 'disetujui')
                                        <span class="badge badge-success text-capitalize"><i
                                                class="fa-regular fa-circle-check mr-1"></i>{{ $usulan->status}}</span>
                                        @elseif ($usulan->status == 'ditolak')
                                        <span class="badge badge-danger text-capitalize" data-toggle="tooltip"
                                            data-placement="top" title="{{ $usulan->catatan }}"
                                            style="cursor: pointer;"><i
                                                class="fa-solid fa-triangle-exclamation mr-1"></i>{{ $usulan->status}}</span>
                                        @elseif ($usulan->status == 'dibatalkan')
                                        <span class="badge badge-danger"><i
                                                class="fa-solid fa-ban mr-1"></i>Dibatalkan</span>
                                        @else
                                        <span class="badge badge-light text-capitalize" data-toggle="tooltip"
                                            data-placement="top" title="Menunggu persetujuan sekretaris"
                                            style="cursor: pointer;"><i
                                                class="fa-regular fa-clock mr-1"></i>{{ $usulan->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pegawai.usulan-surat-korespondensi.show', $usulan->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye
                                                "></i>
                                            Lihat
                                        </a>
                                        @if ($usulan->status == 'disetujui')
                                        <a href="/{{ $usulan->directory}}" class="btn btn-primary btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Download Surat Srikandi">
                                            <i class="fa-solid fa-file-pdf"></i>
                                            Download
                                            @endif
                                    </td>
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

<script src="{{ asset('js/page/pegawai/usulan-surat-srikandi/index.js') }}"></script>

@endpush