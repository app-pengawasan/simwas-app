<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('analis-sdm-pp') }}">
                <img src="{{ asset('img/simwas-text.svg') }}" class="sidebar-brand" alt="brand" style="width: 120px">
            </a>
            <span class="badge badge-primary">Analis SDM</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('analis-sdm-pp') }}">
                <img src="{{ asset('img/simwas.svg') }}" alt="brand" style="width: 42px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('analis-sdm/pp*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('analis-sdm-pp') }}">
                    <i class="fab fa-stumbleupon-circle"></i>
                    <span>Master Pengembangan Profesi</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
