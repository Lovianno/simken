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
                'type'        => 'Mitsubishi Fuso',
                'category'    => 'Truk',
                'year'        => 2018,
                'unit_number' => 'UNIT-001',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'B 5678 DEF',
                'type'        => 'Hino Ranger',
                'category'    => 'Truk',
                'year'        => 2019,
                'unit_number' => 'UNIT-002',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'B 9012 GHI',
                'type'        => 'Isuzu Giga',
                'category'    => 'Truk',
                'year'        => 2020,
                'unit_number' => 'UNIT-003',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'D 3456 JKL',
                'type'        => 'Mitsubishi Colt Diesel',
                'category'    => 'Truk',
                'year'        => 2017,
                'unit_number' => 'UNIT-004',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nopol'       => 'L 7890 MNO',
                'type'        => 'Toyota Dyna',
                'category'    => 'Truk',
                'year'        => 2021,
                'unit_number' => 'UNIT-005',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('vehicles')->insert($vehicles);
    }
}