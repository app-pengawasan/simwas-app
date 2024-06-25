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
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="editMasterUnsurId">Nama Unsur</label>
                        <div class="">
                            <select class="form-control" name="editMasterUnsurId" id="editMasterUnsurId" required>
                                <option value="">Pilih Unsur</option>
                                @foreach ($masterUnsurs as $unsur)
                                <option value="{{ $unsur->id }}">{{ $unsur->nama_unsur }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editMasterSubUnsurId">Nama Subunsur</label>
                        <div class="">
                            <select class="form-control" name="editMasterSubUnsurId" id="editMasterSubUnsurId" required>
                                <option value="">Pilih Subunsur</option>
                                @foreach ($masterSubUnsurs as $unsur)
                                <option value="{{ $unsur->id }}">{{ $unsur->nama_sub_unsur }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editNamaHasilKerja">Nama Hasil Kerja</label>
                        <div class="">
                            <input type="text" class="form-control" name="editNamaHasilKerja" id="editNamaHasilKerja"
                                required>
                            <small id="error-hasil-kerja" class="text-danger"></small>
                        </div>
                    </div>

                    {{-- radiobutton --}}
                    <div class="form-group
                                        {{ $errors->has('status') ? ' has-error' : '' }}">
                        <label class="form-label required" for="editStatus">Status</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="editStatus" value="1" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Gugus Tugas</span>
                            </label>
                            <label class="selectgroup-item">
                                <input id="ngt" type="radio" name="editStatus" value="0" class="selectgroup-input">
                                <span class="selectgroup-button">Bukan Gugus Tugas</span>
                            </label>
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
