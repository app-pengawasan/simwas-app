@if (!isset($type_menu))
<?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('pegawai/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
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
                    {{-- Menu Untuk Pimpinan ['Inspektur Wilayah I,II, III', 'Kabag Umum'] --}}
                    @if (in_array(auth()->user()->jabatan, [11, 12, 13, 14]))
                    <li
                        class="{{ Request::is('pimpinan/rencana-kinerja') || Request::is('pimpinan/rencana-kinerja/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/pimpinan/rencana-kinerja">
                            <span>Persetujuan</span>
                        </a>
                    </li>
                    @endif
                    <li
                        class="{{ Request::is('ketua-tim/rencana-kinerja') || Request::is('ketua-tim/rencana-kinerja/*') || Request::is('ketua-tim/tim-pelaksana/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/ketua-tim/rencana-kinerja">
                            <span>Ketua Tim</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('ketua-tim/norma-hasil') || Request::is('ketua-tim/norma-hasil/*') || Request::is('ketua-tim/norma-hasil/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/ketua-tim/norma-hasil">
                            <span>Usulan Norma Hasil</span>
                        </a>
                    </li>
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
                    <i class="fas fa-file-signature"></i>
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
        {{-- <li class="{{ Request::is('pegawai/kinerja-pegawai') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-file-signature"></i>
            <span>Realisasi Kinerja</span>
        </a>
        </li> --}}
        {{-- Pengelolaan Dokumen --}}
            <li class="menu-header">Pengelolaan Dokumen</li>
        {{-- <li class="nav-item dropdown {{ Request::is('pegawai/st-kinerja*') || Request::is('pegawai/st-pp*') || Request::is('pegawai/st-pd*') || Request::is('pegawai/surat-lain*') || Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i> <span>Surat
                Saya</span></a>
        <ul class="dropdown-menu">
            <li class="{{ Request::is('pegawai/st-kinerja*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('st-kinerja.index') }}">ST Kinerja</a>
            </li>
            <li class="{{ Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('norma-hasil.index') }}">Norma Hasil</a>
            </li>
            <li class="{{ Request::is('pegawai/st-pp*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('st-pp.index') }}">ST Pengembangan Profesi</a>
            </li>
            <li class="{{ Request::is('pegawai/st-pd*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('st-pd.index') }}">ST Perjalanan Dinas</a>
            </li>
            <li class="{{ Request::is('pegawai/surat-lain*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('surat-lain.index') }}">Surat Lain</a>
            </li>
        </ul>
        </li> --}}
        {{-- <li class="{{ Request::is('pegawai/st-kinerja*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('st-kinerja.index') }}">
            <i class="fas fa-wrench"></i>
            <span>ST Kinerja</span>
        </a>
        </li> --}}
            <li class="{{ Request::is('pegawai/usulan-surat-srikandi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('usulan-surat-srikandi.index') }}">
                    <i class="fas fa-solid fa-envelope"></i>
                    <span>Usulan Surat</span>
                </a>
            </li>
            <li class="{{ Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/norma-hasil">
                    <i class="fas fa-check"></i>
                    <span>Norma Hasil</span>
                </a>
            </li>
        {{-- <li class="{{ Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('norma-hasil.index') }}">
            <i class="fas fa-check"></i>
            <span>Norma Hasil</span>
        </a>
        </li>
        <li class="{{ Request::is('pegawai/st-pp*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('st-pp.index') }}">
                <i class="fas fa-briefcase"></i>
                <span>ST Pengembangan Profesi</span>
            </a>
        </li>
        <li class="{{ Request::is('pegawai/st-pd*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('st-pd.index') }}">
                <i class="fas fa-road"></i>
                <span>ST Perjalanan Dinas</span>
            </a>
        </li>
        <li class="{{ Request::is('pegawai/surat-lain*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('surat-lain.index') }}">
                <i class="fas fa-file"></i>
                <span>Surat Lain</span>
            </a>
        </li> --}}
        {{-- <li class="{{ Request::is('pegawai/kirim-dokumen*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kirim-dokumen.index') }}">
            <i class="fas fa-paper-plane"></i>
            <span>Kirim Dokumen</span>
        </a>
        </li>
        <li class="{{ Request::is('pegawai/surat-eksternal*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('surat-eksternal.index') }}">
                <i class="fas fa-file-export"></i>
                <span>Surat Eksternal</span>
            </a>
        </li> --}}
            <li class="menu-header">Kelola Kompetensi</li>
            <li class="{{ Request::is('pegawai/kompetensi*') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/kompetensi">
                    <i class="fas fa-file"></i>
                    <span>Pengembangan Kompetensi</span>
                </a>
            </li>
        </ul>
        @include('components.footer')
        {{-- <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="/dashboard-general-dashboard" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Dashboard Lama
            </a>
        </div> --}}
    </aside>
</div>
