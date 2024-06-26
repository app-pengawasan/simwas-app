@if (!isset($type_menu))
<?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('pegawai.dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('pegawai.dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu" style="margin-bottom: 30px">
            <li class="{{ Request::is('pegawai/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pegawai.dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            {{-- Rencana Kinerja --}}
            <li class="menu-header">Kelola Kinerja</li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-kinerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-pencil-ruler"></i>
                    <span>Rencana Kinerja</span>
                </a>
                <ul class="dropdown-menu">
                    @if ($timKerjaAll > 0)
                    <li
                        class="{{ Request::is('ketua-tim/rencana-kinerja') || Request::is('ketua-tim/rencana-kinerja/*') || Request::is('ketua-tim/tim-pelaksana/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/ketua-tim/rencana-kinerja">
                            <span>PJ Kegiatan</span>
                            @if ($timKerjaPenyusunanCountSidebar > 0)
                            <div class="bg-primary sidebar-count">
                                {{ $timKerjaPenyusunanCountSidebar }}
                            </div>
                            @endif
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('ketua-tim/norma-hasil') || Request::is('ketua-tim/norma-hasil/*') || Request::is('ketua-tim/norma-hasil/*') ? 'active' : '' }} d-flex justify-content-between">
                        <a class="nav-link" href="/ketua-tim/norma-hasil"
                            style="display: flex; align-items: center; text-decoration: none;">
                            <span style="margin-right: 10px;">Usulan Norma Hasil</span>
                            @if ($usulanNormaHasilCountSidebar > 0)
                            <div class="bg-primary sidebar-count">
                                {{ $usulanNormaHasilCountSidebar }}
                            </div>
                            @endif
                        </a>
                    </li>
                    @endif
                    <li
                        class="{{ Request::is('pegawai/rencana-kinerja') || Request::is('pegawai/rencana-kinerja/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/rencana-kinerja">Tugas Saya</a>
                    </li>
                    <li class="{{ Request::is('pegawai/rencana-jam-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/rencana-jam-kerja">Jam Kerja</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'realisasi-kinerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-file-signature"></i>
                    <span>Realisasi Kinerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li
                        class="{{ Request::is('pegawai/realisasi') || Request::is('pegawai/realisasi/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/realisasi">
                            <span>Isi Realisasi</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pegawai/aktivitas-harian') || Request::is('pegawai/aktivitas-harian/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/aktivitas-harian">
                            <span>Aktivitas Harian</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pegawai/nilai-berjenjang') || Request::is('pegawai/nilai-berjenjang/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/nilai-berjenjang">
                            <span>Nilai Hasil Kerja</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'tugas-tim' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-people-group"></i>
                    <span>Tugas Tim</span>
                </a>
                <ul class="dropdown-menu">
                    <li
                        class="{{ Request::is('pegawai/tim/surat-tugas') || Request::is('pegawai/tim/surat-tugas/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/tim/surat-tugas">
                            <span>Surat Tugas</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pegawai/tim/norma-hasil') || Request::is('pegawai/tim/norma-hasil/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/tim/norma-hasil">
                            <span>Norma Hasil</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pegawai/tim/kendali-mutu') || Request::is('pegawai/tim/kendali-mutu/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/tim/kendali-mutu">
                            <span>Kendali Mutu</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ Request::is('pegawai/laporan-kinerja*') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/laporan-kinerja">
                    <i class="fas fa-square-poll-vertical"></i>
                    <span>Laporan Kinerja</span>
                </a>
            </li>
            <li class="menu-header">Pengelolaan Arsip</li>
            {{-- <li class="{{ Request::is('pegawai/usulan-surat-srikandi*') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/usulan-surat-srikandi">
                    <i class="fas fa-solid fa-envelope"></i>
                    <span>Usulan Surat</span>
                </a>
            </li> --}}
            <li class="nav-item dropdown {{ $type_menu === 'usulan-surat' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-solid fa-envelope"></i>
                    <span>Usulan Surat</span>
                </a>
                <ul class="dropdown-menu">
                    <li
                        class="{{ Request::is('pegawai/usulan-surat/surat-tugas*') || Request::is('pegawai/usulan-surat/surat-tugas/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/usulan-surat/surat-tugas">
                            <span>Surat Tugas</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pegawai/usulan-surat/surat-korespondensi') || Request::is('pegawai/usulan-surat/surat-korespondensi/*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pegawai/usulan-surat/surat-korespondensi">
                            <span>Surat Korespondensi</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/norma-hasil">
                    <i class="fas fa-check"></i>
                    <span>Norma Hasil</span>
                </a>
            </li>
            <li class="menu-header">Pengembangan Kompetensi</li>
            <li class="{{ Request::is('pegawai/kompetensi*') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/kompetensi">
                    <i class="fas fa-award"></i>
                    <span>Kelola Kompetensi</span>
                </a>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
