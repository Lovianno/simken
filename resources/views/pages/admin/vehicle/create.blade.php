@extends('layouts.admin')

@section('title', 'Tambah Kendaraan')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}" class="text-decoration-none">Data Kendaraan</a></li>
	<li class="breadcrumb-item active" aria-current="page">Tambah Kendaraan</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Tambah Kendaraan</h5>

				<a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left me-2"></i> Batal
				</a>
			</div>

			<div class="card-body">
				<form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
					@csrf

					{{-- NOMOR POLISI --}}
					<div class="mb-3">
						<label for="nopol" class="form-label">Nomor Polisi <span class="text-danger">*</span></label>
						<input type="text" name="nopol" class="form-control @error('nopol') is-invalid @enderror" required placeholder="Contoh: B 1234 ABC"
							value="{{ old('nopol') }}">
						@error('nopol')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- JENIS/TIPE KENDARAAN --}}
					<div class="mb-3">
						<label for="type" class="form-label">Jenis/Tipe Kendaraan <span class="text-danger">*</span></label>
						<input type="text" name="type" class="form-control @error('type') is-invalid @enderror" required placeholder="Contoh: Truk Fuso"
							value="{{ old('type') }}">
						@error('type')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- KATEGORI KENDARAAN --}}
					<div class="mb-3">
						<label for="category" class="form-label">Kategori Kendaraan <span class="text-danger">*</span></label>
						<select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
							<option value="">-- Pilih Kategori --</option>
							<option value="Mobil" {{ old('category') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
							<option value="Truk" {{ old('category') == 'Truk' ? 'selected' : '' }}>Truk</option>
							<option value="Bus" {{ old('category') == 'Bus' ? 'selected' : '' }}>Bus</option>
							<option value="Sepeda Motor" {{ old('category') == 'Sepeda Motor' ? 'selected' : '' }}>Sepeda Motor</option>
						</select>
						@error('category')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- TAHUN KENDARAAN --}}
					<div class="mb-3">
						<label for="year" class="form-label">Tahun Kendaraan <span class="text-danger">*</span></label>
						<input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" required placeholder="Contoh: 2018" min="1900" max="{{ now()->year + 1 }}"
							value="{{ old('year') }}">
						@error('year')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- NOMOR UNIT --}}
					<div class="mb-3">
						<label for="unit_number" class="form-label">Nomor Unit <span class="text-danger">*</span></label>
						<input type="text" name="unit_number" class="form-control @error('unit_number') is-invalid @enderror" required placeholder="Contoh: UNIT-001"
							value="{{ old('unit_number') }}">
						@error('unit_number')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
				<hr class="my-4">
				<h6 class="fw-semibold mb-3">Data Tambahan (Opsional)</h6>

				{{-- UKURAN TRUK --}}
				<div class="mb-3">
					<label for="truck_size" class="form-label">Ukuran Truk</label>
					<select name="truck_size" id="truck_size" class="form-select @error('truck_size') is-invalid @enderror">
						<option value="">-- Pilih Ukuran --</option>
						<option value="20 FEET" {{ old('truck_size') == '20 FEET' ? 'selected' : '' }}>20 FEET</option>
						<option value="40 FEET" {{ old('truck_size') == '40 FEET' ? 'selected' : '' }}>40 FEET</option>
						<option value="40 SLEDING" {{ old('truck_size') == '40 SLEDING' ? 'selected' : '' }}>40 SLEDING</option>
					</select>
					@error('truck_size')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				{{-- DATA STNK --}}
				<div class="mb-3">
					<label for="stnk_owner" class="form-label">Nama Pemilik di STNK (AN STNK)</label>
					<input type="text" name="stnk_owner" class="form-control @error('stnk_owner') is-invalid @enderror" placeholder="Nama Pemilik"
						value="{{ old('stnk_owner') }}">
					@error('stnk_owner')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="tax_due_date" class="form-label">Jatuh Tempo Pajak Tahunan</label>
						<input type="date" name="tax_due_date" class="form-control @error('tax_due_date') is-invalid @enderror"
							value="{{ old('tax_due_date') }}">
						@error('tax_due_date')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 mb-3">
						<label for="stnk_due_date" class="form-label">Jatuh Tempo STNK 5 Tahunan</label>
						<input type="date" name="stnk_due_date" class="form-control @error('stnk_due_date') is-invalid @enderror"
							value="{{ old('stnk_due_date') }}">
						@error('stnk_due_date')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
				</div>

				{{-- KIR KEPALA / TRACTOR --}}
				<h6 class="fw-semibold mb-3 mt-4">KIR Kepala/Tractor</h6>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="kir_head_number" class="form-label">Nomor KIR Kepala/Tractor</label>
						<input type="text" name="kir_head_number" class="form-control @error('kir_head_number') is-invalid @enderror" placeholder="Nomor KIR"
							value="{{ old('kir_head_number') }}">
						@error('kir_head_number')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 mb-3">
						<label for="kir_head_due_date" class="form-label">Tanggal Jatuh Tempo KIR Kepala</label>
						<input type="date" name="kir_head_due_date" class="form-control @error('kir_head_due_date') is-invalid @enderror"
							value="{{ old('kir_head_due_date') }}">
						@error('kir_head_due_date')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
				</div>

				{{-- KIR KERETA / TRAILER --}}
				<h6 class="fw-semibold mb-3 mt-4">KIR Kereta/Trailer</h6>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="kir_trailer_number" class="form-label">Nomor KIR Kereta/Trailer</label>
						<input type="text" name="kir_trailer_number" class="form-control @error('kir_trailer_number') is-invalid @enderror" placeholder="Nomor KIR"
							value="{{ old('kir_trailer_number') }}">
						@error('kir_trailer_number')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 mb-3">
						<label for="kir_trailer_due_date" class="form-label">Tanggal Jatuh Tempo KIR Kereta</label>
						<input type="date" name="kir_trailer_due_date" class="form-control @error('kir_trailer_due_date') is-invalid @enderror"
							value="{{ old('kir_trailer_due_date') }}">
						@error('kir_trailer_due_date')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
				</div>

				{{-- SUPIR & KETERANGAN --}}
				<div class="mb-3">
					<label for="driver_name" class="form-label">Nama Supir</label>
					<input type="text" name="driver_name" class="form-control @error('driver_name') is-invalid @enderror" placeholder="Nama Supir"
						value="{{ old('driver_name') }}">
					@error('driver_name')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="notes" class="form-label">Keterangan Tambahan</label>
					<textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Keterangan tambahan jika ada">{{ old('notes') }}</textarea>
					@error('notes')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>
					{{-- SUBMIT BUTTON --}}
					<div class="d-flex justify-content-end mt-4">
						<button type="submit" class="btn btn-app-secondary" id="submitVehicleBtn">
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
		const vehicleForm = document.querySelector('form[action="{{ route('vehicles.store') }}"]');
		const submitVehicleBtn = document.getElementById('submitVehicleBtn');
		if (vehicleForm && submitVehicleBtn) {
			vehicleForm.addEventListener('submit', function() {
				submitVehicleBtn.disabled = true;
				submitVehicleBtn.querySelector('.button-content').classList.add('d-none');
				submitVehicleBtn.querySelector('.spinner-content').classList.remove('d-none');
			});
		}
	</script>
@endpush
