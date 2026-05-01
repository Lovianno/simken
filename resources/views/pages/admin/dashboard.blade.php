@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                            <div class="text-center text-md-start">
                                <h4 class="mb-1 fw-bold text-app-primary">
                                    Dashboard Admin SIMKEN
                                </h4>
                                <div class="text-muted">
                                    Ringkasan data pengguna, kursus, dan transaksi
                                </div>

                            </div>
                            <img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" class="img-fluid d-none d-sm-block"
                                style="max-height: 64px" alt="Welcome" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            {{-- Guru Aktif --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-success p-2 mb-2">
                            <i class="bi bi-person-check text-success"></i>
                        </span>
                        <div class="fw-semibold text-muted">Guru Aktif</div>
                        <div class="fs-3 fw-bold">{{ $stats['teacher_active'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Siswa Aktif --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-info p-2 mb-2">
                            <i class="bi bi-person-badge text-info"></i>
                        </span>
                        <div class="fw-semibold text-muted">Siswa Aktif</div>
                        <div class="fs-3 fw-bold">{{ $stats['student_active'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Pengguna Pending --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-warning p-2 mb-2">
                            <i class="bi bi-clock text-warning"></i>
                        </span>
                        <div class="fw-semibold text-muted">Pengguna Pending</div>
                        <div class="fs-3 fw-bold">{{ $stats['user_pending'] ?? '-' }}</div>
                    </div>
                </div>
            </div>



            {{-- Kursus --}}
            {{-- Total Kursus --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-primary p-2 mb-2">
                            <i class="bi bi-book text-primary"></i>
                        </span>
                        <div class="fw-semibold text-muted">Total Kursus</div>
                        <div class="fs-3 fw-bold">{{ $stats['total_course'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Kursus Aktif --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-success p-2 mb-2">
                            <i class="bi bi-journal-check text-success"></i>
                        </span>
                        <div class="fw-semibold text-muted">Kursus Aktif</div>
                        <div class="fs-3 fw-bold">{{ $stats['course_active'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Kursus Pending --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-warning p-2 mb-2">
                            <i class="bi bi-clock text-warning"></i>
                        </span>
                        <div class="fw-semibold text-muted">Kursus Pending</div>
                        <div class="fs-3 fw-bold">{{ $stats['course_pending'] ?? '-' }}</div>
                    </div>
                </div>
            </div>



            {{-- Transaksi --}}
            {{-- Total Transaksi --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-primary p-2 mb-2">
                            <i class="bi bi-receipt text-primary"></i>
                        </span>
                        <div class="fw-semibold text-muted">Total Transaksi</div>
                        <div class="fs-3 fw-bold">{{ $stats['total_transaction'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Transaksi Pending --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-warning p-2 mb-2">
                            <i class="bi bi-clock-history text-warning"></i>
                        </span>
                        <div class="fw-semibold text-muted">Transaksi Pending</div>
                        <div class="fs-3 fw-bold">{{ $stats['transaction_pending'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Pendapatan Hari Ini --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-success p-2 mb-2">
                            <i class="bi bi-cash-coin text-success"></i>
                        </span>
                        <div class="fw-semibold text-muted">Pendapatan Hari Ini</div>
                        <div class="fs-3 fw-bold">
                            Rp {{ number_format($stats['today_income'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pendapatan Bulanan --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-label-info p-2 mb-2">
                            <i class="bi bi-graph-up-arrow text-info"></i>
                        </span>
                        <div class="fw-semibold text-muted">Pendapatan Bulanan</div>
                        <div class="fs-3 fw-bold">
                            Rp {{ number_format($stats['monthly_income'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>




            <!-- Quick Actions -->
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-semibold mb-1">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <a href="/" class="btn btn-outline-success w-100">
                                    <i class="bi bi-person-plus me-1 "></i>
                                    <span class="">Tambah Pengguna</span>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="/" class="btn btn-outline-info w-100">
                                    <i class="bi bi-journal-plus me-1 "></i>
                                    <span class="">Tambah Kursus</span>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="/" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-clipboard-check me-1 "></i>
                                    <span class="">Konfirmasi Pembayaran</span>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="/" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-bookmark me-1 "></i>
                                    <span class="">Tambah Kategori</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Items -->
    </div>
@endsection
