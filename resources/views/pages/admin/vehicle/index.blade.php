@extends('layouts.admin')

@section('title', 'Manajemen Kendaraan')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Kendaraan</li>
@endsection

@section('content')
	<div class="container-fluid">
		<!-- Card: Vehicle List -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4 fs-4">Daftar Data Kendaraan</h5>
				<div class="row g-2 align-items-center">
					<!-- Search -->
					<div class="col-12 col-md-6">
						<form method="GET" class="w-100 d-flex align-items-center gap-2">
							<div class="input-group">
								<span class="input-group-text"><i class="bx bx-search"></i></span>
								<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
									placeholder="Cari nomor polisi, tipe, atau unit...">
								<button class="btn btn-outline-secondary border btn-search-vehicle" type="submit">
									<span class="button-content">Cari</span>
									<span class="spinner-content d-none">
										<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
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
						<a href="{{ route('vehicles.create') }}" class="btn btn-primary w-100 w-md-auto">
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
								<th>Nomor Polisi</th>
								<th>Jenis/Tipe</th>
								<th>Kategori</th>
								<th>Tahun</th>
								<th>Nomor Unit</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($vehicles as $vehicle)
								<tr>
									<td>{{ $vehicles->firstItem() + $loop->index }}</td>
									<td>{{ $vehicle->nopol }}</td>
									<td>{{ $vehicle->type }}</td>
									<td>{{ $vehicle->category }}</td>
									<td>{{ $vehicle->year }}</td>
									<td>{{ $vehicle->unit_number }}</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-info" title="Lihat">
											<i class="bx bx-info-circle"></i> Lihat
										</a>
										<a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning" title="Ubah">
											<i class="bx bx-pencil"></i> Ubah
										</a>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $vehicle->id }}" title="Hapus">
											<i class="bx bx-trash"></i> Hapus
										</button>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center text-muted py-4">
										<i class="bi bi-folder-x fs-4 d-block mb-2"></i>
										Tidak ada data kendaraan tersedia.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<!-- Pagination -->
				<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
					<div class="small text-muted">
						Halaman <strong>{{ $vehicles->currentPage() }}</strong> dari <strong>{{ $vehicles->lastPage() }}</strong><br>
						Menampilkan <strong>{{ $vehicles->perPage() }}</strong> data per halaman (total <strong>{{ $vehicles->total() }}</strong> kendaraan)
					</div>
					<div>{{ $vehicles->links() }}</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Modals -->
	@foreach ($vehicles as $vehicle)
		<div class="modal fade" id="modalCenter{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content rounded-4 shadow-lg border-0 p-2">
					<div class="modal-header border-0 pb-0">
						<div class="d-flex align-items-center gap-2 w-100">
							<i class="bi bi-exclamation-triangle text-danger fs-3 me-2"></i>
							<div class="grow">
								<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Hapus</h5>
								<small class="text-muted">Tindakan ini tidak dapat dibatalkan</small>
							</div>
							<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
					</div>
					<div class="modal-body pt-3 pb-0 px-4">
						<p class="mb-3 fs-6">Hapus kendaraan <strong>{{ $vehicle->nopol }}</strong> ({{ $vehicle->type }})?</p>
					</div>
					<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
						<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
						<form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger px-4 btn-delete-vehicle">
								<span class="button-content"><i class="bi bi-trash me-1"></i> Hapus</span>
								<span class="spinner-content d-none">
									<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
									Menghapus...
								</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endforeach
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner for delete button in modal
			document.querySelectorAll('.modal form').forEach(function(form) {
				form.addEventListener('submit', function(e) {
					var btn = form.querySelector('.btn-delete-vehicle');
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
						var btn = form.querySelector('.btn-search-vehicle');
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
