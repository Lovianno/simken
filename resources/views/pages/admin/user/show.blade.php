@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Detail Data Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Detail Data Pengguna</h5>
				<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Kembali
				</a>
			</div>
			<div class="card-body">
				<div class="row mb-2">
					{{-- FOTO KIRI --}}
					@if ($user->role === 'teacher')
						<div class="col-md-3 text-center mb-3">
							@php
								$name = $user->name ?? 'User';
								$defaultAvatar =
								    'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=000&size=300';
								$photoPath = null;
								if ($user->teacher && $user->teacher->profile_picture_path) {
								    $fullPath = public_path('storage/' . $user->teacher->profile_picture_path);
								    if (file_exists($fullPath)) {
								        $photoPath = asset('storage/' . $user->teacher->profile_picture_path);
								    }
								}
							@endphp
							@if ($photoPath)
								<img src="{{ $photoPath }}" class="img-thumbnail rounded shadow-sm"
									style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
							@else
								<span class="text-danger">Foto profil belum diunggah</span>
							@endif
						</div>
					@endif
					{{-- FORM KANAN (LABEL TETAP RATA KIRI) --}}
					<div class="col-md-9">
						{{-- PERAN & STATUS --}}
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label text-start d-block">Peran</label>
								<select class="form-select" disabled>
									<option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
									<option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
									<option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label text-start d-block">Status</label>
								<select class="form-select" disabled>
									<option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Aktif</option>
									<option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
									<option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
									<option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
								</select>
							</div>
						</div>
						{{-- NAMA --}}
						<div class="mb-3">
							<label class="form-label text-start d-block">Nama</label>
							<input type="text" class="form-control" value="{{ $user->name }}" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label text-start d-block">Email</label>
							<input type="email" class="form-control" value="{{ $user->email }}" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label text-start d-block">Nomor Telepon</label>
							<input type="text" class="form-control" value="{{ $user->phone_number ?? '-' }}" readonly>
						</div>
					</div>
				</div>
				{{-- DATA TEACHER --}}
				@if ($user->role === 'teacher' && $user->teacher)
					<hr>
					<div class="mb-3">
						<label class="form-label">Bio</label>
						<textarea class="form-control" rows="3" readonly>{{ $user->teacher->bio ?? '-' }}</textarea>
					</div>
					<div class="mb-3">
						<label class="form-label">Keahlian</label>
						<input type="text" class="form-control" value="{{ $user->teacher->expertise ?? '-' }}" readonly>
					</div>
				@endif
				<hr class="my-4">
				<div class="mb-3">
					<label class="form-label">Dibuat Pada</label>
					<input type="text" class="form-control" value="{{ $user->created_at->translatedFormat('d F Y, H:i') }}"
						readonly>
				</div>
				<div class="mb-3">
					<label class="form-label">Diperbarui Pada</label>
					<input type="text" class="form-control" value="{{ $user->updated_at->translatedFormat('d F Y, H:i') }}"
						readonly>
				</div>
			</div>

			@if ($user->role === 'teacher' && $user->status === 'pending')
				<div class="card-footer bg-white border-0 d-flex justify-content-end gap-2">
					<button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalApproveTeacher">
						<i class="bi bi-check-circle"></i> Approve
					</button>
					<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRejectTeacher">
						<i class="bi bi-x-circle"></i> Reject
					</button>
				</div>

				<!-- Modal Approve -->
				<div class="modal fade" id="modalApproveTeacher" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content rounded-4 shadow-lg border-0 p-2">
							<div class="modal-header border-0 pb-0">
								<div class="d-flex align-items-center gap-2 w-100">
									<i class="bi bi-check-circle text-success fs-3 me-2"></i>
									<div class="flex-grow-1">
										<h5 class="modal-title mb-0 fw-bold text-success">Konfirmasi Approve</h5>
										<small class="text-muted">Guru akan diaktifkan sebagai pengajar</small>
									</div>
									<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
							</div>
							<div class="modal-body pt-3 pb-0 px-4">
								<p class="mb-3 fs-6">Approve <strong>{{ $user->name }}</strong> sebagai guru?</p>
							</div>
							<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
								<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
								<form action="{{ route('admin.users.approve-teacher', $user) }}" method="POST" class="d-inline">
									@csrf
									@method('PATCH')
									<button type="submit" class="btn btn-success px-4 btn-approve-teacher">
										<span class="button-content"><i class="bi bi-check-circle me-1"></i> Approve</span>
										<span class="spinner-content d-none">
											<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
											Memproses...
										</span>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal Reject -->
				<div class="modal fade" id="modalRejectTeacher" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content rounded-4 shadow-lg border-0 p-2">
							<div class="modal-header border-0 pb-0">
								<div class="d-flex align-items-center gap-2 w-100">
									<i class="bi bi-x-circle text-danger fs-3 me-2"></i>
									<div class="flex-grow-1">
										<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Reject</h5>
										<small class="text-muted">Pengajuan guru akan ditolak</small>
									</div>
									<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
							</div>
							<div class="modal-body pt-3 pb-0 px-4">
								<p class="mb-3 fs-6">Tolak pengajuan <strong>{{ $user->name }}</strong> sebagai guru?</p>
							</div>
							<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
								<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
								<form action="{{ route('admin.users.reject-teacher', $user) }}" method="POST" class="d-inline">
									@csrf
									@method('PATCH')
									<button type="submit" class="btn btn-danger px-4 btn-reject-teacher">
										<span class="button-content"><i class="bi bi-x-circle me-1"></i> Reject</span>
										<span class="spinner-content d-none">
											<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
											Memproses...
										</span>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner for approve button
			document.querySelectorAll('.btn-approve-teacher').forEach(function(btn) {
				btn.closest('form').addEventListener('submit', function(e) {
					btn.disabled = true;
					btn.querySelector('.button-content').classList.add('d-none');
					btn.querySelector('.spinner-content').classList.remove('d-none');
				});
			});
			// Spinner for reject button
			document.querySelectorAll('.btn-reject-teacher').forEach(function(btn) {
				btn.closest('form').addEventListener('submit', function(e) {
					btn.disabled = true;
					btn.querySelector('.button-content').classList.add('d-none');
					btn.querySelector('.spinner-content').classList.remove('d-none');
				});
			});
		});
	</script>
@endpush
