@extends('layouts.admin')

@section('title', 'Kelola Stok — ' . $part->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('parts.index') }}">Data Suku Cadang</a></li>
    <li class="breadcrumb-item active">Kelola Stok</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 ">

            {{-- Info Part --}}
           {{-- Info Part --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex align-items-center gap-3 p-4">
        <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:48px;height:48px;">
            <i class="bx bx-wrench" style="font-size:20px;opacity:.6;"></i>
        </div>
        <div class="flex-grow-1 min-width-0">
            <div class="text-muted small mb-1">Suku Cadang</div>
            <h5 class="mb-0 fw-bold">{{ $part->name }}</h5>
            @if($part->description)
                <small class="text-muted">{{ Str::limit($part->description, 60) }}</small>
            @endif
        </div>
        <div class="text-end flex-shrink-0">
            <div class="text-muted small mb-1">Stok Saat Ini</div>
            <span class="fs-3 fw-bold {{ $part->stock == 0 ? 'text-danger' : ($part->stock <= 10 ? 'text-warning' : 'text-success') }}">
                {{ $part->stock }}
            </span>
            <div class="text-muted small">unit tersedia</div>
            @if($part->stock == 0)
                <span class="badge rounded-pill mt-1" style="background:#FCEBEB;color:#A32D2D;font-size:11px;">
                    <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#E24B4A;margin-right:4px;"></span>Stok habis
                </span>
            @elseif($part->stock <= 10)
                <span class="badge rounded-pill mt-1" style="background:#FAEEDA;color:#854F0B;font-size:11px;">
                    <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#BA7517;margin-right:4px;"></span>Stok menipis
                </span>
            @else
                <span class="badge rounded-pill mt-1" style="background:#EAF3DE;color:#3B6D11;font-size:11px;">
                    <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#639922;margin-right:4px;"></span>Stok aman
                </span>
            @endif
        </div>
    </div>
</div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-4">Pilih Jenis Perubahan Stok</h6>

                    {{-- Radio Toggle --}}
                    <div class="row g-3 mb-4" id="stockTypeSelector">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="stock_type" id="typeAdd" value="add" checked>
                            <label class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center gap-1 stock-type-label" for="typeAdd">
                                <i class="bx bx-plus-circle fs-4"></i>
                                <span class="fw-semibold">Tambah Stok</span>
                                <small class="fw-normal opacity-75">Penerimaan / pembelian</small>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="stock_type" id="typeReduce" value="reduce">
                            <label class="btn btn-outline-warning w-100 py-3 d-flex flex-column align-items-center gap-1 stock-type-label" for="typeReduce">
                                <i class="bx bx-minus-circle fs-4"></i>
                                <span class="fw-semibold">Kurangi Stok</span>
                                <small class="fw-normal opacity-75">Pemakaian / penyesuaian</small>
                            </label>
                        </div>
                    </div>

                    <hr class="mb-4">

                    {{-- Form Tambah Stok --}}
                    <form id="formAdd" action="{{ route('parts.addStock', $part->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Ditambahkan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-plus"></i></span>
                                <input type="number" name="quantity" class="form-control form-control-lg"
                                    min="1" required placeholder="Contoh: 10"
                                    value="{{ old('quantity') }}">
                                <span class="input-group-text">unit</span>
                            </div>
                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('parts.index') }}" class="btn btn-light border px-4">
                                <i class="bx bx-arrow-back me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success px-4 btn-submit">
                                <span class="button-content"><i class="bx bx-save me-1"></i> Simpan Perubahan</span>
                                <span class="spinner-content d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>

                    {{-- Form Kurangi Stok --}}
                    <form id="formReduce" action="{{ route('parts.reduceStock', $part->id) }}" method="POST" class="d-none">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Dikurangi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-minus"></i></span>
                                <input type="number" name="quantity" class="form-control form-control-lg"
                                    min="1" max="{{ $part->stock }}" required placeholder="Contoh: 5"
                                    value="{{ old('quantity') }}">
                                <span class="input-group-text">unit</span>
                            </div>
                            <small class="text-muted">Maksimal {{ $part->stock }} unit</small>
                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alasan Pengurangan <span class="text-danger">*</span></label>
                            <textarea name="note" class="form-control" rows="4"
                                style="resize:none;" required
                                placeholder="Contoh: Pemakaian servis unit UNIT-001...">{{ old('note') }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                            @error('note')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('parts.index') }}" class="btn btn-light border px-4">
                                <i class="bx bx-arrow-back me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 btn-submit">
                                <span class="button-content"><i class="bx bx-save me-1"></i> Simpan Perubahan</span>
                                <span class="spinner-content d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="stock_type"]');
    const formAdd = document.getElementById('formAdd');
    const formReduce = document.getElementById('formReduce');

    function switchForm(type) {
        if (type === 'add') {
            formAdd.classList.remove('d-none');
            formReduce.classList.add('d-none');
        } else {
            formAdd.classList.add('d-none');
            formReduce.classList.remove('d-none');
        }
    }

    radios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            switchForm(this.value);
        });
    });

    // Spinner saat submit
    [formAdd, formReduce].forEach(function (form) {
        form.addEventListener('submit', function () {
            const btn = form.querySelector('.btn-submit');
            if (btn) {
                btn.disabled = true;
                btn.querySelector('.button-content').classList.add('d-none');
                btn.querySelector('.spinner-content').classList.remove('d-none');
            }
        });
    });

    // Jika ada validation error, tampilkan form yang sesuai
    @if($errors->has('note'))
        document.getElementById('typeReduce').checked = true;
        switchForm('reduce');
    @endif
});
</script>
@endpush