@extends('layouts.app')

@section('title', 'Detail Usulan Surat Srikandi')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Usulan Surat Srikandi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/pegawai/usulan-surat-srikandi">Usulan Surat Srikandi</a>
                </div>
                <div class="breadcrumb-item">Detail Usulan</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="{{ route('usulan-surat-srikandi.index') }}">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        @if ($usulanSuratSrikandi->status == 'disetujui')

                        <h1 class="h4 text-dark mb-4 header-card">Informasi Surat Srikandi</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Pejabat Penanda Tangan:</th>
                                <td>{{ $usulanSuratSrikandi->kepala_unit_penandatangan_srikandi}}</td>
                            </tr>
                            {{-- nomor_surat_srikandi --}}
                            <tr>
                                <th>Nomor Surat Srikandi:</th>
                                <td>{{ $usulanSuratSrikandi->nomor_surat_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Dokumen Surat Srikandi:</th>
                                <td>
                                    <a class="badge badge-primary p-2"
                                        href="{{ route('surat-srikandi.download', $usulanSuratSrikandi->id) }}"><i
                                            class="fa-solid fa-file-arrow-down mr-1"></i>Download
                                    </a>
                            <tr>
                                <th>Jenis Naskah Dinas:</th>
                                <td>{{ $usulanSuratSrikandi->jenis_naskah_dinas_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Persetujuan Srikandi:</th>
                                <td>{{ $usulanSuratSrikandi->tanggal_persetujuan_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Derajat Keamanan:</th>
                                <td>{{ $usulanSuratSrikandi->derajat_keamanan_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Kode Klasifikasi Arsip:</th>
                                <td>{{ $usulanSuratSrikandi->kode_klasifikasi_arsip_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Link Srikandi</th>
                                <td>
                                    <a target="_blank" class="badge badge-primary"
                                        href="{{ $usulanSuratSrikandi->link_srikandi }}">
                                        {{ $usulanSuratSrikandi->link_srikandi }}
                                    </a>
                                </td>

                            </tr>
                        </table>
                        @endif
                        <h1 class="h4 text-dark mb-4 header-card">Informasi Pengajuan Surat</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Status Surat:</th>
                                <td>
                                    @if ($usulanSuratSrikandi->status == 'disetujui')
                                    <span class="badge badge-success mr-1"><i
                                            class="fa-regular fa-circle-check mr-1"></i>Disetujui</span>
                                    Pada Tanggal {{ $usulanSuratSrikandi->updated_at->format('d F Y')}}
                                    @elseif ($usulanSuratSrikandi->status == 'ditolak')
                                    <span class="badge badge-danger"><i
                                            class="fa-solid fa-triangle-exclamation mr-1"></i>Ditolak</span>
                                    @else
                                    <span class="badge badge-light"><i
                                            class="fa-regular fa-clock mr-1"></i>Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($usulanSuratSrikandi->status == 'ditolak')
                            <tr>
                                <th>Alasan Ditolak:</th>
                                <td> <span class="text-dark badge ">{{ $usulanSuratSrikandi->catatan }}</span>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Dokumen Surat Usulan:</th>
                                <td>
                                    <a class="badge badge-primary p-2"
                                        href="{{ route('usulan-surat-srikandi.download', $usulanSuratSrikandi->id) }}">
                                        <i class="fa-solid fa-file-arrow-down mr-1"></i>Download</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengajuan:</th>
                                <td>{{ \Carbon\Carbon::parse($usulanSuratSrikandi->created_at)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Pejabat Penanda Tangan:</th>
                                <td>{{ $pejabatPenandaTangan[$usulanSuratSrikandi->pejabat_penanda_tangan] }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Naskah Dinas:</th>
                                <td>{{ $jenisNaskahDinas[$usulanSuratSrikandi->jenis_naskah_dinas] }}</td>
                            </tr>
                            @if($usulanSuratSrikandi->jenis_naskah_dinas_penugasan != null)
                            <tr>
                                <th>Jenis Naskah Dinas Penugasan:</th>
                                <td>{{ $jenisNaskahDinasPenugasan[$usulanSuratSrikandi->jenis_naskah_dinas_penugasan] }}
                                </td>
                            </tr>
                            @endif
                            @if ($usulanSuratSrikandi->jenis_naskah_dinas_korespondensi != null)
                            <tr>
                                <th>Jenis Naskah Dinas Korespondensi:</th>
                                <td>{{ $jenisNaskahDinasKorespondensi[$usulanSuratSrikandi->jenis_naskah_dinas_korespondensi] }}
                                </td>
                            </tr>
                            @endif
                            @if ($usulanSuratSrikandi->kegiatan!= null)
                            <tr>
                                <th>Kegiatan:</th>
                                <td>{{ $kegiatan[$usulanSuratSrikandi->kegiatan] }}</td>
                            </tr>
                            @endif
                            @if($usulanSuratSrikandi->melaksanakan != null)
                            <tr>
                                <th>Melaksananan</th>
                                <td>{{ $usulanSuratSrikandi->melaksanakan }}</td>
                            </tr>
                            @endif
                            @if($usulanSuratSrikandi->kegiatan_pengawasan != null)
                            <tr>
                                <th>Kegiatan Pengawasan:</th>
                                <td>{{ $kegiatanPengawasan[$usulanSuratSrikandi->kegiatan_pengawasan] }}</td>
                            </tr>
                            @endif
                            @if($usulanSuratSrikandi->pendukung_pengawasan != null)
                            <tr>
                                <th>Pendukung Pengawasan:</th>
                                <td>{{ $pendukungPengawasan[$usulanSuratSrikandi->pendukung_pengawasan] }}</td>
                            </tr>
                            @endif
                            @if($usulanSuratSrikandi->unsur_tugas != null)
                            <tr>
                                <th>Unsur Tugas:</th>
                                <td>{{ $unsurTugas[$usulanSuratSrikandi->unsur_tugas] }}</td>
                            </tr>
                            @endif
                            @if($usulanSuratSrikandi->perihal != null)
                            <tr>
                                <th>Perihal:</th>
                                <td>{{ $usulanSuratSrikandi->perihal }}</td>
                            </tr>
                            @endif

                            <tr>
                                <th>Derajat Keamanan:</th>
                                <td>{{ $usulanSuratSrikandi->derajat_keamanan }}</td>
                            </tr>
                            <tr>
                                <th>Kode Klasifikasi Arsip:</th>
                                <td>{{ $usulanSuratSrikandi->kode_klasifikasi_arsip }}</td>
                            </tr>

                            <tr>
                                <th>Usulan Tanggal Penanda Tangan</th>
                                <td>{{ \Carbon\Carbon::parse($usulanSuratSrikandi->usulan_tanggal_penandatanganan)->format('d F Y') }}
                                </td>
                            </tr>
                        </table>
                        {{-- edit and delete button --}}
                        {{-- <div class="d-flex">
                            <div class="buttons ml-auto my-2">
                                <a href="{{ route('usulan-surat-srikandi.edit', $usulanSuratSrikandi->id) }}"
                        id="edit-btn" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                        Edit
                        </a>
                        <form action="{{ route('usulan-surat-srikandi.destroy', $usulanSuratSrikandi->id) }}"
                            method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" id="delete-btn">
                                <i class="fas fa-trash"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div> --}}
            </div>

        </div>
</div>
</section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Bootstrap is required -->
@endpush