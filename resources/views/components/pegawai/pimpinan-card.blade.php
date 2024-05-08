@if ($usulanPimpinanCount != 0)

<div style="gap:5px" class="d-flex flex-column dashboard-card my-4">
    <h2 class="font-weight-normal text-dark h5 mb-1">Pimpinan</h2>
    <div class="d-flex flex-row dashboard-card flex-wrap" style="gap:15px">
        @if ($usulanPimpinanCount != 0)
        <div class="card p-4 mb-2 col-md-3">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-warning"><i class="fa-regular fas fa-newspaper text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Usulan Rencana Kerja</h6>
                    </div>
                </div>
                <a href="/pimpinan/rencana-kinerja" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="d-flex mt-3 align-items-center">
                <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                    {{ $usulanPimpinanCount }}</h1>
                <span class="text-dark ml-2">Rencana Kerja Perlu Reviu</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endif
