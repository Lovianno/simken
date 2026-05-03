<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('nopol', 20)->comment('Nomor Polisi');
            $table->string('type', 100)->comment('Jenis/Tipe Kendaraan');
            $table->enum('category', ['Mobil', 'Truk', 'Bus', 'Sepeda Motor'])->comment('Kategori Kendaraan');
            $table->year('year')->comment('Tahun Kendaraan');
            $table->string('unit_number', 50)->comment('Nomor Unit Internal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};