<div class="modal fade" id="modal-create-masteriku" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-masteriku-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-masteriku-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('master-iku.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_tujuan">Tujuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_tujuan" id="id_tujuan" disabled required>
                                <option value="" selected disabled></option>
                                @foreach ($masterTujuan as $tujuan)
                                    <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                        data-selesai="{{ $tujuan->tahun_selesai }}">{{ $tujuan->tujuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_sasaran">Sasaran</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_sasaran" id="id_sasaran" required>
                                <option value="" selected disabled></option>
                                @foreach ($masterSasaran as $sasaran)
                                    <option value="{{ $sasaran->id_sasaran }}"
                                        data-idtujuan="{{ $sasaran->id_tujuan }}">{{ $sasaran->sasaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="iku">IKU</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="iku" required>
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
