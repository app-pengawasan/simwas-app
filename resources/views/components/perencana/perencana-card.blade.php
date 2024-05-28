<div style="gap:5px" class="d-flex flex-column dashboard-card my-4">
    @if ($totalIkuUnitKerjaCount != 0)
    <div class="card p-4 mb-2 col-md-4">
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-row align-items-center">
                <div class="icon bg-primary"><i class="fas fa-people-group text-white"></i> </div>
                <div class="ms-2 c-details mx-3">
                    <h6 class="mb-0 text-dark">IKU Unit Kerja</h6>
                </div>
            </div>
            <a href="/perencana/target-iku-unit-kerja" class="arrow-button-card" type="button" class="rounded-circle"><i
                    class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div style="width:100%" class="mt-3 d-flex">
            {{-- <h3 class="font-weight-normal text-dark h5">Surat Srikandi</h3> --}}
            @if ($percentageTarget != 0)
            <div style="width:{{ $percentageTarget }}%"
                class="bg-danger text-white p-1 segmented-proggress rounded-bar">
            </div>
            @endif
            @if ($percentageRealisasi != 0)
            <div style="width:{{ $percentageRealisasi }}%"
                class="bg-info text-white p-1 segmented-proggress rounded-bar">
            </div>
            @endif
            @if ($percentageEvaluasi != 0)
            <div style="width:{{ $percentageEvaluasi }}%"
                class="bg-warning text-white p-1 segmented-proggress rounded-bar">
            </div>
            @endif
            @if ($percentageSelesai != 0)
            <div style="width:{{ $percentageSelesai }}%"
                class="bg-success text-white p-1 segmented-proggress rounded-bar">
            </div>
            @endif
        </div>
        <div style="width:100%" class="mt-3 d-flex">
            @if ($targetIkuUnitKerjaCount != 0)
            <div class="mx-2">
                <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Penyusunan Target</h6>
                <div class="d-flex align-items-center">
                    <div class="bg-danger text-white p-1 mr-2 rounded-bar">
                    </div>
                    <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                        {{ $targetIkuUnitKerjaCount }}
                    </div>
                </div>
            </div>
            @endif
            @if ($realisasiIkuUnitKerjaCount != 0)
            <div class="mx-2">
                <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Penyusunan Realisasi</h6>
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white p-1 mr-2 rounded-bar">
                    </div>
                    <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                        {{ $realisasiIkuUnitKerjaCount }}
                    </div>
                </div>
            </div>
            @endif
            @if ($evaluasiIkuUnitKerjaCount != 0)
            <div class="mx-2">
                <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Penyusunan Evaluasi</h6>
                <div class="d-flex align-items-center">
                    <div class="bg-warning text-white p-1 mr-2 rounded-bar">
                    </div>
                    <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                        {{ $evaluasiIkuUnitKerjaCount }}
                    </div>
                </div>
            </div>
            @endif
            @if ($selesaiIkuUnitKerjaCount != 0)
            <div class="mx-2">
                <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Selesai</h6>
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white p-1 mr-2 rounded-bar">
                    </div>
                    <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                        {{ $selesaiIkuUnitKerjaCount }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
