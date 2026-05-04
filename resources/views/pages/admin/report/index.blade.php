@extends('layouts.admin')

@section('title', 'Manajemen Laporan')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Laporan</li>
@endsection

@section('content')
	<div class="container-fluid">
		<!-- Card: Report List -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4 fs-4">Daftar Data Laporan</h5>
				<div class="row g-2 align-items-center">
					<!-- Search -->
					<div class="col-12 col-md-6">
						<form method="GET" class="w-100 d-flex align-items-center gap-2">
							<div class="input-group">
								<span class="input-group-text"><i class="bx bx-search"></i></span>
								<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
									placeholder="Cari nomor polisi atau nama user...">
								<button class="btn btn-outline-secondary border btn-search-report" type="submit">
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
						<a href="{{ route('reports.create') }}" class="btn btn-primary w-100 w-md-auto">
							<i class="bi bi-plus-lg me-1"></i> Buat Laporan
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
								<th>Tanggal</th>
								<th>Nomor Polisi</th>
								<th>User</th>
								<th>Total</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($reports as $report)
								<tr>
									<td>{{ $reports->firstItem() + $loop->index }}</td>
									<td>{{ $report->date->format('d M Y') }}</td>
									<td>{{ $report->vehicle->nopol ?? '-' }}</td>
									<td>{{ $report->user->name ?? '-' }}</td>
									<td>Rp {{ number_format($report->grand_total, 0, ',', '.') }}</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-info" title="Lihat">
											<i class="bx bx-info-circle"></i> Lihat
										</a>
										<a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-warning" title="Ubah">
											<i class="bx bx-pencil"></i> Ubah
										</a>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $report->id }}" title="Hapus">
											<i class="bx bx-trash"></i> Hapus
										</button>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6" class="text-center text-muted py-4">
										<i class="bi bi-folder-x fs-4 d-block mb-2"></i>
										Tidak ada data laporan tersedia.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<!-- Pagination -->
				<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
					<div class="small text-muted">
						Halaman <strong>{{ $reports->currentPage() }}</strong> dari <strong>{{ $reports->lastPage() }}</strong><br>
						Menampilkan <strong>{{ $reports->perPage() }}</strong> data per halaman (total <strong>{{ $reports->total() }}</strong> laporan)
					</div>
					<div>{{ $reports->links() }}</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Modals -->
	@foreach ($reports as $report)
		<div class="modal fade" id="modalCenter{{ $report->id }}" tabindex="-1" aria-hidden="true">
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
						<p class="mb-3 fs-6">Hapus laporan tanggal <strong>{{ $report->date->format('d M Y') }}</strong> untuk kendaraan <strong>{{ $report->vehicle->nopol }}</strong>?</p>
					</div>
					<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
						<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
						<form action="{{ route('reports.destroy', $report) }}" method="POST" class="d-inline">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger px-4 btn-delete-report">
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
					var btn = form.querySelector('.btn-delete-report');
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
						var btn = form.querySelector('.btn-search-report');
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
