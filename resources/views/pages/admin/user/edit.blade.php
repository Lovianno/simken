@extends('layouts.admin')

@section('title', 'Ubah Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ubah Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Ubah Pengguna</h5>
				<a href="{{ route('users.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Batal
				</a>
			</div>
			<div class="card-body">
				<form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
							<x-select-input id="status" name="status" label="Status" :options="[
								'active' => 'Aktif',
								'inactive' => 'Nonaktif',
							]" :selected="old('status', $user->status)" :searchable="false"
								required />
						</div>
					</div>

					{{-- KONFIRMASI PASSWORD --}}
					<div class="mb-3">
						<label for="password_confirmation" class="form-label">Konfirmasi Password <span
								class="text-muted">(Opsional)</span></label>
						<div class="input-group">
							<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
								id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru jika mengubah">
							<button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
								<i class="bi bi-eye-slash"></i>
							</button>
						</div>
						@error('password_confirmation')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- FOTO (TEACHER ONLY) --}}
					<div class="mb-3" id="photoForm" style="display:none;">
						<label for="profile_picture_file" class="form-label">Foto Profil <span class="text-danger">*</span></label>
						@php
							$name = old('name', $user->name ?? 'User');
							$defaultAvatar =
							    'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=000&size=300';
						@endphp
						<div class="text-center mb-3" id="old-photo-container"
							style="{{ !empty($user->teacher->profile_picture_path) ? '' : 'display:none;' }}">
							<img
								src="{{ !empty($user->teacher->profile_picture_path) ? asset('storage/' . $user->teacher->profile_picture_path) : $defaultAvatar }}"
								class="img-thumbnail rounded"
								style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
						</div>
						<div class="text-center mb-3" id="photo-preview-container" style="display:none;">
							<img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
								style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
						</div>
						<input type="file" class="form-control @error('profile_picture_file') is-invalid @enderror"
							id="profile_picture_file" name="profile_picture_file" accept="image/*">
						<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB. Ukuran pas foto: 3x4.</small>
						@error('profile_picture_file')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- BIO & EXPERTISE (TEACHER ONLY) --}}
					<div id="teacherFields" style="display:none;">
						<div class="mb-3">
							<label for="bio" class="form-label">Bio <span class="text-muted">(Opsional)</span></label>
							<textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="3"
							 placeholder="Tulis bio singkat...">{{ old('bio', $user->teacher->bio ?? '') }}</textarea>
							@error('bio')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="expertise" class="form-label">Keahlian <span class="text-muted">(Opsional)</span></label>
							<input type="text" name="expertise" id="expertise"
								class="form-control @error('expertise') is-invalid @enderror" placeholder="Contoh: Matematika, Fisika"
								value="{{ old('expertise', $user->teacher->expertise ?? '') }}">
							@error('expertise')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="d-flex justify-content-end mt-4">
						<button type="submit" class="btn btn-primary" id="submitUserBtn">
							<span class="button-content">
								Simpan
							</span>
							<span class="spinner-content d-none">
								<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
								Sedang Menyimpan...
							</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	@endsection

	@push('scripts')
		<script>
			// No photo/teacher JS needed for migration-aligned users

			const passwordInput = document.getElementById("password");
			const togglePassword = document.getElementById("togglePassword");

			togglePassword.addEventListener("click", function() {
				const type = passwordInput.type === "password" ? "text" : "password";
				passwordInput.type = type;
				this.querySelector("i").classList.toggle("bi-eye");
				this.querySelector("i").classList.toggle("bi-eye-slash");
			});

			const passwordConfirmInput = document.getElementById("password_confirmation");
			const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");

			togglePasswordConfirm.addEventListener("click", function() {
				const type = passwordConfirmInput.type === "password" ? "text" : "password";
				passwordConfirmInput.type = type;
				this.querySelector("i").classList.toggle("bi-eye");
				this.querySelector("i").classList.toggle("bi-eye-slash");
			});

			const userForm = document.querySelector('form[action="{{ route('users.update', $user) }}"]');
			const submitUserBtn = document.getElementById('submitUserBtn');
			if (userForm && submitUserBtn) {
				userForm.addEventListener('submit', function() {
					submitUserBtn.disabled = true;
					submitUserBtn.querySelector('.button-content').classList.add('d-none');
					submitUserBtn.querySelector('.spinner-content').classList.remove('d-none');
				});
			}
		</script>
	@endpush
