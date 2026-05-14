<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->enum('truck_size', ['20 FEET', '40 FEET', '40 SLEDING'])
                ->nullable()
                ->after('category')
                ->comment('Ukuran Truk');

            // Data STNK
            $table->string('stnk_owner', 100)
                ->nullable()
                ->after('truck_size')
                ->comment('Nama Pemilik di STNK (AN STNK)');

            $table->date('tax_due_date')
                ->nullable()
                ->after('stnk_owner')
                ->comment('Jatuh Tempo Pajak Tahunan');

            $table->date('stnk_due_date')
                ->nullable()
                ->after('tax_due_date')
                ->comment('Jatuh Tempo STNK 5 Tahunan');

            // KIR Kepala / Tractor
            $table->string('kir_head_number', 50)
                ->nullable()
                ->after('stnk_due_date')
                ->comment('Nomor KIR Kepala/Tractor');

            $table->date('kir_head_due_date')
                ->nullable()
                ->after('kir_head_number')
                ->comment('Tanggal Jatuh Tempo KIR Kepala');

            // KIR Kereta / Trailer
            $table->string('kir_trailer_number', 50)
                ->nullable()
                ->after('kir_head_due_date')
                ->comment('Nomor KIR Kereta/Trailer');

            $table->date('kir_trailer_due_date')
                ->nullable()
                ->after('kir_trailer_number')
                ->comment('Tanggal Jatuh Tempo KIR Kereta');

            // Supir & Keterangan
            $table->string('driver_name', 100)
                ->nullable()
                ->after('kir_trailer_due_date')
                ->comment('Nama Supir');

            $table->text('notes')
                ->nullable()
                ->after('driver_name')
                ->comment('Keterangan Tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'truck_size',
                'stnk_owner',
                'tax_due_date',
                'stnk_due_date',
                'kir_head_number',
                'kir_head_due_date',
                'kir_trailer_number',
                'kir_trailer_due_date',
                'driver_name',
                'notes',
            ]);
        });
    }
};
