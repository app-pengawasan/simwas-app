<div class="modal fade" id="modal-create-aktivitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-aktivitas-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-aktivitas-label">Tambah Aktivitas</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="" name="myform" id="myform">
                <div class="modal-body">
                    <input type="hidden" name="tgl" id="tgl">
                    <div class="form-group">
                        <label class="form-label" for="tugas">Tugas</label>
                        <select class="form-control select2" name="tugas" id="tugas" required>
                            <option value="" selected disabled>Pilih Tugas</option>
                            @foreach ($tugasSaya as $ts)
                                <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_pelaksana" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="objek">Objek Pengawasan</label>
                        <select class="form-control select2" name="objek" id="objek" required disabled>
                            <option value="" selected disabled>Pilih Objek Pengawasan</option>
                        </select>
                        <small id="error-objek" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="laporan_opengawasan">Bulan Pelaporan</label>
                        <select class="form-control select2" name="laporan_opengawasan" id="laporan_opengawasan" required disabled>
                            <option value="" selected disabled>Pilih Bulan Pelaporan</option>
                        </select>
                        <small id="error-laporan_opengawasan" class="text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group clockpicker" data-autoclose="true">
                                <label class="form-label" for="start">Jam Mulai</label>
                                <input type="text" name="start" id="start" class="form-control" required>
                                <small id="error-start" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group clockpicker" data-autoclose="true">
                                <label class="form-label" for="end">Jam Selesai</label>
                                <input type="text" name="end" id="end" class="form-control" required>
                                {{-- <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span> --}}
                                <small id="error-end" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="aktivitas">Aktivitas</label>
                        <textarea rows="5" class="form-control h-auto" id="aktivitas" name="aktivitas"></textarea>
                        <small id="error-aktivitas" class="text-danger"></small>
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
