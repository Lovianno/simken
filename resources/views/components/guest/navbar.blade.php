<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top shadow-sm">
	<div class="container py-2">
		<a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-decoration-none text-app-primary" href="{{ route('login') }}">
			<img src="{{ asset('assets/img/logo/Circle Logo Simpul.png') }}" alt="SIMKEN" width="36" height="36" class="rounded-circle border">
			<span>SIMKEN</span>
		</a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNavbar"
			aria-controls="guestNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="guestNavbar">
			<ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
				@auth
					<li class="nav-item">
						<a class="btn btn-app-primary px-3" href="{{ route('welcome') }}">Masuk dashboard</a>
					</li>
				@else
					<li class="nav-item">
						<a class="btn btn-app-primary px-3" href="{{ route('login') }}">Login</a>
					</li>
				@endauth
			</ul>
		</div>
	</div>
</nav>