<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('perencana.dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Perencana</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('perencana.dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('perencana') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perencana.dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'iku-unit-kerja' ? 'active active-dropdown' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-solid fa-chart-pie"></i>
                    <span>IKU Unit Kerja</span>
                </a>
                <ul class="dropdown-menu">
                    {{-- Menu Untuk Pimpinan ['Inspektur Wilayah I,II, III', 'Kabag Umum'] --}}
                    <li
                        class="{{ Request::is('perencana/target-iku-unit-kerja/*') || Request::is('perencana/target-iku-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('perencana.target-iku-unit-kerja.index') }}">
                            <span>Target</span>
                            @if ($targetIkuUnitKerjaCount > 0)
                            <div class="bg-primary sidebar-count">
                                {{ $targetIkuUnitKerjaCount }}
                            </div>
                            @endif
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('perencana/realisasi-iku-unit-kerja/*') || Request::is('perencana/realisasi-iku-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('perencana.realisasi-iku-unit-kerja.index') }}">
                            <span>Realisasi</span>
                            @if ($realisasiIkuUnitKerjaCount > 0)
                            <div class="bg-primary sidebar-count">
                                {{ $realisasiIkuUnitKerjaCount }}
                            </div>
                            @endif
                        </a>
                    </li>
                    <li
                        class="{{ Request::is('perencana/evaluasi-iku-unit-kerja/*') || Request::is('perencana/evaluasi-iku-unit-kerja') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('perencana.evaluasi-iku-unit-kerja.index') }}">
                            <span>Evaluasi</span>
                            @if ($evaluasiIkuUnitKerjaCount > 0)
                            <div class="bg-primary sidebar-count">
                                {{ $evaluasiIkuUnitKerjaCount }}
                            </div>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @include('components.footer')
    </aside>
</div>
