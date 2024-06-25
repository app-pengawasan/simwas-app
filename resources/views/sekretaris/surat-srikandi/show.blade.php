@extends('layouts.app')

@section('title', 'Detail Usulan Surat Srikandi')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
{{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.sekretaris-header')
@include('components.sekretaris-sidebar')

@if ($usulanSuratSrikandi->status == 'disetujui')

@include('sekretaris.surat-srikandi.edit')
@endif
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Usulan Surat Srikandi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/sekretaris/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/sekretaris/surat-srikandi">Usulan Surat Srikandi</a>
                </div>
                <div class="breadcrumb-item">Detail Usulan</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">

                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        @if ($usulanSuratSrikandi->status == 'disetujui' || $usulanSuratSrikandi->status ==
                        'dibatalkan')

                        <h1 class="h4 text-dark mb-4 header-card">Informasi Surat Srikandi</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Pejabat Penanda Tangan:</th>
                                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->kepala_unit_penandatangan_srikandi}}</td>
                            </tr>
                            {{-- nomor_surat_srikandi --}}
                            <tr>
                                <th>Nomor Surat Srikandi:</th>
                                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->nomor_surat_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Dokumen Surat Srikandi:</th>
                                <td>
                                    <a class="badge badge-danger p-2" target="_blank"
                                        href="/{{ $usulanSuratSrikandi->suratSrikandi[0]->document_srikandi_pdf_path }}">
                                        <i class="fa-solid fa-file-pdf mr-1"></i>Download</a>
                                    <a class="badge badge-info p-2" target="_blank"
                                        href="/{{ $usulanSuratSrikandi->suratSrikandi[0]->document_srikandi_word_path }}">
                                        <i class="fa-solid fa-file-word mr-1"></i>Download</a>

                            <tr>
                                <th>Jenis Naskah Dinas:</th>
                                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->jenis_naskah_dinas_srikandi }}</td>
                            </tr>
                            {{-- <tr>
                                                                                    <th>Jenis Naskah Dinas Penugasan:</th>
                                                                                    <td>{{ $usulanSuratSrikandi->jenis_naskah_dinas_penugasan }}
                            </td>
                            </tr>
                            <tr>
                                <th>Jenis Naskah Dinas Penugasan:</th>
                                <td>{{ $usulanSuratSrikandi->jenis_naskah_dinas_penugasan }}</td>
                            </tr> --}}
                            {{-- kegiatan --}}
                            <tr>
                                <th>Tanggal Persetujuan Srikandi:</th>
                                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->tanggal_persetujuan_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Derajat Keamanan:</th>
                                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->derajat_keamanan_srikandi }}</td>
                            </tr>
                            <tr>
                                <th>Kode Klasifikasi Arsip:</th>
                                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->kodeKlasifikasiArsip->kode ?? '' }}
                                    {{ $usulanSuratSrikandi->suratSrikandi[0]->kodeKlasifikasiArsip->uraian ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Link Srikandi</th>
                                <td>
                                    <a target="_blank" class="badge badge-primary"
                                        href="{{ $usulanSuratSrikandi->suratSrikandi[0]->link_srikandi }}">
                                        {{ $usulanSuratSrikandi->suratSrikandi[0]->link_srikandi }}
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
                                    Pada Tanggal {{ $usulanSuratSrikandi->updated_at->format('d F Y')}} Oleh
                                    {{ $usulanSuratSrikandi->suratSrikandi[0]->user->name }}
                                    @elseif ($usulanSuratSrikandi->status == 'ditolak')
                                    <span class="badge badge-danger"><i
                                            class="fa-solid fa-triangle-exclamation mr-1"></i>Ditolak</span>
                                    @elseif ($usulanSuratSrikandi->status == 'dibatalkan')
                                    <span class="badge badge-danger"><i
                                            class="fa-solid fa-ban mr-1"></i>Dibatalkan</span>
                                    @else
                                    <span class="badge badge-light"><i class="fa-regular fa-clock mr-1"></i>Menunggu
                                        Persetujuan</span>
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
                                        href="{{ route('pegawai.usulan-surat-srikandi.download', $usulanSuratSrikandi->id) }}">
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
                                <td>{{ $usulanSuratSrikandi->kodeKlasifikasiArsip->kode ?? ''}}
                                    {{ $usulanSuratSrikandi->kodeKlasifikasiArsip->uraian ?? '' }}</td>
                            </tr>

                            <tr>
                                <th>Usulan Tanggal Penanda Tangan</th>
                                <td>{{ \Carbon\Carbon::parse($usulanSuratSrikandi->usulan_tanggal_penandatanganan)->format('d F Y') }}
                                </td>
                            </tr>
                        </table>
                        {{-- edit and delete button --}}
                        <hr class="my-1">
                        <div class="d-flex justify-content-between mt-4">
                            <div class="col-md-12">
                                <a class="btn btn-outline-primary mr-2"
                                    href="{{ route('sekretaris.surat-srikandi.index') }}">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                @if ($usulanSuratSrikandi->status == 'usulan')
                                <button type="button" class="btn btn-danger mr-2" data-toggle="modal"
                                    data-target="#modalTolakSurat">
                                    <i class="fa-regular fa-circle-xmark mr-1"></i>
                                    Tolak
                                </button>
                                <button type="button" class="btn btn-success mr-2" data-toggle="modal"
                                    data-target="#modalSetujuiSurat">
                                    <i class="fa-regular fa-circle-check mr-1"></i>
                                    Setujui
                                </button>
                                @endif
                                @if ($usulanSuratSrikandi->status == 'disetujui')
                                <button type="button" class="btn btn-warning mr-2" data-toggle="modal"
                                    data-target="#modalEditSurat">
                                    <i class="fa-regular fa-edit mr-1"></i>
                                    Ubah Surat
                                </button>
                                <form action="/sekretaris/surat-srikandi/batal/{{$usulanSuratSrikandi->id}}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger mr-2" data-toggle="modal">
                                        <i class="fa-solid fa-ban mr-1"></i>
                                        Batalkan Persetujuan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</div>
<div class="modal fade" id="modalTolakSurat" tabindex="-1" role="dialog" aria-labelledby="modalTolakSuratLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('sekretaris.surat-srikandi.decline', $usulanSuratSrikandi->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakSuratLabel">Tolak Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alasan">Alasan Penolakan</label>
                        <input placeholder="Masukkan Alasan Penolakan" type="text" required class="form-control"
                            name="alasan" id="alasan"></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSetujuiSurat" tabindex="-1" role="dialog" aria-labelledby="modalSetujuiSuratLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('sekretaris.surat-srikandi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSetujuiSuratLabel">Setujui Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="pejabat_penanda_tangan"
                    value="{{ $usulanSuratSrikandi->pejabat_penanda_tangan }}">
                <div class="modal-body">
                    {{-- hidden form id $usulanSuratSrikandi --}}
                    <input type="hidden" name="usulan_surat_srikandi_id" value="{{ $usulanSuratSrikandi->id }}">
                    {{-- jenis naskah dinas --}}
                    <div class="form-group">
                        <label for="jenisNaskahDinas">Jenis Naskah Dinas</label>
                        <select required class="form-control select2 @error('jenisNaskahDinas') is-invalid @enderror"
                            id="jenisNaskahDinas" name="jenisNaskahDinas">
                            <option disabled selected value="">Pilih Jenis Naskah Dinas</option>
                            @foreach ($jenisNaskahDinas as $jenisNaskahDinas)
                            <option {{
                                                                            old('jenisNaskahDinas') == $jenisNaskahDinas ? 'selected' : ''
                                                                        }} value="{{ $jenisNaskahDinas }}">
                                {{ $jenisNaskahDinas }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Jenis Naskah Dinas Harus Diisi</div>
                    </div>
                    {{-- tanggal persetujuan srikandi --}}
                    <div class="form-group
                        {{ $errors->has('tanggal_persetujuan_srikandi') ? 'has-error' : '' }}">
                        <label for="tanggal_persetujuan_srikandi">Tanggal Persetujuan Srikandi</label>
                        <input required type="date" class="form-control" name="tanggal_persetujuan_srikandi"
                            id="tanggal_persetujuan_srikandi" value="{{ old('tanggal_persetujuan_srikandi') }}">
                        @if ($errors->has('tanggal_persetujuan_srikandi'))
                        <span class="help-block
                            text-danger">{{ $errors->first('tanggal_persetujuan_srikandi') }}</span>
                        @endif
                    </div>
                    {{-- nomor surat srikandi --}}
                    <div class="form-group
                        {{ $errors->has('nomor_surat_srikandi') ? 'has-error' : '' }}">
                        <label for="nomor_surat_srikandi">Nomor Surat Srikandi</label>
                        <input required type="text" class="form-control" name="nomor_surat_srikandi"
                            id="nomor_surat_srikandi" value="{{ old('nomor_surat_srikandi') }}">
                        @if ($errors->has('nomor_surat_srikandi'))
                        <span class="help-block
                            text-danger">{{ $errors->first('nomor_surat_srikandi') }}</span>
                        @endif
                    </div>
                    {{-- derajat keamanan --}}
                    <div class="form-group">
                        <label for="derajatKeamanan">Derajat Keamanan</label>
                        <select required class="form-control select2 @error('derajatKeamanan') is-invalid @enderror"
                            id="derajatKeamanan" name="derajatKeamanan">
                            <option disabled selected value="">Pilih Kegiatan Derajat Keamanan
                            </option>
                            @foreach ($derajatKeamanan as $derajatKeamanan)
                            <option {{ old('derajatKeamanan') == $derajatKeamanan ? 'selected' : '' }}
                                value="{{ $derajatKeamanan }}">
                                {{ $derajatKeamanan }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Derajat Kemanan Harus Diisi</div>
                    </div>
                    {{-- kode klasifikasi arsip --}}
                    <div class="form-group">
                        <label for="kodeKlasifikasiArsip">Kode Klasifikasi Arsip</label>
                        <select required class="form-control select2
                            @error('kodeKlasifikasiArsip') is-invalid @enderror" id=" kodeKlasifikasiArsip"
                            name="kodeKlasifikasiArsip">
                            <option disabled selected value="">Pilih Kode Klasifikasi Arsip</option>
                            @foreach ($kodeKlasifikasiArsip as $kodeKlasifikasiArsip)
                            <option {{ old('kodeKlasifikasiArsip') == $kodeKlasifikasiArsip->id ? 'selected' : '' }}
                                value="{{ $kodeKlasifikasiArsip->id }}">
                                {{ $kodeKlasifikasiArsip->nama }}{{ $kodeKlasifikasiArsip->uraian }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Kode Klasifikasi Arsip Harus Diisi</div>
                    </div>
                    {{-- perihal --}}
                    <div class="form-group">
                        <label for="melaksanakan">Melaksanakan</label>
                        <input required placeholder="Input Untuk Melaksanakan" type="text"
                            class="form-control @error('melaksanakan') is-invalid @enderror" id="melaksanakan"
                            name="melaksanakan" value="{{ old('melaksanakan') }}">
                        <div class="invalid-feedback">Melaksanakan Harus Diisi</div>
                    </div>
                    {{-- kepala unit penanda tangan --}}
                    <div class="form-group">
                        <label for="pejabatPenandaTangan">Pejabat Penanda Tangan</label>
                        <select required
                            class="form-control select2 @error('pejabatPenandaTangan') is-invalid @enderror"
                            id="pejabatPenandaTangan" name="pejabatPenandaTangan">
                            <option disabled selected value="">Pilih Pejabat Penanda Tangan</option>
                            @foreach ($pejabatPenandaTangan as $pejabatPenandaTangan)
                            <option {{old('pejabatPenandaTangan') == $pejabatPenandaTangan ? 'selected' : '' }}
                                value="{{ $pejabatPenandaTangan }}">
                                {{ $pejabatPenandaTangan }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Pejabat Penanda Tangan Harus Diisi</div>
                    </div>
                    {{-- link srikandi --}}
                    <div class="form-group
                        {{ $errors->has('link_srikandi') ? 'has-error' : '' }}">
                        <label for="link_srikandi">Link Srikandi</label>
                        <input required type="url" class="form-control" name="link_srikandi" id="link_srikandi"
                            value="{{ old('link_srikandi') }}">
                        @if ($errors->has('link_srikandi'))
                        <span class="help-block
                            text-danger">{{ $errors->first('link_srikandi') }}</span>
                        @endif
                    </div>
                    {{-- upload word document --}}
                    <div class="form-group
                        {{ $errors->has('upload_word_document') ? 'has-error' : '' }}">
                        <label for="upload_word_document">Upload Word Document</label>
                        <input required type="file" class="form-control" name="upload_word_document"
                            id="upload_word_document"
                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            value="{{ old('upload_word_document') }}">
                        @if ($errors->has('upload_word_document'))
                        <span class="help-block
                            text-danger">{{ $errors->first('upload_word_document') }}</span>
                        @endif
                    </div>
                    {{-- upload pdf document --}}
                    <div class="form-group
                        {{ $errors->has('upload_pdf_document') ? 'has-error' : '' }}">
                        <label for="upload_pdf_document">Upload PDF Document</label>
                        <input required type="file" class="form-control" name="upload_pdf_document"
                            id="upload_pdf_document" accept="application/pdf" value="{{ old('upload_pdf_document') }}">
                        @if ($errors->has('upload_pdf_document'))
                        <span class="help-block
                            text-danger">{{ $errors->first('upload_pdf_document') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Bootstrap is required -->
@endpush
