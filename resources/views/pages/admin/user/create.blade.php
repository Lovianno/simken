@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Tambah Pengguna</h5>

				<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left me-2"></i> Batal
				</a>
			</div>

			<div class="card-body">
				<form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
					@csrf

					{{-- ROLE & STATUS --}}
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="role" class="form-label">Peran <span class="text-danger">*</span></label>
							<x-select-input id="role" name="role" label="Peran" :options="[
							    'teacher' => 'Teacher',
							    'student' => 'Student',
							    'admin' => 'Admin',
							]" :selected="old('role', 'student')" :searchable="false"
								required />
						</div>

						<div class="col-md-6 mb-3">
							<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
							<x-select-input id="status" name="status" label="Status" :options="[
							    'active' => 'Aktif',
							    'inactive' => 'Nonaktif',
							    'pending' => 'Pending',
							    'rejected' => 'Ditolak',
							]" :selected="old('status', 'active')" :searchable="false"
								required />
						</div>
					</div>

					{{-- NAMA --}}
					<div class="mb-3">
						<label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
						<input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap"
							value="{{ old('name') }}">
						@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- EMAIL --}}
					<div class="mb-3">
						<label for="email" class="form-label">Email <span class="text-danger">*</span></label>
						<input type="email" name="email" class="form-control" required placeholder="Masukkan email"
							value="{{ old('email') }}">
						@error('email')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- NOMOR TELEPON --}}
					<div class="mb-3">
						<label for="phone_number" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
						<input type="text" name="phone_number" class="form-control" required placeholder="Masukkan nomor telepon"
							value="{{ old('phone_number') }}">
						@error('phone_number')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- PASSWORD --}}
					<div class="mb-3">
						<label for="password" class="form-label">Password <span class="text-danger">*</span></label>
						<div class="input-group">
							<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
								required placeholder="Masukkan password minimal 8 karakter dengan huruf besar, huruf kecil, dan angka">
							<button type="button" class="btn password-toggle-btn" id="togglePassword">
								<i class="bi bi-eye-slash"></i>
							</button>
						</div>
						@error('password')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- KONFIRMASI PASSWORD --}}
					<div class="mb-3">
						<label for="password_confirmation" class="form-label">Konfirmasi Password <span
								class="text-danger">*</span></label>
						<div class="input-group">
							<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
								id="password_confirmation" name="password_confirmation" required placeholder="Masukkan ulang password">
							<button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
								<i class="bi bi-eye-slash"></i>
							</button>
						</div>
						@error('password_confirmation')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- FOTO PROFIL (TEACHER ONLY) --}}
					<div class="mb-3" id="photoForm" style="display:none;">
						<label for="profile_picture_file" class="form-label">Foto Profil <span class="text-danger">*</span></label>
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
							 placeholder="Tulis bio singkat...">{{ old('bio') }}</textarea>
							@error('bio')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="expertise" class="form-label">Keahlian <span class="text-muted">(Opsional)</span></label>
							<input type="text" name="expertise" id="expertise"
								class="form-control @error('expertise') is-invalid @enderror" placeholder="Contoh: Matematika, Fisika"
								value="{{ old('expertise') }}">
							@error('expertise')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					{{-- SUBMIT BUTTON --}}
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
	</div>
@endsection

@push('scripts')
	<script>
		const photoInput = document.getElementById('profile_picture_file');
		const previewContainer = document.getElementById('photo-preview-container');
		const previewImage = document.getElementById('photo-preview');
		const photoForm = document.getElementById('photoForm');
		const roleSelect = document.getElementById('role');

		// Show/hide photoForm and teacherFields based on role selection
		const teacherFields = document.getElementById('teacherFields');

		function toggleTeacherFields() {
			if (roleSelect.value === 'teacher') {
				photoForm.style.display = 'block';
				teacherFields.style.display = 'block';
				photoInput.required = true;
			} else {
				photoForm.style.display = 'none';
				teacherFields.style.display = 'none';
				photoInput.required = false;
				photoInput.value = '';
				previewContainer.style.display = 'none';
			}
		}
		// Initial check on page load
		toggleTeacherFields();
		// Listen for changes
		roleSelect.addEventListener('change', toggleTeacherFields);

		photoInput.addEventListener('change', function(event) {
			const file = event.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					previewImage.src = e.target.result;
					previewContainer.style.display = 'block';
				};
				reader.readAsDataURL(file);
			} else {
				previewContainer.style.display = 'none';
			}
		});

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

		// Spinner on submit
		const userForm = document.querySelector('form[action="{{ route('admin.users.store') }}"]');
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
