
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-4">

            {{-- Welcome Card --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm b text-app-gray overflow-hidden">
                    <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 p-4">
                        <div>
                            <div class="small opacity-75 mb-1">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </div>

                            <h4 class="fw-bold mb-1 text-app-primary">
                                Selamat datang, {{ Auth::user()->name ?? 'Admin' }} 
                            </h4>

                            <p class="mb-0 opacity-75 small">
                                Sistem Informasi Maintanance Kendaraan
                            </p>
                        </div>

                        <img src="{{ asset('assets/img/logo/Logo Simken.svg') }}"
                            class="img-fluid d-none d-sm-block"
                            style="max-height: 60px;"
                            alt="SIMKEN">
                    </div>
                </div>
            </div>

            {{-- Kendaraan & Laporan --}}
            <div class="col-12">
                <div class="d-flex align-items-center mb-3 text-muted small fw-semibold text-uppercase">
                    <i class="bi bi-truck me-2"></i>
                    Kendaraan & Laporan
                </div>

                <div class="row g-3">

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Total Kendaraan
                                    </div>

                                    <h3 class="fw-bold mb-1 text-app-primary">
                                        {{ $stats['total_vehicles'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">Unit Terdaftar</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bx bxs-car"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Total Laporan
                                    </div>

                                    <h3 class="fw-bold mb-1 text-app-primary">
                                        {{ $stats['total_reports'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">Laporan Perbaikan</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Laporan Bulan Ini
                                    </div>

                                    <h3 class="fw-bold mb-1 text-app-primary">
                                        {{ $stats['monthly_reports'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">
                                        {{ now()->translatedFormat('F Y') }}
                                    </small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Biaya Bulan Ini
                                    </div>

                                    <h5 class="fw-bold mb-1 text-app-primary">
                                        Rp {{ number_format($stats['monthly_cost'] ?? 0, 0, ',', '.') }}
                                    </h5>

                                    <small class="text-muted">Total Pengeluaran</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Suku Cadang --}}
            <div class="col-12">
                <div class="d-flex align-items-center mb-3 text-muted small fw-semibold text-uppercase">
                    <i class="bi bi-box-seam me-2"></i>
                    Suku Cadang
                </div>

                <div class="row g-3">

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Total Suku Cadang
                                    </div>

                                    <h3 class="fw-bold mb-1 text-app-primary">
                                        {{ $stats['total_parts'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">Jenis Onderdil</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bx bx-package"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Stok Kritis
                                    </div>

                                    <h3 class="fw-bold text-app-primary mb-1">
                                        {{ $stats['low_stock_parts'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">Stok ≤ 5 Unit</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Stok Masuk
                                    </div>

                                    <h3 class="fw-bold text-app-primary mb-1">
                                        {{ $stats['stock_in_count'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">Transaksi Bulan Ini</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bx bx-trending-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-uppercase text-app-primary small text-muted fw-semibold mb-1">
                                        Stok Keluar
                                    </div>

                                    <h3 class="fw-bold text-app-primary mb-1">
                                        {{ $stats['stock_out_count'] ?? 0 }}
                                    </h3>

                                    <small class="text-muted">Transaksi Bulan Ini</small>
                                </div>

                                <div class="fs-3 text-app-primary">
                                    <i class="bx bx-trending-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Reports --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0 text-app-primary">Laporan Terbaru</h6>
                            <small class="text-muted">5 laporan perbaikan terakhir</small>
                        </div>

                        <a href="{{ route('reports.index') }}" class="text-app-primary text-decoration-none small fw-semibold">
                            Lihat semua
                        </a>
                    </div>

                    <div class="card-body">
                        @forelse($recentReports as $report)
                            <a href="{{ route('reports.show', $report) }}"
                                class="d-flex align-items-center justify-content-between text-decoration-none text-dark border-bottom py-3 gap-3">

                                <div class="d-flex align-items-center gap-3">
                                    <div class=" bg-opacity-10 text-app-primary rounded p-2">
                                        <i class="bi bi-car-front"></i>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $report->vehicle->nopol ?? '-' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $report->vehicle->type ?? '' }}
                                            ·
                                            {{ $report->date->translatedFormat('d M Y') }}
                                        </small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="fw-bold">
                                        Rp {{ number_format($report->grand_total, 0, ',', '.') }}
                                    </div>

                                    @if (isset($report->status))
                                        <span class="badge {{ $report->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                            {{ $report->status === 'active' ? 'Aktif' : 'Dibatalkan' }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard-off fs-1 d-block mb-2"></i>
                                Belum ada laporan
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Low Stock --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0 text-app-primary">Stok Hampir Habis</h6>
                            <small class="text-muted">Onderdil dengan stok ≤ 10 unit</small>
                        </div>

                        <a href="{{ route('parts.index') }}"
                            class="text-app-primary text-decoration-none small fw-semibold">
                            Kelola
                        </a>
                    </div>

                    <div class="card-body">
                        @forelse($lowStockParts  as $part)
                            @php
                                $stock = $part->stock;

                                $progressClass = match (true) {
                                    $stock <= 5 => 'bg-danger',
                                    $stock <= 8 => 'bg-warning',
                                    default => 'bg-secondary',
                                };

                                $width = min(($stock / 10) * 100, 100);
                            @endphp

                            <div class="border-bottom py-3">
                                <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                    <div class="fw-semibold text-truncate">
                                        {{ Str::limit($part->name, 26) }}
                                    </div>

                                    <span class="badge bg-light text-dark border">
                                        {{ $stock }} unit
                                    </span>
                                </div>

                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $progressClass }}"
                                        style="width: {{ $width }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-circle-check fs-1 text-success d-block mb-2"></i>
                                Semua stok dalam kondisi baik
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Quick Action --}}
            <div class="col-12 col-lg-3">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0 text-app-primary">Aksi Cepat</h6>
                        <small class="text-muted">Pintasan menu utama</small>
                    </div>

                    <div class="card-body d-grid gap-2">
                        <a href="{{ route('reports.create') }}" class="btn btn-app-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Buat Laporan
                        </a>

                        <a href="{{ route('vehicles.create') }}" class="btn btn-outline-secondary">
                            <i class="bx bxs-truck me-1"></i>
                            Tambah Kendaraan
                        </a>

                        <a href="{{ route('parts.create') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-package me-1"></i>
                            Tambah Suku Cadang
                        </a>

                        <a href="{{ route('stock_movements.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-transfer me-1"></i>
                            Riwayat Stok
                        </a>

                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-people me-1"></i>
                            Data Pengguna
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
```
