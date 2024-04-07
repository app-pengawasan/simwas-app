<div class="modal fade" id="modal-create-tim-km" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tim-km-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tim-km-label">Kendali Mutu</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNHtim" action="/pegawai/tim/kendali-mutu" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="tugas">Tugas</label>
                        <div class="">
                            <select required id="tugas" name="tugas" class="form-control select2">
                                <option value="" selected disabled>Pilih Tugas</option>
                                @foreach ($tugasSaya as $ts)
                                    @if (!isset($ts->rencanaKerja->kendaliMutu))
                                        <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('tugas'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tugas') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="file">File Kendali Mutu</label>
                        <div class="">
                            <input type="file" name="file" id="file" class="form-control" accept=".rar, .zip" required>
                            @if ($errors->has('file'))
                            <div class="invalid-feedback">
                                {{ $errors->first('file') }}
                            </div>
                            @endif
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
