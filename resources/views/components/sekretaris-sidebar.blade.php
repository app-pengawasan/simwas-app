<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('img/simwas-text.svg') }}" class="sidebar-brand" alt="brand" style="width: 120px">
            <span class="badge badge-primary">Sekretaris</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Sm</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('sekretaris') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('sekretaris-dashboard') }}">
                    <i class="fab fa-stumbleupon-circle"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('sekretaris/norma-hasil*') ? 'active' : '' }}">
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
            </li>
            {{-- <li class="{{ Request::is('sekretaris/surat-eksternal*') ? 'active' : '' }}">
                <a class="nav-link" href="sekretaris/surat-eksternal">
                    <i class="fas fa-file-export"></i>
                    <span>Surat Eksternal</span>
                </a>
            </li> --}}
        </ul>
    </aside>
</div>
