<div class="modal fade" id="modal-create-master-subunsur" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-create-master-SubUnsur-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-master-SubUnsur-label">Form Tambah Subunsur Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.master-subunsur.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="masterUnsurId">Nama Unsur</label>
                        @if (count($masterUnsurs) == 0)
                        <span><small class="text-danger">
                                *Tidak ada data unsur. Silahkan
                                <a href="/admin/master-unsur">
                                    tambah unsur
                                </a>
                                terlebih dahulu.
                            </small>
                        </span>
                        @endif
                        <div class="">
                            <select class="form-control select2" name="masterUnsurId" id="masterUnsurId" required
                                data-placeholder="Pilih Unsur">
                                <option value=""></option>
                                @foreach ($masterUnsurs as $unsur)
                                <option value="{{ $unsur->id }}">{{ $unsur->nama_unsur }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="namaSubUnsur">Nama Subunsur</label>
                        <div class="">
                            <input type="text" class="form-control" name="namaSubUnsur" id="namaSubUnsur" required
                                placeholder="Masukkan Nama Subunsur">
                            <small id="error-SubUnsur" class="text-danger"></small>
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
