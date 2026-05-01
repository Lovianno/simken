<div class="app-overlay"></div>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo">
		<a href="{{ route('admin.dashboard') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
			<span class="app-brand-logo demo">
				<img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" alt="Logo"
					style="height: 32px; width: auto; object-fit: contain;" alt="Logo">
			</span>
			<span class="app-brand-text demo menu-text fw-bolder ms-2 fs-5"
				style="text-transform: none">{{ config('app.name') }}</span>
		</a>

		<a href="#" class="layout-menu-toggle menu-link text-large ms-auto d-none d-xl-none" data-bs-toggle="sidebar"
			data-target="#layout-menu" data-overlay="true">
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
		<ul class="menu-inner py-1 flex-grow-1">
			<!-- Dashboard -->
			<li class="menu-item {{ request()->is(ltrim('admin/dashboard', '/')) ? 'active' : '' }}">
				<a href="{{ route('admin.dashboard') }}" class="menu-link text-decoration-none">
					<i class="menu-icon tf-icons bi bi-speedometer2"></i>
					<div>Dashboard</div>
				</a>
			</li>
			<li class="menu-item {{ request()->is(ltrim('home', '/')) ? 'active' : '' }}">
				<a href="{{ route('beranda') }}" class="menu-link text-decoration-none">
					<i class="menu-icon tf-icons bx bx-home-circle"></i>
					<div>Halaman Utama</div>
				</a>
			</li>

			<!-- Master Data -->
			<li class="menu-header small text-uppercase">
				<span class="menu-header-text">Master Data</span>
			</li>

			<li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
				<a href="{{ route('admin.users.index') }}" class="menu-link text-decoration-none">
					<i class="menu-icon tf-icons bx bx-user"></i>
					<div>Data Pengguna</div>
				</a>
			</li>

			<li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
				<a href="{{ route('admin.categories.index') }}" class="menu-link text-decoration-none">
					<i class="menu-icon tf-icons bi bi-bookmark"></i>
					<div>Data Kategori</div>
				</a>
			</li>

			<!-- Master Data -->
			<li class="menu-header small text-uppercase">
				<span class="menu-header-text">Pendataan</span>
			</li>

			<li class="menu-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
				<a href="{{ route('admin.courses.index') }}" class="menu-link text-decoration-none">
					<i class="menu-icon tf-icons bx bx-book-content"></i>
					<div>Data Kursus</div>
				</a>
			</li>
			<li class="menu-item {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
				<a href="{{ route('admin.transactions.index') }}" class="menu-link text-decoration-none">
					<i class="menu-icon tf-icons bi bi-credit-card"></i>
					<div>Data Transaksi</div>
				</a>
			</li>
		</ul>
	</div>

</aside>
