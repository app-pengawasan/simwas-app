<div class="modal fade" id="modal-create-unitkerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-unitkerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h5 class="modal-title" id="modal-create-unitkerja-label">Form Tambah Unit Kerja</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form method="post" action="{{ route('master-unit-kerja.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate=""> --}}
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="form-group">
                                <label class="form-label" for="kode_wilayah">Kode Wilayah</label>
                                <div class="">
                                    <input type="text" class="form-control" name="kode_wilayah"
                                        id="create-kode_wilayah" value="{{ old('kode_wilayah') }}" required>
                                    <small id="error-kode_wilayah" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="kode_unitkerja">Kode Unit Kerja</label>
                                <div class="">
                                    <input type="text" class="form-control" name="kode_unitkerja"
                                        id="create-kode_unitkerja" value="{{ old('kode_unitkerja') }}" required>
                                    <small id="error-kode_unitkerja" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="nama">Nama</label>
                                <div class="">
                                    <input type="text" class="form-control" name="nama" id="create-nama"
                                        value="{{ old('nama') }}" required>
                                    <small id="error-nama" class="text-danger"></small>
                                </div>
                            </div>
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
