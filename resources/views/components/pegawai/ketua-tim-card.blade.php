@if ($usulanNormaHasilCount != 0 || $timKerjaTotalCount != 0)

<div style="gap:5px" class="d-flex flex-column dashboard-card my-4">
    <h2 class="font-weight-normal text-dark h5 mb-1">Ketua Tim</h2>
    <div class="d-flex flex-row dashboard-card flex-wrap" style="gap:15px">
        @if ($usulanNormaHasilCount != 0)
        <div class="card p-4 mb-2 col-md-3">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-primary"><i class="fas fa-hand-point-up text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Usulan Norma Hasil</h6>
                    </div>
                </div>
                <a href="/ketua-tim/norma-hasil" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="d-flex mt-3 align-items-center">
                <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                    {{ $usulanNormaHasilCount }}</h1>
                <span class="text-dark ml-2">Dokumen Perlu Reviu</span>
            </div>
        </div>
        @endif

        @if ($timKerjaTotalCount != 0)
        <div class="card p-4 mb-2 col-md-3">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-primary"><i class="fas fa-people-group text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Tim Kerja</h6>
                    </div>
                </div>
                <a href="/ketua-tim/rencana-kinerja" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                {{-- <h3 class="font-weight-normal text-dark h5">Surat Srikandi</h3> --}}
                @if ($timKerjaPercentagePenyusunan != 0)
                <div style="width:{{ $timKerjaPercentagePenyusunan }}%"
                    class="bg-danger text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($timKerjaPercentageDiajukan != 0)
                <div style="width:{{ $timKerjaPercentageDiajukan }}%"
                    class="bg-warning text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($timKerjaPercentageDiterima != 0)
                <div style="width:{{ $timKerjaPercentageDiterima }}%"
                    class="bg-success text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                @if ($timKerjaPenyusunanCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Penyusunan</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                            {{ $timKerjaPenyusunanCount }}
                        </div>
                    </div>
                </div>
                @endif
                @if ($timKerjaDiajukanCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Diajukan</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                            {{ $timKerjaDiajukanCount }}
                        </div>
                    </div>
                </div>
                @endif
                @if ($timKerjaDiterimaCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Diterima</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">
                            {{ $timKerjaDiterimaCount }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endif
