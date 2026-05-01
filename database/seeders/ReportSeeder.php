<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // LAPORAN 1 — UNIT-001 (Truk Fuso)
        // =============================================
        $report1Id = DB::table('reports')->insertGetId([
            'vehicle_id'  => 1,
            'user_id'     => 2, // Budi Santoso
            'date'        => '2025-04-10',
            'grand_total' => 0, // akan di-update di bawah
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Issue 1.1 — Rem Blong
        $issue1_1 = DB::table('report_issues')->insertGetId([
            'report_id'         => $report1Id,
            'issue_description' => 'Rem depan dan belakang sudah habis, perlu penggantian kampas rem segera.',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $item1 = ['report_issue_id' => $issue1_1, 'part_id' => 4, 'quantity' => 1, 'unit_price' => 350000, 'total_price' => 350000, 'created_at' => now(), 'updated_at' => now()]; // Kampas Rem Depan
        $item2 = ['report_issue_id' => $issue1_1, 'part_id' => 5, 'quantity' => 1, 'unit_price' => 300000, 'total_price' => 300000, 'created_at' => now(), 'updated_at' => now()]; // Kampas Rem Belakang
        $item3 = ['report_issue_id' => $issue1_1, 'part_id' => 10, 'quantity' => 2, 'unit_price' => 45000, 'total_price' => 90000, 'created_at' => now(), 'updated_at' => now()]; // Minyak Rem
        DB::table('report_items')->insert([$item1, $item2, $item3]);

        // Issue 1.2 — Servis Rutin
        $issue1_2 = DB::table('report_issues')->insertGetId([
            'report_id'         => $report1Id,
            'issue_description' => 'Servis rutin 10.000 km: ganti oli mesin dan filter oli.',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $item4 = ['report_issue_id' => $issue1_2, 'part_id' => 1, 'quantity' => 8, 'unit_price' => 85000, 'total_price' => 680000, 'created_at' => now(), 'updated_at' => now()]; // Oli 8L
        $item5 = ['report_issue_id' => $issue1_2, 'part_id' => 2, 'quantity' => 1, 'unit_price' => 75000, 'total_price' => 75000, 'created_at' => now(), 'updated_at' => now()]; // Filter Oli
        DB::table('report_items')->insert([$item4, $item5]);

        $total1 = 350000 + 300000 + 90000 + 680000 + 75000;
        DB::table('reports')->where('id', $report1Id)->update(['grand_total' => $total1]);

        // Stock movements untuk laporan 1
        $this->insertStockOut(4, 1, $report1Id); // Kampas Rem Depan
        $this->insertStockOut(5, 1, $report1Id); // Kampas Rem Belakang
        $this->insertStockOut(10, 2, $report1Id); // Minyak Rem
        $this->insertStockOut(1, 8, $report1Id);  // Oli Mesin
        $this->insertStockOut(2, 1, $report1Id);  // Filter Oli

        // =============================================
        // LAPORAN 2 — UNIT-002 (Truk Hino)
        // =============================================
        $report2Id = DB::table('reports')->insertGetId([
            'vehicle_id'  => 2,
            'user_id'     => 3, // Siti Rahayu
            'date'        => '2025-04-15',
            'grand_total' => 0,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Issue 2.1 — Mesin Overheat
        $issue2_1 = DB::table('report_issues')->insertGetId([
            'report_id'         => $report2Id,
            'issue_description' => 'Mesin mengalami overheat, V-belt putus dan filter udara kotor.',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $item6 = ['report_issue_id' => $issue2_1, 'part_id' => 6, 'quantity' => 1, 'unit_price' => 180000, 'total_price' => 180000, 'created_at' => now(), 'updated_at' => now()]; // V-Belt
        $item7 = ['report_issue_id' => $issue2_1, 'part_id' => 3, 'quantity' => 1, 'unit_price' => 120000, 'total_price' => 120000, 'created_at' => now(), 'updated_at' => now()]; // Filter Udara
        DB::table('report_items')->insert([$item6, $item7]);

        // Issue 2.2 — Aki Lemah
        $issue2_2 = DB::table('report_issues')->insertGetId([
            'report_id'         => $report2Id,
            'issue_description' => 'Aki soak, kendaraan susah dihidupkan terutama di pagi hari.',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $item8 = ['report_issue_id' => $issue2_2, 'part_id' => 8, 'quantity' => 1, 'unit_price' => 950000, 'total_price' => 950000, 'created_at' => now(), 'updated_at' => now()]; // Aki
        DB::table('report_items')->insert([$item8]);

        $total2 = 180000 + 120000 + 950000;
        DB::table('reports')->where('id', $report2Id)->update(['grand_total' => $total2]);

        $this->insertStockOut(6, 1, $report2Id); // V-Belt
        $this->insertStockOut(3, 1, $report2Id); // Filter Udara
        $this->insertStockOut(8, 1, $report2Id); // Aki

        // =============================================
        // LAPORAN 3 — UNIT-003 (Truk Isuzu Giga)
        // =============================================
        $report3Id = DB::table('reports')->insertGetId([
            'vehicle_id'  => 3,
            'user_id'     => 2, // Budi Santoso
            'date'        => '2025-04-20',
            'grand_total' => 0,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Issue 3.1 — Kopling Selip
        $issue3_1 = DB::table('report_issues')->insertGetId([
            'report_id'         => $report3Id,
            'issue_description' => 'Kopling terasa selip dan berat, perlu penggantian kopling set.',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $item9  = ['report_issue_id' => $issue3_1, 'part_id' => 9, 'quantity' => 1, 'unit_price' => 1500000, 'total_price' => 1500000, 'created_at' => now(), 'updated_at' => now()]; // Kopling Set
        $item10 = ['report_issue_id' => $issue3_1, 'part_id' => 7, 'quantity' => 4, 'unit_price' => 95000, 'total_price' => 380000, 'created_at' => now(), 'updated_at' => now()];   // Busi Pijar
        DB::table('report_items')->insert([$item9, $item10]);

        $total3 = 1500000 + 380000;
        DB::table('reports')->where('id', $report3Id)->update(['grand_total' => $total3]);

        $this->insertStockOut(9, 1, $report3Id); // Kopling Set
        $this->insertStockOut(7, 4, $report3Id); // Busi Pijar

        // =============================================
        // STOCK IN — Pembelian Stok Awal
        // =============================================
        $stockIns = [
            ['part_id' => 1,  'quantity' => 100, 'type' => 'in'],
            ['part_id' => 2,  'quantity' => 50,  'type' => 'in'],
            ['part_id' => 3,  'quantity' => 30,  'type' => 'in'],
            ['part_id' => 4,  'quantity' => 25,  'type' => 'in'],
            ['part_id' => 5,  'quantity' => 25,  'type' => 'in'],
            ['part_id' => 6,  'quantity' => 30,  'type' => 'in'],
            ['part_id' => 7,  'quantity' => 60,  'type' => 'in'],
            ['part_id' => 8,  'quantity' => 15,  'type' => 'in'],
            ['part_id' => 9,  'quantity' => 10,  'type' => 'in'],
            ['part_id' => 10, 'quantity' => 50,  'type' => 'in'],
        ];

        foreach ($stockIns as $s) {
            DB::table('stock_movements')->insert([
                'part_id'        => $s['part_id'],
                'type'           => $s['type'],
                'quantity'       => $s['quantity'],
                'reference_id'   => null,
                'reference_type' => 'purchase',
                'created_at'     => now()->subDays(30),
                'updated_at'     => now()->subDays(30),
            ]);
        }
    }

    private function insertStockOut(int $partId, int $qty, int $reportId): void
    {
        DB::table('stock_movements')->insert([
            'part_id'        => $partId,
            'type'           => 'out',
            'quantity'       => $qty,
            'reference_id'   => $reportId,
            'reference_type' => 'report_item',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}