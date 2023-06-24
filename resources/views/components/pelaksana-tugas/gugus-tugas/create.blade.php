<div class="modal fade" id="modal-create-pelaksana" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-pelaksana-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-pelaksana-label">Form Tambah Pelaksana Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="pt-jabatan">Jabatan</label>
                        <div class="col-sm-10">
                            <select id="pt-jabatan" class="form-control" name="pt-jabatan" disabled required>
                                <option value="1">Pengendali Teknis</option>
                                <option value="2">Ketua Tim</option>
                                <option value="3">PIC</option>
                                <option value="4">Anggota Tim</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="pt-hasil">Hasil Kerja</label>
                        <div class="col-sm-10">
                            <select id="pt-hasil" class="form-control" name="pt-hasil" disabled required>
                                <option value="1">Lembar Reviu</option>
                                <option value="2">Kertas Kerja</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="pelaksana">Nama</label>
                        <div class="col-sm-10">
                            <select id="pelaksana" class="form-control" name="pelaksana">
                                <option value="" selected disabled></option>
                                @foreach ($pegawai as $p)
                                    <?php
                                    $key = array_search($p->id, array_column($rencanaKerja->pelaksana->toArray(), 'id_pegawai'));
                                    ?>
                                    @if ($key === false)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" id="btn-submit-pelaksana">Tambah</button>
            </div>
        </div>
    </div>
</div>
