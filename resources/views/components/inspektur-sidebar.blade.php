@if (!isset($type_menu))
<?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('inspektur.dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Inspektur</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('inspektur.dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('inspektur') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('inspektur.dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('inspektur/penilaian-kinerja*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/penilaian-kinerja">
                    <i class="fas fa-marker"></i>
                    <span>Penilaian Kinerja Pegawai</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-jam-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Rencana Jam Kerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('inspektur/rencana-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/inspektur/rencana-jam-kerja/rekap">
                            <span>Rekap Jam Kerja</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('inspektur/rencana-jam-kerja/pool*') || Request::is('inspektur/rencana-jam-kerja/detail*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/inspektur/rencana-jam-kerja/pool">
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
                    <li class="{{ Request::is('inspektur/realisasi-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/inspektur/realisasi-jam-kerja/rekap">
                            <span>Rekap Jam Kerja</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('inspektur/realisasi-jam-kerja/pool*') || Request::is('inspektur/realisasi-jam-kerja/detail*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/inspektur/realisasi-jam-kerja/pool">
                            <span>Pool Jam Kerja</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li
                class="{{ Request::is('inspektur/rencana-kinerja*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/rencana-kinerja">
                    <i class="fas fa-clipboard"></i>
                    <span>Rencana Kinerja</span>
                </a>
            </li>
            <li
                class="{{ Request::is('inspektur/mph*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/mph">
                    <i class="fas fa-user-gear"></i>
                    <span>Matriks Peran Hasil</span>
                </a>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
