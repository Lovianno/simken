<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'         => 'Admin Utama',
                'email'        => 'admin@bengkel.com',
                'password'     => Hash::make('password'),
                'phone_number' => '081234567890',
                'status'       => 'active',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Budi Santoso',
                'email'        => 'budi@bengkel.com',
                'password'     => Hash::make('password'),
                'phone_number' => '082345678901',
                'status'       => 'active',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Siti Rahayu',
                'email'        => 'siti@bengkel.com',
                'password'     => Hash::make('password'),
                'phone_number' => '083456789012',
                'status'       => 'active',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Joko Widodo',
                'email'        => 'joko@bengkel.com',
                'password'     => Hash::make('password'),
                'phone_number' => '084567890123',
                'status'       => 'inactive',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}