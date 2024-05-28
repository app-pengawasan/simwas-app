@extends('layouts.app')

@section('title', 'Isi Realisasi Kinerja')

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
                <h1>Isi Realisasi Kinerja</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="d-flex mb-2 row" style="gap:10px">
                                <div class="form-group col pr-0" style="margin-bottom: 0;">
                                    <label for="filterBulan" style="margin-bottom: 0;">Bulan</label>
                                    <select class="form-control" id="filterBulan">
                                        <option value="all">Semua Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="form-group col pl-0" style="margin-bottom: 0;">
                                    <label for="filterTahun" style="margin-bottom: 0;">Tahun</label>
                                    <select class="form-control" id="filterTahun" name="filterTahun">
                                        <?php $year = date('Y'); ?>
                                        @for ($i = -5; $i < 8; $i++)
                                            <option value="{{ $year + $i }}">{{ $year + $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="buttons ml-auto my-2">
                                    <a type="button" class="btn btn-primary" href="/pegawai/realisasi/create">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah
                                    </a>
                                </div>
                            </div>
                            <div class="">
                                <table id="table-realisasi"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Tim</th>
                                            <th>Proyek</th>
                                            <th>Tugas</th>
                                            <th>Waktu Unggah</th>
                                            <th>Status</th>
                                            <th>Bukti Dukung</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                            <th class="never">Link Bukti Dukung</th>
                                            <th class="never">created_at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($realisasi as $r)
                                            <tr>
                                                <td>{{ $r->pelaksana->rencanaKerja->proyek->timkerja->nama }}</td>
                                                <td>{{ $r->pelaksana->rencanaKerja->proyek->nama_proyek }}</td>
                                                <td>{{ $r->pelaksana->rencanaKerja->tugas }}</td>
                                                <td>{{ $r->updated_at }}</td>
                                                {{-- <td>{{ date("d-m-Y", strtotime($r->tgl)) }}<br>
                                                    ({{ date("H:i", strtotime($r->start)) }} - {{ date("H:i", strtotime($r->end)) }})
                                                </td> --}}
                                                <td><span class="badge badge-{{ $colorText[$r->status] }}">{{ $status[$r->status] }}</span></td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{ $r->hasil_kerja }}" target="_blank">
                                                            <i class="fa fa-download"></i>
                                                    </a>
                                                    {{-- @if (file_exists(public_path().'/document/realisasi/'.$r->hasil_kerja))
                                                        <a class="btn btn-primary"
                                                        href="{{ asset('document/realisasi/'.$r->hasil_kerja) }}" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-primary"
                                                        href="{{ $r->hasil_kerja }}" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif --}}
                                                </td>
                                                @if ($r->status == 1) 
                                                    <td>{{ $r->catatan }}</td>
                                                @else 
                                                    <td>{{ $r->alasan }}</td>
                                                @endif
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-primary dropdown-toggle no-arrow" 
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right shadow-lg">
                                                            <a href="/pegawai/realisasi/{{ $r->id }}" 
                                                            class="dropdown-item">
                                                                <i class="fas fa-circle-info text-primary mr-2"></i>
                                                                Detail
                                                            </a>
                                                            <a class="dropdown-item" href="/pegawai/realisasi/{{ $r->id }}/edit">
                                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                                Edit
                                                            </a>
                                                            </a>
                                                            <a class="dropdown-item delete-btn" href="javascript:void(0)"
                                                            data-id="{{ $r->id }}">
                                                                <i class="fas fa-trash text-danger mr-2"></i>
                                                                Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (file_exists(public_path().'/document/realisasi/'.$r->hasil_kerja))
                                                        {{ url('/').'/document/realisasi/'.$r->hasil_kerja }}
                                                    @else
                                                        {{ $r->hasil_kerja }}
                                                    @endif
                                                </td>
                                                <td>{{ $r->created_at }}</td>
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
    <script src="{{ asset('js/page/pegawai/realisasi.js') }}"></script>
@endpush
