<div class="modal fade" id="modal-create-mastertujuan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-mastertujuan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-mastertujuan-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('master-tujuan.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tahun_mulai">Tahun Mulai</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tahun_mulai" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -5; $i < 8; $i++)
                                    <option value="{{ $year + $i }}" {{ $i === old('tahun', 0) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tahun_selesai">Tahun Selesai</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tahun_selesai" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -1; $i < 12; $i++)
                                    <option value="{{ $year + $i }}" {{ $i === old('tahun', 4) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tujuan">Tujuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tujuan" value="{{ old('nama') }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
