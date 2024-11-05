<div class="modal fade" id="modal-create-kompetensi" data-backdrop="static" data-keyboard="false"
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
                            <label class="form-label" for="pegawai_id">Pegawai<span class="text-danger">*</span></label>
                            <div class="">
                                <select class="form-control select2" id="pegawai_id" name="pegawai_id" required>
                                    <option value="" disabled selected>Pilih Pegawai</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->name }}</option>
                                    @endforeach
                                </select>
                                <small id="error-pegawai_id" class="text-danger"></small>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="form-label" for="kat">Kategori<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2 kategori" id="kat" name="kat" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($kategori as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-kat" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="jenis">Jenis<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2 jenis" id="jenis" name="jenis" required disabled>
                                <option value="" disabled selected>Pilih Jenis</option>
                            </select>
                            <small id="error-jenis" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="teknis_id">Teknis<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2 teknis" id="teknis_id" name="teknis_id" required disabled>
                                <option value="" disabled selected>Pilih Teknis</option>
                            </select>
                            <small id="error-teknis_id" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama_pelatihan">Nama Pelatihan<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pelatihan" required>
                        <small id="error-nama_pelatihan" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tgl_mulai">Tanggal Mulai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_mulai" required>
                        <small id="error-tgl_mulai" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tgl_selesai">Tanggal Selesai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_selesai" required>
                        <small id="error-tgl_selesai" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="durasi">Durasi (Jam)<span class="text-danger">*</span></label>
                        <input type="number" step=".01" class="form-control" name="durasi" required>
                        <small id="error-durasi" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tgl_sertifikat">Tanggal Sertifikat<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_sertifikat" required>
                        <small id="error-tgl_sertifikat" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-sertifikat">Sertifikat<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="create-sertifikat" accept=".pdf" required>
                        <div class="invalid-feedback">
                            File belum ditambahkan
                        </div>
                        <small id="error-create-sertifikat" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="penyelenggara">Penyelenggara<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2" id="penyelenggara" name="penyelenggara" required>
                                <option value="" disabled selected>Pilih Penyelenggara</option>
                                @foreach ($penyelenggara as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->penyelenggara }}</option>
                                @endforeach
                            </select>
                            <small id="error-penyelenggara" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="jumlah_peserta">Jumlah Peserta</label>
                        <input type="number" class="form-control" name="jumlah_peserta">
                        <small id="error-jumlah_peserta" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="ranking">Ranking</label>
                        <input type="number" class="form-control" name="ranking">
                        <small id="error-ranking" class="text-danger"></small>
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-label" for="catatan">Catatan</label>
                        <div class="">
                            <textarea rows="5" class="form-control h-auto" id="catatan" name="catatan"></textarea>
                        </div>
                    </div> --}}
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
