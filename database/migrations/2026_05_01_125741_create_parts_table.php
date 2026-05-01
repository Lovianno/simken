<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->comment('Nama Onderdil');
            $table->decimal('base_price', 15, 2)->default(0)->comment('Harga Dasar');
            $table->text('description')->nullable()->comment('Deskripsi Onderdil');
            $table->integer('stock')->default(0)->comment('Stok Tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};