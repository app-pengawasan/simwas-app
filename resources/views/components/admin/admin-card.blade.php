<div style="gap:5px" class="d-flex flex-column dashboard-card my-4">
    <div class="d-flex flex-row dashboard-card flex-wrap" style="gap:15px">
        <div class="card p-4 mb-2 col-lg">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-primary"><i class="fas fa-solid fa-users-gear text-white"></i></div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Jumlah Pegawai</h6>
                    </div>
                </div>
                <a href="/admin/master-pegawai" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="d-flex flex-row justify-content-around align-items-center" style="gap:5px">
                <div class="d-flex mt-3 align-items-center flex-column ">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $pegawai8000Count }}</h1>
                    <span class="text-dark text-center">Inspektorat Utama</span>
                </div>
                {{-- create vertical line --}}
                <div style="border-left: 1.5px solid rgba(92, 92, 92, 0.4); height: 70%;opacity: 0.5;"></div>
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $pegawai8010Count }}</h1>
                    <span class="text-dark text-center">Bagian Umum</span>
                </div>
            </div>
        </div>


        <div class="card p-4 mb-2 col-lg">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-primary"><i class="fas fa-solid fa-users text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Jumlah Pegawai</h6>
                    </div>
                </div>
                <a href="/admin/master-pegawai" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="d-flex flex-row justify-content-around align-items-center" style="gap:5px">
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $pegawai8100Count }}</h1>
                    <span class="text-dark text-center">Wilayah 1</span>
                </div>
                <div style="border-left: 1.5px solid rgba(92, 92, 92, 0.4); height: 70%;opacity: 0.5;"></div>
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $pegawai8200Count }}</h1>
                    <span class="text-dark text-center">Wilayah 2</span>
                </div>
                <div style="border-left: 1.5px solid rgba(92, 92, 92, 0.4); height: 70%;opacity: 0.5;"></div>
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $pegawai8300Count }}</h1>
                    <span class="text-dark text-center">Wilayah 3</span>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-2 col-lg">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-info"><i class="fa-solid fa-bullseye fas text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Jumlah Objek</h6>
                    </div>
                </div>
                <a href="/admin/master-unit-kerja" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="d-flex flex-row justify-content-around align-items-center" style="gap:5px">
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $unitKerjaCount }}</h1>
                    <span class="text-dark text-center">Unit Kerja</span>
                </div>
                <div style="border-left: 1.5px solid rgba(92, 92, 92, 0.4); height: 70%;opacity: 0.5;"></div>
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $satuanKerjaCount }}</h1>
                    <span class="text-dark text-center">Satuan Kerja</span>
                </div>
                <div style="border-left: 1.5px solid rgba(92, 92, 92, 0.4); height: 70%;opacity: 0.5;"></div>
                <div class="d-flex mt-3 align-items-center flex-column">
                    <h1 class="text-dark mx-3" style="font-size: 3em; font-weight: bold;">
                        {{ $wilayahKerjaCount }}</h1>
                    <span class="text-dark text-center">Wilayah</span>
                </div>
            </div>
        </div>

    </div>
    <div class="d-flex flex-row dashboard-card flex-wrap" style="gap:15px">
        @if ($timKerjaTotalCount != 0)
        <div class="card p-4 mb-2 col-lg">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon bg-warning"><i class="fas fa-people-group text-white"></i> </div>
                    <div class="ms-2 c-details mx-3">
                        <h6 class="mb-0 text-dark">Tim Kerja</h6>
                    </div>
                </div>
                <a href="/admin/rencana-kinerja" class="arrow-button-card" type="button" class="rounded-circle"><i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div style="width:100%" class="mt-3 d-flex">
                {{-- <h3 class="font-weight-normal text-dark h5">Surat Srikandi</h3> --}}
                @if ($timKerjaPercentagePenyusunan != 0)
                <div style="width:{{ $timKerjaPercentagePenyusunan }}%"
                    class="bg-danger text-white p-1 segmented-proggress rounded-bar">
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
                @if ($timKerjaDiterimaCount != 0)
                <div class="mx-2">
                    <h6 style="font-size: .9em;" class="font-weight-normal m-0 text-dark h5">Disetujui</h6>
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
        <div class="p-4 mb-2 col-lg"></div>
        <div class="p-4 mb-2 col-lg"></div>
    </div>
</div>
