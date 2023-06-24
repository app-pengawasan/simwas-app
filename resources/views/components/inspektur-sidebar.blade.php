<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Simwas</a>
            <span class="badge badge-primary">Inspektur</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Sm</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('inspektur') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('inspektur-dashboard') }}">
                    <i class="fab fa-stumbleupon-circle"></i>
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
                    <i class="fas fa-file"></i>
                    <span>ST Pengembangan Profesi</span>
                </a>
            </li>
            <li class="{{ Request::is('inspektur/st-pd*') ? 'active' : '' }}">
                <a class="nav-link" href="/inspektur/st-pd">
                    <i class="fas fa-road"></i>
                    <span>ST Perjalanan Dinas</span>
                </a>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
