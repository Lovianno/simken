@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
	<section class="bg-app-primary text-white py-5 py-lg-6 mb-0">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8">
					<span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
						Pengaturan Akun
					</span>
					<h1 class="fw-extrabold display-5 mb-3 lh-sm text-white">
						Pengaturan Akun
					</h1>
					<p class="fs-5 opacity-75 mb-0">
						Kelola data akun dan password Anda di bawah ini.
					</p>
				</div>
			</div>
		</div>
	</section>
	<section class="py-5 bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-7">
					<div class="d-flex gap-3 mb-4 justify-content-center">
						<button class="settings-nav-btn active" data-target="#settings-akun" type="button">
							<i class="bi bi-person-circle me-2"></i> Akun
						</button>
						<button class="settings-nav-btn" data-target="#settings-password" type="button">
							<i class="bi bi-lock me-2"></i> Password
						</button>
					</div>
					<div class="settings-content bg-white rounded-4 p-4">
						<div id="settings-akun" class="settings-pane">
							<form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" autocomplete="off">
								@csrf
								@method('PUT')
								@if (auth()->user()->role === 'teacher')
									<div class="d-flex flex-column align-items-center gap-3 mb-4">
										<div id="profile-drop-area" class="drop-area mb-2 position-relative"
											style="width: 220px; aspect-ratio: 3/4; border-radius: 1rem; overflow: hidden; background: #f3f4f6; cursor:pointer;">
											<div id="profile-drop-content"
												class="drop-content h-100 d-flex flex-column align-items-center justify-content-center">
												<div id="profile-drop-text" class="text-app-primary fw-semibold text-center">
													Seret & lepas foto di sini<br><span class="fw-normal text-app-gray">atau klik untuk memilih</span>
												</div>
											</div>
											<div id="profile-preview-wrapper" class="preview-wrapper position-absolute top-0 start-0 w-100 h-100"
												style="display:none;">
												<img id="photoPreview"
													src="{{ auth()->user()->teacher?->profile_picture_path ? asset('storage/' . auth()->user()->teacher->profile_picture_path) : asset('assets/img/default-profile.png') }}"
													alt="Foto Profil" class="w-100 object-fit-cover rounded-3" style="height: calc(100% + 24px)">
												<button type="button" id="profile-remove-btn"
													class="btn btn-sm btn-light preview-remove position-absolute end-0 m-2" style="top: -5px;"
													aria-label="Hapus foto">&times;</button>
											</div>
										</div>
										<input type="file" class="form-control d-none @error('profile_picture_file') is-invalid @enderror"
											id="profile_picture_file" name="profile_picture_file" accept="image/*">
										<small class="text-app-gray">Format: jpg, png, jpeg. Maksimal: 2MB. Ukuran pas foto: 3x4.</small>
										@error('profile_picture_file')
											<div class="invalid-feedback d-block">{{ $message }}</div>
										@enderror
									</div>
								@endif
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="name" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
										<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
											value="{{ old('name', auth()->user()->name) }}" required maxlength="150" placeholder="Masukkan nama">
										@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="col-md-6 mb-3">
										<label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
											value="{{ old('email', auth()->user()->email) }}" required maxlength="150" placeholder="Masukkan email">
										@error('email')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="phone_number" class="form-label fw-semibold">Nomor Telepon <span
												class="text-danger">*</span></label>
										<input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
											name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" required maxlength="20"
											placeholder="Masukkan nomor telepon">
										@error('phone_number')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									@if (auth()->user()->role === 'teacher')
										<div class="col-md-6 mb-3">
											<label for="expertise" class="form-label fw-semibold">Keahlian (Opsional)</label>
											<input type="text" class="form-control @error('expertise') is-invalid @enderror" id="expertise"
												name="expertise" value="{{ old('expertise', auth()->user()->teacher->expertise ?? '') }}" maxlength="100"
												placeholder="Masukkan keahlian">
											@error('expertise')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										<div class="col-md-12 mb-3">
											<label for="bio" class="form-label fw-semibold">Bio (Opsional)</label>
											<textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
											 maxlength="500" placeholder="Masukkan bio singkat">{{ old('bio', auth()->user()->teacher->bio ?? '') }}</textarea>
											@error('bio')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									@endif
								</div>
								<div class="d-flex justify-content-end gap-2 mt-4">
									<button type="submit" class="btn btn-app-primary" id="submitSettingsBtn">
										<span class="button-content">Simpan Perubahan</span>
										<span class="spinner-content d-none">
											<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
											Menyimpan...
										</span>
									</button>
								</div>
							</form>
						</div>
						<div id="settings-password" class="settings-pane d-none">
							<form method="POST" action="{{ route('settings.update-password') }}">
								@csrf
								@method('PUT')
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="old_password" class="form-label fw-semibold">Password Lama <span
												class="text-danger">*</span></label>
										<div class="d-flex align-items-center" style="position:relative;">
											<input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password"
												name="old_password" required placeholder="Masukkan password lama">
											<button type="button" tabindex="-1" class="toggle-password btn btn-link px-2" data-target="old_password"
												style="color:#6b7280; position:absolute; right:0; top:50%; transform:translateY(-50%);"><i
													class="bi bi-eye-slash"></i></button>
										</div>
										@error('old_password')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="col-md-6 mb-3">
										<label for="new_password" class="form-label fw-semibold">Password Baru <span
												class="text-danger">*</span></label>
										<div class="d-flex align-items-center" style="position:relative;">
											<input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password"
												name="new_password" required placeholder="Masukkan password baru">
											<button type="button" tabindex="-1" class="toggle-password btn btn-link px-2" data-target="new_password"
												style="color:#6b7280; position:absolute; right:0; top:50%; transform:translateY(-50%);"><i
													class="bi bi-eye-slash"></i></button>
										</div>
										@error('new_password')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="col-md-6 mb-3">
										<label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span
												class="text-danger">*</span></label>
										<div class="d-flex align-items-center" style="position:relative;">
											<input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
												id="new_password_confirmation" name="new_password_confirmation" required
												placeholder="Konfirmasi password baru">
											<button type="button" tabindex="-1" class="toggle-password btn btn-link px-2"
												data-target="new_password_confirmation"
												style="color:#6b7280; position:absolute; right:0; top:50%; transform:translateY(-50%);"><i
													class="bi bi-eye-slash"></i></button>
										</div>
										@error('new_password_confirmation')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="d-flex justify-content-end gap-2 mt-4">
									<button type="submit" class="btn btn-app-primary" id="submitPasswordBtn">
										<span class="button-content">Ubah Password</span>
										<span class="spinner-content d-none">
											<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
											Menyimpan...
										</span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>

	<style>
		.drop-area {
			border: 2px dashed #cbd5e1;
			border-radius: 1rem;
			background: #f3f4f6;
			cursor: pointer;
			transition: border-color 0.15s, background 0.15s;
			position: relative;
		}

		.drop-area.drop-area-hover {
			border-color: var(--app-primary, #2563eb);
			background: #e0e7ff;
		}

		.drop-content {
			pointer-events: none;
		}

		.preview-wrapper {
			z-index: 2;
		}

		.preview-remove {
			z-index: 3;
			font-size: 1.5rem;
			line-height: 1;
			padding: 0 0.5rem;
		}

		.settings-nav-btn {
			background: #f3f4f6;
			border: none;
			border-radius: 0.75rem;
			padding: 0.75rem 2.2rem;
			font-weight: 600;
			color: #374151;
			font-size: 1.1rem;
			transition: background 0.15s, color 0.15s, box-shadow 0.15s;
			box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
		}

		.settings-nav-btn.active,
		.settings-nav-btn:focus {
			background: var(--app-primary, #2563eb);
			color: #fff;
			box-shadow: 0 2px 8px 0 rgba(37, 99, 235, 0.08);
		}

		.settings-nav-btn:hover:not(.active) {
			background: #e5e7eb;
			color: #2563eb;
		}

		.settings-content {
			min-height: 420px;
		}

		.settings-pane.d-none {
			display: none !important;
		}

		.settings-pane {
			animation: fadeIn 0.2s;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(16px);
			}

			to {
				opacity: 1;
				transform: none;
			}
		}
	</style>

	<script>
		// Drag & Drop Profile Photo
		document.addEventListener('DOMContentLoaded', function() {
			const profileDropArea = document.getElementById('profile-drop-area');
			const profileInput = document.getElementById('profile_picture_file');
			const profilePreview = document.getElementById('photoPreview');
			const profileDropText = document.getElementById('profile-drop-text');
			const profilePreviewWrapper = document.getElementById('profile-preview-wrapper');
			const profileRemoveBtn = document.getElementById('profile-remove-btn');
			// Helper: show/hide preview and text
			function setPreviewVisible(visible) {
				if (visible) {
					profilePreviewWrapper.style.display = '';
					profileDropText.style.display = 'none';
				} else {
					profilePreviewWrapper.style.display = 'none';
					profileDropText.style.display = '';
				}
			}

			function updateProfilePreview(file) {
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						profilePreview.src = e.target.result;
						setPreviewVisible(true);
					};
					reader.readAsDataURL(file);
				} else {
					profilePreview.src =
						"{{ auth()->user()->teacher?->profile_picture_path ? asset('storage/' . auth()->user()->teacher->profile_picture_path) : asset('assets/img/default-profile.png') }}";
					setPreviewVisible(false);
				}
			}
			if (profileDropArea && profileInput && profilePreview && profileDropText && profilePreviewWrapper &&
				profileRemoveBtn) {
				// Remove photo
				profileRemoveBtn.addEventListener('click', function(e) {
					e.preventDefault();
					profileInput.value = '';
					updateProfilePreview(null);
				});
				// Click area to open file
				profileDropArea.addEventListener('click', function(e) {
					// Only trigger if not clicking remove button
					if (!e.target.closest('#profile-remove-btn')) {
						profileInput.click();
					}
				});
				// Drag events
				profileDropArea.addEventListener('dragover', function(e) {
					e.preventDefault();
					profileDropArea.classList.add('drop-area-hover');
				});
				profileDropArea.addEventListener('dragleave', function(e) {
					e.preventDefault();
					profileDropArea.classList.remove('drop-area-hover');
				});
				profileDropArea.addEventListener('drop', function(e) {
					e.preventDefault();
					profileDropArea.classList.remove('drop-area-hover');
					if (e.dataTransfer.files && e.dataTransfer.files[0]) {
						profileInput.files = e.dataTransfer.files;
						updateProfilePreview(e.dataTransfer.files[0]);
					}
				});
				// File input change
				profileInput.addEventListener('change', function(event) {
					updateProfilePreview(event.target.files[0]);
				});
				// Show preview if file already selected (after validation error)
				if (profileInput.files && profileInput.files[0]) {
					updateProfilePreview(profileInput.files[0]);
				} else {
					// Show preview if user sudah punya foto
					const hasPhoto = "{{ auth()->user()->teacher?->profile_picture_path ? '1' : '' }}";
					setPreviewVisible(!!hasPhoto);
				}
			}
		});
		// Toggle password
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
		// Spinner on submit
		const submitSettingsBtn = document.getElementById('submitSettingsBtn');
		const submitPasswordBtn = document.getElementById('submitPasswordBtn');
		if (submitSettingsBtn) {
			submitSettingsBtn.form?.addEventListener('submit', function() {
				submitSettingsBtn.disabled = true;
				submitSettingsBtn.querySelector('.button-content').classList.add('d-none');
				submitSettingsBtn.querySelector('.spinner-content').classList.remove('d-none');
			});
		}
		if (submitPasswordBtn) {
			submitPasswordBtn.form?.addEventListener('submit', function() {
				submitPasswordBtn.disabled = true;
				submitPasswordBtn.querySelector('.button-content').classList.add('d-none');
				submitPasswordBtn.querySelector('.spinner-content').classList.remove('d-none');
			});
		}
		// Settings navigation logic
		document.querySelectorAll('.settings-nav-btn').forEach(btn => {
			btn.addEventListener('click', function() {
				document.querySelectorAll('.settings-nav-btn').forEach(b => b.classList.remove('active'));
				this.classList.add('active');
				document.querySelectorAll('.settings-pane').forEach(pane => pane.classList.add('d-none'));
				const target = document.querySelector(this.dataset.target);
				if (target) target.classList.remove('d-none');
			});
		});
	</script>
@endsection
