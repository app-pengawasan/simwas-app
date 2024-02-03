@if (!isset($type_menu))
<?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('analis-sdm-pp') }}">
                <img src="{{ asset('img/simwas-text.svg') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Analis SDM</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('analis-sdm-pp') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown {{ $type_menu === 'kompetensi' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fab fa-stumbleupon-circle"></i>
                    <span>Kompetensi Pegawai</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('analis-sdm/pp*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('analis-sdm-pp') }}">
                            <span>Master Pengembangan Profesi</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('analis-sdm/kelola-kompetensi') || Request::is('analis-sdm/kelola-kompetensi/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/analis-sdm/kelola-kompetensi">
                            <span>Kelola Kompetensi</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
