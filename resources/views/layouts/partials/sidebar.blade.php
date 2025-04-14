<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('provincias.index') }}" class="brand-link">
        <span class="brand-text font-weight-light">GestionCyE</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('provincias.index') }}" class="nav-link {{ request()->routeIs('provincias.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>Provincias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('zonas.index') }}" class="nav-link {{ request()->routeIs('zonas.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-vector-square"></i>
                        <p>Zonas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('localidades.index') }}" class="nav-link {{ request()->routeIs('localidades.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>Localidades</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>