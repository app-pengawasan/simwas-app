@extends('layouts.app')

@section('title', 'Detail Usulan ST Kinerja dan Norma Hasil')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tolak usulan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/inspektur/st-kinerja/{{ $usulan->id }}" method="post">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')    
                            <input type="hidden" name="status" value="{{ $usulan->status == 0 ? '1' : '4' }}">
                            <input type="hidden" name="id" value="{{ $usulan->id }}">
                            <div class="form-group">
                                <label for="catatan">Beri catatan</label>
                                <input type="text" class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" value="{{ old('catatan') }}">
                                @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tidak Setujui Usulan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Detail Usulan ST Kinerja dan Norma Hasil</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/inspektur/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/inspektur/st-kinerja">ST Kinerja dan Norma Hasil</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h2>Detail Usulan</h2>
                                    <table class="table">
                                        <tr>
                                            <th>Pemohon</th>
                                            <th>:</th>
                                            <td>{{ $usulan->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Backdate</th>
                                            <th>:</th>
                                            <td>{{ $usulan->is_backdate ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor ST</th>
                                            <th>:</th>
                                            <td>
                                            @if ($usulan->status == 0)
                                            <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status == 1)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @else
                                                {{ $usulan->no_surat }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status ST</th>
                                            <th>:</th>
                                            <td>
                                            @if ($usulan->status == 0 || $usulan->status == 3)
                                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status == 1 || $usulan->status == 4)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @elseif ($usulan->status == 2)
                                                <div class="badge badge-light">Belum Upload ST TTD</div>
                                            @else
                                                <div class="badge badge-success">Disetujui</div>
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <td>{{ $usulan->tanggal }}</td>
                                        </tr>
                                            <th>Unit Kerja</th>
                                            <th>:</th>
                                            <td>
                                                {{
                                                    ($usulan->unit_kerja == "8000") ? "Inspektorat Utama" :
                                                    (($usulan->unit_kerja == "8010") ? "Bagian Umum Inspektorat Utama" :
                                                    (($usulan->unit_kerja == "8100") ? "Inspektorat Wilayah I" :
                                                    (($usulan->unit_kerja == "8200") ? "Inspektorat Wilayah II" :
                                                    "Inspektorat Wilayah III")))
                                                }}
                                            </td>
                                        <tr>
                                        <tr>
                                            <th>Tim Kerja</th>
                                            <th>:</th>
                                            <td>{{ $usulan->tim_kerja }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>:</th>
                                            <td>{{ $usulan->tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Untuk Melaksanakan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->melaksanakan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Objek Pengawasan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->objek }}</td>
                                        </tr>
                                        <tr>
                                        <th>Mulai-Selesai</th>
                                        <th>:</th>
                                        <td>{{ $usulan->mulai." - ".$usulan->selesai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gugus Tugas</th>
                                            <th>:</th>
                                            <td>{{ ($usulan->is_gugus_tugas) ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        @if (!($usulan->is_gugus_tugas))
                                        <tr>
                                            <th>Jenis</th>
                                            <th>:</th>
                                            <td>{{ ($usulan->is_perseorangan) ? '1 orang' : 'Kolektif' }}</td>
                                        </tr>
                                        @endif
                                        @if (!($usulan->is_perseorangan))
                                        @if ($usulan->is_gugus_tugas)
                                        <tr>
                                            <th>Pengendali Teknis</th>
                                            <th>:</th>
                                            <td>{{ $usulan->dalnis->name }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>{{ $usulan->is_gugus_tugas ? 'Ketua Tim' : 'Koordinator' }}</th>
                                            <th>:</th>
                                            <td>{{ $usulan->ketuaKoor->name }}</td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <th>Anggota</th>
                                            <th>:</th>
                                            <td>{{ $anggota }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                        <th>Penandatangan</th>
                                        <th>:</th>
                                        <td><?php if ($usulan->penandatangan === 0) {
                                            echo "Inspektur Utama";
                                        } elseif ($usulan->penandatangan === 1) {
                                            echo "Inspektur Wilayah I";
                                        } elseif ($usulan->penandatangan === 2) {
                                            echo "Inspektur Wilayah II";
                                        } elseif ($usulan->penandatangan === 3) {
                                            echo "Inspektur Wilayah III";
                                        } else {
                                            echo "Kepala Bagian Umum";
                                        }?>
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>E-Sign</th>
                                        <th>:</th>
                                        <td>@if($usulan->is_esign)
                                            {{ "Ya" }}
                                        @else
                                            {{ "Tidak" }}
                                        @endif
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>File ST</th>
                                        <th>:</th>
                                        <td><a target="blank" href="{{ $usulan->file }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->catatan }}</td>
                                        </tr>
                                    </table>
                                    {{-- <canvas id="usulan_canvas"></canvas> --}}
                                    </div>
                                </div>
                                    @if ($usulan->status == 0)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                    <a href="/inspektur/st-kinerja/{{ $usulan->id }}/edit" class="btn btn-primary mr-2">
                                                        Edit Usulan
                                                    </a>
                                                    <form action="/inspektur/st-kinerja/{{ $usulan->id }}" method="post" class="mr-2">
                                                        @csrf
                                                        @method('PUT')    
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                        <button type="submit" class="btn btn-success">Setujui Usulan</button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#staticBackdrop">
                                                        Tidak Setujui Usulan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($usulan->status == 3)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                <form action="/inspektur/st-kinerja/{{ $usulan->id }}" method="post" class="mr-2">
                                                    @csrf
                                                    @method('PUT')    
                                                    <input type="hidden" name="status" value="5">
                                                    <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                    <button type="submit" class="btn btn-success">Setujui Usulan</button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#staticBackdrop">
                                                    Tidak Setujui Usulan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    {{-- PDFViewer --}}
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.7.107/build/pdf.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    {{-- <script>
        pdfjsLib.getDocument('./' + $usulan->draft).then(doc => {
            console.log("This file has " + doc._pdfInfo.numPages + " pages");
        });

        doc.getPage(1).then(page => {
            var usulanCanvas = document.getElementById("usulan_canvas");
            var context = usulanCanvas.getContext("2d");

            var viewport = page.getViewport(1);
            usulanCanvas.width = viewport.width;
            usulanCanvas.height = viewport.height;
            page.render({
                canvasContext: context,
                viewport: viewport
            });
        })
    </script>
    <script>
        // Mendapatkan URL file PDF yang ingin ditampilkan
        var pdfFile = "path/to/your/pdf_file.pdf";

        // Memuat PDF menggunakan PDF.js
        pdfjsLib.getDocument(pdfFile).promise.then(function (pdf) {
            var numPages = pdf.numPages;

            // Membuat elemen untuk setiap halaman PDF
            for (var pageNum = 1; pageNum <= numPages; pageNum++) {
                var container = document.createElement("div");
                container.className = "pdf-page";

                // Memuat halaman PDF ke dalam elemen
                pdf.getPage(pageNum).then(function (page) {
                    var canvas = document.createElement("canvas");
                    var context = canvas.getContext("2d");

                    var viewport = page.getViewport({ scale: 1 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport,
                    };

                    page.render(renderContext).promise.then(function () {
                        container.appendChild(canvas);
                    });
                });

                document.getElementById("pdf-viewer").appendChild(container);
            }
        }); 
    </script>--}}
@endpush
