<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = $this->userService->getAll($search);

        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();
        $perPage = $users->perPage();
        $total = $users->total();

        return view('pages.admin.user.index', compact(
            'users',
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

        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userService->create($request->validated());
            return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['register' => 'Terjadi kesalahan saat menambah pengguna. Silakan coba lagi.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return view('pages.admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        return view('pages.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $this->userService->update($user, $request->validated());
            return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['register' => 'Terjadi kesalahan saat memperbarui pengguna. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->delete($user);
        return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil dihapus.');
    }
}
