<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin-dashboard') }}">Simwas</a>
            <span class="badge badge-primary">Admin</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin-dashboard') }}">Sm</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin-dashboard') }}">
                    <i class="fab fa-stumbleupon-circle"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'anggaran' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-money-bill"></i>
                    <span>Anggaran</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/master-anggaran') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('master-anggaran.index') }}">Master Anggaran</a>
                    </li>
                    <li
                        class="{{ Request::is('admin/pagu-anggaran') || Request::is('admin/pagu-anggaran/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pagu-anggaran.index') }}">Pagu Anggaran</a>
                    </li>
                </ul>
            </li>
            <li
                class="{{ Request::is('admin/master-pegawai/*') || Request::is('admin/master-pegawai') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/master-pegawai">
                    <i class="fas fa-users"></i>
                    <span>Master Pegawai</span>
                </a>
            </li>
            <li
                class="{{ Request::is('admin/master-pimpinan/*') || Request::is('admin/master-pimpinan') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/master-pimpinan">
                    <i class="fas fa-user-tie"></i>
                    <span>Kelola Pimpinan</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'objek' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-bullseye"></i>
                    <span>Master Objek</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/master-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-unit-kerja">Unit Kerja</a>
                    </li>
                    <li class="{{ Request::is('admin/master-satuan-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-satuan-kerja">Satuan Kerja</a>
                    </li>
                    <li class="{{ Request::is('admin/master-wilayah-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-wilayah-kerja">Wilayah</a>
                    </li>
                    <li class="{{ Request::is('admin/objek-kegiatan') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/objek-kegiatan">Kegiatan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-kinerja' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-clipboard"></i>
                    <span>Rencana Kinerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('layout-default-layout') }}">Dashboard Kinerja</a>
                    </li>
                    <li class="{{ Request::is('admin/master-tujuan') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-tujuan">Master Tujuan</a>
                    </li>
                    <li class="{{ Request::is('admin/master-sasaran') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-sasaran">Master Sasaran</a>
                    </li>
                    <li class="{{ Request::is('admin/master-iku') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-iku">Master IKU</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
