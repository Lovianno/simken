@extends('layouts.admin')

@section('title', 'Detail Kendaraan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}" class="text-decoration-none">Data Kendaraan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Kendaraan</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0 mb-4 p-3">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold fs-4">Detail Data Kendaraan</h5>
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" class="form-control" value="{{ $vehicle->nopol }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis/Tipe Kendaraan</label>
                    <input type="text" class="form-control" value="{{ $vehicle->type }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" class="form-control" value="{{ $vehicle->category }}" readonly>

                </div>
                <div class="mb-3">
                    <label class="form-label">Tahun Kendaraan</label>
                    <input type="text" class="form-control" value="{{ $vehicle->year }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Unit Internal</label>
                    <input type="text" class="form-control" value="{{ $vehicle->unit_number }}" readonly>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Dibuat Pada</label>
                    <input type="text" class="form-control"
                        value="{{ $vehicle->created_at->translatedFormat('d F Y, H:i') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Diperbarui Pada</label>
                    <input type="text" class="form-control"
                        value="{{ $vehicle->updated_at->translatedFormat('d F Y, H:i') }}" readonly>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2 px-0 pt-3">
                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // No JS needed for show view
    </script>
@endpush
