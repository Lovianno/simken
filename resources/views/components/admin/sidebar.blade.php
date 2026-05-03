<div class="app-overlay"></div>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" alt="Logo"
                    style="height: 32px; width: auto; object-fit: contain;">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2 fs-5"
                style="text-transform: none">{{ config('app.name') }}</span>
        </a>

        <a href="#" class="layout-menu-toggle menu-link text-large ms-auto d-none d-xl-none"
            data-bs-toggle="sidebar" data-target="#layout-menu" data-overlay="true">
        </a>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var overlay = document.querySelector('.app-overlay');
                var closeBtn = document.querySelector('.layout-menu-toggle[data-bs-toggle="sidebar"]');
                if (overlay && closeBtn) {
                    overlay.addEventListener('click', function() {
                        closeBtn.click();
                    });
                }
            });
        </script>
    </div>

    <div class="menu-inner">
        <ul class="menu-inner py-1 grow">

            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-speedometer2"></i>
                    <div>Dashboard</div>
                </a>
            </li>

            <!-- Master Data -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Master Data</span>
            </li>

            <!-- User -->
            <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-people"></i>
                    <div>Data Pengguna</div>
                </a>
            </li>
              <!-- Kendaraan -->
            <li class="menu-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                <a href="{{ route('vehicles.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-car-front"></i>
                    <div>Data Kendaraan</div>
                </a>
            </li>
            <!-- Onderdil -->
            <li class="menu-item {{ request()->routeIs('parts.*') ? 'active' : '' }}">
                <a href="{{ route('parts.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-wrench"></i>
                    <div>Data Suku Cadang</div>
                </a>
            </li>

              <!-- Master Data -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>
            <!-- Perbaikan Kendaraan -->
            <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-tools"></i>
                    <div>Perbaikan Kendaraan</div>
                </a>
            </li>
          

        </ul>
    </div>
</aside>