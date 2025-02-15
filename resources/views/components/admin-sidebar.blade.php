<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Admin</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu" style="margin-bottom: 30px">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'anggaran' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-money-bill"></i>
                    <span>Anggaran</span>
                </a>
                <ul class="dropdown-menu">
                    <li
                        class="{{ Request::is('admin/master-anggaran') || Request::is('admin/master-anggaran/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master-anggaran.index') }}">Master Anggaran</a>
                    </li>
                    <li
                        class="{{ Request::is('admin/pagu-anggaran') || Request::is('admin/pagu-anggaran/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.pagu-anggaran.index') }}">Pagu Anggaran</a>
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
            <li class="nav-item dropdown {{ $type_menu === 'objek' ? 'active active-dropdown' : '' }}">
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
            <li class="nav-item dropdown {{ $type_menu === 'master-arsip' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-folder-closed"></i>
                    <span>Master Arsip</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/master-kode-klasifikasi-arsip') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-kode-klasifikasi-arsip">Master KKA</a>
                    </li>
                    <li class="{{ Request::is('admin/master-laporan') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/master-laporan">Master Laporan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-kinerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-clipboard"></i>
                    <span>Rencana Kinerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/rencana-kinerja*') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/rencana-kinerja">
                            <span>Dashboard Kinerja</span>
                            @if ($timKerjaPenyusunanCount > 0)
                            <div class="bg-primary sidebar-count">
                                {{ $timKerjaPenyusunanCount }}
                            </div>
                            @endif
                        </a>
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
                    <li class="{{ Request::is('admin/master-unsur') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master-unsur.index') }}">Master Unsur</a>
                    </li>
                    <li class="{{ Request::is('admin/master-subunsur') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master-subunsur.index') }}">Master Subunsur</a>
                    </li>
                    <li class="{{ Request::is('admin/master-hasil-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master-hasil-kerja.index') }}">Master Hasil Kerja</a>
                    </li>
                    <li class="{{ Request::is('admin/master-kinerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master-kinerja.index') }}">Master Kinerja</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-jam-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Rencana Jam Kerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/rencana-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/rencana-jam-kerja/rekap">
                            <span>Rekap Jam Kerja</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('admin/rencana-jam-kerja/pool*') || Request::is('admin/rencana-jam-kerja/detail*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/rencana-jam-kerja/pool">
                            <span>Pool Jam Kerja</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'realisasi-jam-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-clock"></i>
                    <span>Realisasi Jam Kerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/realisasi-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/realisasi-jam-kerja/rekap">
                            <span>Rekap Jam Kerja</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('admin/realisasi-jam-kerja/pool*') || Request::is('admin/realisasi-jam-kerja/detail*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/realisasi-jam-kerja/pool">
                            <span>Pool Jam Kerja</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li
                class="{{ Request::is('admin/rekap-nilai/*') || Request::is('admin/rekap-nilai') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/rekap-nilai">
                    <i class="fas fa-square-poll-vertical"></i>
                    <span>Rekap Nilai Kinerja Pegawai</span>
                </a>
            </li>
            <li
                class="{{ Request::is('admin/kinerja-tim/*') || Request::is('admin/kinerja-tim') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/kinerja-tim">
                    <i class="fas fa-people-group"></i>
                    <span>Kinerja Tim</span>
                </a>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
