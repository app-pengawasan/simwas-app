@if (!isset($type_menu))
<?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('inspektur-dashboard') }}">
                <img src="{{ asset('img/simwas-text.svg') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Inspektur</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('inspektur-dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('inspektur') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('inspektur-dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('inspektur/st-kinerja*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/st-kinerja">
                    <i class="fas fa-wrench"></i>
                    <span>ST Kinerja</span>
                </a>
            </li>
            <li class="{{ Request::is('inspektur/st-pp*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/st-pp">
                    <i class="fas fa-briefcase"></i>
                    <span>ST Pengembangan Profesi</span>
                </a>
            </li>
            <li class="{{ Request::is('inspektur/st-pd*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/st-pd">
                    <i class="fas fa-road"></i>
                    <span>ST Perjalanan Dinas</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'rencana-jam-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-clock"></i>
                    <span>Rencana Jam Kerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li
                        class="{{ Request::is('inspektur/rencana-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/inspektur/rencana-jam-kerja/rekap">
                            <span>Rekap Hari Kerja</span>
                        </a>
                    </li>
                    <li
                    class="{{ Request::is('inspektur/rencana-jam-kerja/pool*') || Request::is('inspektur/rencana-kinerja*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/inspektur/rencana-jam-kerja/pool">
                            <span>Pool Jam Kerja</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
