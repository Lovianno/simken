@extends('layouts.auth')

@section('title', 'Login')

@section('content')
	<div class="d-flex justify-content-center align-items-center" style="width: 70%; min-height:100vh;">
		<div class="col-12 col-sm-10 col-md-7 col-lg-5">
			<div class="border-0 rounded-4 p-4">
				<div class="text-center mb-4">
					<a href="{{ route('beranda') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
						<img src="{{ asset('assets/img/logo/Circle Logo Simpul.png') }}" alt="Logo" width="48"
							class="rounded-circle shadow-sm border">
						<span class="fw-bold text-app-primary fs-4" style="letter-spacing:2px;">SIMKEN</span>
					</a>
				</div>
				<form id="formAuthentication" method="POST" action="{{ route('login') }}" class="mb-3">
					@csrf
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
							placeholder="Masukkan email anda" value="{{ old('email') }}" required autofocus />
						@error('email')
							<div class="text-danger mt-1 small">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<div class="d-flex align-items-center" style="position:relative;">
							<input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
								placeholder="Masukkan password anda" required />
							<button type="button" tabindex="-1" class="toggle-password btn btn-link px-2" data-target="password"
								style="color:#6b7280; position:absolute; right:0; top:50%; transform:translateY(-50%);"><i
									class="bi bi-eye-slash"></i></button>
						</div>
						@error('password')
							<div class="text-danger mt-1 small">{{ $message }}</div>
						@enderror
					</div>
					<div class="d-flex align-items-center justify-content-between mb-3">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="remember" name="remember">
							<label class="form-check-label" for="remember">
								Ingat saya
							</label>
						</div>
					</div>
					<div class="mb-3">
						<button class="btn btn-app-primary d-grid w-100" type="submit">Masuk</button>
					</div>
					<div class="mt-4">
						Belum punya akun? <a href="{{ route('register.student.index') }}"
							class="text-app-primary link-underline-hover">Daftar
							gratis sekarang</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		document.querySelectorAll('.toggle-password').forEach(btn => {
			btn.addEventListener('click', function() {
				const target = document.getElementById(this.dataset.target);
				if (target.type === "password") {
					target.type = "text";
					this.innerHTML = `<i class='bi bi-eye'></i>`;
				} else {
					target.type = "password";
					this.innerHTML = `<i class='bi bi-eye-slash'></i>`;
				}
			});
		});
	</script>
@endsection
