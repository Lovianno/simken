<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->query('search');

        // All users
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(10);

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
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $data['password'] = bcrypt($data['password']);

            $user = User::query()->create($data);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
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

        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Only update password if provided
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            $user->update($data);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['register' => 'Terjadi kesalahan saat memperbarui pengguna. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil dihapus.');
    }
}
