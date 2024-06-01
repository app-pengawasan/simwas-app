@if (!isset($type_menu))
<?php $type_menu = ''; ?>
@endif
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('analis-sdm.pp') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Analis SDM</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('analis-sdm.pp') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('analis-sdm') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('analis-sdm.dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'kompetensi' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-award"></i>
                    <span>Kompetensi Pegawai</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('analis-sdm/pp*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('analis-sdm.pp') }}">
                            <span>Master Kompetensi Pegawai</span>
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
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'data-kepegawaian' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fab fa-stumbleupon-circle"></i>
                    <span>Data Kepegawaian Lainnya</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('analis-sdm/master-data-kepegawaian*') ? 'active' : '' }}">
                        <a class="nav-link" href="/analis-sdm/master-data-kepegawaian">
                            <span>Master Data Kepegawaian</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('analis-sdm/data-kepegawaian') || Request::is('analis-sdm/data-kepegawaian/*') ? 'active' : '' }}">
                        <a class="nav-link" href="/analis-sdm/data-kepegawaian">
                            <span>Kelola Data Kepegawaian</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
