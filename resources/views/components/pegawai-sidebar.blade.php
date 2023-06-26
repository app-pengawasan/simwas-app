@if (!isset($type_menu))
    <?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Simwas</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Sm</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('pegawai/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fab fa-stumbleupon-circle"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            {{-- Rencana Kinerja --}}
            <li class="menu-header">Kelola Kinerja</li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-kinerja' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-pencil-ruler"></i>
                    <span>Rencana Kinerja</span>
                </a>
                <ul class="dropdown-menu">
                    {{-- Menu Untuk Pimpinan ['Inspektur Wilayah I,II, II', 'Kabag Umum'] --}}
                    @if (in_array(auth()->user()->jabatan, [11, 12, 13, 14]))
                        <li
                            class="{{ Request::is('pimpinan/rencana-kinerja') || Request::is('pimpinan/rencana-kinerja/*') ? 'active' : '' }}">
                            <a class="nav-link" href="/pimpinan/rencana-kinerja">
                                <span>Persetujuan</span>
                            </a>
                        </li>
                    @endif
                    <li class="{{ Request::is('ketua-tim/rencana-kinerja') ? 'active' : '' }}">
                        <a class="nav-link" href="/ketua-tim/rencana-kinerja">
                            <span>Ketua Tim</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('admin/pagu-anggaran') || Request::is('admin/pagu-anggaran/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pagu-anggaran.index') }}">Anggota Tim</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('pegawai/kinerja-pegawai') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-file-signature"></i>
                    <span>Realisasi Kinerja</span>
                </a>
            </li>
            {{-- Pengelolaan Dokumen --}}
            <li class="menu-header">Pengelolaan Dokumen</li>
            <li
                class="nav-item dropdown {{ Request::is('pegawai/st-kinerja*') || Request::is('pegawai/st-pp*') || Request::is('pegawai/st-pd*') || Request::is('pegawai/surat-lain*') || Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i>
                    <span>Surat Saya</span></a>
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
            </li>
            <li class="{{ Request::is('pegawai/kirim-dokumen*') ? 'active' : '' }}">
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
            </li>
        </ul>
    </aside>
</div>
