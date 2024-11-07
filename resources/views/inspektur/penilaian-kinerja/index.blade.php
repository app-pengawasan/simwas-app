@extends('layouts.app')

@section('title', 'Penilaian Kinerja Pegawai')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')

    <div class="main-content">
        <!-- Modal -->
        @include('components.penilaian.create');
        @include('components.penilaian.edit');
        <section class="section">
            <div class="section-header">
                <h1>Penilaian Kinerja Pegawai Bulanan</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="d-flex mb-2 row" style="gap:10px">
                                <div class="form-group col pr-0" style="margin-bottom: 0;">
                                    <label for="filterBulan" style="margin-bottom: 0;">Bulan Unggah</label>
                                    <select class="form-control select2" id="filterBulan">
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
                                    <label for="filterTahun" style="margin-bottom: 0;">Tahun Unggah</label>
                                    <select class="form-control select2" id="filterTahun" name="filterTahun">
                                        <?php $year = date('Y'); ?>
                                        @for ($i = -5; $i < 8; $i++)
                                            <option value="{{ $year + $i }}">
                                                {{ $year + $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div style="margin-top: 2rem">
                                <table id="table-daftar-nilai"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jumlah Realisasi</th>
                                            {{-- <th>Rencana Jam Kerja</th> --}}
                                            <th>Realisasi Jam Kerja</th>
                                            <th>Rata-Rata Hasil Penilaian Berjenjang</th>
                                            <th>Hasil Penilaian</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                            <th class="never">Bulan</th>
                                            <th class="never">Tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugasCount as $id_pegawai => $count)
                                            @foreach ($count as $tahun => $values)
                                                @foreach ($values['count'] as $bulan => $jumlah_tugas)
                                                    <tr>
                                                        <td>{{ $values['nama'] }}</td>
                                                        <td>{{ $jumlah_tugas }}</td>
                                                        {{-- <td>{{ $values['rencana_jam'][$bulan] }}</td> --}}
                                                        <td>{{ isset($values['realisasi_jam'][$bulan]) ? $values['realisasi_jam'][$bulan] : '-' }}</td>
                                                        <td>{{ isset($values['avg'][$bulan]) ? round($values['avg'][$bulan], 2) : '-' }}</td> 
                                                        <td>{{ isset($values['nilai_ins'][$bulan]) ? round($values['nilai_ins'][$bulan], 2) : '-' }}</td>
                                                        <td>{{ $bulan == 'all' ? '' : (isset($values['catatan']) ? $values['catatan'][$bulan] ?? '' : '') }}</td>
                                                        <td>
                                                            @if ($bulan == 'all')
                                                                <a class="btn btn-primary btn-sm"
                                                                href="/inspektur/penilaian-kinerja/{{ $id_pegawai }}/{{ $bulan }}/{{ $tahun }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @else
                                                                <div class="btn-group dropdown">
                                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle no-arrow" 
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right shadow-lg">
                                                                        <a href="/inspektur/penilaian-kinerja/{{ $id_pegawai }}/{{ $bulan }}/{{ $tahun }}" 
                                                                        class="dropdown-item">
                                                                            <i class="fas fa-circle-info text-primary mr-2"></i>
                                                                            Detail
                                                                        </a>
                                                                        @if (!isset($values['nilai_ins'][$bulan]) || $values['nilai_ins'][$bulan] == null)
                                                                            <a class="dropdown-item nilai-btn" href="javascript:void(0)"
                                                                            data-pegawai="{{ $id_pegawai }}" data-tahun="{{ $tahun }}"
                                                                            data-bulan="{{ $bulan }}" data-toggle="modal" 
                                                                            data-target="#modal-create-nilai">
                                                                                <i class="fas fa-circle-plus text-success mr-2"></i>
                                                                                Nilai
                                                                            </a>
                                                                        @else
                                                                            <a class="dropdown-item edit-btn" href="javascript:void(0)"
                                                                            data-pegawai="{{ $id_pegawai }}" data-tahun="{{ $tahun }}"
                                                                            data-bulan="{{ $bulan }}" data-toggle="modal" 
                                                                            data-target="#modal-edit-nilai">
                                                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                                                Edit Nilai
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>{{ $bulan }}</td>
                                                        <td>{{ $tahun }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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
    <script src="{{ asset('js/page/inspektur-penilaian-kinerja.js') }}"></script>
@endpush
