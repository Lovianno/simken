@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<!-- Card: User Aktif/Nonaktif -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4 fs-4">Daftar Data Pengguna</h5>
				@if ($errors->has('delete'))
					<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
						<i class="bi bi-exclamation-circle-fill me-2"></i>
						{{ $errors->first('delete') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
				<div class="row g-2 align-items-center">
					<!-- Search -->
					<div class="col-12 col-md-6">
						<form method="GET" class="w-100 d-flex align-items-center gap-2">
							<div class="input-group">
								<span class="input-group-text"><i class="bi bi-search"></i></span>
								<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
									placeholder="Cari nama atau email...">
								<button class="btn btn-outline-secondary border btn-search-user" type="submit">
									<span class="button-content">Cari</span>
									<span class="spinner-content d-none">
										<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
										Mencari
									</span>
								</button>
							</div>
							<a href="{{ url()->current() }}"
								class="btn btn-secondary border d-flex align-items-center gap-1 {{ request('search') ? '' : 'd-none' }}">
								<i class="bi bi-arrow-counterclockwise"></i>
								<span>Reset</span>
							</a>
						</form>
					</div>
					<div class="col-12 col-md-auto ms-md-auto text-md-end">
						<a href="{{ route('users.create') }}" class="btn btn-primary w-100 w-md-auto">
							<i class="bi bi-plus-lg me-1"></i> Tambah Baru
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr class="text-start">
								<th>#</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Nomor Telepon</th>
								<th class="text-center">Status</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($users as $user)
								<tr>
									<td>{{ $users->firstItem() + $loop->index }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->phone_number ?? '-' }}</td>
									<td>
										@php
											$status = $user->status;
											$badgeClass = $status === 'active' ? 'text-success border-success' : 'text-secondary border-secondary';
										@endphp
										<span class="badge bg-opacity-10 border {{ $badgeClass }} border-opacity-25 px-2 py-1 rounded-2"><i class="bi bi-check-circle-fill me-1"></i> {{ $status }}</span>
									</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i>
											Lihat</a>
										<a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i>
											Ubah</a>
										@if (auth()->id() === $user->id)
											<button type="button" class="btn btn-secondary btn-sm" disabled title="Tidak dapat menghapus akun sendiri"><i
													class="bi bi-trash"></i> Hapus</button>
										@elseif ($user->report()->exists())
											<button type="button" class="btn btn-secondary btn-sm" disabled title="Tidak dapat menghapus user yang memiliki laporan"><i
													class="bi bi-trash"></i> Hapus</button>
										@else
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
												data-bs-target="#modalCenter{{ $user->id }}"><i class="bi bi-trash"></i> Hapus</button>
										@endif
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6" class="text-center text-muted py-4">
										<i class="bi bi-folder-x fs-4 d-block mb-2"></i>
										Tidak ada data ditemukan.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				@foreach ($users as $user)
					@if (auth()->id() !== $user->id && !$user->report()->exists())
						<div class="modal fade" id="modalCenter{{ $user->id }}" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content rounded-4 shadow-lg border-0 p-2">
									<div class="modal-header border-0 pb-0">
										<div class="d-flex align-items-center gap-2 w-100">
											<i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-2"></i>
											<div class="grow">
												<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Hapus</h5>
												<small class="text-muted">Aksi ini tidak dapat dibatalkan</small>
											</div>
											<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
									</div>
									<div class="modal-body pt-3 pb-0 px-4">
										<p class="mb-3 fs-6">Apakah Anda yakin ingin menghapus
											<strong>{{ Str::limit($user->name, 15, '...') }}</strong>?
											<br><span class="text-danger">Semua data yang pernah dibuat oleh pengguna ini akan terhapus juga.</span>
										</p>
									</div>
									<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
										<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
										<form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger px-4 btn-delete-user">
												<span class="button-content"><i class="bi bi-trash me-1"></i> Hapus</span>
												<span class="spinner-content d-none">
													<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
													Menghapus
												</span>
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach
				<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
					<div class="small text-muted">
						Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
						Menampilkan <strong>{{ $perPage }}</strong> data per halaman (total <strong>{{ $total }}</strong>
						user)
					</div>
					<div>
						{{ $users->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner for delete button in modal
			document.querySelectorAll('.modal form').forEach(function(form) {
				form.addEventListener('submit', function(e) {
					var btn = form.querySelector('.btn-delete-user');
					if (btn) {
						btn.disabled = true;
						btn.querySelector('.button-content').classList.add('d-none');
						btn.querySelector('.spinner-content').classList.remove('d-none');
					}
				});
			});

			// Spinner for search button
			document.querySelectorAll('form input[name="search"]').forEach(function(input) {
				var form = input.closest('form');
				if (form) {
					form.addEventListener('submit', function(e) {
						var btn = form.querySelector('.btn-search-user');
						if (btn) {
							btn.disabled = true;
							btn.querySelector('.button-content').classList.add('d-none');
							btn.querySelector('.spinner-content').classList.remove('d-none');
						}
					});
				}
			});
		});
	</script>
@endpush
