<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('arsiparis-dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Arsiparis</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('arsiparis-dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('arsiparis') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('arsiparis-dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('arsiparis/surat-tugas*') ? 'active' : '' }}">
                <a class="nav-link" href="/arsiparis/surat-tugas">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Surat Tugas</span>
                </a>
            </li>
            <li class="{{ Request::is('arsiparis/norma-hasil*') ? 'active' : '' }}">
                <a class="nav-link" href="/arsiparis/norma-hasil">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Norma Hasil</span>
                </a>
            </li>
            <li class="{{ Request::is('arsiparis/kendali-mutu*') ? 'active' : '' }}">
                <a class="nav-link" href="/arsiparis/kendali-mutu">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Kendali Mutu</span>
                </a>
            </li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'iku-unit-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-solid fa-chart-pie"></i>
                    <span>IKU Unit Kerja</span>
                </a>
                <ul class="dropdown-menu"> --}}
                    {{-- Menu Untuk Pimpinan ['Inspektur Wilayah I,II, III', 'Kabag Umum'] --}}
                    {{-- <li class="{{ Request::is('perencana/target-iku-unit-kerja/*') || Request::is('perencana/target-iku-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('target-iku-unit-kerja.index') }}">
                            <span>Target</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('perencana/realisasi-iku-unit-kerja/*') || Request::is('perencana/realisasi-iku-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('realisasi-iku-unit-kerja.index') }}">
                            <span>Realisasi</span>
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('perencana/evaluasi-iku-unit-kerja/*') || Request::is('perencana/evaluasi-iku-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('evaluasi-iku-unit-kerja.index') }}">
                            <span>Evaluasi</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
        </ul>
        @include('components.footer')
    </aside>
</div>
