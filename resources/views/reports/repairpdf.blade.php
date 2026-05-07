<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Favicon -->
	<link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Perbaikan — {{ $report->vehicle->nopol }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #1a1a1a;
            background: #fff;
            padding: 40px 50px;
        }

        /* ── Header ─────────────────────────────────────────── */
        .header {
            text-align: center;
            border-bottom: 3px solid #1a1a1a;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .header .company-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        .header .doc-subtitle {
            font-size: 9pt;
            color: #555;
            margin-top: 3px;
        }

        /* ── Info Kendaraan ──────────────────────────────────── */
        .info-section {
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 10.5pt;
            vertical-align: top;
        }

        .info-table td.label {
            width: 160px;
            font-weight: bold;
        }

        .info-table td.colon {
            width: 14px;
            text-align: center;
        }

        .info-table td.value {
            padding-left: 4px;
        }

        /* ── Main Table ──────────────────────────────────────── */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10.5pt;
        }

        .report-table th {
            background-color: #1e3a8a;
            color: #fff;
            padding: 8px 10px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #1e3a8a;
        }

        .report-table td {
            padding: 7px 10px;
            border: 1px solid #ccc;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .report-table .issue-label {
            font-weight: bold;
        }

        .report-table .td-center {
            text-align: center;
        }

        .report-table .td-right {
            text-align: right;
        }

        /* ── Grand Total Row ─────────────────────────────────── */
        .grand-total-row td {
            background-color: #fff !important;
            color: #1a1a1a;
            font-weight: bold;
            padding: 9px 10px;
        }

        /* ── Footer / TTD ────────────────────────────────────── */
        .footer-section {
            margin-top: 30px;
        }

        .ttd-table {
            width: 100%;
        }

        .ttd-table td {
            vertical-align: top;
            font-size: 10.5pt;
        }

        .ttd-block {
            text-align: center;
            width: 200px;
        }

        .ttd-block .ttd-title {
            margin-bottom: 4px;
        }

        .ttd-block .ttd-space {
            height: 70px;
        }

        .ttd-block .ttd-line {
            border-top: 1.5px solid #1a1a1a;
            padding-top: 4px;
            font-weight: bold;
        }

        .ttd-block .ttd-role {
            font-size: 9.5pt;
            color: #555;
        }

        /* ── Watermark jika diperlukan ───────────────────────── */
        .page-number {
            text-align: right;
            font-size: 8.5pt;
            color: #999;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    {{-- ── HEADER ──────────────────────────────────────────────────── --}}
    <div class="header">
        {{-- <div class="company-name">{{ config('app.name', 'Workshop') }}</div> --}}
        <div class="doc-title">Laporan Perbaikan &amp; Rincian Onderdil</div>
        {{-- <div class="doc-subtitle">Dokumen resmi bengkel kendaraan</div> --}}
    </div>

    {{-- ── INFO KENDARAAN ──────────────────────────────────────────── --}}
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">No. Polisi Kendaraan</td>
                <td class="colon">:</td>
                <td class="value">{{ $report->vehicle->nopol ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tipe Kendaraan</td>
                <td class="colon">:</td>
                <td class="value">{{ $report->vehicle->type . ' ' . $report->vehicle->year . ' ' . $report->vehicle->model ?? '-' }}</td>
            </tr>
            @if($report->vehicle->unit_number)
            <tr>
                <td class="label">Nomor Unit / Lambung</td>
                <td class="colon">:</td>
                <td class="value">{{ $report->vehicle->unit_number }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Tanggal Laporan</td>
                <td class="colon">:</td>
                <td class="value">{{ $report->date->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Dibuat Oleh</td>
                <td class="colon">:</td>
                <td class="value">{{ $report->user->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- ── TABEL KERUSAKAN & ONDERDIL ─────────────────────────────── --}}
    <table class="report-table">
        <thead>
            <tr>
                <th style="width:28%;">Kategori Kerusakan</th>
                <th style="width:30%;">Nama Onderdil</th>
                <th style="width:7%;">Jml</th>
                <th style="width:17%;">Harga Satuan</th>
                <th style="width:18%;">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->reportIssue as $issue)
                @php
                    $items     = $issue->reportItem;
                    $itemCount = $items->count();
                @endphp

                @if($itemCount === 0)
                    {{-- Issue tanpa item --}}
                    <tr>
                        <td class="issue-label">{{ $issue->issue_description }}</td>
                        <td colspan="4" class="td-center" style="color:#999;font-style:italic;">
                            Tidak ada suku cadang
                        </td>
                    </tr>
                @else
                    @foreach($items as $i => $item)
                        <tr>
                            @if($i === 0)
                                <td class="issue-label" rowspan="{{ $itemCount }}">
                                    {{ $issue->issue_description }}
                                </td>
                            @endif
                            <td>{{ $item->part->name ?? '-' }}</td>
                            <td class="td-center">{{ $item->quantity }}</td>
                            <td class="td-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="td-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="grand-total-row">
                <td colspan="4" style="text-align:right;letter-spacing:0.5px;">
                    GRAND TOTAL KESELURUHAN
                </td>
                <td style="text-align:right;">
                    Rp {{ number_format($report->grand_total, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- ── TANDA TANGAN ─────────────────────────────────────────────── --}}
    <div class="footer-section">
        <table class="ttd-table">
            <tr>
                <td>
                    {{-- Kiri: Kota & Tanggal --}}
                    <div style="font-size:10.5pt;">
                        Surabaya, {{ $report->date->translatedFormat('d F Y') }}
                    </div>
                </td>
                <td style="text-align:right;">
                    <div class="ttd-block" style="display:inline-block;">
                        <div class="ttd-title">Admin Workshop,</div>
                        <div class="ttd-space"></div>
                        <div class="ttd-line">{{ $report->user->name ?? '................................' }}</div>
                        <div class="ttd-role">Admin Workshop</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── PAGE INFO ────────────────────────────────────────────────── --}}
    <div class="page-number">
        Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>