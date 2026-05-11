<?php

namespace App\Services;

use App\Models\Part;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartService
{
    public function __construct(private StockMovementService $StockMovementService) {}

    public function getAll(?string $search = null, int $perPage = 10)
    {
        return Part::query()
            ->when($search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }

    public function getPartOptions()
    {
        return Part::where('stock', '>', 0)->orderBy('name')->get();
    }

    public function getPartById(int $id): Part
    {
        return Part::findOrFail($id);
    }

    public function getPartByIdWithLock(int $id): Part
    {
        return Part::lockForUpdate()->findOrFail($id);
    }

    // ── MINOR 1: Ganti manual transaction → DB::transaction() ──
    public function create(array $data): Part
    {
        return DB::transaction(fn() => Part::create($data));
    }

    // ── MINOR 1: Ganti manual transaction → DB::transaction() ──
    public function update(Part $part, array $data): bool
    {
        return DB::transaction(fn() => $part->update($data));
    }

    public function delete(Part $part): ?bool
    {
        return $part->delete();
    }

    public function addStock(Part $part, int $quantity, string $note, bool $useTransaction = true): bool
    {
        $partId   = $part->getKey();
        $movement = [
            'part_id'  => $partId,
            'type'     => 'in',
            'quantity' => $quantity,
            'note'     => $note,
            'user_id'  => Auth::id(),
        ];

        $execute = function () use ($partId, $quantity, $movement, $useTransaction, $part) {
            // Jika standalone, ambil ulang dengan lock
            // Jika dari parent transaction, pakai instance yang sudah di-lock
            $lockedPart = $useTransaction
                ? $this->getPartByIdWithLock($partId)
                : $part;

            $lockedPart->increment('stock', $quantity);
            $this->StockMovementService->recordStockMovement($movement);
        };

        // ── MINOR 1: Ganti manual try/catch → DB::transaction() ──
        if ($useTransaction) {
            DB::transaction($execute);
        } else {
            $execute();
        }

        return true;
    }

    public function reduceStock(Part $part, int $quantity, string $note, bool $useTransaction = true): bool
    {
        $partId = $part->getKey();

      
        if ($part->stock < $quantity) {
            throw new \Exception(
                "Stok {$part->name} tidak cukup. Dibutuhkan {$quantity}, tersedia {$part->stock}"
            );
        }

        $movement = [
            'part_id'  => $partId,
            'type'     => 'out',
            'quantity' => $quantity,
            'note'     => $note,
            'user_id'  => Auth::id(),
        ];

        $execute = function () use ($partId, $quantity, $movement, $useTransaction, $part) {
            // Jika standalone, ambil ulang dengan lock
            // Jika dari parent transaction, pakai instance yang sudah di-lock
            $lockedPart = $useTransaction
                ? $this->getPartByIdWithLock($partId)
                : $part;

            // ── Re-validasi setelah lock — ini yang benar-benar terpercaya ──
            if ($lockedPart->stock < $quantity) {
                throw new \Exception(
                    "Stok {$lockedPart->name} tidak cukup. Dibutuhkan {$quantity}, tersedia {$lockedPart->stock}"
                );
            }

            $lockedPart->decrement('stock', $quantity);
            $this->StockMovementService->recordStockMovement($movement);
        };

        // ── MINOR 1: Ganti manual try/catch → DB::transaction() ──
        if ($useTransaction) {
            DB::transaction($execute);
        } else {
            $execute();
        }

        return true;
    }
}