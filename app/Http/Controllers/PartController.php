<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Http\Requests\PartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // All parts
        $parts = Part::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })
            ->orderByDesc('updated_at')
            ->paginate(10);

        $currentPage = $parts->currentPage();
        $lastPage = $parts->lastPage();
        $perPage = $parts->perPage();
        $total = $parts->total();

        return view('pages.admin.part.index', compact(
            'parts',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.part.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $part = Part::query()->create($data);

            DB::commit();
            return redirect()->route('parts.index')->with('success', 'Data Suku Cadang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menambah suku cadang. Silakan coba lagi.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Part $part)
    {
        return view('pages.admin.part.show', compact('part'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Part $part)
    {
        return view('pages.admin.part.edit', compact('part'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartRequest $request, Part $part)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $part->update($data);

            DB::commit();
            return redirect()->route('parts.index')->with('success', 'Data Suku Cadang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui suku cadang. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->route('parts.index')->with('success', 'Data Suku Cadang berhasil dihapus.');
    }

    /**
     * Add stock to the part.
     */
    public function addStock(Request $request, Part $part): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Jumlah stok wajib diisi.',
            'quantity.integer' => 'Jumlah stok harus berupa angka.',
            'quantity.min' => 'Jumlah stok minimal 1.',
        ]);

        DB::beginTransaction();
        try {
            $part->increment('stock', $validated['quantity']);

            DB::commit();
            return redirect()->route('parts.index')->with('success', "Stok berhasil ditambahkan sebanyak {$validated['quantity']} unit.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambah stok. Silakan coba lagi.']);
        }
    }

    /**
     * Reduce stock from the part.
     */
    public function reduceStock(Request $request, Part $part): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', "max:{$part->stock}"],
        ], [
            'quantity.required' => 'Jumlah stok wajib diisi.',
            'quantity.integer' => 'Jumlah stok harus berupa angka.',
            'quantity.min' => 'Jumlah stok minimal 1.',
            'quantity.max' => "Jumlah stok tidak boleh lebih dari {$part->stock} unit.",
        ]);

        DB::beginTransaction();
        try {
            $part->decrement('stock', $validated['quantity']);

            DB::commit();
            return redirect()->route('parts.index')->with('success', "Stok berhasil dikurangi sebanyak {$validated['quantity']} unit.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengurangi stok. Silakan coba lagi.']);
        }
    }
}
