<div style="gap:15px" class="d-flex flex-column dashboard-card">
    <h2 class="font-weight-normal text-dark h5 mb-0">Pegawai</h2>
    <div class="d-flex flex-row dashboard-card flex-wrap" style="gap:15px">
        @if ($total_usulan != 0)
        <div class="card p-4 mb-2 col-md-3">
            {{-- as pegawai --}}
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
                <div style="width:{{ $percentage_usulan }}%"
                    class="bg-warning text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($percentage_disetujui != 0)
                <div style="width:{{ $percentage_disetujui }}%"
                    class="bg-success text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($percentage_ditolak != 0)
                <div style="width:{{ $percentage_ditolak }}%"
                    class="bg-danger text-white p-1 segmented-proggress rounded-bar">
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



        @if ($normaHasilCount != 0)
        <div class="card p-4 mb-2 col-md-3">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-info"> <i class="fas fa-check text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Norma Hasil</h6>
                    </div>
                </div>
                <a href="/pegawai/norma-hasil" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                {{-- <h3 class="font-weight-normal text-dark h5">Surat Srikandi</h3> --}}
                @if ($normaHasilPercentageDiperiksa != 0)
                <div style="width:{{ $normaHasilPercentageDiperiksa }}%"
                    class="bg-warning text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($normaHasilPercentageDisetujui != 0)
                <div style="width:{{ $normaHasilPercentageDisetujui }}%"
                    class="bg-success text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($normaHasilPercentageDitolak != 0)
                <div style="width:{{ $normaHasilPercentageDitolak }}%"
                    class="bg-danger text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                @if ($normaHasilDiperiksa != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Usulan</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $normaHasilDiperiksa }}
                        </div>
                    </div>
                </div>
                @endif
                @if ($normaHasilDisetujui != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Disetujui</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $normaHasilDisetujui }}
                        </div>
                    </div>
                </div>
                @endif
                @if ($normaHasilDitolak != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Ditolak</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $normaHasilDitolak }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>



<div style="gap:15px" class="d-flex flex-column dashboard-card mt-2">
    <h2 class="font-weight-normal text-dark h5 mb-0">Ketua Tim</h2>
    <div class="d-flex flex-row dashboard-card" style="gap:15px">
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
                <h1 class="text-dark" style="font-size: 3em; font-weight: bold;">
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
                <a href="/pegawai/norma-hasil" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                {{-- <h3 class="font-weight-normal text-dark h5">Surat Srikandi</h3> --}}
                @if ($timKerjaPercentagePenyusunan != 0)
                <div style="width:{{ $timKerjaPercentagePenyusunan }}%"
                    class="bg-warning text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($timKerjaPercentageDiajukan != 0)
                <div style="width:{{ $timKerjaPercentageDiajukan }}%"
                    class="bg-success text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
                @if ($timKerjaPercentageDiterima != 0)
                <div style="width:{{ $timKerjaPercentageDiterima }}%"
                    class="bg-danger text-white p-1 segmented-proggress rounded-bar">
                </div>
                @endif
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                @if ($timKerjaPenyusunanCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Penyusunan</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $timKerjaPenyusunanCount }}
                        </div>
                    </div>
                </div>
                @endif
                @if ($timKerjaDiajukanCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Diajukan</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $timKerjaDiajukanCount }}
                        </div>
                    </div>
                </div>
                @endif
                @if ($timKerjaDiterimaCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Diterima</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white p-1 mr-2 rounded-bar">
                        </div>
                        <div style="font-size: 1.2em;" class="font-weight-bold text-dark">{{ $timKerjaDiterimaCount }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
</div>
