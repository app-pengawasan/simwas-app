<div class="modal fade" id="modal-create-tim-norma-hasil" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tim-norma-hasil-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tim-norma-hasil-label">Laporan Norma Hasil</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNHtim" action="/pegawai/tim/norma-hasil" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="nomor">Nomor Dokumen</label>
                        <div class="">
                            <select class="form-control" id="nomor" name="nomor" required>
                                <option value="" selected disabled>Pilih Nomor Dokumen</option>
                                @foreach ($draf as $un)
                                    <option value="{{ $un->id }}" data-nama="{{ $un->nama_dokumen }}">
                                        R-{{ $un->normaHasilAccepted->nomor_norma_hasil}}/{{ $un->normaHasilAccepted->unit_kerja}}/{{ $un->normaHasilAccepted->kode_klasifikasi_arsip}}/{{
                                            $kodeHasilPengawasan[$un->normaHasilAccepted->kode_norma_hasil]}}/{{ date('Y', strtotime($un->normaHasilAccepted->tanggal_norma_hasil)) }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-nomor" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Dokumen</label>
                        <div class="">
                            <input type="text" name="nama" id="nama" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">File Laporan</label>
                        <div class="">
                            <input type="file" name="nama" id="nama" class="form-control" accept=".pdf" required>
                            <small id="error-file" class="text-danger"></small>
                        </div>
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
