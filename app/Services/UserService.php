<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Get all users with optional search filter and pagination.
     */
    public function getAll(?string $search = null, int $perPage = 10)
    {
        return User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }

    /**
     * Create a new user.
     */
    public function create(array $data): User
    {
        DB::beginTransaction();
        try {
            $data['password'] = bcrypt($data['password']);
            $user = User::query()->create($data);
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing user.
     */
    public function update(User $user, array $data): bool
    {
        DB::beginTransaction();
        try {
            // Only update password if provided
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            $result = $user->update($data);
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}