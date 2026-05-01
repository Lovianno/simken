<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $search = $request->query('search');

        // User aktif/nonaktif
        $users = User::query()
            ->whereIn('status', [User::STATUS_ACTIVE, User::STATUS_INACTIVE])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(10);

        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();
        $perPage = $users->perPage();
        $total = $users->total();

        // Count user pending+rejected
        $pendingCount = User::query()
            ->whereIn('status', [User::STATUS_PENDING, User::STATUS_REJECTED])
            ->count();

        return view('pages.admin.user.index', compact(
            'users',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total',
            'pendingCount'
        ));
    }

    /**
     * Lazy: List user pending & rejected (for lazy load)
     */
    public function pendingList()
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->whereIn('status', [User::STATUS_PENDING, User::STATUS_REJECTED])
            ->orderByRaw("FIELD(status, 'pending', 'rejected')")
            ->orderByDesc('created_at')
            ->paginate(10);

        $links = (string) $users->links();

        return response()->json([
            'users' => $users,
            'links' => $links,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();

        DB::beginTransaction();
        try {
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture_file')) {
                $profilePicturePath = $request->file('profile_picture_file')->store('profile-pictures', 'public');
            }

            $data['password'] = bcrypt($data['password']);

            unset($data['profile_picture_path']);

            $user = User::query()->create($data);

            if ($user->role === User::ROLE_TEACHER) {
                $teacherData = [];
                if (!empty($profilePicturePath)) {
                    $teacherData['profile_picture_path'] = $profilePicturePath;
                }
                if (!empty($data['bio'])) {
                    $teacherData['bio'] = $data['bio'];
                }
                if (!empty($data['expertise'])) {
                    $teacherData['expertise'] = $data['expertise'];
                }
                $user->teacher()->create($teacherData);
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil ditambahkan.');
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
        $this->authorize('view', $user);

        $user->load('teacher');

        return view('pages.admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load('teacher');

        return view('pages.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validated();

        DB::beginTransaction();
        try {
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture_file')) {
                $profilePicturePath = $request->file('profile_picture_file')->store('profile-pictures', 'public');
            }

            // Only update password if provided
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            unset($data['profile_picture_path']);

            $user->update($data);

            if ($user->role === User::ROLE_TEACHER && $user->teacher) {
                $teacherData = [];
                if (!empty($profilePicturePath)) {
                    $teacherData['profile_picture_path'] = $profilePicturePath;
                }
                if (!empty($data['bio'])) {
                    $teacherData['bio'] = $data['bio'];
                }
                if (!empty($data['expertise'])) {
                    $teacherData['expertise'] = $data['expertise'];
                }
                if (!empty($teacherData)) {
                    $user->teacher->update($teacherData);
                }
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil diperbarui.');
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
        $this->authorize('delete', $user);

        if ($user->role === User::ROLE_TEACHER && $user->teacher) {
            $user->teacher->delete();
        }

        if ($user->teacher->profile_picture_path) {
            Storage::disk('public')->delete($user->teacher->profile_picture_path);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil dihapus.');
    }

    /**
     * Approve teacher application.
     */
    public function approveTeacher(User $user)
    {
        $this->authorize('update', $user);
        if ($user->role !== User::ROLE_TEACHER || $user->status !== User::STATUS_PENDING) {
            return redirect()->back()->withErrors(['approve' => 'Aksi tidak valid.']);
        }
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $teacherData['approved_at'] = now();
        $user->teacher()->update($teacherData);

        return redirect()->route('admin.users.show', $user)->with('success', 'Pengajuan guru di-approve.');
    }

    /**
     * Reject teacher application.
     */
    public function rejectTeacher(User $user)
    {
        $this->authorize('update', $user);
        if ($user->role !== User::ROLE_TEACHER || $user->status !== User::STATUS_PENDING) {
            return redirect()->back()->withErrors(['reject' => 'Aksi tidak valid.']);
        }
        $user->status = User::STATUS_REJECTED;
        $user->save();
        return redirect()->route('admin.users.show', $user)->with('success', 'Pengajuan guru ditolak.');
    }
}
