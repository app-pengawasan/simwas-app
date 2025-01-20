<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">PJ Kegiatan</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu" style="margin-bottom: 30px">
            <li class="nav-item dropdown {{ $type_menu === 'rencana-jam-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Rencana Jam Kerja</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('pjk/rencana-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pjk/rencana-jam-kerja/rekap">
                            <span>Rekap Jam Kerja</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pjk/rencana-jam-kerja/pool*') || Request::is('pjk/rencana-jam-kerja/detail*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pjk/rencana-jam-kerja/pool">
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
                    <li class="{{ Request::is('pjk/realisasi-jam-kerja/rekap')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pjk/realisasi-jam-kerja/rekap">
                            <span>Rekap Jam Kerja</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('pjk/realisasi-jam-kerja/pool*') || Request::is('pjk/realisasi-jam-kerja/detail*')  ? 'active' : '' }}">
                        <a class="nav-link" href="/pjk/realisasi-jam-kerja/pool">
                            <span>Pool Jam Kerja</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
