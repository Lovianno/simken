<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartSeeder extends Seeder
{
    public function run(): void
    {
        $parts = [
            [
                'name'        => 'Oli Mesin 10W-40',
                'base_price'  => 85000,
                'description' => 'Oli mesin untuk kendaraan berat, kemasan 1 liter',
                'stock'       => 50,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Filter Oli',
                'base_price'  => 75000,
                'description' => 'Filter oli standar untuk mesin diesel truk',
                'stock'       => 30,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Filter Udara',
                'base_price'  => 120000,
                'description' => 'Filter udara primer untuk mesin truk',
                'stock'       => 20,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Kampas Rem Depan',
                'base_price'  => 350000,
                'description' => 'Kampas rem depan untuk truk berat, 1 set',
                'stock'       => 15,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Kampas Rem Belakang',
                'base_price'  => 300000,
                'description' => 'Kampas rem belakang untuk truk berat, 1 set',
                'stock'       => 15,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'V-Belt / Fan Belt',
                'base_price'  => 180000,
                'description' => 'Sabuk kipas mesin, ukuran standar truk',
                'stock'       => 25,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Busi Pijar (Glow Plug)',
                'base_price'  => 95000,
                'description' => 'Busi pijar untuk mesin diesel, per buah',
                'stock'       => 40,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Aki / Baterai 12V 100Ah',
                'base_price'  => 950000,
                'description' => 'Aki kering 12V 100Ah untuk truk',
                'stock'       => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Kopling Set',
                'base_price'  => 1500000,
                'description' => 'Set kopling lengkap untuk truk medium',
                'stock'       => 8,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Minyak Rem DOT 4',
                'base_price'  => 45000,
                'description' => 'Minyak rem DOT 4, kemasan 500ml',
                'stock'       => 35,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('parts')->insert($parts);
    }
}