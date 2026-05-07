@extends('layouts.admin')

@section('title', 'Riwayat Pergerakan Stok')

@section('breadcrumb')
    <li class="breadcrumb-item active">Riwayat Stok</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Card: Stock Movement List -->
        <div class="card shadow-sm border-0 mb-4 p-3">
            <div class="card-header bg-white border-0 mb-2">
                <h5 class="card-title fw-semibold mb-4 fs-4">Data Riwayat Pergerakan Stok</h5>
                <div class="row g-2 align-items-center">
                    <!-- Search -->
                    <div class="col-12 col-md-6">
                        <form method="GET" class="w-100 d-flex align-items-center gap-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                                    placeholder="Cari nama suku cadang atau nama user...">
                                <button class="btn btn-outline-secondary border btn-search-stock" type="submit">
                                    <span class="button-content">Cari</span>
                                    <span class="spinner-content d-none">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                    </span>
                                </button>
                            </div>
                            <a href="{{ url()->current() }}"
                                 class="btn btn-secondary border d-flex align-items-center gap-1 {{ request('search') || request('type') ? '' : 'd-none' }}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                <span>Reset</span>
                            </a>
                        </form>
                    </div>

                    {{-- Filter Type --}}
                    <div class="col-12 col-md-auto ms-md-auto">
                        <form method="GET" class="d-flex align-items-center gap-2">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()"
                                style="min-width:150px;">
                                <option value="">Semua Tipe</option>
                                <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Stok Masuk</option>
                                <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Stok Keluar
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-start">
                                <th>#</th>
                                <th>Suku Cadang</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Operator</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockMovements as $movement)
                                @php
                                    $isIn = $movement->type === 'in';
                                @endphp
                                <tr>
                                    <td>{{ $stockMovements->firstItem() + $loop->index }}</td>

                                    {{-- Suku Cadang --}}
                                    <td>
                                        <div class="fw-semibold">{{ $movement->part->name ?? '-' }}</div>
                                    </td>

                                    {{-- Tipe Badge --}}
                                    <td>
                                        @if ($isIn)
                                            <span
                                                class="badge bg-opacity-15 text-success border border-success border-opacity-25 px-2 py-1">
                                                <i class="bi bi-arrow-up me-1"></i> Masuk
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-opacity-15 text-warning border border-warning border-opacity-25 px-2 py-1">
                                                <i class="bi bi-arrow-down me-1"></i> Keluar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Jumlah --}}
                                    <td>
                                        <span class="fw-bold {{ $isIn ? 'text-success' : 'text-warning' }}">
                                            {{ $isIn ? '+' : '-' }}{{ $movement->quantity }} unit
                                        </span>
                                    </td>



                                    {{-- Keterangan / Note --}}
                                    <td>
                                        @if ($movement->note)
                                            <span class="text-truncate d-inline-block" style="max-width:200px;"
                                                title="{{ $movement->note }}">
                                                {{ $movement->note }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    {{-- Operator --}}
                                    <td>
                                        @if ($movement->user)
                                            <div class="d-flex align-items-center gap-2">
                                              
                                                <span class="small">{{ $movement->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="small text-muted">
                                        {{ $movement->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        Tidak ada riwayat pergerakan stok ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <div class="small text-muted">
                        Halaman <strong>{{ $stockMovements->currentPage() }}</strong> dari
                        <strong>{{ $stockMovements->lastPage() }}</strong><br>
                        Menampilkan <strong>{{ $stockMovements->perPage() }}</strong> data per halaman (total
                        <strong>{{ $stockMovements->total() }}</strong> transaksi)
                    </div>
                    <div>{{ $stockMovements->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Spinner for search button
            document.querySelectorAll('form input[name="search"]').forEach(function(input) {
                var form = input.closest('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        var btn = form.querySelector('.btn-search-stock');
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
