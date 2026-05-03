@extends('layouts.admin')

@section('title', 'Detail Suku Cadang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('parts.index') }}" class="text-decoration-none">Data Suku Cadang</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Suku Cadang</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0 mb-4 p-3">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold fs-4">Detail Data Suku Cadang</h5>
                <a href="{{ route('parts.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Suku Cadang</label>
                    <input type="text" class="form-control" value="{{ $part->name }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($part->base_price, 0, ',', '.') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok Tersedia</label>
                    <input type="text" class="form-control" value="{{ $part->stock }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" rows="4" readonly>{{ $part->description }}</textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Dibuat Pada</label>
                    <input type="text" class="form-control"
                        value="{{ $part->created_at->translatedFormat('d F Y, H:i') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Diperbarui Pada</label>
                    <input type="text" class="form-control"
                        value="{{ $part->updated_at->translatedFormat('d F Y, H:i') }}" readonly>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2 px-0 pt-3">
                    <a href="{{ route('parts.edit', $part) }}" class="btn btn-warning">
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
