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
            <li class="menu-header">Kinerja Pegawai</li>
            <li class="{{ Request::is('pegawai/rencana-kinerja') ? 'active' : '' }}">
                <a class="nav-link" href="/pegawai/rencana-kinerja">
                    <i class="fas fa-pencil-ruler"></i>
                    <span>Rencana Kinerja</span>
                </a>
            </li>
            <li class="{{ Request::is('pegawai/kinerja-pegawai') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-file-signature"></i>
                    <span>Realisasi Kinerja</span>
                </a>
            </li>
            {{-- Pengelolaan Dokumen --}}
            <li class="menu-header">Pengelolaan Dokumen</li>
            <li class="nav-item dropdown {{ Request::is('pegawai/st-kinerja*') || Request::is('pegawai/st-pp*') || Request::is('pegawai/st-pd*') || Request::is('pegawai/surat-lain*') || Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-file"></i> <span>Surat Saya</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('pegawai/st-kinerja*') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('st-kinerja.index') }}">ST Kinerja</a>
                    </li>
                    <li class="{{ Request::is('pegawai/norma-hasil*') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('norma-hasil.index') }}">Norma Hasil</a>
                    </li>
                    <li class="{{ Request::is('pegawai/st-pp*') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('st-pp.index') }}">ST Pengembangan Profesi</a>
                    </li>
                    <li class="{{ Request::is('pegawai/st-pd*') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('st-pd.index') }}">ST Perjalanan Dinas</a>
                    </li>
                    <li class="{{ Request::is('pegawai/surat-lain*') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('surat-lain.index') }}">Surat Lain</a>
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

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="/dashboard-general-dashboard" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Dashboard Lama
            </a>
        </div>
    </aside>
</div>
