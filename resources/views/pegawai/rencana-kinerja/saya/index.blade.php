@extends('layouts.app')

@section('title', 'Kelola Rencana Kinerja')

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
        <section class="section">
            <div class="section-header">
                <h1>Tugas Kinerja Saya</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center mb-3">
                                <p class="col-8 m-0">
                                    <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                    Menampilkan seluruh tugas yang telah disetujui Pimpinan.
                                </p>
                                <div class="my-2 col-4 float-right form-group">
                                    <label for="filterTahun" style="margin-bottom: 0;">Tahun</label>
                                    <select class="form-control" id="filterTahun" name="filterTahun" required>
                                        <?php $year = date('Y'); ?>
                                        @for ($i = -5; $i < 8; $i++)
                                            <option value="{{ $year + $i }}">
                                                {{ $year + $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <?php
                            $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                            $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja'];
                            ?>
                            <table id="tim-kerja" class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th>Tim</th>
                                        <th>Proyek</th>
                                        <th>Tugas</th>
                                        <th>Peran</th>
                                        <th>Hasil kerja</th>
                                        <th id="title">Rencana Jam Kerja</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Aksi</th>
                                        <th class="never">tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tugasSaya as $ts)
                                    <tr>
                                        <td>
                                            {{ $ts->rencanaKerja->proyek->timkerja->nama }}
                                        </td>
                                        <td>
                                            {{ $ts->rencanaKerja->proyek->nama_proyek }}
                                        </td>
                                        <td>
                                            {{ $ts->rencanaKerja->tugas }}
                                        </td>
                                        <td>
                                            {{ $jabatanPelaksana[$ts->pt_jabatan] }}
                                        </td>
                                        <td>
                                            @if ($ts->pt_jabatan == 3)
                                                @if ($ts->pt_hasil == 2)
                                                    Kertas Kerja
                                                @else
                                                    {{ $hasilKerja[$ts->pt_hasil] }}
                                                @endif
                                            @elseif ($ts->pt_jabatan == 4)
                                                Kertas Kerja
                                            @else
                                                {{ $hasilKerja2[$ts->pt_hasil] }}
                                            @endif
                                        </td>
                                        <td class="convert" value="{{ $ts->total }}">{{ $ts->total }}</td>
                                        {{-- <td>
                                            <span class="badge badge-{{ $statusColor[$ts->rencanaKerja->status_realisasi] }}">{{ $statusTugas[$ts->rencanaKerja->status_realisasi] }}</span>
                                        </td> --}}
                                        <td>
                                            <a href="/pegawai/rencana-kinerja/{{ $ts->id_rencanakerja }}"
                                                class="btn btn-primary" style="width: 42px">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($ts->pt_jabatan == 3 || $ts->pt_jabatan == 2)
                                                @if ($ts->rencanaKerja->status_realisasi == 0)
                                                    <a href="javascript:void(0)" class="btn btn-danger disable-btn"
                                                        data-id="{{ $ts->id_rencanakerja }}" style="width: 42px"
                                                        data-toggle="modal" data-target="#disable-tugas">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $ts->rencanaKerja->proyek->timkerja->tahun }}</td>
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
    <script src="{{ asset('js/page/pegawai/rencana-kerja-saya.js') }}"></script>
@endpush
