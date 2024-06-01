<div class="modal fade" id="modal-edit-master-subunsur" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-master-subunsur-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-master-subunsur-label">Form Tambah Unsur Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-form" method="POST" action="{{ route('admin.master-subunsur.update', 'link-id') }}"
                enctype="multipart/form-data" class=" needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="editId" id="editId">
                    <div class="form-group">
                        <label class="form-label" for="editMasterUnsurId">Nama Unsur</label>
                        <div class="">
                            <select class="form-control" name="editMasterUnsurId" id="editMasterUnsurId" required>
                                <option disabled value="">Pilih Unsur</option>
                                @foreach ($masterUnsurs as $unsur)
                                <option id={{ $unsur->id }} value="{{ $unsur->id }}">{{ $unsur->nama_unsur }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="namaSubUnsur">Nama Subunsur</label>
                        <div class="">
                            <input type="text" class="form-control" name="editNamaSubUnsur" id="namaSubUnsur" required>
                            <small id="error-unsur" class="text-danger"></small>
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
