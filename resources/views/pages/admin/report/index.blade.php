@extends('layouts.admin')

@section('title', 'Perbaikan Kendaraan')

@section('breadcrumb')
	<li class="breadcrumb-item active">Laporan Perbaikan Kendaraan</li>
@endsection

@section('content')
	<div class="container-fluid">
		<!-- Card: Report List -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4 fs-4">Data Laporan Perbaikan Kendaraan</h5>
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
						<a href="{{ route('reports.create') }}" class="btn btn-app-secondary w-100 w-md-auto">
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
								<th>Status</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($reports as $report)
								<tr>
									<td>{{ $reports->firstItem() + $loop->index }}</td>
									<td>{{ $report->date->translatedFormat('d F Y') }}</td>
									<td>{{ $report->vehicle->nopol ?? '-' }}</td>
									<td>{{ $report->user->name ?? '-' }}</td>
									<td>Rp {{ number_format($report->grand_total, 0, ',', '.') }}</td>
									<td>
										@if($report->status === 'active')
											<span class="badge bg-opacity-10 w-100 text-success border border-success border-opacity-25 px-2 py-1 rounded-2">
												<i class="bi bi-check-circle-fill me-1"></i> Aktif
											</span>
										@else
											<span class="badge r bg-opacity-10 w-100 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-2">
												<i class="bi bi-x-circle-fill me-1"></i> Dibatalkan
											</span>
										@endif
									</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-info" title="Lihat">
											<i class="bx bx-info-circle"></i> Lihat
										</a>
										
										
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center text-muted py-4">
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
		@if($report->status === 'active')
			
		@endif
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
