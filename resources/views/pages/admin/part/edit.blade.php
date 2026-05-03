@extends('layouts.admin')

@section('title', 'Ubah Suku Cadang')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('parts.index') }}" class="text-decoration-none">Data Suku Cadang</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ubah Suku Cadang</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Ubah Suku Cadang</h5>
				<a href="{{ route('parts.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Batal
				</a>
			</div>
			<div class="card-body">
				<form action="{{ route('parts.update', $part) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					{{-- NAMA SUKU CADANG --}}
					<div class="mb-3">
						<label for="name" class="form-label">Nama Suku Cadang <span class="text-danger">*</span></label>
						<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Contoh: Oli Mesin SAE 15W40"
							value="{{ old('name', $part->name) }}">
						@error('name')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- HARGA DASAR --}}
					<div class="mb-3">
						<label for="base_price" class="form-label">Harga <span class="text-danger">*</span></label>
						<input type="number" name="base_price" class="form-control @error('base_price') is-invalid @enderror" step="0.01" min="0" required placeholder="Contoh: 50000"
							value="{{ old('base_price', $part->base_price) }}">
						@error('base_price')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>


					{{-- DESKRIPSI --}}
					<div class="mb-3">
						<label for="description" class="form-label">Deskripsi</label>
						<textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Deskripsi singkat tentang suku cadang ini">{{ old('description', $part->description) }}</textarea>
						@error('description')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end mt-4">
						<button type="submit" class="btn btn-primary" id="submitPartBtn">
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
		const partForm = document.querySelector('form[action="{{ route('parts.update', $part) }}"]');
		const submitPartBtn = document.getElementById('submitPartBtn');
		if (partForm && submitPartBtn) {
			partForm.addEventListener('submit', function() {
				submitPartBtn.disabled = true;
				submitPartBtn.querySelector('.button-content').classList.add('d-none');
				submitPartBtn.querySelector('.spinner-content').classList.remove('d-none');
			});
		}
	</script>
@endpush
