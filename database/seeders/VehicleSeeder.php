<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'nopol'       => 'B 1234 ABC',
                'type'        => 'Truk Fuso',
                'year'        => 2018,
                'unit_number' => 'UNIT-001',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'B 5678 DEF',
                'type'        => 'Truk Hino Ranger',
                'year'        => 2019,
                'unit_number' => 'UNIT-002',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'B 9012 GHI',
                'type'        => 'Truk Isuzu Giga',
                'year'        => 2020,
                'unit_number' => 'UNIT-003',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'D 3456 JKL',
                'type'        => 'Truk Mitsubishi Colt Diesel',
                'year'        => 2017,
                'unit_number' => 'UNIT-004',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'L 7890 MNO',
                'type'        => 'Truk Toyota Dyna',
                'year'        => 2021,
                'unit_number' => 'UNIT-005',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('vehicles')->insert($vehicles);
    }
}