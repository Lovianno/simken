<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Http\Requests\PartRequest;
use App\Services\PartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartController
{
    public function __construct(private PartService $partService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $parts = $this->partService->getAll($search);

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
        try {
            $this->partService->create($request->validated());
            return redirect()->route('parts.index')->with('success', 'Data Suku Cadang berhasil ditambahkan.');
        } catch (\Exception $e) {
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
        try {
            $this->partService->update($part, $request->validated());
            return redirect()->route('parts.index')->with('success', 'Data Suku Cadang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui suku cadang. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part)
    {
        $this->partService->delete($part);
        return redirect()->route('parts.index')->with('success', 'Data Suku Cadang berhasil dihapus.');
    }

    /**
     * Add stock to the part.
     */

    public function formStock(Part $part)
    {
        return view('pages.admin.part.stock', compact('part'));
    }
    public function addStock(Request $request, Part $part): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Jumlah stok wajib diisi.',
            'quantity.integer' => 'Jumlah stok harus berupa angka.',
            'quantity.min' => 'Jumlah stok minimal 1.',
        ]);

        $data['dataStockMovement'] = [
            'part_id' => $part->getKey(),
            'type' => 'in',
            'quantity' => $data['quantity'],
            'note' => "Penambahan stok sebanyak {$data['quantity']} item",
            'user_id' => Auth::id(),
        ];

        try {
            $this->partService->addStock($part, $data);
            return redirect()->route('parts.index')->with('success', "Stok berhasil ditambahkan sebanyak {$data['quantity']} unit.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambah stok. Silakan coba lagi.']);
        }
    }

    /**
     * Reduce stock from the part.
     */
    public function reduceStock(Request $request, Part $part) 
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', "max:{$part->stock}"],
            'note' => ['required', 'string', 'max:500'],
        ], 
        [
            'quantity.required' => 'Jumlah stok wajib diisi.',
            'quantity.integer' => 'Jumlah stok harus berupa angka.',
            'quantity.min' => 'Jumlah stok minimal 1.',
            'quantity.max' => "Jumlah stok tidak boleh lebih dari {$part->stock} unit.",
            'note.required' => 'Alasan pengurangan stok wajib diisi.',
            'note.string' => 'Alasan pengurangan stok harus berupa teks.',
            'note.max' => 'Alasan pengurangan stok maksimal 500 karakter.',
        ]);

        $data['dataStockMovement'] = [
            'part_id' => $part->getKey(),
            'type' => 'out',
            'quantity' => $data['quantity'],
            'note' => $data['note'],
            'user_id' => Auth::id(),
        ];
        try {
            $this->partService->reduceStock($part, $data);
            return redirect()->route('parts.index')->with('success', "Stok berhasil dikurangi sebanyak {$data['quantity']} unit.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengurangi stok. Silakan coba lagi.']);
        }
    }
}
