<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Admin123'),
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        // TEACHER 1
        User::firstOrCreate(
            ['email' => 'teacher1@example.com'],
            [
                'name' => 'Ahmad Fauzi',
                'password' => bcrypt('Teacher123'),
                'role' => User::ROLE_TEACHER,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        // TEACHER 2
        User::firstOrCreate(
            ['email' => 'teacher2@example.com'],
            [
                'name' => 'Siti Aisyah',
                'password' => bcrypt('Teacher123'),
                'role' => User::ROLE_TEACHER,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        // TEACHER 3
        User::firstOrCreate(
            ['email' => 'teacher3@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('Teacher123'),
                'role' => User::ROLE_TEACHER,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        // STUDENT
        User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => bcrypt('Student123'),
                'role' => User::ROLE_STUDENT,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );
    }
}
