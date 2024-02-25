@if ($total_usulan != 0)

<div class="card p-4 mb-2">
    <div class="d-flex justify-content-between">
        <div class="d-flex flex-row align-items-center">
            <div class="icon bg-danger"> <i class="fas fa-envelope text-white"></i></i> </div>
            <div class="ms-2 c-details mx-3">
                <h6 class="mb-0 text-dark">Surat Srikandi</h6>
            </div>
        </div>
        <a href="{{ route('usulan-surat-srikandi.index') }}" class="arrow-button-card" type="button"
            class="rounded-circle"><i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div style="width:100%" class="mt-3 d-flex">
        {{-- <h3 class="font-weight-normal text-dark h5">Surat Srikandi</h3> --}}
        @if ($percentage_usulan != 0)
        <div style="width:{{ $percentage_usulan }}%" class="bg-warning text-white p-1 segmented-proggress rounded-bar">
        </div>
        @endif
        @if ($percentage_disetujui != 0)
        <div style="width:{{ $percentage_disetujui }}%"
            class="bg-success text-white p-1 segmented-proggress rounded-bar">
        </div>
        @endif
        @if ($percentage_ditolak != 0)
        <div style="width:{{ $percentage_ditolak }}%" class="bg-danger text-white p-1 segmented-proggress rounded-bar">
        </div>
        @endif
    </div>
    <div style="width:100%" class="mt-3 d-flex">
        @if ($usulanCount != 0)
        <div class="mx-2">
            <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Usulan</h6>
            <div class="d-flex align-items-center">
                <div class="bg-warning text-white p-1 mr-2 rounded-bar">
                </div>
                <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $usulanCount }}</div>
            </div>
        </div>
        @endif
        @if ($disetujuiCount != 0)
        <div class="mx-2">
            <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Disetujui</h6>
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-1 mr-2 rounded-bar">
                </div>
                <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $disetujuiCount }}
                </div>
            </div>
        </div>
        @endif
        @if ($ditolakCount != 0)
        <div class="mx-2">
            <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Ditolak</h6>
            <div class="d-flex align-items-center">
                <div class="bg-danger text-white p-1 mr-2 rounded-bar">
                </div>
                <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $ditolakCount }}</div>
            </div>
        </div>
        @endif
    </div>
</div>

@endif
