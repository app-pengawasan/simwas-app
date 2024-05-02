<div class="modal fade" id="modal-create-kompetensi" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-kompetensi-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-kompetensi-label">Form Tambah Kompetensi</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="" name="myform" id="myform">
                <div class="modal-body">
                    <input type="hidden" name="role" id="role" value="{{ $role }}">
                    @if ($role == 'analis sdm')
                        <div class="form-group">
                            <label class="form-label" for="pegawai_id">Pegawai</label>
                            <div class="">
                                <select class="form-control" id="pegawai_id" name="pegawai_id" required>
                                    <option value="" disabled selected>Pilih Pegawai</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->name }}</option>
                                    @endforeach
                                    <option value="" disabled></option>
                                </select>
                                <small id="error-pegawai_id" class="text-danger"></small>
                            </div>
                        </div>
                    @endif
                    <div class="form-group div_create_pp">
                        <label class="form-label" for="pp_id">Jenis Pengembangan Kompetensi</label>
                        <div class="">
                            <select class="form-control pp_id" id="pp_id" name="pp_id" required>
                                <option value="" disabled selected>Pilih Jenis Pengembangan</option>
                                @foreach ($pps as $pp)
                                <option value="{{ $pp->id }}">
                                    {{ $pp->jenis }}</option>
                                @endforeach
                                {{-- <option value="999">Lainnya</option> --}}
                                <option value="" disabled></option>
                            </select>
                            <small id="error-pp_id" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-inline form-one-line form-other-pp mt-3">
                        <label class="form-label" for="pp_lain">Sebutkan:</label>
                        <input type="text" name="pp_lain" id="pp_lain" class="form-control ml-3 pp_lain">
                        <small id="error-pp-lain" class="text-danger"></small>
                    </div>
                    <div class="form-group div_create_namapp">
                        <label class="form-label" for="nama_pp_id">Nama Pengembangan Kompetensi</label>
                        <div class="">
                            <select class="form-control nama_pp_id" name="nama_pp_id" id="nama_pp_id" required disabled>
                                <option value="" selected disabled class="disabled">Pilih Nama Pengembangan</option>
                                @foreach ($nama_pps as $nama_pp)
                                    <option value="{{ $nama_pp->id }}" data-pp="{{ $nama_pp->pp_id }}">{{ $nama_pp->nama }}</option>
                                @endforeach
                                {{-- <option value="999">Lainnya</option> --}}
                                <option value="" disabled></option>
                            </select>
                            <small id="error-nama_pp_id" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-inline form-one-line form-other-namepp mt-3">
                        <label class="form-label" for="nama_pp_lain">Sebutkan:</label>
                        <input type="text" name="nama_pp_lain" id="nama_pp_lain" class="form-control ml-3 nama_pp_lain">
                        <small id="error-nama_pp_lain" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-sertifikat">Sertifikat</label>
                        <input type="file" class="form-control" name="create-sertifikat" accept=".pdf" required>
                        <div class="invalid-feedback">
                            File belum ditambahkan
                        </div>
                        <small id="error-create-sertifikat" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="catatan">Catatan</label>
                        <div class="">
                            <textarea rows="5" class="form-control h-auto" id="catatan" name="catatan"></textarea>
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
