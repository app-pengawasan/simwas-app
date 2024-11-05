@extends('layouts.app')

@section('title', 'Kelola Kompetensi Pegawai')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @if ($role == 'analis-sdm')
        @include('components.analis-sdm-header')
        @include('components.analis-sdm-sidebar')
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
                            <div class="form-group">
                                <input type="hidden" name="data-id" id="data-id" value="{{ $kompetensi->id }}">
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
    @else
        @include('components.header')
        @include('components.pegawai-sidebar')
    @endif
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Kompetensi</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="row mb-4 pb-0">
                                <div class="col-md-8">                               
                                    @if ($role == 'analis-sdm')
                                        <a class="btn btn-primary" href="/analis-sdm/kelola-kompetensi">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>
                                        @if ($kompetensi->status == 3)
                                            <a class="btn btn-success" id="setuju-btn">
                                                <i class="fas fa-check-circle"></i> Setujui
                                            </a>
                                            <a class="btn btn-danger" data-toggle="modal"
                                            data-target="#staticBackdrop">
                                                <i class="fas fa-circle-xmark"></i> Tolak
                                            </a>
                                        @endif
                                    @else
                                        <a class="btn btn-primary" href="/pegawai/kompetensi">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <table class="mb-4 table table-striped responsive">
                                @if ($role == 'analis-sdm')
                                    <tr>
                                        <th>Pegawai</th>
                                        <td>{{ $kompetensi->pegawai->name }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $kompetensi->teknis->jenis->kategori->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td>{{ $kompetensi->teknis->jenis->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Teknis</th>
                                    <td>{{ $kompetensi->teknis->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pelatihan</th>
                                    <td>{{ $kompetensi->nama_pelatihan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $kompetensi->tgl_mulai }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $kompetensi->tgl_selesai }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>{{ $kompetensi->durasi }} jam</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sertifikat</th>
                                    <td>{{ $kompetensi->tgl_sertifikat }}</td>
                                </tr>
                                <tr>
                                    <th>Sertifikat</th>
                                    <td>
                                        <a class="btn btn-sm btn-primary"
                                        href="{{ asset('document/sertifikat/'.$kompetensi->sertifikat) }}" target="_blank">
                                            <i class="fas fa-eye mr-1"></i>Lihat
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <td>{{ $kompetensi->penyelenggaraDiklat->penyelenggara }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Peserta</th>
                                    <td>{{ $kompetensi->jumlah_peserta }}</td>
                                </tr>
                                <tr>
                                    <th>Ranking</th>
                                    <td>{{ $kompetensi->ranking }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($kompetensi->status == 1)
                                            <span class="badge badge-{{ $colorText[$kompetensi->status] }}">{{ $status[$kompetensi->status] }} oleh {{ $kompetensi->analis->name }}</span>
                                        @else
                                            <span class="badge badge-{{ $colorText[$kompetensi->status] }}">{{ $status[$kompetensi->status] }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @if ($kompetensi->status == 2)
                                <tr>
                                    <th>Alasan Penolakan</th>
                                    <td>{{ $kompetensi->catatan }}</td>
                                </tr>
                                @endif
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
    <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        $("#setuju-btn").on("click", function () {
            let dataId = $('#data-id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Aksi ini tidak dapat dibatalkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "var(--primary)",
                cancelButtonColor: "var(--danger)",
                confirmButtonText: "Setujui",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/analis-sdm/kelola-kompetensi/${dataId}`,
                        type: "PUT",
                        cache: false,
                        data: {
                            _token: token,
                            terima: true
                        },
                        success: function (response) {
                            location.reload();
                        },
                    });
                }
            });
        });

        $('#tolak-submit').on("click", function () {
            let dataId = $('#data-id').val();
            let catatan = $('#catatan').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/analis-sdm/kelola-kompetensi/${dataId}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    tolak: true,
                    catatan: catatan
                },
                success: function (response) {
                    location.reload();
                },
                error: function (error) {
                    let errorResponses = error.responseJSON;
                    let errors = Object.entries(errorResponses.errors);

                    errors.forEach(([key, value]) => {
                        // console.log(key);
                        let errorMessage = document.getElementById(`error-${key}`);
                        errorMessage.innerText = `${value}`;
                    });
                },
            });
        });
    </script>
@endpush
