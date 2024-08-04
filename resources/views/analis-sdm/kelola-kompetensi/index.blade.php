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
    @include('components.analis-sdm-header')
    @include('components.analis-sdm-sidebar')

    <div class="main-content">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tolak Kompetensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="data-id" id="data-id">
                            <div class="form-group">
                                <label for="draft">Alasan Penolakan</label>
                                <input placeholder="Berikan Alasan Penolakan" required type="text" class="form-control"
                                    name="catatan" id="catatan">
                                <small id="error-catatan" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                                <i class="fas fa-exclamation-triangle"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn" id="tolak-submit">
                                <i class="fas fa-save"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('components.kelola-kompetensi.create');
        @include('components.kelola-kompetensi.edit');
        <section class="section">
            <div class="section-header">
                <h1>Kelola Kompetensi Pegawai</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="d-flex mb-2 row" style="gap:10px">
                                <div class="form-group col pr-0" style="margin-bottom: 0;">
                                    <label for="filterUnitKerja" style="margin-bottom: 0;">Unit Kerja</label>
                                    <select class="form-control select2" id="filterUnitKerja" autocomplete="off">
                                        <option value="all">Semua</option>
                                        <option value="8000">Inspektorat Utama</option>
                                        <option value="8010">Bagian Umum Inspektorat Utama</option>
                                        <option value="8100">Inspektorat Wilayah I</option>
                                        <option value="8200">Inspektorat Wilayah II</option>
                                        <option value="8300">Inspektorat Wilayah III</option>
                                    </select>
                                </div>
                                <div class="form-group col pl-0" style="margin-bottom: 0;">
                                    <label for="filterTahun" style="margin-bottom: 0;">Jenis Kompetensi</label>
                                    <select class="form-control select2" id="filterJenis" name="filterJenis">
                                        <option value="all">Semua</option>
                                        <option value="1">Sertifikasi</option>
                                        <option value="2">Diklat Penjenjangan</option>
                                        <option value="3">Diklat Subtantif</option>
                                        <option value="4">Pelatihan</option>
                                        <option value="5">Workshop</option>
                                        <option value="6">Seminar</option>
                                        <option value="7">Pelatihan di Kantor Sendiri</option>
                                        <option value="999">Lainnya</option>
                                    </select>
                                </div>
                            </div>
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
                                            {{-- <th>No.</th> --}}
                                            <th>Pegawai</th>
                                            <th>Jenis Pengembangan Kompetensi</th>
                                            <th>Pengembangan Kompetensi</th>
                                            <th>Sertifikat</th>
                                            {{-- <th>Catatan</th> --}}
                                            <th>Status</th>
                                            <th>Aksi</th>
                                            <th class="never">sertifikat_link</th>
                                            <th class="never">unit kerja</th>
                                            <th class="never">kode jenis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php
                                            $i = 0;
                                        @endphp --}}
                                        @foreach ($kompetensi as $k)
                                            <tr>
                                                {{-- <td>{{ ++$i }}</td> --}}
                                                <td>{{ $k->pegawai->name }}</td>

                                                @if ($k->pp->id == 999) <td>{{ $k->pp_lain }}</td>
                                                @else <td>{{ $k->pp->jenis }}</td>
                                                @endif

                                                @if ($k->namaPp->id == 999) <td>{{ $k->nama_pp_lain }}</td>
                                                @else <td>{{ $k->namaPp->nama }}</td>
                                                @endif
                                                
                                                <td>
                                                    <a class="btn btn-sm btn-primary"
                                                    href="{{ asset('document/sertifikat/'.$k->sertifikat) }}" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                {{-- <td>{{ $k->catatan }}</td> --}}
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
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle no-arrow" 
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        data-id="{{ $k->id }}">
                                                            {{-- <i class="fas fa-stamp"></i> --}}...
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right shadow-lg">
                                                            <a href="/analis-sdm/kelola-kompetensi/{{ $k->id }}" class="dropdown-item">
                                                                <i class="fas fa-circle-info text-primary mr-2"></i>
                                                                Detail
                                                            </a>
                                                            <a href="javascript:void(0)" class="dropdown-item edit-btn"
                                                                data-id="{{ $k->id }}"
                                                                data-toggle="modal" data-target="#modal-edit-kompetensi">
                                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                                Edit
                                                            </a>
                                                            @if ($k->status == 3)
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                data-id="{{ $k->id }}" id="setuju-btn">
                                                                    <i class="far fa-check-circle text-success mr-2"></i>
                                                                    Setujui
                                                                </a>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                data-id="{{ $k->id }}" data-toggle="modal"
                                                                data-target="#staticBackdrop" id="tolak-btn">
                                                                    <i class="far fa-circle-xmark text-danger mr-2"></i>
                                                                    Tolak
                                                                </a>
                                                            @endif
                                                            <a href="javascript:void(0)" class="dropdown-item delete-btn"
                                                            data-id="{{ $k->id }}">
                                                                <i class="fas fa-trash text-danger mr-2"></i>
                                                                Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ url('/').'/document/sertifikat/'.$k->sertifikat }}</td>
                                                <td>{{ $k->pegawai->unit_kerja }}</td>
                                                <td>{{ $k->pp->id }}</td>
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
    <script src="{{ asset('js/page/kompetensi.js') }}"></script>
@endpush
