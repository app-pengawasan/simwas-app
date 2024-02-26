<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('sekretaris-dashboard') }}">
                <img src="{{ asset('img/simwas-text.png') }}" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Sekretaris</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('sekretaris-dashboard') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('sekretaris') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('sekretaris-dashboard') }}">
                    <i class="fab fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('sekretaris/surat-srikandi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('surat-srikandi.index') }}">
                    <i class="fab fa-regular fa-folder-open"></i>
                    <span>Surat Srikandi</span>
                </a>
            </li>
            <li class="{{ Request::is('sekretaris/arsip-surat*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('surat-srikandi.arsip') }}">
                    <i class="fas fa-solid fa-box-archive"></i>
                    <span>Arsip Surat</span>
                </a>
            </li>
            {{-- <li class="{{ Request::is('sekretaris/norma-hasil*') ? 'active' : '' }}">
            <a class="nav-link" href="/sekretaris/norma-hasil">
                <i class="fas fa-check"></i>
                <span>Norma Hasil</span>
            </a>
            </li>
            <li class="{{ Request::is('sekretaris/usulan-surat*') ? 'active' : '' }}">
                <a class="nav-link" href="/sekretaris/usulan-surat">
                    <i class="fas fa-file"></i>
                    <span>Usulan Surat</span>
                </a>
            </li> --}}
            {{-- <li class="{{ Request::is('sekretaris/surat-eksternal*') ? 'active' : '' }}">
            <a class="nav-link" href="sekretaris/surat-eksternal">
                <i class="fas fa-file-export"></i>
                <span>Surat Eksternal</span>
            </a>
            </li> --}}
        </ul>
        @include('components.footer')
    </aside>
</div>
