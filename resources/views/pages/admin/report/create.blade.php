@extends('layouts.admin')

@section('title', 'Buat Laporan Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}" class="text-decoration-none">Data Laporan</a></li>
    <li class="breadcrumb-item active">Buat Laporan</li>
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('reports.store') }}" method="POST" id="formCreateReport">
        @csrf

        {{-- ── SECTION 1: Info Laporan ─────────────────────────────── --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                   
                    <h6 class="fw-bold mb-0 fs-5">Informasi Laporan</h6>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Laporan <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', now()->format('Y-m-d')) }}" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kendaraan <span class="text-danger">*</span></label>
                        <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->nopol }} — {{ $vehicle->type }} ({{ $vehicle->unit_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECTION 2: Daftar Kerusakan ─────────────────────────── --}}
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                
                <h6 class="fw-bold mb-0 fs-5">Daftar Kerusakan & Suku Cadang</h6>
            </div>
            <button type="button" class="btn btn-app-secondary btn-sm px-3" id="btnAddIssue">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kerusakan
            </button>
        </div>

        {{-- Issue List --}}
        <div id="issueList">
            {{-- Template akan diklon oleh JS, dan juga dirender ulang jika ada old input --}}
        </div>

        {{-- Empty state --}}
        <div id="emptyIssue" class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                <p class="mb-0">Belum ada kerusakan ditambahkan.<br>
                    <span class="small">Klik <strong>Tambah Kerusakan</strong> untuk mulai mengisi.</span>
                </p>
            </div>
        </div>

        {{-- ── SECTION 3: Grand Total & Submit ─────────────────────── --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                           
                            <div>
                                <div class="fw-bold small fs-5">Total Keseluruhan</div>
                            </div>
                        </div>
                        <div class="fs-3 fw-bold text-gray ms-4" id="grandTotalDisplay">Rp 0</div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('reports.index') }}" class="btn btn-light border px-4">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-app-secondary px-4 btn-submit-report">
                            <span class="button-content"><i class="bi bi-save me-1"></i> Simpan Laporan</span>
                            <span class="spinner-content d-none">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

{{-- ── Hidden Template: Issue Card ─────────────────────────────────── --}}
<template id="issueTemplate">
    <div class="issue-card card border-0 shadow-sm mb-3" data-issue-index="__IDX__">
        <div class="card-body p-4">
            {{-- Issue Header --}}
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge bg-opacity-10 text-gray border border-secondary border-opacity-25 px-2 py-1 rounded-2 issue-number">
                    Kerusakan #<span class="num">1</span>
                </span>
                <div class="flex-grow-1"></div>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-issue">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>

            {{-- Deskripsi Kerusakan --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                <textarea name="issues[__IDX__][issue_description]" class="form-control issue-description" rows="2"
                    style="resize:none;" 
                    placeholder="Contoh: Rem depan aus, perlu penggantian kampas rem..." required></textarea>
                <div class="invalid-feedback d-block issue-error"></div>
            </div>

            {{-- Tabel Suku Cadang --}}
            <div class="mb-2">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <label class="form-label fw-semibold mb-0">
                        <i class="bi bi-box-seam me-1 text-muted"></i> Suku Cadang Digunakan
                    </label>
                    <button type="button" class="btn btn-sm btn-outline-success btn-add-item">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baris
                    </button>
                </div>
                <div class="invalid-feedback d-block items-error text-danger small mb-2"></div>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width:220px;">Nama Suku Cadang</th>
                                <th style="width:110px;">Jumlah</th>
                                <th style="width:170px;">Harga Satuan</th>
                                <th style="width:170px;">Total</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody class="item-list">
                            {{-- rows --}}
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-semibold small">Subtotal Kerusakan</td>
                                <td class="fw-semibold text-end subtotal-display">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="item-empty text-muted small mt-2 ps-1">
                    <i class="bi bi-info-circle me-1"></i> Belum ada suku cadang. Klik <strong>Tambah Baris</strong>.
                </div>
            </div>
        </div>
    </div>
</template>

{{-- ── Hidden Template: Item Row ────────────────────────────────────── --}}
<template id="itemTemplate">
    <tr class="item-row" data-item-index="__IIDX__">
        <td>
            <select name="issues[__IDX__][items][__IIDX__][part_id]"
                class="form-select form-select-sm select-part" required >
                <option value="">-- Pilih Suku Cadang --</option>
                @foreach($parts as $part)
                    <option value="{{ $part->id }}"
                        data-price="{{ $part->base_price }}"
                        data-stock="{{ $part->stock }}">
                        {{ $part->name }}
                        (Stok: {{ $part->stock }})
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback d-block part-error text-danger small"></div>
        </td>
        <td>
            <input type="number" name="issues[__IDX__][items][__IIDX__][quantity]"
                class="form-control form-control-sm input-qty"
                 value="1" required  min="1">
            <div class="invalid-feedback d-block qty-error text-danger small"></div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">Rp</span>
                <input type="number" name="issues[__IDX__][items][__IIDX__][unit_price]"
                    class="form-control input-price"
                    min="0" value="0" required disabled>
            </div>
        </td>
        <td class="text-end fw-semibold total-cell align-middle">Rp 0</td>
        <td class="text-center align-middle">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item px-2">
                <i class="bi bi-x-lg"></i>
            </button>
        </td>
    </tr>
</template>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const partsData = @json($parts->keyBy('id'));
    let issueCount = 0;

    // ── Helpers ──────────────────────────────────────────────────────
    function formatRp(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    function updateSubtotal(issueCard) {
        let sub = 0;
        issueCard.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.input-price').value) || 0;
            const qty   = parseInt(row.querySelector('.input-qty').value)   || 0;
            const total = price * qty;
            row.querySelector('.total-cell').textContent = formatRp(total);
            sub += total;
        });
        issueCard.querySelector('.subtotal-display').textContent = formatRp(sub);
        updateGrandTotal();
    }

    function updateGrandTotal() {
        let grand = 0;
        document.querySelectorAll('.subtotal-display').forEach(el => {
            grand += parseFloat(el.textContent.replace(/[^0-9]/g, '')) || 0;
        });
        document.getElementById('grandTotalDisplay').textContent = formatRp(grand);
    }

    function renumberIssues() {
        document.querySelectorAll('.issue-card').forEach((card, i) => {
            card.querySelector('.issue-number .num').textContent = i + 1;
        });
    }

    function toggleEmpty() {
        const hasIssue = document.querySelectorAll('.issue-card').length > 0;
        document.getElementById('emptyIssue').style.display = hasIssue ? 'none' : '';
    }

    function updateItemEmpty(issueCard) {
        const hasItems = issueCard.querySelectorAll('.item-row').length > 0;
        issueCard.querySelector('.item-empty').style.display = hasItems ? 'none' : '';
    }

    // ── Add Item Row ──────────────────────────────────────────────────
    function addItemRow(issueCard, issueIdx) {
        const itemList  = issueCard.querySelector('.item-list');
        const itemCount = itemList.querySelectorAll('.item-row').length;
        const tmpl      = document.getElementById('itemTemplate').innerHTML
            .replaceAll('__IDX__', issueIdx)
            .replaceAll('__IIDX__', itemCount);

        const tmp = document.createElement('tbody');
        tmp.innerHTML = tmpl;
        const row = tmp.querySelector('tr');
        itemList.appendChild(row);
        bindItemEvents(row, issueCard);
        updateItemEmpty(issueCard);
        updateSubtotal(issueCard);
    }

    function bindItemEvents(row, issueCard) {
        // Pilih part → isi harga otomatis & set max quantity
        row.querySelector('.select-part').addEventListener('change', function () {
            const opt = this.selectedOptions[0];
            const price = opt?.dataset?.price ?? 0;
            const stock = opt?.dataset?.stock ?? 1;
            row.querySelector('.input-price').value = price;
            row.querySelector('.input-qty').max = stock;
            updateSubtotal(issueCard);
        });

        // Qty / price change
        row.querySelector('.input-qty').addEventListener('input', () => updateSubtotal(issueCard));
        row.querySelector('.input-price').addEventListener('input', () => updateSubtotal(issueCard));

        // Remove row
        row.querySelector('.btn-remove-item').addEventListener('click', function () {
            row.remove();
            updateItemEmpty(issueCard);
            updateSubtotal(issueCard);
        });
    }

    // ── Add Issue Card ────────────────────────────────────────────────
    function addIssueCard() {
        const idx  = issueCount++;
        const tmpl = document.getElementById('issueTemplate').innerHTML
            .replaceAll('__IDX__', idx);

        const tmp = document.createElement('div');
        tmp.innerHTML = tmpl;
        const card = tmp.querySelector('.issue-card');

        document.getElementById('issueList').appendChild(card);

        // Remove issue
        card.querySelector('.btn-remove-issue').addEventListener('click', function () {
            card.remove();
            renumberIssues();
            toggleEmpty();
            updateGrandTotal();
        });

        // Add item row
        card.querySelector('.btn-add-item').addEventListener('click', function () {
            addItemRow(card, idx);
        });

        renumberIssues();
        toggleEmpty();
        updateItemEmpty(card);

        // Auto-scroll ke card baru
        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ── Init ──────────────────────────────────────────────────────────
    document.getElementById('btnAddIssue').addEventListener('click', addIssueCard);
    toggleEmpty();

    // Restore old input jika ada validation error
    @if(old('issues'))
        const errors = @json($errors->toArray());
        @foreach(old('issues', []) as $iIdx => $issue)
            (function() {
                addIssueCard();
                const cards = document.querySelectorAll('.issue-card');
                const card  = cards[cards.length - 1];
                const textarea = card.querySelector('textarea');
                textarea.value = @json($issue['issue_description'] ?? '');
                
                // Tampilkan error jika ada
                const issueError = errors['issues.{{ $iIdx }}.issue_description'];
                if (issueError && issueError.length > 0) {
                    textarea.classList.add('is-invalid');
                    card.querySelector('.issue-error').textContent = issueError[0];
                }

                // Tampilkan error items jika ada
                const itemsError = errors['issues.{{ $iIdx }}.items'];
                if (itemsError && itemsError.length > 0) {
                    card.querySelector('.items-error').textContent = itemsError[0];
                }

                @if(!empty($issue['items']))
                    @foreach($issue['items'] as $itemIdx => $item)
                        addItemRow(card, {{ $iIdx }});
                        const rows = card.querySelectorAll('.item-row');
                        const row  = rows[rows.length - 1];
                        const selectPart = row.querySelector('.select-part');
                        selectPart.value  = @json($item['part_id'] ?? '');
                        selectPart.dispatchEvent(new Event('change', { bubbles: true }));
                        row.querySelector('.input-qty').value = @json($item['quantity'] ?? 1);
                        
                        // Tampilkan error jika ada
                        const partError = errors['issues.{{ $iIdx }}.items.{{ $itemIdx }}.part_id'];
                        if (partError && partError.length > 0) {
                            selectPart.classList.add('is-invalid');
                            row.querySelector('.part-error').textContent = partError[0];
                        }
                        
                        const qtyError = errors['issues.{{ $iIdx }}.items.{{ $itemIdx }}.quantity'];
                        if (qtyError && qtyError.length > 0) {
                            row.querySelector('.input-qty').classList.add('is-invalid');
                            row.querySelector('.qty-error').textContent = qtyError[0];
                        }
                        
                        updateSubtotal(card);
                    @endforeach
                @endif
            })();
        @endforeach
    @endif

    // Spinner submit
    document.getElementById('formCreateReport').addEventListener('submit', function () {
        const btn = this.querySelector('.btn-submit-report');
        btn.disabled = true;
        btn.querySelector('.button-content').classList.add('d-none');
        btn.querySelector('.spinner-content').classList.remove('d-none');
    });

})();
</script>
@endpush