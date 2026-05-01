<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
            EnrollmentSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
