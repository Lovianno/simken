@extends('layouts.admin')

@section('title', 'Riwayat Perbaikan — ' . $vehicle->nopol)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}" class="text-decoration-none">Data Kendaraan</a></li>
    <li class="breadcrumb-item"><a href="{{ route('vehicles.show', $vehicle) }}" class="text-decoration-none">{{ $vehicle->nopol }}</a></li>
    <li class="breadcrumb-item active">Riwayat Perbaikan</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- ── Info Kendaraan ──────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-auto">
                    <div class="rounded-3 bg-app-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:56px;height:56px;">
                        <i class="bx bxs-car text-app-white fs-3"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="text-muted small mb-1">Kendaraan</div>
                    <h5 class="fw-bold mb-1">{{ $vehicle->nopol }}</h5>
                    <div class="d-flex flex-wrap gap-2">
                         @if($vehicle->category)
                        <span class="badge bg-app-primary bg-opacity-10 text-app-white border border-app-primary border-opacity-25 px-2 py-1">
                            <i class="bx bx-tag me-1"></i>{{ $vehicle->category }}
                        </span>
                        @endif
                        <span class="badge bg-app-primary bg-opacity-10 text-app-white border border-app-primary border-opacity-25 px-2 py-1">
                            <i class="bx bx-car me-1"></i>{{ $vehicle->type .' '. $vehicle->year }}
                        </span>
                       
                       
                        <span class="badge bg-app-primary bg-opacity-10 text-app-white border border-app-primary border-opacity-25 px-2 py-1">
                            <i class="bx bx-barcode me-1"></i>{{ $vehicle->unit_number }}
                        </span>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <div class="text-muted small mb-1">Total Perbaikan</div>
                    <div class="fs-3 fw-bold text-app-primary">{{ $reports->total() }}</div>
                    <div class="text-muted small">laporan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Timeline ─────────────────────────────────────────────────── --}}
    @if($reports->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="bx bx-clipboard fs-1 d-block mb-3 opacity-25"></i>
                <p class="mb-0 fw-semibold">Belum ada riwayat perbaikan</p>
                <small>Kendaraan ini belum pernah memiliki laporan perbaikan.</small>
            </div>
        </div>
    @else
        {{-- Group by year --}}
        @php
            $grouped = $reports->getCollection()->groupBy(fn($r) => $r->date->format('Y'));
        @endphp

        @foreach($grouped as $year => $yearReports)
            {{-- Year label --}}
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-app-primary text-white rounded-2 px-3 py-1 fw-bold small">{{ $year }}</div>
                <div class="flex-grow-1 border-top"></div>
                <div class="text-muted small">{{ $yearReports->count() }} laporan</div>
            </div>

            <div class="timeline mb-4 ps-2">
                @foreach($yearReports as $report)
                    @php
                        $issueCount = $report->reportIssue?->count() ?? 0;
                        $totalItems = $report->reportIssue?->sum(fn($i) => $i->reportItem?->count() ?? 0) ?? 0;
                    @endphp

                    <div class="timeline-item mb-3">
                        <div class="d-flex gap-3">
                            {{-- Dot + line --}}
                            <div class="timeline-dot-wrap d-flex flex-column align-items-center flex-shrink-0" style="width:20px;">
                                <div class="rounded-circle bg-app-primary border border-3 border-white shadow-sm flex-shrink-0"
                                    style="width:14px;height:14px;margin-top:6px;"></div>
                                @if(!$loop->last)
                                    <div class="flex-grow-1 border-start border-2 border-app-primary border-opacity-25 mt-1"></div>
                                @endif
                            </div>

                            {{-- Card --}}
                            <a href="{{ route('reports.show', $report) }}"
                                class="card border-0 shadow-sm flex-grow-1 mb-0 text-decoration-none text-dark repair-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="text-muted small">
                                                    <i class="bx bx-calendar me-1"></i>
                                                    {{ $report->date->translatedFormat('d F Y') }}
                                                </span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="badge  bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                                                    <i class="bx bx-wrench me-1"></i>{{ $issueCount }} kerusakan
                                                </span>
                                                <span class="badge  bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1">
                                                    <i class="bx bx-box me-1"></i>{{ $totalItems }} suku cadang
                                                </span>
                                            </div>

                                            {{-- Preview issue descriptions --}}
                                            @if($issueCount > 0)
                                                <ul class="mb-0 mt-2 ps-3">
                                                    @foreach($report->reportIssue->take(3) as $issue)
                                                        <li class="small text-muted">
                                                            {{ Str::limit($issue->issue_description, 60) }}
                                                        </li>
                                                    @endforeach
                                                    @if($issueCount > 3)
                                                        <li class="small text-muted fst-italic">
                                                            +{{ $issueCount - 3 }} kerusakan lainnya...
                                                        </li>
                                                    @endif
                                                </ul>
                                            @endif
                                        </div>

                                        <div class="text-end flex-shrink-0">
                                            <div class="text-muted small mb-1">Total Biaya</div>
                                            <div class="fw-bold text-app-primary">
                                                Rp {{ number_format($report->grand_total, 0, ',', '.') }}
                                            </div>
                                            <div class="text-muted small mt-2">
                                                {{ $report->user->name ?? '-' }}
                                            </div>
                                            <div class="text-app-primary small mt-1">
                                                Lihat Detail <i class="bx bx-chevron-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
            <div class="small text-muted">
                Halaman <strong>{{ $reports->currentPage() }}</strong> dari <strong>{{ $reports->lastPage() }}</strong>
                (total <strong>{{ $reports->total() }}</strong> laporan)
            </div>
            <div>{{ $reports->links() }}</div>
        </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .repair-card {
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .repair-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.10) !important;
    }
</style>
@endpush