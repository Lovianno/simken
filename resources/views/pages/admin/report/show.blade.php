@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}" class="text-decoration-none">Data Laporan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Laporan</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0 mb-4 p-3">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold fs-4">Detail Laporan</h5>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Laporan</label>
                            <input type="text" class="form-control" value="{{ $report->date->format('d M Y') }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor Polisi</label>
                            <input type="text" class="form-control" value="{{ $report->vehicle->nopol ?? '-' }}"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Kendaraan</label>
                            <input type="text" class="form-control" value="{{ $report->vehicle->category ?? '-' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tipe Kendaraan</label>
                            <input type="text" class="form-control" value="{{ $report->vehicle->type ?? '-' }}" readonly>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Kendaraan</label>
                            <input type="text" class="form-control" value="{{ $report->vehicle->year ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor Lambung</label>
                            <input type="text" class="form-control" value="{{ $report->vehicle->unit_number ?? '-' }}" readonly>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Nama Pembuat</label>
                            <input type="text" class="form-control" value="{{ $report->user->name ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>

                @if ($report->reportIssue && $report->reportIssue->count() > 0)
                    <hr>
                    <h6 class="fw-semibold mb-3">Daftar Item Laporan</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr class="text-center bg-light">
                                    <th>Kerusakan</th>
                                    <th>Nama Suku Cadang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report->reportIssue as $issue)
                                    @php
                                        $issueItems = $issue->reportItem;
                                        $isFirstItem = true;
                                    @endphp
                                    @foreach ($issueItems as $item)
                                        <tr>
                                            @if ($isFirstItem)
                                                <td rowspan="{{ $issueItems->count() }}" class="align-middle fw-semibold">
                                                    {{ $issue->issue_description ?? '-' }}
                                                </td>
                                                @php $isFirstItem = false; @endphp
                                            @endif
                                            <td>{{ $item->part->name ?? '-' }}</td>
                                            <td class="text-center">{{ $item->quantity ?? '-' }}</td>
                                            <td class="text-end">Rp
                                                {{ number_format($item->unit_price ?? 0, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp
                                                {{ number_format($item->total_price ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-light fw-semibold">
                                    <td colspan="4" class="text-end">GRAND TOTAL KESELURUHAN</td>
                                    <td class="text-end">Rp {{ number_format($report->grand_total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Dibuat Pada</label>
                            <input type="text" class="form-control"
                                value="{{ $report->created_at->translatedFormat('d F Y, H:i') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Diperbarui Pada</label>
                            <input type="text" class="form-control"
                                value="{{ $report->updated_at->translatedFormat('d F Y, H:i') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2 px-0 pt-3">
                    <a href="{{ route('reports.edit', $report) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-4 shadow-lg border-0 p-2">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2 w-100">
                        <i class="bi bi-exclamation-triangle text-danger fs-3 me-2"></i>
                        <div class="grow">
                            <h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Hapus</h5>
                            <small class="text-muted">Tindakan ini tidak dapat dibatalkan</small>
                        </div>
                        <button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body pt-3 pb-0 px-4">
                    <p class="mb-3 fs-6">Hapus laporan tanggal <strong>{{ $report->date->format('d M Y') }}</strong> untuk
                        kendaraan <strong>{{ $report->vehicle->nopol }}</strong>?</p>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('reports.destroy', $report) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 btn-delete-report">
                            <span class="button-content"><i class="bi bi-trash me-1"></i> Hapus</span>
                            <span class="spinner-content d-none">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Menghapus...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Spinner for delete button in modal
            document.querySelector('form[action*="destroy"]')?.addEventListener('submit', function(e) {
                var btn = this.querySelector('.btn-delete-report');
                if (btn) {
                    btn.disabled = true;
                    btn.querySelector('.button-content').classList.add('d-none');
                    btn.querySelector('.spinner-content').classList.remove('d-none');
                }
            });
        });
    </script>
@endpush
