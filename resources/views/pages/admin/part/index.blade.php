@extends('layouts.admin')

@section('title', 'Manajemen Suku Cadang')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Suku Cadang</li>
@endsection

@section('content')
	<div class="container-fluid">
		<!-- Card: Part List -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4 fs-4">Daftar Data Suku Cadang</h5>
				<div class="row g-2 align-items-center">
					<!-- Search -->
					<div class="col-12 col-md-6">
						<form method="GET" class="w-100 d-flex align-items-center gap-2">
							<div class="input-group">
								<span class="input-group-text"><i class="bx bx-search"></i></span>
								<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
									placeholder="Cari nama suku cadang...">
								<button class="btn btn-outline-secondary border btn-search-part" type="submit">
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
						<a href="{{ route('parts.create') }}" class="btn btn-primary w-100 w-md-auto">
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
								<th>Harga</th>
								<th>Stok</th>
								<th>Deskripsi</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($parts as $part)
								<tr>
									<td>{{ $parts->firstItem() + $loop->index }}</td>
									<td>{{ Str::limit($part->name, 20) }}</td>
									<td>Rp {{ number_format($part->base_price, 0, ',', '.') }}</td>
									<td>{{ $part->stock }} </td>
									<td>{{ Str::limit($part->description, 20) }}</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('parts.show', $part) }}" class="btn btn-sm btn-info" title="Lihat">
											<i class="bx bx-info-circle"></i> Lihat
										</a>
										
										<a href="{{ route('parts.stock', $part->id) }}" class="btn btn-sm btn-success" title="Stock">
											<i class="bx bx-archive"></i> Stok
										</a>
										<a href="{{ route('parts.edit', $part) }}" class="btn btn-sm btn-warning" title="Ubah">
											<i class="bx bx-pencil"></i> Ubah
										</a>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $part->id }}" title="Hapus">
											<i class="bx bx-trash"></i> Hapus
										</button>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6" class="text-center text-muted py-4">
										<i class="bi bi-folder-x fs-4 d-block mb-2"></i>
										Tidak ada data suku cadang tersedia.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<!-- Pagination -->
				<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
					<div class="small text-muted">
						Halaman <strong>{{ $parts->currentPage() }}</strong> dari <strong>{{ $parts->lastPage() }}</strong><br>
						Menampilkan <strong>{{ $parts->perPage() }}</strong> data per halaman (total <strong>{{ $parts->total() }}</strong> suku cadang)
					</div>
					<div>{{ $parts->links() }}</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Modals -->
	@foreach ($parts as $part)
		<div class="modal fade" id="modalCenter{{ $part->id }}" tabindex="-1" aria-hidden="true">
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
						<p class="mb-3 fs-6">Hapus suku cadang <strong>{{ $part->name }}</strong>?</p>
					</div>
					<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
						<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
						<form action="{{ route('parts.destroy', $part) }}" method="POST" class="d-inline">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger px-4 btn-delete-part">
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

		<!-- Add Stock Modal -->
		<div class="modal fade" id="modalAddStock{{ $part->id }}" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content rounded-4 shadow-lg border-0 p-2">
					<div class="modal-header border-0 pb-0">
						<div class="d-flex align-items-center gap-2 w-100">
							<i class="bi bi-plus-circle text-success fs-3 me-2"></i>
							<div class="grow">
								<h5 class="modal-title mb-0 fw-bold">Tambah Stok</h5>
								<small class="text-muted">{{ $part->name }}</small>
							</div>
							<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
					</div>
					<div class="modal-body pt-3 pb-0 px-4">
						<form id="formAddStock{{ $part->id }}" action="{{ route('parts.addStock', $part->id) }}" method="POST">
							@csrf
							<div class="mb-3">
								<label for="quantity_add_{{ $part->id }}" class="form-label">Jumlah yang Ditambahkan <span class="text-danger">*</span></label>
								<input type="number" id="quantity_add_{{ $part->id }}" name="quantity" class="form-control" min="1" required placeholder="Contoh: 10">
								<small class="text-muted">Stok saat ini: <strong>{{ $part->stock }}</strong></small>
							</div>
							
						</form>
					</div>
					<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
						<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
						<button type="submit" form="formAddStock{{ $part->id }}" class="btn btn-success px-4 btn-submit-stock">
							<span class="button-content"><i class="bi bi-plus-lg me-1"></i> Tambah</span>
							<span class="spinner-content d-none">
								<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Reduce Stock Modal -->
		<div class="modal fade" id="modalReduceStock{{ $part->id }}" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content rounded-4 shadow-lg border-0 p-2">
					<div class="modal-header border-0 pb-0">
						<div class="d-flex align-items-center gap-2 w-100">
							<i class="bi bi-dash-circle text-warning fs-3 me-2"></i>
							<div class="grow">
								<h5 class="modal-title mb-0 fw-bold">Kurangi Stok</h5>
								<small class="text-muted">{{ $part->name }}</small>
							</div>
							<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
					</div>
					<div class="modal-body pt-3 pb-0 px-4">
						<form id="formReduceStock{{ $part->id }}" action="{{ route('parts.reduceStock', $part->id) }}" method="POST">
							@csrf
							<div class="mb-3">
								<label for="quantity_reduce_{{ $part->id }}" class="form-label">Jumlah yang Dikurangi <span class="text-danger">*</span></label>
								<input type="number" id="quantity_reduce_{{ $part->id }}" name="quantity" class="form-control" min="1" max="{{ $part->stock }}" required placeholder="Contoh: 5">
								<small class="text-muted">Stok saat ini: <strong>{{ $part->stock }}</strong></small>
							</div>
							<div class="mb-3">
								<label for="note_{{ $part->id }}" class="form-label">Alasan Pengurangan Stok <span class="text-danger">*</span></label>
								<textarea id="note_{{ $part->id }}" name="note" class="form-control" rows="4" style="resize: none;" required placeholder="Masukkan alasan pengurangan stok..."></textarea>
								<small class="form-text text-muted d-block mt-2">Jelaskan alasan pengurangan stok dengan detail</small>
							</div>
						</form>
					</div>
					<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
						<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
						<button type="submit" form="formReduceStock{{ $part->id }}" class="btn btn-warning px-4 btn-submit-stock">
							<span class="button-content"><i class="bi bi-dash-lg me-1"></i> Kurangi</span>
							<span class="spinner-content d-none">
								<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
							</span>
						</button>
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
			document.querySelectorAll('form[id^="formAddStock"], form[id^="formReduceStock"]').forEach(function(form) {
				form.addEventListener('submit', function(e) {
					var btn = form.parentElement.querySelector('.btn-submit-stock');
					if (btn) {
						btn.disabled = true;
						btn.querySelector('.button-content').classList.add('d-none');
						btn.querySelector('.spinner-content').classList.remove('d-none');
					}
				});
			});

			// Delete form spinner
			document.querySelectorAll('form[action*="destroy"]').forEach(function(form) {
				form.addEventListener('submit', function(e) {
					var btn = form.querySelector('.btn-delete-part');
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
						var btn = form.querySelector('.btn-search-part');
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
