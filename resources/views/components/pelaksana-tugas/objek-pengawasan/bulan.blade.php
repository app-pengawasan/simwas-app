<div class="modal fade" id="modal-bulan-objek" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-bulan-objek-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="show-id" name="show-id">
                <div class="h5 text-dark d-flex align-items-center py-2 mb-3" style="border-bottom: 1px solid #818181">
                    <div class="badge alert-primary mr-2" style="width: 25px; height: 25px">
                        <i class="fa-solid fa-file-contract fa-xs"></i>
                    </div>
                    <h1 class="h6 mb-0 text-bold text-dark">Bulan Pelaporan Kinerja</h1>
                </div>

                <?php
                $bulan = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                    'November', 'Desember'
                ];
                ?>
                @foreach ($bulan as $key => $value)

                <div class="form-group px-2 mb-1">
                    <label class="mb-1">{{ $value }}</label>
                    <div class="d-flex align-items-center">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input name="bulan-{{ $value }}" type="radio" value="1" class="selectgroup-input" disabled>
                                <span class="selectgroup-button">Ya</span>
                            </label>
                            <label class="selectgroup-item">
                                <input name="bulan-{{ $value }}" type="radio" value="0" class="selectgroup-input1" disabled>
                                <span class="selectgroup-button1">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
