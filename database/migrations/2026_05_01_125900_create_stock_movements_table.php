<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('parts')->restrictOnDelete();
            $table->enum('type', ['in', 'out'])->comment('Tipe Pergerakan Stok');
            $table->integer('quantity')->comment('Jumlah');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('ID Referensi (polymorphic)');
            $table->string('reference_type', 50)->nullable()->comment('Tipe Referensi: report_item, purchase, adjustment');
            $table->timestamps();

            $table->index(['reference_id', 'reference_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};