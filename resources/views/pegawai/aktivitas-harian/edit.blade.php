<div class="modal fade" id="modal-edit-aktivitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-aktivitas-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-aktivitas-label">Edit Aktivitas</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="" name="myeditform" id="myeditform">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label class="form-label" for="edit-tugas">Tugas</label>
                        <select class="form-control" name="edit-tugas" id="edit-tugas" required disabled>
                            @foreach ($tugasSaya as $ts)
                                <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-laporan_opengawasan">Bulan Pelaporan</label>
                        <select class="form-control" name="edit-laporan_opengawasan" id="edit-laporan_opengawasan" required disabled>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-tgl">Tanggal</label>
                        <input type="date" name="edit-tgl" id="edit-tgl" class="form-control" required>
                        <small id="error-edit-tgl" class="text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group clockpicker" data-placement="top" data-autoclose="true">
                                <label class="form-label" for="edit-start">Jam Mulai</label>
                                <input type="text" name="edit-start" id="edit-start" class="form-control" required>
                                <small id="error-edit-start" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group clockpicker" data-placement="top" data-autoclose="true">
                                <label class="form-label" for="edit-end">Jam Selesai</label>
                                <input type="text" name="edit-end" id="edit-end" class="form-control" required>
                                {{-- <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span> --}}
                                <small id="error-edit-end" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="aktivitas">Aktivitas</label>
                        <textarea rows="5" class="form-control h-auto" id="edit-aktivitas" name="edit-aktivitas"></textarea>
                        <small id="error-edit-aktivitas" class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" id="btn-edit-submit" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
