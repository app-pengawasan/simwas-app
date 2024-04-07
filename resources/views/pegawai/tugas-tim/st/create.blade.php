<div class="modal fade" id="modal-create-tim-st" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tim-st-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tim-st-label">Surat Tugas</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNHtim" action="/pegawai/tim/surat-tugas" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="tugas">Tugas</label>
                        <div class="">
                            <select required id="tugas" name="tugas" class="form-control select2">
                                <option value="" selected disabled>Pilih Tugas</option>
                                @foreach ($tugasSaya as $ts)
                                <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
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
                        <label class="form-label" for="nomor_st">Nomor Dokumen</label>
                        <div class="">
                            <input type="text" name="nomor_st" id="nomor_st" class="form-control" required>
                            @if ($errors->has('nomor_st'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nomor_st') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Dokumen</label>
                        <div class="">
                            <input type="text" name="nama" id="nama" class="form-control" required>
                            @if ($errors->has('nama'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nama') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="file">File Surat Tugas</label>
                        <div class="">
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
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
